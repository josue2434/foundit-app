<x-app-layout>
    <!-- Línea de gradiente -->
    <div class="fixed top-0 left-0 w-full h-screen bg-gradient-to-br from-[#2045c2] via-[#5a8ff2] to-[#b3d1ff]"></div>
    
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Nuevo Empleado -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
            <form action="{{route('register')}}" method="POST" class="p-8">
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

                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Apellido
                        </label>
                        <input
                            type="text"
                            name="apellido"
                            value="{{ old('apellido') }}"
                            placeholder="Ingrese el apellido del trabajador"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Ingrese el apellido del trabajador"
                        >
                        @error('apellido')
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
                            <option value="operador" {{ old('tipo') == 'operador' ? 'selected' : '' }} title="Acceso limitado a funciones operativas">Operador</option>
                            <option value="admin" {{ old('tipo') == 'admin' ? 'selected' : '' }} title="Acceso completo a todas las funciones del sistema">Administrador</option>
                        </select>
                        @error('rol')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estatus -->
                {{--     <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Estatus
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center cursor-pointer" title="El trabajador podrá acceder al sistema">
                                <input 
                                    type="radio" 
                                    name="status" 
                                    value="active" 
                                    class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2] focus:ring-2" 
                                    {{ old('status', 'active') == 'active' ? 'checked' : '' }}
                                >
                                <span class="ml-2 text-gray-700 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Activo
                                </span>
                            </label>
                        </div>
                    </div> --}}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Mejorar la experiencia visual de los campos
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-[#2045c2]', 'ring-opacity-20');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-[#2045c2]', 'ring-opacity-20');
                });
            });
        });
    </script>

    <style>
        /* Estilos adicionales para mejorar la apariencia */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }
        
        input:focus, select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(32, 69, 194, 0.1);
        }
        
        /* Mejorar la apariencia del select */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        /* Animación suave para los botones */
        button:hover, a:hover {
            transform: translateY(-1px);
        }
        
        /* Mejorar la apariencia de los radio buttons */
        input[type="radio"]:checked {
            background-color: #2045c2;
            border-color: #2045c2;
        }
    </style>
</x-app-layout>