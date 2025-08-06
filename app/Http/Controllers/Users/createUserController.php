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
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6|confirmed', 
                'tipo' => 'required|string|in:admin,operador', // Validar que solo sean valores permitidos
                // Comentado temporalmente - no se usan almacen y estante por ahora
                'almacen' => 'required|string', // Validar almacenes permitidos
                // 'estante' => 'required|string|in:E1,E2,E3,E4,E5', // Validar estantes permitidos
            ]);

            //registrar el usuario en la API externa
            // Obtener token de la sesión (usar el mismo nombre que en login: jwt_token)
            $token = session('jwt_token');

            if (!$token) {
                return redirect()->back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->with('error', 'Error: Se requiere autenticación para registrar usuarios. Por favor, inicia sesión como administrador.');
            } else {
                Log::info('CONTROLADOR: Usando token de la sesión para registro');
            }

            // Buscar el nombre y dirección del almacén por su ID
            $almacenes = $this->externalUserService->getAlmacenes($token);
            //capturamos datos para el registro
            $almacenSeleccionado = collect($almacenes['data'] ?? [])->firstWhere('_id', $request->almacen);
            $nombreAlmacen = $almacenSeleccionado['name'] ?? $request->almacen; // fallback al ID si no se encuentra
            $direccionAlmacen = $almacenSeleccionado['direccion'] ?? 'Dirección por defecto';

            //obtener los estantes del almacén seleccionado
            $estantes = $almacenSeleccionado['estantes'] ?? []; 

            //recorrer y acceder a los atributos de los estantes
            foreach ($estantes as $estante) {
                $nombreEstante = $estante['nombre'] ?? 'Estante sin nombre';
                $nameDispositivo = $estante['nameDispositivo'] ?? 'Dispositivo sin nombre';
                $ip = $estante['ip'] ?? 'IP no disponible';
            
            }
            
            $externalResultado = $this->externalUserService->registerUser([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'password' => $request->password,
                'tipo' => $request->tipo,
                // Enviar el nombre y dirección reales del almacén
                'almacen' => $nombreAlmacen,
                'direccion' => $direccionAlmacen,
                //enviar datos del estantes 
                'nombre'=> $nombreEstante,
                'nameDispositivo' => $nameDispositivo,
                'ip' => $ip,
                
            ], $token);


            // Verificar si el registro fue exitoso
            if ($externalResultado['success']) {
            
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
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->except('password', 'password_confirmation'));
                
        } catch(\Exception $e){
            // Manejo de excepciones generales
            
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Error al registrar el usuario: ' . $e->getMessage());
        }
    }

    //metodo para eliminar al usuario
    public function destroy($id){
        try {
            // Obtener el token de la sesión
            $token = session('jwt_token');
            
            if (!$token) {
                Log::warning('CONTROLADOR: No hay token de autorización disponible para eliminar usuario', [
                    'user_id' => $id
                ]);
                return redirect()->route('workers')->with('error', 'No hay autorización válida. Por favor, inicia sesión nuevamente.');
            }

            Log::info('CONTROLADOR: Iniciando eliminación de usuario', [
                'user_id' => $id,
                'has_token' => !empty($token)
            ]);

            // Llamar al servicio para eliminar el usuario
            $result = $this->externalUserService->deleteUserById($id, $token); 

            if ($result['success']) {
                Log::info('CONTROLADOR: Usuario eliminado exitosamente', [
                    'user_id' => $id
                ]);
                return redirect()->route('workers')->with('success', 'Usuario eliminado exitosamente.');
            } else {
                Log::error('CONTROLADOR: Error al eliminar usuario', [
                    'error' => $result['error'] ?? 'Error desconocido',
                    'user_id' => $id
                ]);
                return redirect()->route('workers')->with('error', 'Error al eliminar el usuario: ' . ($result['error'] ?? 'Error desconocido'));
            }
        } catch (\Exception $e) {
            Log::error('CONTROLADOR: Excepción al eliminar usuario', [
                'message' => $e->getMessage(),
                'user_id' => $id
            ]);
            return redirect()->route('workers')->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
        
    }

    // Método para mostrar el formulario de edición de usuario
    public function edit($id){
        try {
            Log::info('CONTROLADOR: Método edit llamado', [
                'received_id' => $id,
                'id_type' => gettype($id),
                'id_empty' => empty($id)
            ]);

            // Obtener el token de la sesión
            $token = session('jwt_token');
            
            if (!$token) {
                Log::warning('CONTROLADOR: No hay token de autorización disponible para editar usuario', [
                    'user_id' => $id
                ]);
                return redirect()->route('workers')->with('error', 'No hay autorización válida. Por favor, inicia sesión nuevamente.');
            }

            Log::info('CONTROLADOR: Iniciando obtención de datos de usuario para edición', [
                'user_id' => $id,
                'has_token' => !empty($token)
            ]);

            // Llamar al servicio para obtener los datos del usuario
            $result = $this->externalUserService->getUserById($id, $token); 

            Log::info('CONTROLADOR: Resultado de getUserById', [
                'success' => $result['success'] ?? 'no success key',
                'data_keys' => isset($result['data']) ? array_keys($result['data']) : 'no data',
                'user_id' => $id
            ]);

            if ($result['success']) {
                Log::info('CONTROLADOR: Datos de usuario obtenidos exitosamente', [
                    'user_id' => $id,
                    'user_data' => $result['data']
                ]);
                
                // Pasar los datos del usuario a la vista de edición
                return view('workers.edit_workers', ['user' => $result['data']]);
            } else {
                Log::error('CONTROLADOR: Error al obtener datos del usuario', [
                    'error' => $result['error'] ?? 'Error desconocido',
                    'user_id' => $id
                ]);
                return redirect()->route('workers')->with('error', 'Error al obtener los datos del usuario: ' . ($result['error'] ?? 'Error desconocido'));
            }
        } catch (\Exception $e) {
            Log::error('CONTROLADOR: Excepción al obtener datos del usuario', [
                'message' => $e->getMessage(),
                'user_id' => $id
            ]);
            return redirect()->route('workers')->with('error', 'Error al obtener los datos del usuario: ' . $e->getMessage());
        }
    }

    // Método para actualizar un usuario
    public function update(Request $request, $id){
        try {
            // Obtener el token de la sesión
            $token = session('jwt_token');
            
            if (!$token) {
                Log::warning('CONTROLADOR: No hay token de autorización disponible para actualizar usuario', [
                    'user_id' => $id
                ]);
                return redirect()->route('workers')->with('error', 'No hay autorización válida. Por favor, inicia sesión nuevamente.');
            }

            // Validar los datos del formulario
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'nullable|string|min:6|confirmed', // Contraseña opcional
                'tipo' => 'required|string|in:admin,operador',
                //'almacen' => 'required|string|in:JW1,JW2,JW3,JW4',
                //'estante' => 'required|string|in:E1,E2,E3,E4,E5',
                'estado' => 'required|string|in:activo,inactivo',
            ]);

            Log::info('CONTROLADOR: Iniciando actualización de usuario', [
                'user_id' => $id,
                'email' => $request->email,
                'tipo' => $request->tipo,
                'name' => $request->name
            ]);

            // Preparar datos para enviar a la API
            $updateData = [
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'tipo' => $request->tipo,
                //'almacen' => $request->almacen,
                //'estante' => $request->estante,
                'estado' => $request->estado === 'activo', // Convertir string a boolean
            ];

            Log::info('CONTROLADOR: Datos preparados para actualización', [
                'updateData' => $updateData,
                'user_id' => $id,
                'estado_form' => $request->estado,
                'estado_boolean' => $request->estado === 'activo'
            ]);

            // Solo incluir la contraseña si se proporcionó
            if ($request->filled('password')) {
                $updateData['password'] = $request->password;
            }

            // Actualizar el usuario en la API externa
            $externalResultado = $this->externalUserService->updateUser($id, $updateData, $token);

            Log::info('CONTROLADOR: Respuesta del servicio de actualización', [
                'response' => $externalResultado,
                'success' => $externalResultado['success'] ?? 'No success key',
                'user_id' => $id
            ]);

            // Verificar si la actualización fue exitosa
            if ($externalResultado['success']) {
                Log::info('CONTROLADOR: Usuario actualizado exitosamente', [
                    'user_id' => $id,
                    'email' => $request->email
                ]);

                return redirect()->route('workers')->with('success', 'Usuario actualizado exitosamente: ' . $request->name . ' ' . $request->apellido);
            } else {
                Log::error('CONTROLADOR: Error en la actualización del usuario', [
                    'error' => $externalResultado['error'] ?? 'Error desconocido',
                    'user_id' => $id,
                    'email' => $request->email
                ]);

                // Manejar errores específicos de la API
                $errorMessage = $externalResultado['error'] ?? 'Error desconocido al actualizar el usuario';
                
                return redirect()->back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->with('error', $errorMessage);
            }

        } catch(\Illuminate\Validation\ValidationException $e) {
            // Errores de validación específicos de Laravel
            Log::warning('CONTROLADOR: Error de validación en actualización', [
                'errors' => $e->errors(),
                'user_id' => $id,
                'email' => $request->email ?? 'No email'
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->except('password', 'password_confirmation'));
                
        } catch(\Exception $e){
            // Manejo de excepciones generales
            Log::error('CONTROLADOR: Excepción al actualizar usuario', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => $id,
                'email' => $request->email ?? 'No email'
            ]);
            
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }
}
