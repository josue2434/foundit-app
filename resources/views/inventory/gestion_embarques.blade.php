<x-app-layout>
    <div class="p-6">
        <!-- Encabezado - Con fondo blanco más tenue -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded" title="Página para gestionar la recepción y entrada de materiales al almacén">RECIBO/ENTRADA</h1>
        </div>
        <!-- Sección de localización de material - Diseño mejorado -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-[#2045c2] mb-4" title="Herramientas para buscar y filtrar materiales existentes">Localizar material</h2>
                    <div class="flex gap-4 flex-col md:flex-row">
                        <!-- Búsqueda -->
                        <div class="flex-1">
                            <form action="#" method="GET">
                                <div class="relative flex">
                                    <input
                                        type="text"
                                        id="searchInput"
                                        name="búsqueda"
                                        class="w-full h-10 pl-10 pr-4 rounded-l-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                        placeholder="Buscar por código o nombre..."
                                        title="Ingrese el código o nombre del material que desea buscar"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <button
                                        class="h-10 px-4 bg-[#2045c2] text-white rounded-r-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150"
                                        title="Iniciar búsqueda con los criterios ingresados"
                                    >
                                        Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- Filtros -->
                        <div class="flex gap-4 md:w-auto">
                            <select
                                class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                title="Filtrar materiales por categoría"
                            >
                                <option value="">Todas las categorías</option>
                                <option value="ferreteria" title="Materiales de ferretería como tornillos, tuercas, etc.">Ferretería</option>
                                <option value="electronica" title="Componentes electrónicos como cables, conectores, etc.">Electrónica</option>
                                <option value="herramientas" title="Herramientas de trabajo como destornilladores, llaves, etc.">Herramientas</option>
                            </select>
                            <select
                                class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                title="Cambiar el orden de visualización de los materiales"
                            >
                                <option value="">Ordenar por</option>
                                <option value="codigo" title="Ordenar alfabéticamente por código">Código</option>
                                <option value="nombre" title="Ordenar alfabéticamente por nombre">Nombre</option>
                                <option value="ubicacion" title="Ordenar por ubicación en el almacén">Ubicación</option>
                            </select>
                        </div>
                        <!-- Botón Material -->
                        <a
                            href="{{ route('register_form') }}"
                            class="h-10 px-6 bg-[#2045c2] text-white rounded-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150 flex items-center justify-center"
                            title="Registrar un nuevo material en el sistema"
                        >
                            Nuevo material
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Materiales sin ubicación - Sección que muestra materiales pendientes de ubicar -->
        <div class="mb-8">
            <!-- Título de la sección con color rojo para destacar la atención requerida -->
            <h2 class="text-lg font-semibold text-[#ff3333] inline-block bg-white bg-opacity-40 px-4 py-2 rounded mb-4">Materiales Sin Ubicación</h2>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="overflow-x-auto">
                    <!-- Tabla de materiales sin ubicación -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Encabezados de la tabla -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Código único del material">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre descriptivo del material">Material</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Clasificación del material">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Cantidad disponible">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Ubicación física (pendiente de asignar)">Ubicación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Opciones disponibles para este material">Acciones</th>
                            </tr>
                        </thead>
                        <!-- Cuerpo de la tabla con datos dinámicos -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Ejemplo de fila de material sin ubicación -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MAT001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tornillo Phillips</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ferretería</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">UBICACION PENDIENTE</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <!-- Botón para ver historial -->
                                    <button type="button" onclick="openHistoryModal('MAT001')" class="text-[#2045c2] hover:text-[#ff3333] inline-block" title="Ver historial de movimientos del material">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <!-- Botón para asignar ubicación -->
                                    <a href="{{ route('register_location') }}" class="text-[#2045c2] hover:text-[#ff3333]" title="Asignar ubicación física al material">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Mensaje cuando no hay materiales sin ubicación -->
                    <p class="p-4 text-gray-500">NO HAY MATERIALES SIN UBICACION.</p>
                </div>
            </div>
        </div>
        <!-- Modal de Edición -->
        <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"></div>
        <!-- Modal de Nuevo Material -->
        <div id="newMaterialModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"></div>
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
        background-image: url('{{ asset('img/imgingreso.jpg') }}');
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
            // Fondo semitransparente
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(19, 18, 18, 0.4)';
            }
        });
        function openHistoryModal(code) {
            openMovementsModal(code);
        }
    </script>
</x-app-layout>
