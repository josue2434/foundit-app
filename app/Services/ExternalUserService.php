<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalUserService
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url') ?? 'http://localhost:3000';
        $this->timeout = config('services.external_api.timeout', 30);
    }

    /**
     * Obtener headers comunes para las peticiones este se encarga de establecer los headers comunes 
     * para las peticiones funciona como guardián de las peticiones
     */
    private function getCommonHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Service para Registrar usuario en la API externa de Node.js
     */
    public function registerUser(array $userData, ?string $token = null): array
    {
        try {
            // Log de los datos que se van a enviar
            Log::info('SERVICIO: Iniciando registro de usuario en API externa', [
                'email' => $userData['email'] ?? 'No email',
                'name' => $userData['name'] ?? 'No name',
                'tipo' => $userData['tipo'] ?? 'No tipo',
                'almacen' => $userData['almacen'] ?? 'No almacen',
                'datos_completos' => $userData
            ]);

            $response = Http::timeout($this->timeout) // post a la API externa
                ->withHeaders($this->getCommonHeaders())
                ->post($this->baseUrl . '/users', [
                    'name' => $userData['name'],
                    'apellido' => $userData['apellido'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'tipo' => $userData['tipo'],
                    //'almacen' => $userData['almacen'] ?? null, // Comentado para usar petición separada
                    // 'estante' => $userData['estante'] ?? null, // Mantener comentado por ahora
                ]);

            // Log detallado de la respuesta
            Log::info('SERVICIO: Respuesta de la API al crear usuario', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'success' => $response->successful(),
                'endpoint' => $this->baseUrl . '/users'
            ]);

            if ($response->successful()) { //si la respuesta es exitosa
                $userCreated = $response->json();
                $userId = $userCreated['usuario']['_id'] ?? $userCreated['data']['_id'] ?? $userCreated['_id'] ?? null;
                
                Log::info('Usuario registrado exitosamente en API externa', [
                    'email' => $userData['email'],
                    'user_id' => $userId,
                    'response_keys' => array_keys($userCreated),
                    'usuario_object' => $userCreated['usuario'] ?? 'No usuario object',
                    'usuario_keys' => isset($userCreated['usuario']) ? array_keys($userCreated['usuario']) : 'No keys',
                    'full_response' => $userCreated,
                    'almacen_a_asignar' => $userData['almacen'] ?? 'No almacen'
                ]);

                // Asignar almacén al usuario usando su ID (petición separada)
                if ($userId && isset($userData['almacen']) && !empty($userData['almacen'])) {
                    Log::info('ALMACEN: Iniciando asignación de almacén', [
                        'user_id' => $userId,
                        'almacen_codigo' => $userData['almacen'],
                        'endpoint' => $this->baseUrl . '/almacenes/' . $userId,
                        'datos_a_enviar' => [
                            'name' => $userData['almacen'],
                            'direccion' => 'Dirección por defecto'
                        ]
                    ]);

                    $almacenHeaders = $this->getCommonHeaders();
                    if ($token) {
                        $almacenHeaders['Authorization'] = 'Bearer ' . $token;
                        Log::info('ALMACEN: Usando token de autorización para asignar almacén');
                    } else {
                        Log::warning('ALMACEN: Sin token de autorización para asignar almacén');
                    }

                    $almacenResponse = Http::timeout($this->timeout)
                        ->withHeaders($almacenHeaders)
                        ->put($this->baseUrl . '/almacenes/' . $userId, [
                            'name' => $userData['almacen'], // El código/nombre del almacén seleccionado
                            'direccion' => $userData['direccion'] // Puedes cambiar esto por una dirección real
                        ]);
                    
                    Log::info('ALMACEN: Respuesta del endpoint almacenes', [
                        'status_code' => $almacenResponse->status(),
                        'response_body' => $almacenResponse->body(),
                        'success' => $almacenResponse->successful(),
                        'user_id' => $userId,
                        'almacen' => $userData['almacen'],
                        'headers_sent' => array_keys($almacenHeaders),
                        'has_auth_header' => isset($almacenHeaders['Authorization']),
                        'endpoint_used' => $this->baseUrl . '/almacenes/' . $userId
                    ]);
                    
                    if (!$almacenResponse->successful()) {
                        Log::warning('Error al asignar almacén al usuario', [
                            'user_id' => $userId,
                            'almacen' => $userData['almacen'],
                            'status' => $almacenResponse->status(),
                            'response' => $almacenResponse->body(),
                            'endpoint_usado' => $this->baseUrl . '/almacenes/' . $userId
                        ]);
                    } else {
                        Log::info('Almacén asignado exitosamente al usuario', [
                            'user_id' => $userId,
                            'almacen' => $userData['almacen'],
                            'response_data' => $almacenResponse->json()
                        ]);
                    }
                } else {
                    if (!$userId) {
                        Log::warning('No se pudo obtener el ID del usuario creado para asignar almacén');
                    }
                    if (!isset($userData['almacen']) || empty($userData['almacen'])) {
                        Log::info('No se proporcionó almacén para asignar al usuario');
                    }
                }

                return [ //retorna el resultado exitoso
                    'success' => true,
                    'data' => $userCreated,
                    'status_code' => $response->status()
                ];
            }

            Log::error('Error al registrar usuario en API externa', [ // registra el error en el log
                'status' => $response->status(),
                'response' => $response->body(),
                'email' => $userData['email'],
                'request_data' => [
                    'name' => $userData['name'] ?? 'No name',
                    'apellido' => $userData['apellido'] ?? 'No apellido',
                    'email' => $userData['email'] ?? 'No email',
                    'tipo' => $userData['tipo'] ?? 'No tipo',
                    'almacen' => $userData['almacen'] ?? null
                ]
            ]);

            // Intentar parsear el error específico para errores 400
            $errorMessage = 'Error en la API externa';
            if ($response->status() === 400) {
                $responseBody = $response->json();
                if (isset($responseBody['error'])) {
                    $errorMessage = $responseBody['error'];
                } elseif (isset($responseBody['message'])) {
                    $errorMessage = $responseBody['message'];
                } else {
                    $errorMessage = 'Datos de usuario inválidos (Error 400)';
                }
            }

            return [ //retorna el error de la API externa
                'success' => false,
                'error' => $errorMessage,
                'status_code' => $response->status(),
                'details' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al registrar usuario en API externa', [
                'message' => $e->getMessage(),
                'email' => $userData['email']
            ]);

            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    // Service login para iniciar sesión en la API externa de Node.js
    public function login(array $credentials): array
    {
        try {
            $response = Http::timeout($this->timeout) // post a la API externa
                ->withHeaders($this->getCommonHeaders())
                ->post($this->baseUrl . '/login', [
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                ]);

            if ($response->successful()) { //si la respuesta es exitosa
                Log::info('Usuario autenticado exitosamente en API externa', [
                    'email' => $credentials['email']
                ]);

                return [ //retorna el resultado exitoso
                    'success' => true,
                    'data' => $response->json(),
                    'status_code' => $response->status()
                ];
            }

            Log::error('Error al autenticar usuario en API externa', [ // registra el error
                'status' => $response->status(),
                'response' => $response->body(),
                'email' => $credentials['email']
            ]);

            return [ //retornar si no existe el usuario
                'success' => false,
                //'error' => 'Error en la API externa: ' . $response->body(),
                'error' => 'Credenciales inválidas',
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al autenticar usuario en API externa', [ // registra la excepción
                'message' => $e->getMessage(),
                'email' => $credentials['email']
            ]);

            return [ //retorna el error de conexión
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }

    }

    /**
     * service Cerrar sesión en la API externa (invalidar token)
     */
    public function logout(string $token): bool
    {
        try {
            $response = Http::timeout($this->timeout) // post a la API externa
                ->withHeaders(array_merge($this->getCommonHeaders(), [ // agrega el token JWT a los headers
                    'Authorization' => 'Bearer ' . $token, // agrega el token JWT a los headers
                ]))
                ->post($this->baseUrl . '/logout'); // post a la API externa

            if ($response->successful()) { // si la respuesta es exitosa
                Log::info('Logout exitoso en API externa'); // registra el logout exitoso en el log
                return true; //retorna true si el logout fue exitoso
            }

            Log::warning('Error al hacer logout en API externa', [ //registra el error en el log
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al hacer logout en API externa', [ //registra la excepción en el log
                'message' => $e->getMessage()
            ]);

            return false; //retorna false si ocurre una excepción
        }
    }

    //Sevice para Obtener Usuarios Registrados en la API externa
    public function getRegisteredUsers(?string $token = null):array{
        try {
            $headers = $this->getCommonHeaders();
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token;
                Log::info('Solicitando usuarios con token de autorización');
            } else {
                Log::warning('Solicitando usuarios sin token de autorización');
            }

            $response = Http::timeout($this->timeout) // get a la API externa
                ->withHeaders($headers)
                ->get($this->baseUrl . '/users');

            if ($response->successful()) { // si la respuesta es exitosa
                $responseData = $response->json();
                $users = $responseData['usuarios'] ?? []; // Extraer los usuarios del campo correcto
                
                Log::info('Usuarios obtenidos exitosamente de la API externa', [
                    'total_from_api' => $responseData['total'] ?? 'N/A',
                    'users_count' => count($users),
                    'api_response_keys' => array_keys($responseData),
                    'first_user_keys' => count($users) > 0 ? array_keys($users[0]) : 'No users'
                ]);
                
                return [
                    'success' => true,
                    'data' => $users, // Devolver solo el array de usuarios
                    'status_code' => $response->status(),
                    'total' => $responseData['total'] ?? count($users),
                    'mensaje' => $responseData['mensaje'] ?? ''
                ];
            }

            Log::error('Error al obtener usuarios de la API externa', [ // registra el error en el log
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al obtener usuarios de la API externa', [ // registra la excepción en el log
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    //Service para eliminar un usuario por id
    public function deleteUserById(string $userId, ?string $token = null): array
    {
        try {
            $headers = $this->getCommonHeaders();
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token; // agrega el token JWT a los headers
                Log::info('Eliminando usuario con token de autorización');// esto solo es debug XD
            } else {
                Log::warning('Eliminando usuario sin token de autorización');
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->delete($this->baseUrl . '/users/' . $userId); // delete a la API externa

            if ($response->successful()) {
                Log::info('Usuario eliminado exitosamente de la API externa', [
                    'user_id' => $userId
                ]);
                
                return [
                    'success' => true,
                    'status_code' => $response->status(),
                    'mensaje' => 'Usuario eliminado exitosamente.'
                ];
            }

            Log::error('Error al eliminar usuario de la API externa', [
                'status' => $response->status(),
                'response' => $response->body(),
                'user_id' => $userId
            ]);

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al eliminar usuario de la API externa', [
                'message' => $e->getMessage(),
                'user_id' => $userId
            ]);

            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    //Service para obtener un usuario por id
    public function getUserById(string $userId, ?string $token = null): array
    {
        try {
            $headers = $this->getCommonHeaders();
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token;
                Log::info('Obteniendo usuario por ID con token de autorización', ['user_id' => $userId]);
            } else {
                Log::warning('Obteniendo usuario por ID sin token de autorización', ['user_id' => $userId]);
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->get($this->baseUrl . '/users/id/' . $userId); // get a la API externa

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Extraer los datos del usuario del campo correcto según la estructura de la API
                $userData = $responseData['usuario'] ?? $responseData;
                
                Log::info('Usuario obtenido exitosamente de la API externa', [
                    'user_id' => $userId,
                    'api_response_keys' => array_keys($responseData),
                    'user_data_keys' => is_array($userData) ? array_keys($userData) : 'Not array',
                    'mensaje' => $responseData['mensaje'] ?? 'No mensaje'
                ]);
                
                return [
                    'success' => true,
                    'data' => $userData, // Devolver solo los datos del usuario
                    'status_code' => $response->status()
                ];
            }

            Log::error('Error al obtener usuario de la API externa', [
                'status' => $response->status(),
                'response' => $response->body(),
                'user_id' => $userId
            ]);

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al obtener usuario de la API externa', [
                'message' => $e->getMessage(),
                'user_id' => $userId
            ]);

            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    //Service para actualizar un usuario por id
    public function updateUser(string $userId, array $userData, ?string $token = null): array
    {
        try {
            $headers = $this->getCommonHeaders();
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token;
                Log::info('Actualizando usuario con token de autorización', ['user_id' => $userId]);
            } else {
                Log::warning('Actualizando usuario sin token de autorización', ['user_id' => $userId]);
            }

            Log::info('Datos a enviar para actualizar usuario', [
                'user_id' => $userId,
                'userData' => $userData,
                'endpoint' => $this->baseUrl . '/users/id/' . $userId
            ]);

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->put($this->baseUrl . '/users/id/' . $userId, $userData); // PUT al endpoint /users/id/{id}

            Log::info('Respuesta de la API al actualizar usuario', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'user_id' => $userId
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::info('Usuario actualizado exitosamente en la API externa', [
                    'user_id' => $userId,
                    'email' => $userData['email'] ?? 'N/A'
                ]);
                
                return [
                    'success' => true,
                    'data' => $responseData,
                    'status_code' => $response->status()
                ];
            }

            Log::error('Error al actualizar usuario en la API externa', [
                'status' => $response->status(),
                'response' => $response->body(),
                'user_id' => $userId,
                'email' => $userData['email'] ?? 'N/A'
            ]);

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al actualizar usuario en la API externa', [
                'message' => $e->getMessage(),
                'user_id' => $userId,
                'email' => $userData['email'] ?? 'N/A'
            ]);

            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    //Service para obtener almacenes 

    public function getAlmacenes(?string $token = null): array
    {
        try {

            $headers = $this->getCommonHeaders();  //obtener los headers
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token;
                Log::info('Obteniendo almacenes con token de autorización');
            } else {
                Log::warning('Obteniendo almacenes sin token de autorización');
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->get($this->baseUrl . '/almacenes/all'); // get a la API externa

            if ($response->successful()) {
                $responseData = $response->json();
                $almacenes = $responseData['almacenes'] ?? []; // Extraer los almacenes del campo correcto
                
                Log::info('Almacenes obtenidos exitosamente de la API externa', [
                    'total_from_api' => $responseData['total'] ?? 'N/A',
                    'almacenes_count' => count($almacenes),
                    'api_response_keys' => array_keys($responseData),
                    'first_almacen_keys' => count($almacenes) > 0 ? array_keys($almacenes[0]) : 'No almacenes'
                ]);
                
                return [
                    'success' => true,
                    'data' => $almacenes, // Devolver solo el array de almacenes
                    'status_code' => $response->status(),
                    'total' => $responseData['total'] ?? count($almacenes),
                    'mensaje' => $responseData['mensaje'] ?? ''
                ];
            }

            

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Excepción al obtener almacenes de la API externa', [
                'message' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }

    }        

}
