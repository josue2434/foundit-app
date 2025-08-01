<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Nuevo Almacén -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
            {{-- El action="#" y method="POST" son solo para la estructura visual del formulario, no hay funcionalidad de backend --}}
            <form action="#" method="POST" class="p-8">
                @csrf
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="text-center">
                        <h1 class="text-2xl font-semibold text-[#2045c2]">AGREGAR NUEVO ALMACÉN</h1>
                        <p class="text-gray-600 mt-1">Ingrese los detalles del nuevo almacén</p>
                    </div>
                    <!-- Nombre del Almacén -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Nombre del Almacén
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ingrese el nombre del almacén (ej. Almacén Principal)"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Ingrese el nombre completo del almacén"
                        >
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Dirección -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Dirección
                        </label>
                        <input
                            type="text"
                            name="direccion"
                            value="{{ old('direccion') }}"
                            placeholder="Ingrese la dirección física del almacén"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200"
                            required
                            title="Ingrese la dirección completa del almacén"
                        >
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Cantidad de Estantes -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#2045c2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Cantidad de Estantes
                        </label>
                        <select
                            name="cantidad_estantes"
                            class="w-full h-12 px-4 text-lg rounded-lg border border-gray-300 focus:border-[#2045c2] focus:ring-2 focus:ring-[#2045c2] focus:ring-opacity-20 transition-all duration-200 bg-white"
                            required
                            title="Seleccione la cantidad de estantes que tendrá este almacén"
                        >
                            <option value="">Seleccione cantidad</option>
                            @for ($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ old('cantidad_estantes') == $i ? 'selected' : '' }}>{{ $i }} Estantes</option>
                            @endfor
                        </select>
                        @error('cantidad_estantes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a
                        href="{{ route('almacenes.index') }}"
                        class="px-6 py-3 text-lg font-medium text-[#ff3333] bg-[#fff5f5] border border-[#ff3333] rounded-lg hover:bg-[#ffe5e5] flex items-center justify-center transition-colors duration-150 no-underline"
                        title="Cancelar el registro y volver a la lista de almacenes"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                    {{-- El type="submit" es solo para la estructura visual del formulario, no hay funcionalidad de backend --}}
                    <button
                        type="submit"
                        class="px-6 py-3 text-lg font-medium text-white bg-[#2045c2] rounded-lg hover:bg-[#1a3aa3] shadow-md flex items-center justify-center transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                        title="Guardar la información del nuevo almacén"
                        id="submit-btn"
                    >
                        <svg class="animate-spin h-5 w-5 mr-2 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Fondo de pantalla con gradiente -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);
            
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            }

            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submit-btn');
            const spinner = submitBtn.querySelector('.animate-spin');

            form.addEventListener('submit', function() {
                // Esto es solo para simular un estado de carga visual, no envía datos reales
                spinner.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                // Puedes añadir un setTimeout aquí para "resetear" el botón después de un tiempo
                // setTimeout(() => {
                //     spinner.classList.add('hidden');
                //     submitBtn.disabled = false;
                //     submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                // }, 2000);
            });
        });
    </script>
</x-app-layout>
