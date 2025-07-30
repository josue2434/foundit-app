<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Edición de Empleado -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
            @php
                $userId = $user['_id'] ?? $user['id'] ?? null;
            @endphp
            
            @if($userId)
                <form action="{{ route('updateUser', $userId) }}" method="POST" class="p-8">
            @else
                <div class="p-8 text-center">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h3 class="text-red-800 font-medium">Error: No se puede editar el usuario</h3>
                        <p class="text-red-600 mt-2">No se encontró un ID válido para este usuario.</p>
                        <a href="{{ route('workers') }}" class="mt-4 inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Volver a la lista
                        </a>
                    </div>
                </div>
            @endif
            
            @if($userId)
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="text-center">
                        <h1 class="text-2xl font-semibold text-[#2045c2]">EDITAR TRABAJADOR</h1>
                        <p class="text-gray-600 mt-1">Modifique los detalles del trabajador</p>
                    </div>
                    
                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Nombre -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Nombre
                        </label>
                        <input 
                            type="text"
                            name="name"
                            value="{{ old('name', $user['name'] ?? '') }}"
                            placeholder="Ingrese el nombre completo"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]"
                            required
                            title="Modifique el nombre completo del trabajador"
                        >
                    </div>
                    
                    <!-- Apellido -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Apellido
                        </label>
                        <input 
                            type="text"
                            name="apellido"
                            value="{{ old('apellido', $user['apellido'] ?? '') }}"
                            placeholder="Ingrese el apellido completo"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]"
                            required
                            title="Modifique el apellido completo del trabajador"
                        >
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            type="email"
                            name="email"
                            value="{{ old('email', $user['email'] ?? '') }}"
                            placeholder="Ingrese el correo electrónico"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]"
                            required
                            title="Modifique el correo electrónico del trabajador"
                        >
                    </div>
                    <!-- Contraseña -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Contraseña (Dejar en blanco para mantener la actual)
                        </label>
                        <input 
                            type="password"
                            name="password"
                            placeholder="Ingrese la nueva contraseña"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]"
                            title="Deje este campo en blanco si no desea cambiar la contraseña actual"
                        >
                    </div>
                    <!-- Confirmar Contraseña -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Confirmar Contraseña
                        </label>
                        <input 
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirme la nueva contraseña"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]"
                            title="Repita la nueva contraseña para confirmar que coincide"
                        >
                    </div>
                   



                    <!-- Permisos de Administrador -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Permisos de Usuario
                        </label>
                        <select name="tipo" class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]" title="Modifique el nivel de permisos del trabajador" required>
                            <option value="">Seleccione tipo de usuario</option>
                            <option value="admin" {{ old('tipo', $user['tipo'] ?? '') == 'admin' ? 'selected' : '' }} title="Acceso completo a todas las funciones del sistema">Administrador</option>
                            <option value="operador" {{ old('tipo', $user['tipo'] ?? '') == 'operador' ? 'selected' : '' }} title="Acceso limitado a funciones operativas">Operador</option>
                        </select>
                    </div>
                    
                    <!-- Estatus -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Estatus
                        </label>
                        <div class="flex items-center space-x-4">
                            @php
                                $estado = old('estado', $user['estado'] ?? $user['activo'] ?? 'activo');
                                $isActive = (strtolower($estado) === 'activo' || $estado === true || $estado === 1);
                            @endphp
                            <label class="inline-flex items-center" title="El trabajador podrá acceder al sistema">
                                <input type="radio" name="estado" value="activo" class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2]" {{ $isActive ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Activo</span>
                            </label>
                            <label class="inline-flex items-center" title="El trabajador no podrá acceder al sistema">
                                <input type="radio" name="estado" value="inactivo" class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2]" {{ !$isActive ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Inactivo</span>
                            </label>
                        </div>
                    </div>

                    <!-- Almacén Asignado -->
                    {{-- <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Almacén Asignado
                        </label>
                        <select
                            name="almacen"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            required
                            title="Seleccione el almacén donde trabajará el empleado"
                        >
                            <option value="">Seleccione almacén</option>
                            <option value="JW1" {{ old('almacen', $user['almacen'] ?? '') == 'JW1' ? 'selected' : '' }} title="Almacén principal">JW1 - Almacén Principal</option>
                            <option value="JW2" {{ old('almacen', $user['almacen'] ?? '') == 'JW2' ? 'selected' : '' }} title="Almacén secundario">JW2 - Almacén Secundario</option>
                            <option value="JW3" {{ old('almacen', $user['almacen'] ?? '') == 'JW3' ? 'selected' : '' }} title="Almacén terciario">JW3 - Almacén Terciario</option>
                            <option value="JW4" {{ old('almacen', $user['almacen'] ?? '') == 'JW4' ? 'selected' : '' }} title="Almacén cuaternario">JW4 - Almacén Cuaternario</option>
                        </select>
                    </div> --}}
                    
                    <!-- Estante Asignado -->
                    {{-- <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Estante Asignado
                        </label>
                        <select
                            name="estante"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            required
                            title="Seleccione el estante específico donde trabajará el empleado"
                        >
                            <option value="">Seleccione estante</option>
                            <option value="E1" {{ old('estante', $user['estante'] ?? '') == 'E1' ? 'selected' : '' }} title="Estante 1 - Zona A">E1 - Zona A</option>
                            <option value="E2" {{ old('estante', $user['estante'] ?? '') == 'E2' ? 'selected' : '' }} title="Estante 2 - Zona B">E2 - Zona B</option>
                            <option value="E3" {{ old('estante', $user['estante'] ?? '') == 'E3' ? 'selected' : '' }} title="Estante 3 - Zona C">E3 - Zona C</option>
                            <option value="E4" {{ old('estante', $user['estante'] ?? '') == 'E4' ? 'selected' : '' }} title="Estante 4 - Zona D">E4 - Zona D</option>
                            <option value="E5" {{ old('estante', $user['estante'] ?? '') == 'E5' ? 'selected' : '' }} title="Estante 5 - Zona E">E5 - Zona E</option>
                        </select>
                    </div> --}}











                    <!-- Fecha de Registro (Solo lectura) -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Fecha de Registro
                        </label>
                        <input 
                            type="text"
                            value="{{ date('d/m/Y') }}"
                            class="w-full h-12 text-lg rounded-lg bg-gray-50 border-gray-300 text-gray-500"
                            readonly
                            title="Fecha en que el trabajador fue registrado en el sistema (no modificable)"
                        >
                    </div>
                </div>
                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a 
                        href="{{ route('workers') }}"
                        class="px-6 py-3 text-lg font-medium text-[#ff3333] bg-[#fff5f5] border border-[#ff3333] rounded-lg hover:bg-[#ffe5e5] flex items-center justify-center"
                        title="Cancelar la edición y volver a la lista de trabajadores"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                    <button 
                        type="submit"
                        class="px-6 py-3 text-lg font-medium text-white bg-[#2045c2] rounded-lg hover:bg-[#1a3aa3] shadow-md flex items-center justify-center"
                        title="Guardar los cambios realizados al trabajador"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Actualizar
                    </button>
                </div>
            @endif
            </form>
        </div>
    </div>
    
    <!-- color del gradiente -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #2045c2 0%, #5a8ff2 50%, #b3d1ff 100%);
        z-index: -9999;
        pointer-events: none;
    "></div>
    
    <!-- Script para ajustar el fondo y la visualización -->
    <script>
        // Este script mejora la visualización  del usuario
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);
            
            // fondo semitransparente
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            }
        });
    </script>
</x-app-layout>
