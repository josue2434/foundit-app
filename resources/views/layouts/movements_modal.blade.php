<!-- ===== MODAL PARA HISTORIAL DE MOVIMIENTOS ===== -->
<!-- Este modal muestra el historial de movimientos de un producto específico -->
<div id="movementsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">

        <!-- 📋 HEADER DEL MODAL -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-[#2045c2] dark:text-blue-400 flex items-center">
                <!-- 📊 Icono de historial -->
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Historial de Movimientos
            </h3>
            <!-- ❌ Botón para cerrar -->
            <button onclick="closeMovementsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <!-- 📊 CONTENIDO DEL MODAL -->
        <div class="mt-4">
            <!-- 🏷️ Información del producto -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            Producto: <span id="modalProductCode" class="font-bold text-[#2045c2] dark:text-blue-400">-</span>
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Últimos movimientos registrados</p>
                    </div>
                </div>
            </div>
            <!-- 📋 TABLA DE MOVIMIENTOS -->
            <div class="max-h-96 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cantidad</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuario</th>
                        </tr>
                    </thead>
                    <tbody id="movementsTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Los datos se cargarán aquí dinámicamente -->
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p>No hay movimientos registrados</p>
                                    <p class="text-xs mt-1">Los movimientos aparecerán aquí cuando se registren</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 🔘 BOTONES DEL MODAL -->
        <div class="flex justify-end mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button
                onclick="closeMovementsModal()"
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200"
            >
                Cerrar
            </button>
        </div>
    </div>
</div><!-- 🎯 JAVASCRIPT PARA EL MODAL --><script>
    // 🔧 FUNCIÓN PARA ABRIR EL MODAL
    function openMovementsModal(productCode) {
        // Mostrar el código del producto en el modal
        document.getElementById('modalProductCode').textContent = productCode;

        // Mostrar el modal
        document.getElementById('movementsModal').classList.remove('hidden');

        // Aquí podrías hacer una llamada AJAX para cargar los datos reales
        // loadMovementsData(productCode);

        console.log('Abriendo historial para producto:', productCode);
    }
    // 🔧 FUNCIÓN PARA CERRAR EL MODAL
    function closeMovementsModal() {
        document.getElementById('movementsModal').classList.add('hidden');
    }
    // 🔧 CERRAR MODAL AL HACER CLIC FUERA
    document.getElementById('movementsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMovementsModal();
        }
    });
    // 🔧 CERRAR MODAL CON LA TECLA ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMovementsModal();
        }
    });
</script>
