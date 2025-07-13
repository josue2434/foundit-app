<x-app-layout>
    <div class="p-6">
        <!-- Header simple -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">REPORTES</h1>
        </div>
        <!-- Panel de filtros simplificado -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Filtro de período -->
                <div>
                    <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                    <select id="period" class="w-full h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Selecciona el período de tiempo para filtrar los movimientos">
                        <option value="day">Hoy</option>
                        <option value="week">Esta semana</option>
                        <option value="month" selected>Este mes</option>
                        <option value="all">Todos</option>
                    </select>
                </div>
                <!-- Filtro de tipo de movimiento -->
                <div>
                    <label for="movement_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de movimiento</label>
                    <select id="movement_type" class="w-full h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtra por entradas o salidas de inventario">
                        <option value="">Todos los movimientos</option>
                        <option value="entrada">Entradas</option>
                        <option value="salida">Salidas</option>
                    </select>
                </div>
                <!-- Búsqueda por código o nombre -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar material</label>
                    <div class="relative">
                        <input type="text" id="search" placeholder="Código o nombre..." class="w-full h-10 pl-10 pr-4 rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Busca por código o nombre del material">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Botón de aplicar filtros -->
            <div class="mt-4">
                <button type="button" class="h-10 px-6 bg-[#2045c2] text-white rounded-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150" title="Aplicar los filtros seleccionados">
                    Filtrar
                </button>
            </div>
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
                        <!-- Fila de ejemplo 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT001</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cable HDMI 2m</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Material ingresado al inventario">
                                    Entrada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">50</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT001')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Cable HDMI 2m">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 2 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">14/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT002</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tornillo hexagonal 10mm</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Material retirado del inventario">
                                    Salida
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">200</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW2</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT002')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Tornillo hexagonal 10mm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 3 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT003</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Multímetro digital</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Material ingresado al inventario">
                                    Entrada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT003')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Multímetro digital">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 4 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT004</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Destornillador Phillips</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Material retirado del inventario">
                                    Salida
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW4</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT004')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Destornillador Phillips">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 5 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">11/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT005</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Batería recargable AA</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Material ingresado al inventario">
                                    Entrada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT005')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Batería recargable AA">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 6 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT006</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cable de red 3m</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Material ingresado al inventario">
                                    Entrada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW1</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT006')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Cable de red 3m">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 7 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">09/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT007</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cinta aislante</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Material retirado del inventario">
                                    Salida
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW2</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT007')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Cinta aislante">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 8 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">08/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT008</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tuerca hexagonal 8mm</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Material ingresado al inventario">
                                    Entrada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">500</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW2</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT008')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Tuerca hexagonal 8mm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 9 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT009</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lámpara LED 10W</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" title="Material retirado del inventario">
                                    Salida
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW3</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT009')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Lámpara LED 10W">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Fila de ejemplo 10 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">06/06/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT010</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cinta métrica 5m</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" title="Material ingresado al inventario">
                                    Entrada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">JW4</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Botón para ver historial -->
                                <button type="button" onclick="openHistoryModal('MAT010')" class="text-[#2045c2] hover:text-[#1a3aa3]" title="Ver historial completo de Cinta métrica 5m">
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
        // Función para abrir el modal de historial
        function openHistoryModal(code) {
            // Prevenir comportamiento por defecto si está dentro de un formulario
            event && event.preventDefault();
            // Llamar a la función del modal de movimientos
            if (typeof openMovementsModal === 'function') {
                openMovementsModal(code);
            } else {
                console.error('La función openMovementsModal no está definida');
            }
        }
    </script>
</x-app-layout>
