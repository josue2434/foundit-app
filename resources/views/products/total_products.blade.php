<x-app-layout>
    <div class="p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-80 px-4 py-2 rounded-lg shadow-sm" title="">MATERIALES TOTALES</h1>
        </div>

        <!-- Barra de búsqueda y filtros -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="relative flex">
                        <input
                            type="text"
                            placeholder="Buscar por código o nombre..."
                            class="w-full h-10 pl-10 pr-4 rounded-l-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                        >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <button
                            type="button"
                            class="h-10 px-4 bg-[#2045c2] text-white rounded-r-lg hover:bg-[#1a3aa3] shadow-md"
                        >
                            Buscar
                        </button>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4">
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50 min-w-[180px]">
                        <option value="">Todas las categorías</option>
                        <option value="electronica">Electrónica</option>
                        <option value="ferreteria">Ferretería</option>
                        <option value="herramientas">Herramientas</option>
                    </select>
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50 min-w-[180px]">
                        <option value="">Ordenar por</option>
                        <option value="codigo">Código</option>
                        <option value="nombre">Nombre</option>
                        <option value="stock">Stock</option>
                    </select>
                    <select class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50 min-w-[180px]">
                        <option value="">Todos los almacenes</option>
                        <option value="JW1">JW1</option>
                        <option value="JW2">JW2</option>
                        <option value="JW3">JW3</option>
                        <option value="JW4">JW4</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Sección: Materiales Caros -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-80 px-4 py-2 rounded-lg shadow-sm mb-4" title="">Materiales de Alto Valor:</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#e6ebfa]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left"></th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Almacén</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT010</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Microcontrolador ARM</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Electronica</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW2</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">D-01-01</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT010')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT011</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sensor de Presión Industrial</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Electronica</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">D-01-02</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT011')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección: Materiales Críticos -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-80 px-4 py-2 rounded-lg shadow-sm mb-4">Materiales B. Inventario:</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#e6ebfa]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left"></th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Almacén</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT007</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">HP-09-LOL</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Electrónica</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">9</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW2</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">P2-B-2</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT007')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT005</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Resistencias 10K</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Electrónica</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">C-02-04</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT005')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección: Ferretería -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-80 px-4 py-2 rounded-lg shadow-sm mb-4">Ferretería:</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#e6ebfa]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left"></th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Almacén</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tornillos M4</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ferretería</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">50</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A-01-02</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT001')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tuercas M4</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ferretería</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A-01-03</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT002')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección: Herramientas -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-80 px-4 py-2 rounded-lg shadow-sm mb-4">Herramientas:</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#e6ebfa]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left"></th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Almacén</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT020</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Destornillador Precisión</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Herramientas</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW3</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">F-01-01</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT020')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT021</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Alicate de Corte</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Herramientas</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW2</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">F-01-02</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openHistoryModal('MAT021')"
                                        class="text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluir el modal de movimientos -->
    @include('layouts.movements_modal')
    <!-- De aqui es el codigo para el fondo de pantalla img pantalla completa -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/totale.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -9999;
        pointer-events: none;
    "></div>
    @push('scripts')
    <script>
        // Alias para mantener compatibilidad con el código anterior
        function openHistoryModal(code) {
            openMovementsModal(code);
        }

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
    </script>
    @endpush
</x-app-layout>
