<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExternalUserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class getUsersController extends Controller
{
    //
    protected ExternalUserService $externalUserService; // Servicio para interactuar con la API externa de usuarios

    public function __construct(ExternalUserService $externalUserService) // Inyección de dependencia del servicio
    {
        $this->externalUserService = $externalUserService; // Asignación del servicio al controlador
    }

    public function workers(){
        return view('workers.workers'); // Retorna la vista de trabajadores
    }

    public function index(Request $request){

        //llamar el servicio para obtener los usuarios
        try {
            // Obtener el token JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');
            // Filtros desde query string
            $puestoFilter = strtolower(trim((string) $request->query('puesto', '')));
            $estadoFilter = strtolower(trim((string) $request->query('estado', '')));
            $qFilter = trim((string) $request->query('q', ''));
            
            if (!$jwtToken) {
                Log::warning('Intento de obtener usuarios sin token JWT en sesión', [
                    'user_email' => $userEmail
                ]);
                return view('workers.workers', ['users' => [], 'error' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.']);
            }

            Log::info('CONTROLADOR: Obteniendo usuarios con token JWT', [
                'user_email' => $userEmail,
                'has_token' => !empty($jwtToken)
            ]);

            $response = $this->externalUserService->getRegisteredUsers($jwtToken);
            
            Log::info('CONTROLADOR: Respuesta completa del servicio', [
                'response' => $response,
                'success' => $response['success'] ?? 'No success key',
                'data_type' => isset($response['data']) ? gettype($response['data']) : 'No data key',
                'data_content' => isset($response['data']) ? $response['data'] : 'No data'
            ]);

            if($response['success']){ // Verifica si la respuesta es exitosa
                $users = $response['data'] ?? [];
                
                // Asegurar que $users es un array
                if (!is_array($users)) {
                    Log::warning('CONTROLADOR: Los datos no son un array', [
                        'data_type' => gettype($users),
                        'data' => $users
                    ]);
                    $users = [];
                }
                
                // Aplicar filtros en servidor si vienen en la request
                if ($puestoFilter !== '' || $estadoFilter !== '' || $qFilter !== '') {
                    $users = array_values(array_filter($users, function ($user) use ($puestoFilter, $estadoFilter, $qFilter) {
                        // Normalizar puesto (tipo)
                        $tipo = strtolower((string)($user['tipo'] ?? ''));

                        // Normalizar estado (puede venir como string o boolean en claves 'estado' o 'activo')
                        $estadoRaw = $user['estado'] ?? $user['activo'] ?? null;
                        $estadoNorm = 'activo';
                        if (is_bool($estadoRaw)) {
                            $estadoNorm = $estadoRaw ? 'activo' : 'inactivo';
                        } elseif (is_numeric($estadoRaw)) {
                            $estadoNorm = ((int)$estadoRaw) === 1 ? 'activo' : 'inactivo';
                        } elseif (is_string($estadoRaw)) {
                            $estadoNorm = strtolower($estadoRaw);
                        }

                        $matchesPuesto = $puestoFilter === '' ? true : ($tipo === $puestoFilter);
                        $matchesEstado = $estadoFilter === '' ? true : ($estadoNorm === $estadoFilter);

                        // Filtro por nombre completo o correo (insensible a acentos y mayúsculas)
                        if ($qFilter !== '') {
                            $qNorm = Str::lower(Str::ascii($qFilter));
                            $fullName = trim((string)($user['name'] ?? '') . ' ' . (string)($user['apellido'] ?? ''));
                            $email = (string)($user['email'] ?? '');
                            $fullNorm = Str::lower(Str::ascii($fullName));
                            $emailNorm = Str::lower(Str::ascii($email));
                            $matchesQuery = (strpos($fullNorm, $qNorm) !== false) || (strpos($emailNorm, $qNorm) !== false);
                        } else {
                            $matchesQuery = true;
                        }

                        return $matchesPuesto && $matchesEstado && $matchesQuery;
                    }));

                    Log::info('CONTROLADOR: Filtros aplicados', [
                        'puesto' => $puestoFilter,
                        'estado' => $estadoFilter,
                        'q' => $qFilter,
                        'result_count' => count($users)
                    ]);
                }

                Log::info('CONTROLADOR: Datos procesados para vista', [
                    'users_count' => count($users),
                    'users_type' => gettype($users),
                    'first_user' => count($users) > 0 && isset($users[0]) ? $users[0] : 'No users available'
                ]);

                return view('workers.workers', ['users' => $users]); // Retorna la vista con los usuarios

            } else {
                Log::error('CONTROLADOR: Error al obtener usuarios', [
                    'error' => $response['error'] ?? 'Error desconocido',
                    'status_code' => $response['status_code'] ?? 'N/A',
                    'user_email' => $userEmail
                ]);
                
                return view('workers.workers', ['users' => [], 'error' => 'Error al obtener los usuarios: ' . ($response['error'] ?? 'Error desconocido')]); 
            }
        } catch (\Exception $e) {
            Log::error('CONTROLADOR: Excepción al obtener usuarios', [
                'message' => $e->getMessage(),
                'user_email' => $request->session()->get('user.email', 'No email')
            ]);
            
            return view('workers.workers', ['users' => [], 'error' => 'Error al obtener los usuarios: ' . $e->getMessage()]); 
        }
    }

    

}
