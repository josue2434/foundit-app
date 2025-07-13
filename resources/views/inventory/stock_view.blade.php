<x-app-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <!-- Título con fondo semitransparente para mejor legibilidad -->
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">GESTIÓN ALMACÉN</h1>
        </div>
        <!-- Búsqueda y Filtros -->
        <div class="mb-6 card bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Búsqueda - Campo de texto con botón para buscar materiales -->
                <div class="flex-1">
                    <form action="#" method="GET">
                        <!-- Formulario de búsqueda con icono integrado -->
                        <div class="relative flex">
                            <input
                                type="text"
                                id="searchInput"
                                name="busqueda"
                                placeholder="Buscar por código o nombre..."
                                class="w-full h-10 pl-10 pr-4 rounded-l-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                title="Ingrese el código o nombre del material que desea buscar"
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
                                class="h-10 px-4 bg-[#2045c2] text-white rounded-r-lg hover:bg-[#1a3aa3] shadow-md"
                                title="Iniciar búsqueda con los criterios ingresados"
                            >
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Filtros - Selectores para filtrar por diferentes criterios -->
                <div class="flex flex-wrap gap-4">
                    <!-- Selector de categorías -->
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtrar materiales por categoría">
                        <option value="">Todas las categorías</option>
                        <option value="ferreteria">Ferretería</option>
                        <option value="electronica">Electrónica</option>
                        <option value="herramientas">Herramientas</option>
                    </select>
                    <!-- Selector de ordenamiento -->
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Cambiar el orden de visualización de los materiales">
                        <option value="">Ordenar por</option>
                        <option value="codigo">Código</option>
                        <option value="nombre">Nombre</option>
                        <option value="ubicacion">Ubicación</option>
                    </select>
                    <!-- Selector de almacenes -->
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtrar materiales por almacén">
                        <option value="">Todos los almacenes</option>
                        <option value="JW1">JW1</option>
                        <option value="JW2">JW2</option>
                        <option value="JW3">JW3</option>
                        <option value="JW4">JW4</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Materiales con ubicación - Sección principal que muestra el inventario ubicado -->
        <div>
            <!-- Título de la sección con color azul corporativo -->
            <h2 class="text-lg font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded mb-4">INVENTARIO</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <!-- Tabla de materiales con ubicación -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Encabezados de la tabla -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Código único del material">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Código de barras para escaneo">Barcode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre descriptivo del material">Material</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Clasificación del material">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Cantidad disponible">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Identificador del almacén">Almacén</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Ubicación física completa (pasillo-columna-fila)">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Opciones disponibles para este material">Acciones</th>
                            </tr>
                        </thead>
                        <!-- Cuerpo de la tabla con datos de ejemplo -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Ejemplo de fila de material -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="w-32 h-8 bg-gray-200 rounded flex items-center justify-center text-xs">
                                        Código de Barras
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tornillo Phillips</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ferretería</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="Pasillo P1, Columna A, Fila 1">P1-A-1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <!-- Botón para ver historial -->
                                    <button onclick="openHistoryModal('MAT001')" class="text-[#2045c2] hover:text-[#ff3333]" title="Ver historial de movimientos del material">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Mensaje cuando no hay inventario -->
                    <div class="p-4 text-center text-gray-500 hidden" id="no-inventory">
                        <p>NO HAY INVENTARIO PARA MOSTRAR.</p>
                    </div>
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
        });
        // Alias para mantener compatibilidad con el código anterior
        function openHistoryModal(code) {
            openMovementsModal(code);
        }
    </script>
</x-app-layout>
