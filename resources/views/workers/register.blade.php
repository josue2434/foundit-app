<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Nuevo Empleado -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
            <form action="" method="POST" class="p-8">
                @csrf
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="text-center">
                        <h1 class="text-2xl font-semibold text-[#2045c2]">REGISTRAR NUEVO TRABAJADOR</h1>
                        <p class="text-gray-600 mt-1">Ingrese los detalles del nuevo trabajador</p>
                    </div>
                    <!-- Nombre -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Nombre
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ingrese el nombre completo"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Ingrese el nombre completo del trabajador"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Ingrese el correo electrónico"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Ingrese un correo electrónico válido para el trabajador"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Contraseña -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Contraseña
                        </label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Ingrese la contraseña"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Ingrese una contraseña segura para el trabajador"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Confirmar Contraseña -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Confirmar Contraseña
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirme la contraseña"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Repita la contraseña para confirmar que coincide"
                        >
                        <div id="password-match-error" class="mt-1 text-sm text-red-600 hidden">Las contraseñas no coinciden</div>
                    </div>
                   




                    <!-- Permisos de Administrador -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Permisos de Usuario
                        </label>
                        <select 
                            name="rol"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200 bg-white"
                            title="Seleccione el nivel de permisos que tendrá el trabajador"
                        >
                            <option value="oper"  title="Acceso limitado a funciones operativas">Operador</option>
                            <option value="adm"  title="Acceso completo a todas las funciones del sistema">Administrador</option>
                        </select>
                        @error('rol')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Estatus -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Estatus
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center" title="El trabajador podrá acceder al sistema">
                                <input type="radio" name="activo" value="1" class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2]" >
                                <span class="ml-2 text-gray-700">Activo</span>
                            </label>
                            <label class="inline-flex items-center" title="El trabajador no podrá acceder al sistema">
                                <input type="radio" name="activo" value="0" class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2]" >
                                <span class="ml-2 text-gray-700">Inactivo</span>
                            </label>
                        </div>
                    </div>



 <!-- Almacén Asignado -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Almacén Asignado
                        </label>
                        <select
                            name="almacen"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200 bg-white"
                            required
                            title="Seleccione el almacén donde trabajará el empleado"
                        >
                            <option value="">Seleccione almacén</option>
                            <option value="JW1"  title="Almacén principal">JW1 - Almacén Principal</option>
                            <option value="JW2"  title="Almacén secundario">JW2 - Almacén Secundario</option>
                            <option value="JW3"  title="Almacén de materiales especiales">JW3 - Materiales Especiales</option>
                            <option value="JW4"  title="Almacén de reserva">JW4 - Almacén de Reserva</option>
                        </select>
                        @error('almacen')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Estante Asignado -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Estante Asignado
                        </label>
                        <select
                            name="estante"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200 bg-white"
                            required
                            title="Seleccione el estante específico donde trabajará el empleado"
                        >
                            <option value="">Seleccione estante</option>
                            <option value="E1" title="Estante 1 - Zona A">E1 - Zona A</option>
                            <option value="E2" title="Estante 2 - Zona B">E2 - Zona B</option>
                            <option value="E3" title="Estante 3 - Zona C">E3 - Zona C</option>
                            <option value="E4" title="Estante 4 - Zona D">E4 - Zona D</option>
                            <option value="E5"title="Estante 5 - Zona E">E5 - Zona E</option>
                        </select>
                        @error('estante')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                </div>
                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a
                        href="{{ route('workers') }}"
                        class="px-6 py-3 text-lg font-medium text-[#ff3333] bg-[#fff5f5] border border-[#ff3333] rounded-lg hover:bg-[#ffe5e5] flex items-center justify-center transition-colors duration-150 no-underline"
                        title="Cancelar el registro y volver a la lista de trabajadores"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-3 text-lg font-medium text-white bg-[#2045c2] rounded-lg hover:bg-[#1a3aa3] shadow-md flex items-center justify-center transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                        title="Guardar la información del nuevo trabajador"
                        id="submit-btn"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- color del gradiente gradiente -->
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
        // Este script mejora la visualización del usuario
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);
            
            // fondo semitransparente
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            }
            
            // Elementos del formulario
            const password = document.querySelector('input[name="password"]');
            const confirmPassword = document.querySelector('input[name="password_confirmation"]');
            const errorDiv = document.getElementById('password-match-error');
            const submitBtn = document.getElementById('submit-btn');
                        
            // Función para validar coincidencia de contraseñas
            function validatePasswordMatch() {
                if (confirmPassword.value && password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    errorDiv.classList.remove('hidden');
                    submitBtn.disabled = true;
                } else {
                    confirmPassword.setCustomValidity('');
                    errorDiv.classList.add('hidden');
                    submitBtn.disabled = false;
                }
            }
                        
            // Event listeners para validación en tiempo real
            password.addEventListener('input', validatePasswordMatch);
            confirmPassword.addEventListener('input', validatePasswordMatch);
                        
            // Validación adicional del formulario
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    validatePasswordMatch();
                    confirmPassword.focus();
                }
            });
        });
    </script>
</x-app-layout>
