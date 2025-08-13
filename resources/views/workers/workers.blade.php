<x-app-layout>
    <div class="p-6 relative">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded" title="Página para gestionar la información de los trabajadores">TRABAJADORES</h1>
            <a href="{{ route('getAlmacenes') }}"
                class="px-4 py-2 bg-[#2045c2] text-white rounded-lg hover:bg-[#1a3aa3] shadow-md transition-colors duration-150"
                title="Registrar un nuevo trabajador">
                Nuevo Empleado
            </a>
        </div>

        <!-- Búsqueda y Filtros -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('view_workers') }}" class="flex flex-col md:flex-row gap-4" id="filtersForm">
                <!-- Búsqueda por nombre o correo (solo UI por ahora) -->
                <div class="flex-1">
                    <div class="relative flex">
                        <input name="q" value="{{ request('q') }}" type="text" placeholder="Buscar por nombre o correo..."
                            class="w-full h-10 pl-10 pr-4 rounded-l-lg border border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            title="Ingrese el nombre o correo del trabajador que desea buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-[#2045c2]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <button type="submit"
                            class="h-10 px-4 bg-[#2045c2] text-white rounded-r-lg hover:bg-[#1a3aa3] shadow-md"
                            title="Iniciar búsqueda con los criterios ingresados">
                            Buscar
                        </button>
                    </div>
                </div>
                <!-- Filtro por puesto -->
                <select name="puesto" class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtrar trabajadores por puesto" onchange="document.getElementById('filtersForm').submit()">
                    <option value="" {{ request('puesto')==='' ? 'selected' : '' }}>Todos los puestos</option>
                    <option value="operador" {{ request('puesto')==='operador' ? 'selected' : '' }}>Operador</option>
                    <option value="admin" {{ request('puesto')==='admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                <!-- Filtro por estado -->
                <select name="estado" class="h-10 rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50" title="Filtrar trabajadores por estado (activo/inactivo)" onchange="document.getElementById('filtersForm').submit()">
                    <option value="" {{ request('estado')==='' ? 'selected' : '' }}>Todos los estados</option>
                    <option value="activo" {{ request('estado')==='activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado')==='inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </form>
        </div>

        <!-- Tabla de Trabajadores -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#e6ebfa]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Nombre completo del trabajador">Nombre Completo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Correo electrónico del trabajador">Correo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Rol del trabajador en el sistema">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Estado actual del trabajador (activo/inactivo)">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" title="Opciones para editar o eliminar">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(isset($users) && count($users) > 0)
                            @foreach ($users as $user )
                            
                            <!-- Fila de ejemplo 1 -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user['name'] ?? 'N/A'}} {{$user['apellido'] ?? ''}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user['email'] ?? 'N/A'}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$user['tipo'] ?? 'N/A'}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $estado = $user['estado'] ?? $user['activo'] ?? 'activo';
                                        $isActive = (strtolower($estado) === 'activo' || $estado === true || $estado === 1);
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $isActive ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('edit_workers', ['id' => $user['_id'] ?? 1]) }}" class="inline-block text-[#2045c2] hover:text-[#1a3aa3] transition-colors duration-150" title="Editar información del trabajador">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('deleteUser', $user['_id']) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar este empleado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block text-red-600 hover:text-red-900 transition-colors duration-150" title="Eliminar trabajador del sistema">
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
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    @if(isset($error))
                                        <div class="text-red-600">{{ $error }}</div>
                                    @else
                                        No hay usuarios registrados.
                                    @endif
                                </td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- De aqui es el codigo para el fondo de pantalla img pantalla completa -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/rh.jpg') }}');
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
        });
    </script>
</x-app-layout>
