<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ExternalUserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected ExternalUserService $externalUserService;

    public function __construct(ExternalUserService $externalUserService)
    {
        $this->externalUserService = $externalUserService;
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => ['required', 'string', 'in:admin,user,worker'],
        ]);

        try {
            // Registrar ÚNICAMENTE en la API externa de Node.js
            $externalResult = $this->externalUserService->registerUser([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => $request->password,
                'tipo' => $request->tipo,
            ]);

            if (!$externalResult['success']) {
                Log::warning('Falló el registro en API externa', [
                    'email' => $request->email,
                    'error' => $externalResult['error']
                ]);

                return back()->withInput($request->only('name', 'apellido', 'email', 'tipo'))
                            ->withErrors(['email' => 'Error al registrar usuario: ' . ($externalResult['error'] ?? 'Error desconocido')]);
            }

            // Usuario registrado exitosamente en la API
            $userData = $externalResult['data']['user'] ?? [];
            
            // Guardar datos del usuario en la sesión (NO en base de datos)
            $request->session()->put('user', [
                'id' => $userData['_id'] ?? null,
                'name' => $userData['name'] ?? $request->name,
                'apellido' => $userData['apellido'] ?? $request->apellido,
                'email' => $userData['email'] ?? $request->email,
                'tipo' => $userData['tipo'] ?? $request->tipo,
            ]);

            // Guardar token JWT si está disponible
            if (isset($externalResult['data']['token'])) {
                $request->session()->put('jwt_token', $externalResult['data']['token']);
            }

            // Marcar usuario como autenticado en la sesión
            $request->session()->put('authenticated', true);

            Log::info('Usuario registrado exitosamente en API externa', [
                'email' => $request->email,
                'user_id' => $userData['_id'] ?? 'N/A'
            ]);

            return redirect()->route('dashboard')->with('success', 'Registro exitoso! Bienvenido.');

        } catch (\Exception $e) {
            Log::error('Error durante el proceso de registro', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput($request->only('name', 'apellido', 'email', 'tipo'))
                        ->withErrors(['email' => 'Error interno del servidor durante el registro.']);
        }
    }
}
