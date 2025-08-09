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
                ->get($this->baseUrl . '/materiales/allWEB', $filters);

            if ($response->successful()) {
                $responseData = $response->json();
                $materiales = $responseData['materiales'] ?? []; // Extraer los materiales del campo correcto
                
                
                return [
                    'success' => true,
                    'data' => $materiales, // Devolver solo el array de materiales
                    'status_code' => $response->status(),
                    'total' => $responseData['total'] ?? count($materiales),
                    'mensaje' => $responseData['mensaje'] ?? ''
                ];
            }

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status()
            ];
        } catch (\Exception $e) {

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
                
                
                $materiales = $responseData['materiales'] ?? [];    
                
                return [
                    'success' => true,
                    'data' => $materiales,
                    'status_code' => $response->status(),
                    'total' => $responseData['total'] ?? count($materiales),
                    'mensaje' => $responseData['mensaje'] ?? '',
                    'search_term' => $name
                ];
            }

            return [
                'success' => false,
                'error' => 'Error en la API externa: ' . $response->body(),
                'status_code' => $response->status(),
                'search_term' => $name
            ];
        } catch (\Exception $e) {

            return [
                'success' => false,
                'error' => 'Error de conexión con la API externa: ' . $e->getMessage(),
                'status_code' => 500,
                'search_term' => $name
            ];
        }
    }
}