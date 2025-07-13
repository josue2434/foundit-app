<x-app-layout>
    <!-- Gradiente de fondo - Crea un efecto visual atractivo que mejora la experiencia del usuario -->
    <div class="fixed top-0 left-0 w-full h-screen bg-gradient-to-br from-[#2045c2] via-[#5a8ff2] to-[#b3d1ff]"></div>

    <div class="p-6">
        <!-- Header - Título y descripción de la página -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-[#2045c2] inline-block bg-white bg-opacity-40 px-4 py-2 rounded">
                EDITAR MATERIAL
                <p class="text-gray-600 mt-2 text-sm">Modifique la ubicación y cantidad del material</p>
            </h1>
        </div>
        <!-- Formulario - Contenedor principal del formulario de edición -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm border border-gray-200 relative z-10">
            <form action="#" method="POST" class="p-8">
                @csrf
                <!-- Token CSRF para protección contra ataques de falsificación de solicitudes -->
                <input type="hidden" name="material_id" value="1"> {{-- Campo oculto para ID del material --}}
                <input type="hidden" name="detalle_id" value="1"> {{-- Campo oculto para ID del detalle --}}
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
                                value="Tornillos M4"
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
                        <!-- Cantidad del Material (Editable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Cantidad
                            </label>
                            <input
                                type="number"
                                name="cantidad"
                                value="1000"
                                class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                min="1"
                                required
                                title="Cantidad disponible del material"
                            >
                        </div>
                    </div>
                    <!-- Barra de ubicación actual -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-md font-medium text-[#2045c2] mb-3">Ubicación Actual</h3>
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Almacén</label>
                                <div class="bg-white border border-gray-200 rounded-md px-3 py-2 text-gray-700">JW1</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Pasillo</label>
                                <div class="bg-white border border-gray-200 rounded-md px-3 py-2 text-gray-700">P1</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Columna</label>
                                <div class="bg-white border border-gray-200 rounded-md px-3 py-2 text-gray-700">B</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Fila</label>
                                <div class="bg-white border border-gray-200 rounded-md px-3 py-2 text-gray-700">2</div>
                            </div>
                        </div>
                    </div>
                    <!-- Selector de Ubicación - Sección para modificar la ubicación física -->
                    <div class="pt-4">
                        <h3 class="text-lg font-medium text-[#2045c2] mb-6">Modificar Ubicación</h3>
                        <!-- Grid de 2 columnas para los selectores de ubicación -->
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <!-- Selector de Almacén - Primera parte de la ubicación -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Almacén</label>
                                <select
                                    name="almacen"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione el almacén donde se ubicará el material"
                                >
                                    <!-- Opciones de almacenes disponibles -->
                                    <option value="">Seleccione almacén</option>
                                    <option value="JW1" selected title="Almacén principal">JW1</option>
                                    <option value="JW2" title="Almacén secundario">JW2</option>
                                    <option value="JW3" title="Almacén de materiales especiales">JW3</option>
                                    <option value="JW4" title="Almacén de reserva">JW4</option>
                                </select>
                            </div>
                            <!-- Selector de Pasillo - Segunda parte de la ubicación -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Pasillo</label>
                                <select
                                    name="pasillo"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione el pasillo donde se ubicará el material"
                                >
                                    <!-- Opciones de pasillos disponibles -->
                                    <option value="">Seleccione pasillo</option>
                                    <option value="P1" selected title="Pasillo 1 - Zona frontal">Pasillo 1</option>
                                    <option value="P2" title="Pasillo 2 - Zona central">Pasillo 2</option>
                                    <option value="P3" title="Pasillo 3 - Zona posterior">Pasillo 3</option>
                                    <option value="P4" title="Pasillo 4 - Zona lateral">Pasillo 4</option>
                                </select>
                            </div>
                        </div>
                        <!-- Segunda fila de selectores -->
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Selector de Columna - Tercera parte de la ubicación -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Columna</label>
                                <select
                                    name="columna"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione la columna donde se ubicará el material"
                                >
                                    <!-- Opciones de columnas disponibles -->
                                    <option value="">Seleccione columna</option>
                                    <option value="A" title="Columna A - Lado izquierdo">A</option>
                                    <option value="B" selected title="Columna B - Centro izquierda">B</option>
                                    <option value="C" title="Columna C - Centro derecha">C</option>
                                    <option value="D" title="Columna D - Lado derecho">D</option>
                                </select>
                            </div>
                            <!-- Selector de Fila - Cuarta parte de la ubicación -->
                            <div>
                                <label class="block text-base font-medium text-gray-700 mb-2">Fila</label>
                                <select
                                    name="fila"
                                    class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                                    required
                                    title="Seleccione la fila donde se ubicará el material"
                                >
                                    <!-- Opciones de filas disponibles -->
                                    <option value="">Seleccione fila</option>
                                    <option value="1" title="Fila 1 - Nivel inferior">1</option>
                                    <option value="2" selected title="Fila 2 - Nivel medio-bajo">2</option>
                                    <option value="3" title="Fila 3 - Nivel medio-alto">3</option>
                                    <option value="4" title="Fila 4 - Nivel superior">4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botones de acción - Controles para cancelar o guardar -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <!-- Botón Cancelar - Regresa a la página anterior -->
                    <button
                        type="button"
                        onclick="history.back()"
                        class="px-6 py-3 text-lg font-medium text-[#ff3333] bg-[#fff5f5] border border-[#ff3333] rounded-lg hover:bg-[#ffe5e5]"
                        title="Cancelar la edición y volver a la página anterior"
                    >
                        Cancelar
                    </button>
                    <!-- Botón Guardar - Envía el formulario -->
                    <button
                        type="submit"
                        class="px-6 py-3 text-lg font-medium text-white bg-[#2045c2] rounded-lg hover:bg-[#1a3aa3] shadow-md"
                        title="Guardar los cambios realizados al material"
                    >
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Script para ajustar el fondo y la visualización -->
    <script>
        // Este script mejora la visualización del gradiente con el contenido
        document.addEventListener('DOMContentLoaded', function() {
            // Asegura que el contenido principal esté por encima del gradiente
            const mainContent = document.querySelector('.p-6');
            if (mainContent) {
                mainContent.style.position = 'relative';
                mainContent.style.zIndex = '10';
            }
        });
    </script>
</x-app-layout>
