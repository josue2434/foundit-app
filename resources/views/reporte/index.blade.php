<x-app-layout>
    <div class="p-6">
        <!-- Header simple -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">REPORTES</h1>
        </div>
        @php
            // Acepta distintos nombres de variable desde el controlador de forma robusta
            $movements = $movements ?? $reportItems ?? $items ?? $data ?? $materiales ?? [];
        @endphp
        <!-- Panel de filtros simplificado -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <form id="reportsFiltersForm" action="{{ route('getReporte') }}" method="GET">
                <input type="hidden" id="reportsExportFlag" name="export" value="">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filtro de período -->
                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                        <select id="period" name="period" class="w-full h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Selecciona el período de tiempo para filtrar los movimientos">
                            @php $period = request('period', 'month'); @endphp
                            <option value="day" {{ $period === 'day' ? 'selected' : '' }}>Hoy</option>
                            <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Esta semana</option>
                            <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Este mes</option>
                            <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Todos</option>
                        </select>
                    </div>
                    <!-- Filtro de tipo de movimiento -->
                    <div>
                        <label for="movement_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de movimiento</label>
                        <select id="movement_type" name="movement_type" class="w-full h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtra por entradas o salidas de inventario">
                            @php $mt = request('movement_type', ''); @endphp
                            <option value="" {{ $mt === '' ? 'selected' : '' }}>Todos los movimientos</option>
                            <option value="entrada" {{ $mt === 'entrada' ? 'selected' : '' }}>Entradas</option>
                            <option value="salida" {{ $mt === 'salida' ? 'selected' : '' }}>Salidas</option>
                        </select>
                    </div>
                    <!-- Búsqueda por código o nombre -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar material</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search', '') }}" placeholder="Código o nombre..." class="w-full h-10 pl-10 pr-4 rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Busca por código o nombre del material">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Botón de aplicar filtros -->
                <div class="mt-4 flex items-center gap-3">
                    <button type="submit" id="reportsFiltersSubmit" class="h-10 px-6 bg-[#2045c2] text-white rounded-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150 flex items-center" title="Aplicar los filtros seleccionados">
                        <span id="reportsFiltersSubmitText">Filtrar</span>
                        <span id="reportsFiltersSpinner" class="hidden ml-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                    <button type="button" id="reportsExportBtn" class="h-10 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md transition-colors duration-150" title="Generar reporte en CSV con los filtros actuales">
                        Generar reporte
                    </button>
                    @if(request()->hasAny(['period','movement_type','search']))
                        <a href="{{ route('getReporte') }}" class="h-10 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-150">Limpiar</a>
                    @endif
                </div>
            </form>
        </div>
        <!-- Tabla de movimientos simplificada -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Fecha del movimiento">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Código único del material">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre del material">Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Tipo de movimiento: entrada o salida">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Cantidad de unidades">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Ubicación del almacén">Almacén</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Ver historial completo del material">Historial</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $isEmpty = (is_array($movements) && count($movements) === 0) || ($movements instanceof \Illuminate\Support\Collection && $movements->isEmpty()); @endphp
                        @forelse($movements as $m)
                            @php
                                // Fecha: incluye 'timestamp' como posible fuente
                                $fecha = data_get($m, 'fecha') ?? data_get($m, 'date') ?? data_get($m, 'created_at') ?? data_get($m, 'timestamp');
                                try { $fechaFmt = $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y') : ''; } catch (\Exception $e) { $fechaFmt = (string) $fecha; }

                                // Código: usa '_id' si no existe codigo/code
                                $codigo = data_get($m, 'codigo') ?? data_get($m, 'code') ?? data_get($m, 'material.codigo') ?? data_get($m, 'material.code') ?? data_get($m, '_id');

                                // Nombre del material
                                $nombre = data_get($m, 'material') ?? data_get($m, 'nombre') ?? data_get($m, 'material.nombre') ?? data_get($m, 'material.name');

                                // Tipo de movimiento: intenta en campos directos o desde el último elemento de 'movimiento'
                                $tipoRaw = (string) (data_get($m, 'tipo') ?? data_get($m, 'movement_type') ?? '');
                                if ($tipoRaw === '') {
                                    $movs = data_get($m, 'movimiento') ?? data_get($m, 'movements');
                                    if (is_array($movs) && !empty($movs)) {
                                        $ultimo = end($movs);
                                        $tipoRaw = (string) (data_get($ultimo, 'tipo') ?? data_get($ultimo, 'type') ?? '');
                                    }
                                }
                                $tipo = strtolower($tipoRaw);

                                // Cantidad y almacén
                                $cantidad = data_get($m, 'cantidad') ?? data_get($m, 'quantity');
                                $almacen = data_get($m, 'almacen') ?? data_get($m, 'warehouse');

                                // Badge visual para tipo
                                $isEntrada = str_contains($tipo, 'entrada') || $tipo === 'in' || $tipo === 'entrada';
                                $badgeClasses = $isEntrada
                                    ? 'bg-green-100 text-green-800'
                                    : (str_contains($tipo, 'salida') || $tipo === 'out' || $tipo === 'salida' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800');
                                $tipoLabel = $tipoRaw !== '' ? ($isEntrada ? 'Entrada' : ((str_contains($tipo, 'salida') || $tipo === 'out') ? 'Salida' : $tipoRaw)) : '—';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fechaFmt }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if(!empty($codigo))
                                        <svg class="barcode" data-code="{{ $codigo }}" role="img" aria-label="Código de barras de {{ $codigo }}" style="width: 240px; height: 34px; display: block;"></svg>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $nombre ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }}" title="Tipo de movimiento">
                                        {{ $tipoLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cantidad ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $almacen ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" onclick="openHistoryModal(@json($codigo), event)" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de {{ $nombre }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-sm text-gray-500">No hay resultados para los filtros aplicados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($movements instanceof \Illuminate\Pagination\Paginator || $movements instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $movements->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
        <!-- Incluir el modal de movimientos -->
        @include('layouts.movements_modal')
    </div>
    <!-- De aqui es el codigo para el fondo de pantalla img pantalla completa -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/prod1.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -9999;
        pointer-events: none;
    "></div>
    <!-- Librería de código de barras (cliente) -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);

            // fondo semitransparente
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(19, 18, 18, 0.4)';
            }

            // Añade efecto de hover a las filas de las tablas
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.classList.add('bg-gray-50');
                });
                row.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-gray-50');
                });
            });

            // Manejo del formulario de filtros (submit y spinner)
            const form = document.getElementById('reportsFiltersForm');
            const searchInput = document.getElementById('search');
            const submitBtn = document.getElementById('reportsFiltersSubmit');
            const submitText = document.getElementById('reportsFiltersSubmitText');
            const submitSpinner = document.getElementById('reportsFiltersSpinner');
            const exportBtn = document.getElementById('reportsExportBtn');
            const exportFlag = document.getElementById('reportsExportFlag');

            if (form) {
                form.addEventListener('submit', function(e) {
                    // Si hay campo de búsqueda vacío, no bloqueamos (es opcional)
                    submitBtn.disabled = true;
                    submitText.textContent = 'Filtrando...';
                    submitSpinner.classList.remove('hidden');
                });
            }

            if (searchInput) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        form && form.requestSubmit();
                    }
                    if (e.key === 'Escape') {
                        searchInput.value = '';
                        searchInput.focus();
                    }
                });
            }

            if (exportBtn && form && exportFlag) {
                exportBtn.addEventListener('click', function () {
                    const ok = window.confirm('¿Deseas generar el reporte con los filtros actuales?');
                    if (!ok) return;
                    // Marcar exportación y abrir en nueva pestaña
                    exportFlag.value = '1';
                    const prevTarget = form.getAttribute('target');
                    form.setAttribute('target', '_blank');
                    // Opcional: feedback visual breve
                    exportBtn.disabled = true;
                    setTimeout(() => { exportBtn.disabled = false; }, 1000);
                    form.submit();
                    // Revertir estado para futuras acciones normales
                    exportFlag.value = '';
                    if (prevTarget === null) form.removeAttribute('target'); else form.setAttribute('target', prevTarget);
                });
            }

            // Renderizar códigos de barras si hay elementos con class="barcode"
            const barcodeSvgs = document.querySelectorAll('svg.barcode');
            if (barcodeSvgs.length && typeof JsBarcode === 'function') {
                barcodeSvgs.forEach(svg => {
                    const val = svg.getAttribute('data-code');
                    if (val) {
                        try {
                            JsBarcode(svg, val, {
                                format: 'CODE128',
                                displayValue: true,
                                textPosition: 'bottom',
                                textMargin: 2,
                                fontSize: 10,
                                height: 30,
                                width: 1.0,
                                margin: 0
                            });
                        } catch (e) {
                            console.error('No se pudo generar el código de barras:', e);
                        }
                    }
                });
            }
        });
        // Función para abrir el modal de historial
        function openHistoryModal(code, e) {
            // Prevenir comportamiento por defecto si está dentro de un formulario
            if (e && typeof e.preventDefault === 'function') e.preventDefault();
            // Llamar a la función del modal de movimientos
            if (typeof openMovementsModal === 'function') {
                openMovementsModal(code);
            } else {
                console.error('La función openMovementsModal no está definida');
            }
        }
    </script>
</x-app-layout>
