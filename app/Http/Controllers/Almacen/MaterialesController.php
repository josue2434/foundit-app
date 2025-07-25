<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExternalMaterialService; // Asegúrate de que este servicio exista y esté configurado correctamente
use Illuminate\Support\Facades\Log;

class MaterialesController extends Controller
{
    //
    protected ExternalMaterialService $externalMaterialService; // Inyección de dependencia del servicio

    public function __construct(ExternalMaterialService $externalMaterialService) // Inyección de dependencia del servicio
    {   
        $this->externalMaterialService = $externalMaterialService; // Asignación del servicio al controlador
    }

    public function gestionEmbarques() //ruta para la vista
    {
        return view('inventory.materiales');
    }

    public function index(Request $request){
        try {
            // Obtenemos el token JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');
            
            if (!$jwtToken) {
                Log::warning('Intento de obtener materiales sin token JWT en sesión', [
                    'user_email' => $userEmail
                ]);
                return view('inventory.materiales', ['materiales' => [], 'error' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.']);
            }

            Log::info('CONTROLADOR: Obteniendo materiales con token JWT', [
                'user_email' => $userEmail,
                'has_token' => !empty($jwtToken)
            ]);

            $response = $this->externalMaterialService->getMateriales([], $jwtToken);

            Log::info('CONTROLADOR: Respuesta completa del servicio', [
                'response' => $response,
                'success' => $response['success'] ?? 'No success key',
                'data_type' => isset($response['data']) ? gettype($response['data']) : 'No data key',
                'data_content' => isset($response['data']) ? $response['data'] : 'No data'
            ]);

            if($response['success']){ // Verifica si la respuesta es exitosa
                $materiales = $response['data'] ?? [];
                
                // Asegurar que $materiales es un array
                if (!is_array($materiales)) {
                    Log::warning('CONTROLADOR: Los datos no son un array', [
                        'data_type' => gettype($materiales),
                        'data' => $materiales
                    ]);
                    $materiales = [];
                }
                
                Log::info('CONTROLADOR: Datos procesados para vista', [
                    'materiales_count' => count($materiales),
                    'materiales_type' => gettype($materiales),
                    'first_material' => count($materiales) > 0 && isset($materiales[0]) ? $materiales[0] : 'No materials available'
                ]);

                return view('inventory.materiales', ['materiales' => $materiales]); // Retorna la vista con los materiales

            } else {
                Log::error('CONTROLADOR: Error al obtener materiales', [
                    'error' => $response['error'] ?? 'Error desconocido',
                    'status_code' => $response['status_code'] ?? 'N/A',
                    'user_email' => $userEmail
                ]);
                
                return view('inventory.materiales', ['materiales' => [], 'error' => 'Error al obtener los materiales: ' . ($response['error'] ?? 'Error desconocido')]); 
            }
        } catch (\Exception $e) {
            Log::error('CONTROLADOR: Excepción al obtener materiales', [
                'message' => $e->getMessage(),
                'user_email' => $request->session()->get('user.email', 'No email')
            ]);
            
            return view('inventory.materiales', ['materiales' => [], 'error' => 'Error al obtener los materiales: ' . $e->getMessage()]); 
        }
    }

    // Método para buscar materiales por nombre
    public function buscarMaterialesPorNombre(Request $request){
        try {
            $name = $request->input('name'); // Obtener el nombre del material desde la solicitud
            if (empty($name)) {
                return view('inventory.materiales', ['materiales' => [], 'error' => 'El nombre del material es requerido.']);
            }

            // Obtenemos el token JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');
            
            if (!$jwtToken) {
                Log::warning('Intento de buscar materiales sin token JWT en sesión', [
                    'user_email' => $userEmail
                ]);
                return view('inventory.materiales', ['materiales' => [], 'error' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.']);
            }

            Log::info('CONTROLADOR: Buscando materiales por nombre con token JWT', [
                'user_email' => $userEmail,
                'has_token' => !empty($jwtToken),
                'search_name' => $name
            ]);

            // Usar el método específico para buscar por nombre
            $response = $this->externalMaterialService->getMaterialByName($name, $jwtToken);

            Log::info('CONTROLADOR: Respuesta completa del servicio de búsqueda', [
                'response' => $response,
                'success' => $response['success'] ?? 'No success key',
                'data_type' => isset($response['data']) ? gettype($response['data']) : 'No data key',
                'data_content' => isset($response['data']) ? $response['data'] : 'No data'
            ]);

            if($response['success']){ // Verifica si la respuesta es exitosa
                $materiales = $response['data'] ?? [];
                
                // Asegurar que $materiales es un array
                if (!is_array($materiales)) {
                    Log::warning('CONTROLADOR: Los datos de búsqueda no son un array', [
                        'data_type' => gettype($materiales),
                        'data' => $materiales
                    ]);
                    $materiales = [];
                }
                
                Log::info('CONTROLADOR: Datos de búsqueda procesados para vista', [
                    'materiales_count' => count($materiales),
                    'materiales_type' => gettype($materiales),
                    'first_material' => count($materiales) > 0 && isset($materiales[0]) ? $materiales[0] : 'No materials available',
                    'search_term' => $name
                ]);

                return view('inventory.materiales', [
                    'materiales' => $materiales,
                    'search_term' => $name,
                    'mensaje' => count($materiales) > 0 ? "Se encontraron " . count($materiales) . " material(es) con el nombre: {$name}" : "No se encontraron materiales con el nombre: {$name}"
                ]);
                
            } else {
                Log::error('CONTROLADOR: Error al buscar materiales por nombre', [
                    'error' => $response['error'] ?? 'Error desconocido',
                    'status_code' => $response['status_code'] ?? 'N/A',
                    'user_email' => $userEmail,
                    'search_name' => $name
                ]);
                
                return view('inventory.materiales', [
                    'materiales' => [], 
                    'error' => 'Error al buscar materiales: ' . ($response['error'] ?? 'Error desconocido'),
                    'search_term' => $name
                ]); 
            }

        } catch (\Exception $e) {
            Log::error('CONTROLADOR: Excepción al buscar materiales por nombre', [
                'message' => $e->getMessage(),
                'user_email' => $request->session()->get('user.email', 'No email'),
                'search_name' => $name ?? 'N/A'
            ]);
            
            return view('inventory.materiales', [
                'materiales' => [], 
                'error' => 'Error al buscar materiales: ' . $e->getMessage(),
                'search_term' => $name ?? ''
            ]);
        }
    }

}
