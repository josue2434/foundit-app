<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Nuevo Embarque -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200">
            <form action="#" method="post" class="p-8">
                @csrf
                <div class="space-y-6">
                    <!-- Header -->
                    <div class="text-center">
                        <h1 class="text-2xl font-semibold text-[#2045c2]">AGREGAR REGISTRO RECIBO/ENTRADA</h1>
                        <p class="text-gray-600 mt-1">Ingrese los detalles del nuevo Recibo/Entrada</p>
                    </div>
                    <!-- Código del Material -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Código del Material
                        </label>
                        <input
                            type="text"
                            name="codigo"
                            placeholder="Ingrese el código del material"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            required
                            title="Código único que identificará el material en el sistema"
                        >
                    </div>
                    <!-- Material -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Material
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            placeholder="Ingrese el nombre del material"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            required
                            title="Nombre descriptivo del material"
                        >
                    </div>
                    <!-- Categoría -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Categoría
                        </label>
                        <select
                            name="categoria"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            required
                            title="Clasificación del material según su tipo"
                        >
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <option value="Ferretería" title="Materiales de ferretería como tornillos, tuercas, etc.">Ferretería</option>
                            <option value="Electrónica" title="Componentes electrónicos como cables, conectores, etc.">Electrónica</option>
                            <option value="Herramientas" title="Herramientas de trabajo como destornilladores, llaves, etc.">Herramientas</option>
                        </select>
                    </div>
                    <!-- Cantidad -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Cantidad
                        </label>
                        <input
                            type="number"
                            name="unidad_medida"
                            placeholder="Ingrese la cantidad"
                            class="w-full h-12 text-lg rounded-lg border-gray-300 focus:border-[#2045c2] focus:ring-[#2045c2] focus:ring-opacity-50"
                            min="1"
                            required
                            title="Cantidad de unidades del material"
                        >
                    </div>
                    <!-- Ubicación (Deshabilitada) -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">
                            Ubicación
                        </label>
                        <input
                            type="text"
                            placeholder="Pendiente de asignar en área de Almacen"
                            class="w-full h-12 text-lg rounded-lg bg-gray-50 border-gray-300 text-gray-500"
                            disabled
                            title="La ubicación será asignada posteriormente por el personal de almacén"
                        >
                        <p class="mt-2 text-sm text-gray-500">La ubicación será asignada en el área de Almacen</p>
                    </div>
                </div>
                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button
                        type="button"
                        onclick="history.back()"
                        class="px-6 py-3 text-lg font-medium text-[#ff3333] bg-[#fff5f5] border border-[#ff3333] rounded-lg hover:bg-[#ffe5e5]"
                        title="Cancelar el registro y volver a la página anterior"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-3 text-lg font-medium text-white bg-[#2045c2] rounded-lg hover:bg-[#1a3aa3] shadow-md"
                        title="Guardar el nuevo material en el sistema"
                    >
                        Guardar
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
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            }
        });
    </script>
</x-app-layout>
