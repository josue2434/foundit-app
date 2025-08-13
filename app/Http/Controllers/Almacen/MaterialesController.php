<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExternalMaterialService; // 
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

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

    public function index(Request $request) //funcion para obtener materiales
    {
        try {
            // Obtenemos el token JWT desde la sesión
            $jwtToken = $request->session()->get('jwt_token');
            $userEmail = $request->session()->get('user.email');

            if (!$jwtToken) {
                return [
                    'success' => false,
                    'message' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.',
                    'status' => 401,
                    'data' => []
                ];
            }

            $response = $this->externalMaterialService->getMateriales([], $jwtToken);

            if ($response['success']) { // Verifica si la respuesta es exitosa
                return $response; // Retorna la respuesta completa del servicio
            }

            return [
                'success' => false,
                'message' => 'Error al obtener los materiales.',
                'status' => 500,
                'data' => []
            ];

        } catch (\Exception $e) {

        return [
        'success' => false,
        'error' => $e->getMessage(),
        'status_code' => 500,
        'data' => [],
            ];
        }
    }

    public function getAllmateriales(Request $request){ //funcion para obtener materiales
        try {
            
            $response = $this->index($request); // Llamamos al método index para obtener los materiales 

            if(!is_array($response) || !$response['success'] ?? false) {
                $msg = $response['error'] ?? $response['message'] ?? 'Error desconocido';

                return view('inventory.materiales', [
                    'materiales' => [],
                    'error' => $msg
                ]);
            }

            //si la respuesta es exitosa
            $materiales = $response['data'] ?? []; // Extraer los materiales del campo correcto
            if (!is_array($materiales)) {
                $materiales = [];
            }

            return view('inventory.materiales', [
                'materiales' => $materiales,
                'error' => null
            ]);

        } catch (\Exception $e) {
        
            return view('inventory.materiales', [
                'materiales' => [],
                'error' => 'Error al obtener los materiales: ' . $e->getMessage()
            ]);
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

    //obtener todos los materiales para reporte
    public function getAllMaterialesForReport(Request $request){

        try{

            // 1) Obtener materiales base
            $response = $this->index($request);

            if(!is_array($response) || !($response['success'] ?? false)) {
                $msg = $response['error'] ?? $response['message'] ?? 'Error desconocido';

                return view('reporte.index', [
                    'materiales' => [],
                    'error' => $msg
                ]);
            }

            $materiales = $response['data'] ?? [];
            if (!is_array($materiales)) {
                $materiales = [];
            }

            // 2) Filtros
            $period = $request->query('period', 'month'); // day|week|month|all
            $movementType = $request->query('movement_type', ''); // entrada|salida|''
            $search = trim((string) $request->query('search', ''));

            $now = Carbon::now();
            $startDate = null;
            switch ($period) {
                case 'day':
                    $startDate = $now->copy()->startOfDay();
                    break;
                case 'week':
                    $startDate = $now->copy()->startOfWeek();
                    break;
                case 'month':
                    $startDate = $now->copy()->startOfMonth();
                    break;
                case 'all':
                default:
                    $startDate = null;
                    break;
            }

            $filtered = array_values(array_filter($materiales, function ($m) use ($startDate, $movementType, $search) {
                // a) Período por fecha/timestamp
                if ($startDate) {
                    $fechaRaw = $m['fecha'] ?? $m['date'] ?? $m['created_at'] ?? $m['timestamp'] ?? null;
                    if ($fechaRaw) {
                        try {
                            $fecha = Carbon::parse($fechaRaw);
                            if ($fecha->lt($startDate)) return false;
                        } catch (\Exception $e) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }

                // b) Tipo de movimiento
                if ($movementType !== '') {
                    $tipoRaw = $m['tipo'] ?? $m['movement_type'] ?? '';
                    if ($tipoRaw === '') {
                        $movs = $m['movimiento'] ?? $m['movements'] ?? [];
                        if (is_array($movs) && !empty($movs)) {
                            $ultimo = end($movs);
                            $tipoRaw = $ultimo['tipo'] ?? $ultimo['type'] ?? '';
                        }
                    }
                    $t = strtolower((string) $tipoRaw);
                    $isEntrada = str_contains($t, 'entrada') || $t === 'in';
                    $isSalida = str_contains($t, 'salida') || $t === 'out';
                    if ($movementType === 'entrada' && !$isEntrada) return false;
                    if ($movementType === 'salida' && !$isSalida) return false;
                }

                // c) Búsqueda en material/descripcion/código
                if ($search !== '') {
                    $needle = mb_strtolower($search);
                    $material = mb_strtolower((string) ($m['material'] ?? $m['nombre'] ?? $m['name'] ?? ''));
                    $desc = mb_strtolower((string) ($m['descripcion'] ?? $m['description'] ?? ''));
                    $code = mb_strtolower((string) ($m['codigo'] ?? $m['code'] ?? ($m['_id'] ?? '')));
                    if (!str_contains($material, $needle) && !str_contains($desc, $needle) && !str_contains($code, $needle)) {
                        return false;
                    }
                }

                return true;
            }));

            // 3) Orden por fecha desc si existe
            usort($filtered, function ($a, $b) {
                $fa = $a['fecha'] ?? $a['date'] ?? $a['created_at'] ?? $a['timestamp'] ?? null;
                $fb = $b['fecha'] ?? $b['date'] ?? $b['created_at'] ?? $b['timestamp'] ?? null;
                try { $ca = $fa ? Carbon::parse($fa) : null; } catch (\Exception $e) { $ca = null; }
                try { $cb = $fb ? Carbon::parse($fb) : null; } catch (\Exception $e) { $cb = null; }
                if ($ca && $cb) return $cb <=> $ca;
                if ($ca) return -1;
                if ($cb) return 1;
                return 0;
            });

            // 3.1) Exportación CSV si se solicita
            if ($request->filled('export')) {
                $filename = 'reporte_' . Carbon::now()->format('Ymd_His') . '.csv';
                return response()->streamDownload(function () use ($filtered) {
                    $out = fopen('php://output', 'w');
                    // BOM para compatibilidad con Excel (UTF-8)
                    fprintf($out, "\xEF\xBB\xBF");
                    // Encabezados
                    fputcsv($out, ['Fecha', 'Código', 'Material', 'Tipo', 'Cantidad', 'Almacén']);
                    foreach ($filtered as $m) {
                        $fechaRaw = $m['fecha'] ?? $m['date'] ?? $m['created_at'] ?? $m['timestamp'] ?? '';
                        try { $fechaFmt = $fechaRaw ? Carbon::parse($fechaRaw)->format('d/m/Y') : ''; } catch (\Exception $e) { $fechaFmt = (string) $fechaRaw; }
                        $codigo = $m['codigo'] ?? $m['code'] ?? ($m['material']['codigo'] ?? ($m['material']['code'] ?? ($m['_id'] ?? '')));
                        $nombre = $m['material'] ?? $m['nombre'] ?? ($m['material']['nombre'] ?? ($m['material']['name'] ?? ''));
                        $tipoRaw = $m['tipo'] ?? $m['movement_type'] ?? '';
                        if ($tipoRaw === '') {
                            $movs = $m['movimiento'] ?? $m['movements'] ?? [];
                            if (is_array($movs) && !empty($movs)) {
                                $ultimo = end($movs);
                                $tipoRaw = $ultimo['tipo'] ?? $ultimo['type'] ?? '';
                            }
                        }
                        $t = strtolower((string) $tipoRaw);
                        $tipoLabel = ($t === '' ? '—' : ((str_contains($t, 'entrada') || $t === 'in') ? 'Entrada' : ((str_contains($t, 'salida') || $t === 'out') ? 'Salida' : ucfirst($t))));
                        $cantidad = $m['cantidad'] ?? $m['quantity'] ?? '';
                        $almacen = $m['almacen'] ?? $m['warehouse'] ?? '';
                        fputcsv($out, [$fechaFmt, $codigo, $nombre, $tipoLabel, $cantidad, $almacen]); 
                    }
                    fclose($out); // Cerrar el recurso de salida
                }, $filename, [
                    'Content-Type' => 'text/csv; charset=UTF-8',
                ]);
            }

            // 4) Paginar
            $page = Paginator::resolveCurrentPage('page');
            $perPage = (int) $request->query('per_page', 10);
            $collection = new Collection($filtered);
            $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
            $paginator = new LengthAwarePaginator(
                $results,
                $collection->count(),
                $perPage,
                $page,
                [
                    'path' => Paginator::resolveCurrentPath(),
                    'pageName' => 'page',
                ]
            );

            // 5) Retornar a la vista de reportes
            return view('reporte.index', [
                'materiales' => $paginator,
                'error' => null
            ]);

        }catch (\Exception $e) {
            Log::error('Error en getAllMaterialesForReport: '.$e->getMessage());
            return view('reporte.index', [
                'materiales' => [],
                'error' => 'Error al obtener los materiales: '.$e->getMessage(),
            ]);
        }
    }

    

}
