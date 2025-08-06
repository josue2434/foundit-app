<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ExternalAlmacenService{
    private $baseUrl;
    private $timeout;

    public function __construct(){
        $this->baseUrl = config('services.external_api.base_url' ?? 'http://localhost:3000');
        $this->timeout = config('services.external_almacen.timeout', 30); // Tiempo de espera por defecto
    }

    //obtener heder JWT
    private function getCommonHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    //service para registrar un nuevo almacen
    public function createAlmacen(array $data,?string $jwtToken= null)
    {
        $headers = $this->getCommonHeaders();

        try {
            if ($jwtToken) {
                $headers['Authorization'] = 'Bearer ' . $jwtToken;
            }
            $response = Http::withHeaders($headers)
                ->timeout($this->timeout)
                ->post("{$this->baseUrl}/almacenes", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error en la creación: ' . $response->body(),
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage(),
            ];
        }
    }

    public function createEstante(array $data, ?string $jwtToken = null , $idUser = null){
        //obtenemos los headers
        $headers = $this->getCommonHeaders();

        try{

            if($jwtToken){ // Si se proporciona un token JWT, lo agregamos a los headers
                $headers['Authorization'] = 'Bearer ' . $jwtToken;
            }

            // Realizamos la petición POST al servicio externo
            $response = Http::withHeaders($headers)
            ->timeout($this->timeout)
            ->post("{$this->baseUrl}/estantes/".$idUser, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }else{
                return [
                    'success' => false,
                    'message' => 'Error en la creación del estante: ' . $response->body(),
                ];
            }

        }catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage(),
            ];
        }
    }
}
