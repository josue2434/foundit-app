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
     * Obtener headers comunes para las peticiones
     */
    private function getCommonHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Registrar usuario en la API externa de Node.js
     */
    public function registerUser(array $userData): array
    {
        try {

            $response = Http::timeout($this->timeout) // post a la API externa
                ->withHeaders($this->getCommonHeaders())
                ->post($this->baseUrl . '/users', [
                    'name' => $userData['name'],
                    'apellido' => $userData['apellido'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'tipo' => $userData['tipo'],
                ]);

            if ($response->successful()) { //si la respuesta es exitosa
                Log::info('Usuario registrado exitosamente en API externa', [
                    'email' => $userData['email']
                ]);

                return [ //retorna el resultado exitoso
                    'success' => true,
                    'data' => $response->json(),
                    'status_code' => $response->status()
                ];
            }

            Log::error('Error al registrar usuario en API externa', [ // registra el error en el log
                'status' => $response->status(),
                'response' => $response->body(),
                'email' => $userData['email']
            ]);

            return [ //retorna el error de la API externa
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
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

    //login para iniciar sesión en la API externa de Node.js
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
     * Cerrar sesión en la API externa (invalidar token)
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

    //Obtener Usuarios Registrados en la API externa
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

}
