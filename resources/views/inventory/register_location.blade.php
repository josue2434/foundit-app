<x-app-layout>
    <div class="p-6">
        <!-- Header - Título y descripción de la página -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">ASIGNAR UBICACIÓN</h1>
            <p class="text-gray-600 mt-2 text-sm">Seleccione la ubicación para el material</p>
        </div>
        <!-- Formulario - Contenedor principal del formulario de asignación -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm border border-gray-200">
            <form action="#" method="POST" class="p-8">
                @csrf
                <!-- Token CSRF para protección contra ataques de falsificación de solicitudes -->
                <input type="hidden" name="material_id" value="1"> {{-- Campo oculto para ID del material --}}
                <div class="space-y-6">
                    <!-- Sección de información del material (No editable) -->
                    <div class="grid grid-cols-2 gap-6 pb-6 border-b border-gray-200">
                        <!-- Código del Material - Identificador único -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Código del Material
                            </label>
                            <input
                                type="text"
                                name="codigo"
                                value="MAT001"
                                class="w-full h-12 text-lg rounded-lg bg-gray-50 border-gray-300 text-gray-700"
                                readonly
                                title="Código único que identifica el material en el sistema"
                            >
                        </div>
                        <!-- Nombre del Material -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Material
                            </label>
                            <input
                                type="text"
                                name="nombre"
                                value="Tornillo Phillips"
                                class="w-full h-12 text-lg rounded-lg bg-gray-50 border-gray-300 text-gray-700"
                                readonly
                                title="Nombre descriptivo del material"
                            >
                        </div>
                        <!-- Categoría del Material -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Categoría
                            </label>
                            <input
                                type="text"
                                name="categoria"
                                value="Ferretería"
                                class="w-full h-12 text-lg rounded-lg bg-gray-50 border-gray-300 text-gray-700"
                                readonly
                                title="Clasificación del material según su tipo"
                            >
                        </div>
                        <!-- Cantidad del Material -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Cantidad
                            </label>
                            <input
                                type="text"
                                name="unidad_medida"
                                value="100"
                                class="w-full h-12 text-lg rounded-lg bg-gray-50 border-gray-300 text-gray-700"
                                readonly
                                title="Cantidad disponible del material"
                            >
                        </div>
                    </div>
                    <!-- Selector de Ubicación - Sección para asignar la ubicación física -->
                    <div class="pt-4">
                        <h3 class="text-lg font-medium text-[#2045c2] mb-6">Seleccionar Nueva Ubicación</h3>
                        <!-- Grid de 2 columnas para los selectores de ubicación -->
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <!-- Selector de Almacén -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Almacén</label>
                                <select
                                    name="almacen"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione el almacén donde se ubicará el material"
                                >
                                    <option value="">Seleccione almacén</option>
                                    <option value="JW1" title="Almacén principal">JW1</option>
                                    <option value="JW2" title="Almacén secundario">JW2</option>
                                    <option value="JW3" title="Almacén de materiales especiales">JW3</option>
                                    <option value="JW4" title="Almacén de reserva">JW4</option>
                                </select>
                            </div>
                            <!-- Selector de Pasillo -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Pasillo</label>
                                <select
                                    name="pasillo"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione el pasillo donde se ubicará el material"
                                >
                                    <option value="">Seleccione pasillo</option>
                                    <option value="P1" title="Pasillo 1 - Zona frontal">Pasillo 1</option>
                                    <option value="P2" title="Pasillo 2 - Zona central">Pasillo 2</option>
                                    <option value="P3" title="Pasillo 3 - Zona posterior">Pasillo 3</option>
                                    <option value="P4" title="Pasillo 4 - Zona lateral">Pasillo 4</option>
                                </select>
                            </div>
                        </div>
                        <!-- Segunda fila de selectores -->
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Selector de Columna -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Columna</label>
                                <select
                                    name="columna"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione la columna donde se ubicará el material"
                                >
                                    <option value="">Seleccione columna</option>
                                    <option value="A" title="Columna A - Lado izquierdo">A</option>
                                    <option value="B" title="Columna B - Centro izquierda">B</option>
                                    <option value="C" title="Columna C - Centro derecha">C</option>
                                    <option value="D" title="Columna D - Lado derecho">D</option>
                                </select>
                            </div>
                            <!-- Selector de Fila -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Fila</label>
                                <select
                                    name="fila"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione la fila donde se ubicará el material"
                                >
                                    <option value="">Seleccione fila</option>
                                    <option value="1" title="Fila 1 - Nivel inferior">1</option>
                                    <option value="2" title="Fila 2 - Nivel medio-bajo">2</option>
                                    <option value="3" title="Fila 3 - Nivel medio-alto">3</option>
                                    <option value="4" title="Fila 4 - Nivel superior">4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button
                        type="button"
                        onclick="history.back()"
                        class="px-6 py-3 text-lg font-medium text-[#ff3333] bg-[#fff5f5] border border-[#ff3333] rounded-lg hover:bg-[#ffe5e5]"
                        title="Cancelar la asignación y volver a la página anterior"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-3 text-lg font-medium text-white bg-[#2045c2] rounded-lg hover:bg-[#1a3aa3] shadow-md"
                        title="Guardar la ubicación asignada al material"
                    >
                        Guardar Ubicación
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Aquí cambié la imagen por el gradiente -->
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
        // Este script mejora la visualización y experiencia del usuario
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);
            
            // fondo semitransparente
            const mainContainer = document.querySelector('.p-6');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            }
        });
    </script>
</x-app-layout>
