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
                
                return view('', ['materiales' => [], 'error' => 'Error al obtener los materiales: ' . ($response['error'] ?? 'Error desconocido')]); 
            }
        } catch (\Exception $e) {
            Log::error('CONTROLADOR: Excepción al obtener materiales', [
                'message' => $e->getMessage(),
                'user_email' => $request->session()->get('user.email', 'No email')
            ]);
            
            return view('inventory.materiales', ['materiales' => [], 'error' => 'Error al obtener los materiales: ' . $e->getMessage()]); 
        }
    }

}
