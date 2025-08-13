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
            // Filtros desde query string (mantener valor original para API, normalizar para comparación local)
            $almacenParam = trim((string) $request->query('almacen', ''));
            $movementParam = trim((string) $request->query('movement', ''));
            $almacenFilter = strtolower($almacenParam);
            $movementFilter = strtolower($movementParam);

            if (!$jwtToken) {
                return [
                    'success' => false,
                    'message' => 'Token de sesión inválido. Por favor inicia sesión nuevamente.',
                    'status' => 401,
                    'data' => []
                ];
            }

            // Pasar filtros a la API si son soportados (usar valores originales)
            $apiFilters = [];
            if ($almacenParam !== '') { $apiFilters['almacen'] = $almacenParam; }
            if ($movementParam !== '') { $apiFilters['movement'] = $movementParam; }

            $response = $this->externalMaterialService->getMateriales($apiFilters, $jwtToken);

            if ($response['success']) { // Verifica si la respuesta es exitosa
                // Filtro adicional en servidor por robustez
                $materialesRaw = $response['data'] ?? [];
                $materiales = $materialesRaw;
                if (!is_array($materiales)) { $materiales = []; }

                // Construir lista dinámica de almacenes desde los datos completos de la API
                $warehouseSet = [];
                if (is_array($materialesRaw)) {
                    foreach ($materialesRaw as $m) {
                        $name = (string) ($m['almacen'] ?? $m['warehouse'] ?? '');
                        if ($name !== '') { $warehouseSet[$name] = true; }
                    }
                }
                $warehouseOptions = array_keys($warehouseSet);

                if ($almacenFilter !== '' || $movementFilter !== '') {
                    $materiales = array_values(array_filter($materiales, function ($m) use ($almacenFilter, $movementFilter) {
                        // Almacén
                        $alm = strtolower((string) ($m['almacen'] ?? $m['warehouse'] ?? ''));
                        $matchesAlmacen = $almacenFilter === '' ? true : ($alm === $almacenFilter || str_contains($alm, $almacenFilter));

                        // Movimiento: intenta en campo directo o último de arreglo
                        $tipoRaw = $m['tipo'] ?? $m['movement_type'] ?? '';
                        if ($tipoRaw === '') {
                            $movs = $m['movimiento'] ?? $m['movements'] ?? [];
                            if (is_array($movs) && !empty($movs)) {
                                $ultimo = end($movs);
                                $tipoRaw = $ultimo['tipo'] ?? $ultimo['type'] ?? (is_string($ultimo) ? $ultimo : '');
                            }
                        }
                        $t = strtolower((string) $tipoRaw);
                        $tNorm = (str_contains($t, 'entrada') || $t === 'in') ? 'entrada' : ((str_contains($t, 'salida') || $t === 'out') ? 'salida' : $t);
                        $matchesMovement = $movementFilter === '' ? true : ($tNorm === $movementFilter);

                        return $matchesAlmacen && $matchesMovement;
                    }));
                }

                // Devolver estructura consistente
                return [
                    'success' => true,
                    'data' => $materiales,
                    'status' => $response['status_code'] ?? 200,
                    'warehouses' => $warehouseOptions
                ];
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
                'error' => null,
                // Persistir filtros en la vista
                'search_term' => $request->query('name', ''),
                'almacen' => $request->query('almacen', ''),
                'movement' => $request->query('movement', ''),
                'warehouses' => $response['warehouses'] ?? []
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

    /**
     * Retorna el historial de movimientos de un material en formato JSON
     */
    public function historialMovimientos(Request $request, string $id)
    {
        try {
            $jwtToken = $request->session()->get('jwt_token');
            if (!$jwtToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado',
                ], 401);
            }

            // Intentar obtener los movimientos desde el servicio; si falla, caer a buscar en el listado completo
            $movements = [];
            try {
                if (method_exists($this->externalMaterialService, 'getMaterialMovements')) {
                    $svc = \call_user_func([$this->externalMaterialService, 'getMaterialMovements'], $id, $jwtToken);
                    if (($svc['success'] ?? false) && isset($svc['data'])) {
                        $movements = $svc['data'];
                    }
                }
            } catch (\Throwable $t) {
                // Continuar con fallback
            }

            $materialCode = null;
            $materialSelected = null;
            if (empty($movements)) {
                // Fallback: obtener todos y filtrar por id
                $all = $this->externalMaterialService->getMateriales([], $jwtToken);
                if (($all['success'] ?? false) && is_array($all['data'])) {
                    foreach ($all['data'] as $m) {
                        $mid = (string)($m['_id'] ?? $m['id'] ?? '');
                        $mcode = (string)($m['codigo'] ?? $m['code'] ?? '');
                        if ($mid === $id || $mcode === $id) {
                            $materialCode = $mcode ?: $mid;
                            $materialSelected = $m;
                            $movements = $m['movimiento'] ?? $m['movements'] ?? [];
                            break;
                        }
                    }
                }
            }

            // Intentar nuevamente con el código del material si existe
            if (empty($movements) && $materialCode && method_exists($this->externalMaterialService, 'getMaterialMovements')) {
                try {
                    $svc2 = \call_user_func([$this->externalMaterialService, 'getMaterialMovements'], $materialCode, $jwtToken);
                    if (($svc2['success'] ?? false) && isset($svc2['data'])) {
                        $movements = $svc2['data'];
                    }
                } catch (\Throwable $t) {}
            }

            // Normalizar a estructura común
            $normalized = [];
            if (is_array($movements)) {
                foreach ($movements as $mv) {
                    if (is_string($mv)) {
                        $tipoStr = strtolower($mv);
                        $tipo = (str_contains($tipoStr, 'entrada') || $tipoStr === 'in') ? 'Entrada' : ((str_contains($tipoStr, 'salida') || $tipoStr === 'out') ? 'Salida' : ucfirst($mv));
                        $normalized[] = [
                            'fecha' => null,
                            'fecha_creacion' => null,
                            'fecha_actualizacion' => null,
                            'tipo' => $tipo,
                            'type_key' => $tipoStr === 'in' ? 'entrada' : ($tipoStr === 'out' ? 'salida' : $tipoStr),
                            'cantidad' => null,
                            'usuario' => null,
                        ];
                        continue;
                    }

                    $tipoRaw = (string)($mv['tipo'] ?? $mv['type'] ?? '');
                    $tipoLow = strtolower($tipoRaw);
                    $typeKey = $tipoLow === '' ? '' : ((str_contains($tipoLow, 'entrada') || $tipoLow === 'in') ? 'entrada' : ((str_contains($tipoLow, 'salida') || $tipoLow === 'out') ? 'salida' : $tipoLow));
                    $tipo = $typeKey === '' ? '—' : ucfirst($typeKey);

                    // Fechas: creación y actualización (si existen)
                    $createdRaw = $mv['fecha'] ?? $mv['date'] ?? $mv['created_at'] ?? $mv['createdAt'] ?? $mv['timestamp'] ?? $mv['time'] ?? null;
                    $updatedRaw = $mv['updated_at'] ?? $mv['updatedAt'] ?? null;
                    $fechaDisplay = $updatedRaw ?: $createdRaw;
                    try { $fechaFmt = $fechaDisplay ? Carbon::parse($fechaDisplay)->format('d/m/Y H:i') : null; } catch (\Exception $e) { $fechaFmt = is_string($fechaDisplay) ? $fechaDisplay : null; }
                    try { $createdFmt = $createdRaw ? Carbon::parse($createdRaw)->format('d/m/Y H:i') : null; } catch (\Exception $e) { $createdFmt = is_string($createdRaw) ? $createdRaw : null; }
                    try { $updatedFmt = $updatedRaw ? Carbon::parse($updatedRaw)->format('d/m/Y H:i') : null; } catch (\Exception $e) { $updatedFmt = is_string($updatedRaw) ? $updatedRaw : null; }
                    $cantidad = $mv['cantidad'] ?? $mv['cantidad_total'] ?? $mv['quantity'] ?? $mv['qty'] ?? null;
                    // Usuario puede venir como string, objeto o campos separados
                    if (isset($mv['usuario'])) {
                        $usuario = is_array($mv['usuario']) ? ($mv['usuario']['nombre'] ?? $mv['usuario']['name'] ?? $mv['usuario']['email'] ?? null) : $mv['usuario'];
                    } elseif (isset($mv['user'])) {
                        $usuario = is_array($mv['user']) ? ($mv['user']['nombre'] ?? $mv['user']['name'] ?? $mv['user']['email'] ?? null) : $mv['user'];
                    } else {
                        $usuario = $mv['usuario_nombre'] ?? $mv['usuario_email'] ?? null;
                    }

                    $normalized[] = [
                        'fecha' => $fechaFmt, // preferimos actualización si existe
                        'fecha_creacion' => $createdFmt,
                        'fecha_actualizacion' => $updatedFmt,
                        'tipo' => $tipo,
                        'type_key' => $typeKey,
                        'cantidad' => $cantidad,
                        'usuario' => $usuario,
                    ];
                }
            }

            // Si solo obtuvimos tipos sin detalles pero tenemos datos de nivel superior del material, crear un registro enriquecido
            $needsEnrich = empty($normalized) || (isset($normalized[0]) && ($normalized[0]['cantidad'] === null && $normalized[0]['usuario'] === null && $normalized[0]['fecha'] === null));
            if ($needsEnrich && is_array($materialSelected)) {
                $tipoRawTop = $materialSelected['tipo'] ?? $materialSelected['movement_type'] ?? null;
                if (!$tipoRawTop) {
                    // usar primer tipo si viene como string
                    if (isset($movements[0]) && is_string($movements[0])) { $tipoRawTop = $movements[0]; }
                }
                $tipoLowTop = strtolower((string)$tipoRawTop);
                $typeKeyTop = $tipoLowTop === '' ? '' : ((str_contains($tipoLowTop, 'entrada') || $tipoLowTop === 'in') ? 'entrada' : ((str_contains($tipoLowTop, 'salida') || $tipoLowTop === 'out') ? 'salida' : $tipoLowTop));
                $tipoTop = $typeKeyTop === '' ? '—' : ucfirst($typeKeyTop);

                $createdRawTop = $materialSelected['fecha'] ?? $materialSelected['date'] ?? $materialSelected['created_at'] ?? $materialSelected['createdAt'] ?? $materialSelected['timestamp'] ?? null;
                $updatedRawTop = $materialSelected['updated_at'] ?? $materialSelected['updatedAt'] ?? null;
                $displayTop = $updatedRawTop ?: $createdRawTop;
                try { $fechaFmtTop = $displayTop ? Carbon::parse($displayTop)->format('d/m/Y H:i') : null; } catch (\Exception $e) { $fechaFmtTop = is_string($displayTop) ? $displayTop : null; }
                try { $createdFmtTop = $createdRawTop ? Carbon::parse($createdRawTop)->format('d/m/Y H:i') : null; } catch (\Exception $e) { $createdFmtTop = is_string($createdRawTop) ? $createdRawTop : null; }
                try { $updatedFmtTop = $updatedRawTop ? Carbon::parse($updatedRawTop)->format('d/m/Y H:i') : null; } catch (\Exception $e) { $updatedFmtTop = is_string($updatedRawTop) ? $updatedRawTop : null; }

                $cantidadTop = $materialSelected['cantidad'] ?? $materialSelected['quantity'] ?? null;
                $usuarioTop = $materialSelected['usuario'] ?? ($materialSelected['user']['name'] ?? ($materialSelected['user']['email'] ?? null)) ?? $materialSelected['usuario_nombre'] ?? null;

                $normalized = [[
                    'fecha' => $fechaFmtTop,
                    'fecha_creacion' => $createdFmtTop,
                    'fecha_actualizacion' => $updatedFmtTop,
                    'tipo' => $tipoTop,
                    'type_key' => $typeKeyTop,
                    'cantidad' => $cantidadTop,
                    'usuario' => $usuarioTop,
                ]];
            }

            return response()->json([
                'success' => true,
                'material_id' => $id,
                'movements' => $normalized,
            ]);

        } catch (\Throwable $e) {
            Log::error('Error en historialMovimientos: '.$e->getMessage(), ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener movimientos',
            ], 500);
        }
    }
}
