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

    public function index(Request $request){ //funcion para obtener materiales
        try {
            // Obtenemos el token JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');
            
            if (!$jwtToken) {

                return view('inventory.materiales', ['materiales' => [], 'error' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.']);
            }

            $response = $this->externalMaterialService->getMateriales([], $jwtToken);

            //dd($response); // Para depurar la respuesta del servicio

            if($response['success']){ // Verifica si la respuesta es exitosa
                $materiales = $response['data'] ?? [];
                
                // Asegurar que $materiales es un array
                if (!is_array($materiales)) {
                    $materiales = [];
                }

                return view('inventory.materiales', ['materiales' => $materiales]); // Retorna la vista con los materiales

            } else {
                
                return view('inventory.materiales', ['materiales' => [], 'error' => 'Error al obtener los materiales: ' . ($response['error'] ?? 'Error desconocido')]); 
            }
        } catch (\Exception $e) {
        
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
            
                return view('inventory.materiales', ['materiales' => [], 'error' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.']);
            }

            // Usar el método específico para buscar por nombre
            $response = $this->externalMaterialService->getMaterialByName($name, $jwtToken);


            if($response['success']){ // Verifica si la respuesta es exitosa
                $materiales = $response['data'] ?? [];
                
                // Asegurar que $materiales es un array
                if (!is_array($materiales)) {
                
                    $materiales = [];
                }
            

                return view('inventory.materiales', [
                    'materiales' => $materiales,
                    'search_term' => $name,
                    'mensaje' => count($materiales) > 0 ? "Se encontraron " . count($materiales) . " material(es) con el nombre: {$name}" : "No se encontraron materiales con el nombre: {$name}"
                ]);
                
            } else {
            
                
                return view('inventory.materiales', [
                    'materiales' => [], 
                    'error' => 'Error al buscar materiales: ' . ($response['error'] ?? 'Error desconocido'),
                    'search_term' => $name
                ]); 
            }

        } catch (\Exception $e) {
            
            return view('inventory.materiales', [
                'materiales' => [], 
                'error' => 'Error al buscar materiales: ' . $e->getMessage(),
                'search_term' => $name ?? ''
            ]);
        }
    }

}
