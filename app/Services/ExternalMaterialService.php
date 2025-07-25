<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalMaterialService{
    private string $baseUrl; // Base URL de la API externa
    private int $timeout; // Tiempo de espera para las peticiones

    public function __construct()// Constructor para inicializar la URL base y el timeout
    {
        $this->baseUrl = config('services.external_api.base_url') ?? 'http://localhost:3000';
        $this->timeout = config('services.external_api.timeout', 30);
    }

    /**
    * Obtener headers comunes para las peticiones
    **/
    private function getCommonHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function getMateriales(array $filters = [], ?string $token = null): array
    {
        try {
            $headers = $this->getCommonHeaders();
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token;
                Log::info('Solicitando materiales con token de autorización');
            } else {
                Log::warning('Solicitando materiales sin token de autorización');
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->get($this->baseUrl . '/materiales/all', $filters);

            if ($response->successful()) {
                $responseData = $response->json();
                $materiales = $responseData['materiales'] ?? []; // Extraer los materiales del campo correcto
                
                Log::info('Materiales obtenidos exitosamente de la API externa', [
                    'total_from_api' => $responseData['total'] ?? 'N/A',
                    'materiales_count' => count($materiales),
                    'api_response_keys' => array_keys($responseData),
                    'first_material_keys' => count($materiales) > 0 ? array_keys($materiales[0]) : 'No materials'
                ]);
                
                return [
                    'success' => true,
                    'data' => $materiales, // Devolver solo el array de materiales
                    'status_code' => $response->status(),
                    'total' => $responseData['total'] ?? count($materiales),
                    'mensaje' => $responseData['mensaje'] ?? ''
                ];
            }

            Log::error('Error al obtener materiales de la API externa', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Excepción al obtener materiales de la API externa', [
                'message' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'error' => 'Error de conexión con la API externa: ' . $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    //metodo para buscar materiales por nombre
    public function getMaterialByName(string $name, ?string $token = null): array
    {
        try {
            $headers = $this->getCommonHeaders();
            
            // Si se proporciona un token, agregarlo a los headers
            if ($token) {
                $headers['Authorization'] = 'Bearer ' . $token;
                Log::info('SERVICIO: Solicitando materiales por nombre con token de autorización', [
                    'search_name' => $name
                ]);
            } else {
                Log::warning('SERVICIO: Solicitando materiales por nombre sin token de autorización', [
                    'search_name' => $name
                ]);
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->get($this->baseUrl . '/materiales/name/' . urlencode($name));

            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::info('SERVICIO: Respuesta completa de búsqueda por nombre', [
                    'url_called' => $this->baseUrl . '/materiales/name/' . urlencode($name),
                    'search_name' => $name,
                    'status_code' => $response->status(),
                    'response_keys' => array_keys($responseData),
                    'raw_response' => $responseData
                ]);
                
                $materiales = $responseData['materiales'] ?? [];    
                
                Log::info('Materiales obtenidos exitosamente por nombre', [
                    'search_name' => $name,
                    'total_from_api' => $responseData['total'] ?? 'N/A',
                    'materiales_count' => count($materiales),
                    'api_response_keys' => array_keys($responseData),
                    'first_material_keys' => count($materiales) > 0 ? array_keys($materiales[0]) : 'No materials',
                    'first_material_content' => count($materiales) > 0 ? $materiales[0] : 'No materials'
                ]);
                
                return [
                    'success' => true,
                    'data' => $materiales,
                    'status_code' => $response->status(),
                    'total' => $responseData['total'] ?? count($materiales),
                    'mensaje' => $responseData['mensaje'] ?? '',
                    'search_term' => $name
                ];
            }

            Log::error('Error al obtener materiales por nombre de la API externa', [
                'search_name' => $name,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status(),
                'search_term' => $name
            ];
        } catch (\Exception $e) {
            Log::error('Excepción al obtener materiales por nombre de la API externa', [
                'search_name' => $name,
                'message' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'error' => 'Error de conexión con la API externa: ' . $e->getMessage(),
                'status_code' => 500,
                'search_term' => $name
            ];
        }
    }
}