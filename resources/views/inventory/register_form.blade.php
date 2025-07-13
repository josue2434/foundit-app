<x-app-layout>
    <!-- Notificación de error flotante MÁS CENTRADA -->
    <div id="errorAlert" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <!-- Contenedor de la alerta más centrado -->
        <div class="bg-white rounded-lg shadow-2xl border-4 border-red-500 p-6 max-w-md w-full mx-auto relative z-10 error-pulse transform translate-y-0">
            <!-- Icono de error grande -->
            <div class="flex justify-center mb-4">
                <div class="rounded-full bg-red-100 p-3">
                    <svg class="h-12 w-12 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            <!-- Título de error -->
            <h3 class="text-xl font-bold text-red-700 text-center mb-2">¡Atención!</h3>

            <!-- Mensaje de error -->
            <div class="text-center mb-4">
                <p class="text-base font-medium text-gray-800 mb-2">Por favor corrige los siguientes errores:</p>
                <ul class="text-left bg-red-50 p-3 rounded-lg border border-red-200">
                    <li class="flex items-start mb-2">
                        <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-red-700">Error de ejemplo</span>
                    </li>
                </ul>
            </div>

            <!-- Botón de cerrar -->
            <div class="flex justify-center">
                <button id="closeError" class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-300 shadow-md">
                    Entendido
                </button>
            </div>

            <!-- Botón de cerrar (X) -->
            <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700" id="closeErrorX">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <!-- Notificación de éxito flotante MÁS CENTRADA -->
    <div id="successAlert" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <!-- Contenedor de la alerta más centrado -->
        <div class="bg-white rounded-lg shadow-2xl border-4 border-green-500 p-6 max-w-md w-full mx-auto relative z-10 success-pulse transform translate-y-0">
            <!-- Icono de éxito grande -->
            <div class="flex justify-center mb-4">
                <div class="rounded-full bg-green-100 p-3">
                    <svg class="h-12 w-12 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Título de éxito -->
            <h3 class="text-xl font-bold text-green-700 text-center mb-4">¡Operación Exitosa!</h3>

            <!-- Mensaje de éxito -->
            <p class="text-center text-gray-800 mb-4">Material registrado correctamente</p>

            <!-- Botón de cerrar -->
            <div class="flex justify-center">
                <button id="closeSuccess" class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-300 shadow-md">
                    Aceptar
                </button>
            </div>

            <!-- Botón de cerrar (X) -->
            <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700" id="closeSuccessX">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <div class="min-h-screen flex items-center justify-center p-6">
        <!-- Formulario de Nuevo Embarque -->
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg border border-gray-200 relative z-10">
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
    <!-- De aquí es el código para el fondo de pantalla img pantalla completa -->
    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/imgingreso.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -9999;
        pointer-events: none;
    "></div>
    <style>
        /* Animación de pulso para el error */
        @keyframes errorPulse {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }

        /* Animación de pulso para el éxito */
        @keyframes successPulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .error-pulse {
            animation: errorPulse 2s infinite;
        }

        .success-pulse {
            animation: successPulse 2s infinite;
        }

        /* Animación de entrada mejorada para centrado */
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        #errorAlert > div,
        #successAlert > div {
            animation: modalFadeIn 0.3s ease-out forwards;
        }

        /* Animación de salida */
        .modal-fade-out {
            opacity: 0 !important;
            transform: scale(0.95) translateY(10px) !important;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);
            // Fondo semitransparente
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(19, 18, 18, 0.4)';
            }
            // Cerrar alerta de error
            const closeErrorBtn = document.getElementById('closeError');
            const closeErrorXBtn = document.getElementById('closeErrorX');
            const errorAlert = document.getElementById('errorAlert');

            function closeErrorModal() {
                if (errorAlert) {
                    const modalContent = errorAlert.querySelector('div');

                    modalContent.classList.add('modal-fade-out');

                    setTimeout(() => {
                        errorAlert.style.display = 'none';
                    }, 300);
                }
            }

            if (closeErrorBtn) {
                closeErrorBtn.addEventListener('click', closeErrorModal);
            }

            if (closeErrorXBtn) {
                closeErrorXBtn.addEventListener('click', closeErrorModal);
            }

            // Cerrar alerta de éxito
            const closeSuccessBtn = document.getElementById('closeSuccess');
            const closeSuccessXBtn = document.getElementById('closeSuccessX');
            const successAlert = document.getElementById('successAlert');

            function closeSuccessModal() {
                if (successAlert) {
                    const modalContent = successAlert.querySelector('div');

                    modalContent.classList.add('modal-fade-out');

                    setTimeout(() => {
                        successAlert.style.display = 'none';
                    }, 300);
                }
            }

            if (closeSuccessBtn) {
                closeSuccessBtn.addEventListener('click', closeSuccessModal);
            }

            if (closeSuccessXBtn) {
                closeSuccessXBtn.addEventListener('click', closeSuccessModal);
            }

            // Auto-cerrar después de 8 segundos
            if (errorAlert) {
                setTimeout(closeErrorModal, 8000);
            }

            if (successAlert) {
                setTimeout(closeSuccessModal, 8000);
            }
        });
    </script>
</x-app-layout>
