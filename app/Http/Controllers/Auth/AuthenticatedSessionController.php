<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\ExternalUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected ExternalUserService $externalUserService;

    public function __construct(ExternalUserService $externalUserService)
    {
        $this->externalUserService = $externalUserService;
    }

    /**
     * Display the login view.
     */
    public function create(): View // muestra la vista de inicio de sesión
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // Autenticar ÚNICAMENTE con la API externa de Node.js
            $loginResult = $this->externalUserService->login([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Verificar si la autenticación fue exitosa
            if (!$loginResult['success']) {
                $errorMessage = $loginResult['error'] ?? 'Credenciales inválidas o error en el servidor externo.';
                
                Log::warning('Falló la autenticación en API externa', [
                    'email' => $request->email,
                    'error' => $errorMessage
                ]);

                return back()->withInput($request->only('email', 'remember'))
                            ->withErrors(['email' => $errorMessage]);
            }

            // Extraer datos de la respuesta de Node.js
            $nodeJsToken = $loginResult['data']['token'] ?? null;
            $nodeJsUser = $loginResult['data']['user'] ?? null;

            // Verificar que tenemos los datos necesarios
            if (!$nodeJsToken || !$nodeJsUser || empty($nodeJsUser['email'])) {
                Log::error('Respuesta incompleta de Node.js en login', [
                    'response_data' => $loginResult['data'] ?? null
                ]);

                return back()->withInput($request->only('email', 'remember')) //retorna con error sobre la respuesta inesperada
                            ->withErrors(['email' => 'Error: Respuesta inesperada del servidor de autenticación.']);
            }

            // Guardar datos del usuario en la sesión (NO en base de datos)
            $request->session()->put('user', [
                'id' => $nodeJsUser['id'] ?? null,
                'name' => $nodeJsUser['name'] ?? '',
                'apellido' => $nodeJsUser['apellido'] ?? '',
                'email' => $nodeJsUser['email'],
                'tipo' => $nodeJsUser['tipo'] ?? 'user',
            ]);

            // Guardar token JWT en la sesión
            $request->session()->put('jwt_token', $nodeJsToken);
            
            // Marcar usuario como autenticado en la sesión
            $request->session()->put('authenticated', true);

            // Regenerar la sesión por seguridad
            $request->session()->regenerate();

            Log::info('Login exitoso', [ // registra el login exitoso en el log
                'email' => $nodeJsUser['email'],
                'user_id' => $nodeJsUser['_id'] ?? 'N/A',
                'has_token' => !empty($nodeJsToken)
            ]);

            // Redirigir al dashboard
            return redirect()->intended(route('dashboard'));

        } catch (\Exception $e) {
            Log::error('Excepción durante el login', [ //registra el error en el log
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput($request->only('email', 'remember')) //retorna con error de excepción
                        ->withErrors(['email' => 'Error interno del servidor durante el login.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse //funcion para cerrar sesión
    {
        try {
            // Intentar logout en la API externa si tenemos token
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');
            
            if ($jwtToken) { //si tenemos token JWT
                $logoutResult = $this->externalUserService->logout($jwtToken);  //hacer logout en la API externa
                
                if (!$logoutResult) { // registra el fallo de logout
                    Log::warning('Falló el logout en API externa', [ // registra el fallo de logout
                        'email' => $userEmail
                    ]);
                }
            }

            Log::info('Logout exitoso', [
                'email' => $userEmail
            ]);

        } catch (\Exception $e) {
            Log::error('Error durante logout en API externa', [
                'error' => $e->getMessage()
            ]);
        }

        // Limpiar toda la sesión
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
