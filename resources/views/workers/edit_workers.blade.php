<x-app-layout>
    <!-- linea de gradiente  -->
    <div class="fixed top-0 left-0 w-full h-screen bg-gradient-to-br from-[#2045c2] via-[#5a8ff2] to-[#b3d1ff]"></div>

    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Edición de Empleado -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
           
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="text-center">
                        <h1 class="text-2xl font-semibold text-[#2045c2]">EDITAR TRABAJADOR</h1>
                        <p class="text-gray-600 mt-1">Modifique los detalles del trabajador</p>
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Nombre
                        </label>
                        <input 
                            type="text"
                            name="name"
                            value="{{ old('name', 'Juan Pérez') }}"
                            placeholder="Ingrese el nombre completo"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]"
                            required
                            title="Modifique el nombre completo del trabajador"
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
                            value="{{ old('email', 'juan.perez@example.com') }}"
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
                        <select name="rol" class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2]" title="Modifique el nivel de permisos del trabajador">
                            <option value="adm" {{ old('rol', 'adm') == 'adm' ? 'selected' : '' }} title="Acceso completo a todas las funciones del sistema">Administrador</option>
                            <option value="oper" {{ old('rol', 'adm') == 'oper' ? 'selected' : '' }} title="Acceso limitado a funciones operativas">Operador</option>
                        </select>
                    </div>

                    <!-- Estatus -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Estatus
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center" title="El trabajador podrá acceder al sistema">
                                <input type="radio" name="activo" value="1" class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2]" {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Activo</span>
                            </label>
                            <label class="inline-flex items-center" title="El trabajador no podrá acceder al sistema">
                                <input type="radio" name="activo" value="0" class="h-5 w-5 text-[#2045c2] focus:ring-[#2045c2]" {{ old('activo', '1') == '0' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Inactivo</span>
                            </label>
                        </div>
                    </div>

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
            </form>
        </div>
    </div>
</x-app-layout>
