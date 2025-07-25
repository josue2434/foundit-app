<x-app-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <!-- Título con fondo semitransparente para mejor legibilidad -->
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">GESTIÓN ALMACÉN</h1>
            
            <!-- Botón para ver todos los materiales -->
            <a href="{{ route('stock.view') }}" 
               class="bg-[#2045c2] hover:bg-[#1a3aa3] text-white px-4 py-2 rounded-lg transition-colors duration-150 shadow-md"
               title="Ver todos los materiales">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Ver Todos
            </a>
        </div>

        <!-- Mostrar mensaje de búsqueda si existe -->
        @if(isset($search_term) && !empty($search_term))
            <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="text-blue-800 font-medium">
                        Resultados de búsqueda para: "{{ $search_term }}"
                    </span>
                </div>
                @if(isset($mensaje))
                    <p class="text-blue-700 mt-1 text-sm">{{ $mensaje }}</p>
                @endif
            </div>
        @endif

        <!-- Búsqueda y Filtros -->
        <div class="mb-6 card bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Búsqueda - Campo de texto con botón para buscar materiales -->
                <div class="flex-1">
                    <form action="{{ route('materiales.buscar') }}" method="GET" id="searchForm">
                        <!-- Formulario de búsqueda con icono integrado -->
                        <div class="relative flex">
                            <input
                                type="text"
                                id="searchInput"
                                name="name"
                                value="{{ $search_term ?? '' }}"
                                placeholder="Buscar por código o nombre..."
                                class="w-full h-10 pl-10 pr-4 rounded-l-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                title="Ingrese el código o nombre del material que desea buscar"
                                required
                            >
                            <!-- Icono de lupa para la búsqueda -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <!-- Botón de búsqueda -->
                            <button
                                type="submit"
                                id="searchButton"
                                class="h-10 px-4 bg-[#2045c2] text-white rounded-r-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150 flex items-center"
                                title="Iniciar búsqueda con los criterios ingresados"
                            >
                                <span id="searchButtonText">Buscar</span>
                                <div id="searchSpinner" class="hidden ml-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Filtros - Selectores para filtrar por diferentes criterios -->
                <div class="flex flex-wrap gap-4">
                    <!-- Selector de almacenes -->
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtrar materiales por almacén">
                        <option value="">Todos los almacenes</option>
                        <option value="almacen">Almacén</option>
                        <option value="homeoffice">Almacen de HomeOffice</option>
                    </select>
                    <!-- Selector de movimientos -->
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtrar por tipo de movimiento">
                        <option value="">Todos los movimientos</option>
                        <option value="entrada">Entrada</option>
                        <option value="salida">Salida</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Materiales con ubicación - Sección principal que muestra el inventario ubicado -->
        <div>
            <!-- Título de la sección con color azul corporativo -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">
                    @if(isset($search_term) && !empty($search_term))
                        RESULTADOS DE BÚSQUEDA
                    @else
                        INVENTARIO
                    @endif
                </h2>
                
                @if(isset($materiales) && count($materiales) > 0)
                    <span class="text-sm text-gray-600 bg-white bg-opacity-40 px-3 py-1 rounded">
                        {{ count($materiales) }} material(es) encontrado(s)
                    </span>
                @endif
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <!-- Tabla de materiales con ubicación -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Encabezados de la tabla -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre del material">Material</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Descripción del material">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Cantidad disponible">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Ubicación física">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre del almacén">Almacén</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Estante donde se encuentra">Estante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Último movimiento">Movimiento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Opciones disponibles">Acciones</th>
                            </tr>
                        </thead>
                        <!-- Cuerpo de la tabla con datos reales -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if(isset($materiales) && count($materiales) > 0)
                                @foreach ($materiales as $material)
                                <!-- Fila de material real -->
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if(isset($search_term) && !empty($search_term))
                                            {!! str_ireplace($search_term, '<mark class="bg-yellow-200 px-1 rounded">' . $search_term . '</mark>', $material['name'] ?? 'N/A') !!}
                                        @else
                                            {{ $material['name'] ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if(isset($search_term) && !empty($search_term))
                                            {!! str_ireplace($search_term, '<mark class="bg-yellow-200 px-1 rounded">' . $search_term . '</mark>', $material['description'] ?? 'N/A') !!}
                                        @else
                                            {{ $material['description'] ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                            {{ $material['cantidad'] ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $material['ubicacion'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $material['almacen']['name'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $material['estante']['name'] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if(isset($material['movimientos']) && count($material['movimientos']) > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $material['movimientos'][0] === 'entrada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($material['movimientos'][0]) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <!-- Botón para ver historial -->
                                        <button onclick="openHistoryModal('{{ $material['_id'] ?? 'N/A' }}')" class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150" title="Ver historial de movimientos del material">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        @if(isset($error))
                                            <div class="text-red-600 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $error }}
                                            </div>
                                        @elseif(isset($search_term) && !empty($search_term))
                                            <div class="text-gray-500 flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                                <p class="text-lg font-medium">No se encontraron materiales</p>
                                                <p class="text-sm">No hay materiales que coincidan con "{{ $search_term }}"</p>
                                                <a href="{{ route('stock.view') }}" class="mt-2 text-[#2045c2] hover:underline">Ver todos los materiales</a>
                                            </div>
                                        @else
                                            <div class="text-gray-500 flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <p class="text-lg font-medium">No hay materiales registrados</p>
                                                <p class="text-sm">Aún no se han registrado materiales en el sistema</p>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Incluir el modal de movimientos -->
        @include('layouts.movements_modal')
    </div>
    <!-- De aquí es el código para el fondo de pantalla img pantalla completa -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/pexels.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -9999;
        pointer-events: none;
    "></div>
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

            // Configuración del formulario de búsqueda
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const searchButtonText = document.getElementById('searchButtonText');
            const searchSpinner = document.getElementById('searchSpinner');

            // Enfocar automáticamente el campo de búsqueda si está vacío
            if (searchInput && !searchInput.value.trim()) {
                searchInput.focus();
            }

            // Manejar el envío del formulario de búsqueda
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    const searchTerm = searchInput.value.trim();
                    
                    if (!searchTerm) {
                        e.preventDefault();
                        alert('Por favor ingrese un término de búsqueda');
                        searchInput.focus();
                        return false;
                    }

                    // Mostrar spinner durante la búsqueda
                    searchButton.disabled = true;
                    searchButtonText.textContent = 'Buscando...';
                    searchSpinner.classList.remove('hidden');
                });
            }

            // Permitir búsqueda al presionar Enter en el campo de búsqueda
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchForm.dispatchEvent(new Event('submit'));
                    }
                });

                // Limpiar búsqueda con Escape
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        searchInput.value = '';
                        searchInput.focus();
                    }
                });
            }

            // Botón para limpiar búsqueda (si hay término de búsqueda activo)
            @if(isset($search_term) && !empty($search_term))
                const clearSearchButton = document.createElement('button');
                clearSearchButton.innerHTML = '✕ Limpiar';
                clearSearchButton.className = 'ml-2 px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded transition-colors duration-150';
                clearSearchButton.onclick = function() {
                    window.location.href = '{{ route("stock.view") }}';
                };
                searchButton.parentNode.appendChild(clearSearchButton);
            @endif
        });

        // Alias para mantener compatibilidad con el código anterior
        function openHistoryModal(code) {
            openMovementsModal(code);
        }
    </script>
</x-app-layout>
