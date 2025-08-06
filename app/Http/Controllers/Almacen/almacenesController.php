<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use App\Services\ExternalAlmacenService;
use App\Services\ExternalUserService;
use Illuminate\Http\Request;

class AlmacenesController extends Controller
{
    protected ExternalUserService $externalUserService;
    protected ExternalAlmacenService $externalAlmacenService;

    public function __construct(ExternalUserService $externalUserService, ExternalAlmacenService $externalAlmacenService)
    {
        $this->externalUserService = $externalUserService;
        $this->externalAlmacenService = $externalAlmacenService;
    }

    private function obtenerAlmacenes(Request $request)
    {
        try{
            // Obtener toekn JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            //$userEmail = $request->session()->get('user.email');
    
            if (!$jwtToken) {
                return null;
            }
    
            // Llamar al servicio externo para obtener los almacenes
            $response = $this->externalUserService->getAlmacenes($jwtToken);

            if(!$response['success']) {
                return null; // Manejar el error de la API externa
            }

           // return $response['data'] ?? []; // Asegurar que $almacenes es un array
            return $response;

            //madamos al formulario
            //return view('workers.register', compact('almacenes'));

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de conexión: ' . $e->getMessage()], 500);    

        }

        
    }

    public function index(Request $request){
        // Llamar al método para obtener los almacenes
        $response = $this->obtenerAlmacenes($request);
        if ($response === null) {
            return redirect()->route('almacenes.index')->with('error', 'No se pudieron obtener los almacenes.');
        }

        $almacenes = $response['data'] ?? [];
        $operadoresPorAlmacen = $response['operadoresPorAlmacen'] ?? [];

        // Crear un array asociativo: nombre => cantidad
    $conteoOperadores = [];
    foreach ($operadoresPorAlmacen as $item) {
        $conteoOperadores[trim(strtolower($item['name']))] = $item['cantidad'];
    }  

        //dd($almacenes, $conteoOperadores);
        return view('almacen.index-almacen', compact('almacenes', 'conteoOperadores')); // Retornar la vista con los almacenes
    }

    public function showRegisterForm(Request $request){
        // Llamar al método para obtener los almacenes
        $almacenes = $this->obtenerAlmacenes($request);

        if ($almacenes === null) {
            return redirect()->route('almacenes.index')->with('error', 'No se pudieron obtener los almacenes.');
        }
        $almacenes = $almacenes['data'] ?? [];

        return view('workers.register', compact('almacenes')); // Retornar la vista de registro de trabajadores con los almacenes
    

    }

    public function detroyalmacen(Request $request, $id)
    {
        // Llamar al servicio externo para eliminar el almacén
        $jwtToken = $request->session()->get('jwt_token');
        if (!$jwtToken) {
            return redirect()->route('almacenes.index')->with('error', 'No se pudo obtener el token de sesión.');
        }

        // Llamar al servicio externo para eliminar el almacén
        $response = $this->externalUserService->deleteAlmacenById($id, $jwtToken);

        if (!$response['success']) {
            return redirect()->route('almacenes.index')->with('error', 'No se pudo eliminar el almacén.');
        }

        return redirect()->route('getallAlmacenes')->with('success', 'Almacén eliminado exitosamente.');
    }

    public function createAlmacen(Request $request){
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'nombre' => 'required', //esto es para el estante
            'nameDispositivo' => 'required|string|max:255', // nombre del dispositivo
            'ip' => 'required|string|max:255', // IP del dispositivo
        ]);

        $data = [ //datos del almacén
            'name' => $request->input('name'),
            'direccion' => $request->input('direccion'),
        ];

        
        try{
            $jwtToken = $request->session()->get('jwt_token'); // Obtener el token JWT de la sesión
            if (!$jwtToken) {
                return redirect()->route('getallAlmacenes')->with('error', 'No se pudo obtener el token de sesión.');
            }
            // Llamar al servicio externo para crear el almacén
            $response = $this->externalAlmacenService->createAlmacen($data, $jwtToken);
            //dd($response);

            //obtener el ID del usuario logueado           
            $user = $request->session()->get('user');
            $idUser = $user['id'] ?? null;
            
            $idAlmacen = $response['data']['_id'] ?? null; // Obtener el ID del almacén creado

            //dd($idAlmacen);

            if (!$idAlmacen) {
                //dd('No se pudo obtener el ID del almacén creado.');
                return redirect()->route('getallAlmacenes')->with('error', 'No se pudo obtener el ID del almacén creado.');
            }

            if(!$idUser){
                return redirect()->route('getallAlmacenes')->with('error', 'No se pudo obtener el ID del usuario logueado.');
            }
            
            $dataDispositivo = [ //datos del dispositivo
                'nombre' => $request->input('nombre'),
                'nameDispositivo' => $request->input('nameDispositivo'),
                'ip' => $request->input('ip'),
                'almacenId' => $idAlmacen, // ID del almacén creado
            ];

            //dd($idUser);
            //crear el estante
            $responseEstante = $this->externalAlmacenService->createEstante($dataDispositivo, $jwtToken, $idUser);

            //dd($responseEstante);

            if ($responseEstante['success']) {
                return redirect()->route('getallAlmacenes')->with('success', 'Almacén creado exitosamente.');
            }

            return redirect()->route('getallAlmacenes')->with('error', 'Error al crear el almacén: ' . $response['message']);

        }catch (\Exception $e) {
            return redirect()->route('getallAlmacenes')->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }
}
