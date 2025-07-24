<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExternalUserService;
use Illuminate\Support\Facades\Log;


class createUserController extends Controller
{
    //
    protected ExternalUserService $externalUserService; // Servicio para interactuar con la API externa de usuarios

    public function __construct(ExternalUserService $externalUserService) // Inyección de dependencia del servicio
    {
        $this->externalUserService = $externalUserService; // Asignación del servicio al controlador
    }

    //metodo para registrar al usuario
    public function store(Request $request){
        
        //llamar el servicio para registrar al usuario
        try{
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|string|email|max:255', // Quitar unique:users porque validamos contra la API
                'password' => 'required|string|min:6|confirmed', // Cambiar a min:6 para coincidir con frontend
                'tipo' => 'required|string|in:admin,operador', // Validar que solo sean valores permitidos
            ]);

            Log::info('CONTROLADOR: Iniciando registro de usuario', [
                'email' => $request->email,
                'tipo' => $request->tipo,
                'name' => $request->name
            ]);

            //registrar el usuario en la API externa
            $externalResultado = $this->externalUserService->registerUser([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => $request->password,
                'tipo' => $request->tipo,
            ]);

            Log::info('CONTROLADOR: Respuesta del servicio de registro', [
                'response' => $externalResultado,
                'success' => $externalResultado['success'] ?? 'No success key'
            ]);

            // Verificar si el registro fue exitoso
            if ($externalResultado['success']) {
                Log::info('CONTROLADOR: Usuario registrado exitosamente', [
                    'user_data' => $externalResultado['data'] ?? 'No data',
                    'email' => $request->email
                ]);

                return redirect()->route('workers')->with('success', 'Usuario registrado exitosamente: ' . $request->name . ' ' . $request->apellido);
            } else {
                Log::error('CONTROLADOR: Error en el registro del usuario', [
                    'error' => $externalResultado['error'] ?? 'Error desconocido',
                    'email' => $request->email
                ]);

                // Manejar errores específicos de la API
                $errorMessage = $externalResultado['error'] ?? 'Error desconocido al registrar el usuario';
                
                return redirect()->back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->with('error', $errorMessage);
            }

        } catch(\Illuminate\Validation\ValidationException $e) {
            // Errores de validación específicos de Laravel
            Log::warning('CONTROLADOR: Error de validación en registro', [
                'errors' => $e->errors(),
                'email' => $request->email ?? 'No email'
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->except('password', 'password_confirmation'));
                
        } catch(\Exception $e){
            // Manejo de excepciones generales
            Log::error('CONTROLADOR: Excepción al registrar usuario', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'email' => $request->email ?? 'No email'
            ]);
            
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Error al registrar el usuario: ' . $e->getMessage());
        }
    }
}
