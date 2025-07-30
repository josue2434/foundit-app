<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Services\ExternalUserService;
use Illuminate\Http\Request;

class AlmacenesController extends Controller
{
    protected ExternalUserService $externalUserService;

    public function __construct(ExternalUserService $externalUserService)
    {
        $this->externalUserService = $externalUserService;
    }

    public function index(Request $request)
    {
        try{
            // Obtener toekn JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');
    
            if (!$jwtToken) {
                return response()->json(['error' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.'], 401);
            }
    
            // Llamar al servicio externo para obtener los almacenes
            $response = $this->externalUserService->getAlmacenes($jwtToken);
    
            if(!$response['success']) {
                return response()->json(['error' => $response['error'] ?? 'Error al obtener almacenes.'], 500);
            }

            $almacenes = $response['data'] ?? []; // Asegurar que $almacenes es un array

            //madamos al formulario
            return view('workers.register', compact('almacenes'));

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de conexión: ' . $e->getMessage()], 500);    

        }

        
    }
}
