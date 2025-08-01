<x-app-layout>
    <div class="p-6 relative">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded" title="Página para gestionar los almacenes">ALMACENES</h1>
            <a href="{{ route('almacenes.crear') }}"
                class="px-4 py-2 bg-[#2045c2] text-white rounded-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150"
                title="Agregar un nuevo almacén">
                Nuevo Almacén
            </a>
        </div>

        <!-- Búsqueda y Filtros (Opcional, similar a trabajadores) -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative flex">
                        <input type="text" placeholder="Buscar por nombre o dirección..."
                            class="w-full h-10 pl-10 pr-4 rounded-l-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            title="Ingrese el nombre o dirección del almacén que desea buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <button type="button"
                            class="h-10 px-4 bg-[#2045c2] text-white rounded-r-lg hover:bg-[#1a3aa3] shadow-md"
                            title="Iniciar búsqueda con los criterios ingresados">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Almacenes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#e6ebfa]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre del almacén">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Dirección física del almacén">Dirección</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Número total de estantes en el almacén">Estantes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Cantidad de trabajadores asignados a este almacén">Trabajadores Asignados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Opciones para editar o eliminar">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Ejemplo de datos estáticos para almacenes --}}
                        @php
                            $almacenes = [
                                ['id' => 1, 'nombre' => 'Almacén Principal (JW1)', 'direccion' => '', 'estantes' => 10, 'trabajadores' => 5],
                                ['id' => 2, 'nombre' => 'Almacén Secundario (JW2)', 'direccion' => '', 'estantes' => 8, 'trabajadores' => 3],
                                ['id' => 3, 'nombre' => 'Almacén de Materiales Especiales (JW3)', 'direccion' => '', 'estantes' => 5, 'trabajadores' => 2],
                            ];
                        @endphp

                        @if(isset($almacenes) && count($almacenes) > 0)
                            @foreach ($almacenes as $almacen)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $almacen['nombre'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $almacen['direccion'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $almacen['estantes'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $almacen['trabajadores'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('almacenes.edit', ['id' => $almacen['id']]) }}" class="inline-block text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150" title="Editar información del almacén">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                         <!-- Estos formularios son solo para visualización, no tienen funcionalidad de backend  -->
                                        <form action="#" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar este almacén? Esto también podría afectar a los trabajadores y materiales asignados.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block text-red-600 hover:text-red-900 transition-colors duration-150" title="Eliminar almacén del sistema">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No hay almacenes registrados.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Fondo de pantalla con imagen -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/imgalma.jpg') }}');
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
            const mainContainer = document.querySelector('.p-6');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(19, 18, 18, 0.4)'; /* Fondo semitransparente */
            }
        });
    </script>
</x-app-layout>
