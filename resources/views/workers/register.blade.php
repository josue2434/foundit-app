<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Nuevo Empleado -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
            <form action="{{route('registerUser')}}" method="POST" class="p-8">
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

                    <!-- Permisos de Usuario -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Tipo de Usuario
                        </label>
                        <select 
                            name="tipo"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200 bg-white"
                            title="Seleccione el nivel de permisos que tendrá el trabajador"
                            required
                        >
                            <option value="">Seleccione un tipo de usuario</option>
                            <option value="operador" {{ old('tipo') == 'operador' ? 'selected' : '' }} title="Acceso limitado a funciones operativas">Operador</option>
                            <option value="admin" {{ old('tipo') == 'admin' ? 'selected' : '' }} title="Acceso completo a todas las funciones del sistema">Administrador</option>
                        </select>
                        @error('tipo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                            <option value="JW1" {{ old('almacen') == 'JW1' ? 'selected' : '' }} title="Almacén principal">JW1 - Almacén Principal</option>
                            <option value="JW2" {{ old('almacen') == 'JW2' ? 'selected' : '' }} title="Almacén secundario">JW2 - Almacén Secundario</option>
                            <option value="JW3" {{ old('almacen') == 'JW3' ? 'selected' : '' }} title="Almacén de materiales especiales">JW3 - Materiales Especiales</option>
                            <option value="JW4" {{ old('almacen') == 'JW4' ? 'selected' : '' }} title="Almacén de reserva">JW4 - Almacén de Reserva</option>
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
                            <option value="E1" {{ old('estante') == 'E1' ? 'selected' : '' }} title="Estante 1 - Zona A">E1 - Zona A</option>
                            <option value="E2" {{ old('estante') == 'E2' ? 'selected' : '' }} title="Estante 2 - Zona B">E2 - Zona B</option>
                            <option value="E3" {{ old('estante') == 'E3' ? 'selected' : '' }} title="Estante 3 - Zona C">E3 - Zona C</option>
                            <option value="E4" {{ old('estante') == 'E4' ? 'selected' : '' }} title="Estante 4 - Zona D">E4 - Zona D</option>
                            <option value="E5" {{ old('estante') == 'E5' ? 'selected' : '' }} title="Estante 5 - Zona E">E5 - Zona E</option>
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
                        
            const form = document.querySelector('form');
            const name = document.querySelector('input[name="name"]');
            const apellido = document.querySelector('input[name="apellido"]');
            const email = document.querySelector('input[name="email"]');
            const tipo = document.querySelector('select[name="tipo"]');
            const almacen = document.querySelector('select[name="almacen"]');
            const estante = document.querySelector('select[name="estante"]');
            
            // Función para validar coincidencia de contraseñas
            function validatePasswordMatch() {
                if (confirmPassword.value && password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    errorDiv.classList.remove('hidden');
                    return false;
                } else {
                    confirmPassword.setCustomValidity('');
                    errorDiv.classList.add('hidden');
                    return true;
                }
            }
                        
            // Event listeners para validación en tiempo real
            password.addEventListener('input', validatePasswordMatch);
            confirmPassword.addEventListener('input', validatePasswordMatch);
                        
            // Validación adicional del formulario
            const form = document.querySelector('form');
            
            // Función para validar todos los campos requeridos
            function validateRequiredFields() {
                const requiredFields = [name, apellido, email, password, confirmPassword, tipo, almacen, estante];
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                    }
                });
                
                return isValid && validatePasswordMatch();
            }
            
            // Función para actualizar el estado del botón
            function updateSubmitButton() {
                submitBtn.disabled = !validateRequiredFields();
            }
            
            // Event listeners para validación en tiempo real   
            password.addEventListener('input', function() {
                validatePasswordMatch();
                updateSubmitButton();
            });
            
            confirmPassword.addEventListener('input', function() {
                validatePasswordMatch();
                updateSubmitButton();
            });
            
            // Event listeners para campos requeridos
            [name, apellido, email, tipo, almacen, estante].forEach(field => {
                field.addEventListener('input', updateSubmitButton);
                field.addEventListener('change', updateSubmitButton);
            });
            
            // Validación del formulario antes del envío
            form.addEventListener('submit', function(e) {
                // Validar que todos los campos requeridos estén llenos
                if (!validateRequiredFields()) {
                    e.preventDefault();
                    alert('Por favor, complete todos los campos requeridos.');
                    return false;
                }
                
                // Validar coincidencia de contraseñas
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    validatePasswordMatch();
                    confirmPassword.focus();
                    return false;
                }
                
                // Validar formato de email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    e.preventDefault();
                    alert('Por favor, ingrese un email válido.');
                    email.focus();
                    return false;
                }
                
                // Validar longitud de contraseña
                if (password.value.length < 6) {
                    e.preventDefault();
                    alert('La contraseña debe tener al menos 6 caracteres.');
                    password.focus();
                    return false;
                }
                
                // Si todo está correcto, mostrar loading
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                `;
                submitBtn.disabled = true;
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
            
            // Inicializar estado del botón
            updateSubmitButton();
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
        
        /* Animación de spinner */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        /* Estilos para campos requeridos */
        input:required:invalid {
            border-color: #fca5a5;
        }
        
        input:required:valid {
            border-color: #86efac;
        }
        
        /* Estado deshabilitado del botón */
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        button:disabled:hover {
            transform: none;
        }
    </style>
</x-app-layout>
