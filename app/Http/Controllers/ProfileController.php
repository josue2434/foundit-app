<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ExternalUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected ExternalUserService $externalUserService;

    public function __construct(ExternalUserService $externalUserService)
    {
        $this->externalUserService = $externalUserService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        // Obtener datos del usuario desde la sesión
        $userData = $request->session()->get('user');
        
        if (!$userData) {
            Log::warning('Intento de acceso a perfil sin datos de usuario en sesión');
            return redirect()->route('login')->withErrors(['error' => 'Sesión inválida. Por favor inicia sesión nuevamente.']);
        }

        Log::info('Acceso a perfil exitoso', [
            'user_email' => $userData['email'] ?? 'No email',
            'user_id' => $userData['id'] ?? 'No ID'
        ]);

        return view('profile.edit', [
            'user' => (object) $userData, // Convertir array a objeto para compatibilidad con las vistas
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            // Obtener datos actuales del usuario desde la sesión
            $userData = $request->session()->get('user');
            
            if (!$userData) {
                Log::warning('Intento de actualización de perfil sin datos de usuario en sesión');
                return redirect()->route('login')->withErrors(['error' => 'Sesión inválida.']);
            }

            // Por ahora, solo actualizar los datos en la sesión
            // En el futuro podrías implementar una llamada a la API para actualizar en Node.js
            $validatedData = $request->validated();
            
            // Actualizar datos en la sesión
            $userData['name'] = $validatedData['name'] ?? $userData['name'];
            $userData['email'] = $validatedData['email'] ?? $userData['email'];
            
            $request->session()->put('user', $userData);

            Log::info('Perfil actualizado en sesión', [
                'user_email' => $userData['email'],
                'updated_fields' => array_keys($validatedData)
            ]);

            return Redirect::route('profile.edit')->with('status', 'profile-updated');

        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil', [
                'error' => $e->getMessage(),
                'user_email' => $userData['email'] ?? 'No email'
            ]);

            return back()->withErrors(['error' => 'Error al actualizar el perfil.']);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            // Validar password (por ahora no podemos verificar contra la API, así que omitir)
            $userData = $request->session()->get('user');
            
            if (!$userData) {
                return redirect()->route('login');
            }

            Log::info('Usuario eliminando cuenta', [
                'user_email' => $userData['email'] ?? 'No email'
            ]);

            // Limpiar sesión
            $request->session()->flush();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('success', 'Cuenta eliminada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al eliminar cuenta', [
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Error al eliminar la cuenta.']);
        }
    }
}
