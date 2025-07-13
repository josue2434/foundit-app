<!-- ===== SECCIÓN: ELIMINAR CUENTA ===== -->
<section class="bg-white dark:bg-gray-800 bg-opacity-95 rounded-lg shadow-lg p-6 border-l-4 border-red-500">
    <!-- Header de la sección -->
    <header class="pb-4 mb-6">
        <h2 class="text-xl font-semibold text-red-600 dark:text-red-400 flex items-center">
            <!-- Icono de advertencia -->
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ __('Eliminar Cuenta') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <!-- Botón de eliminar cuenta -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center"
    >
        <!-- Icono de eliminar -->
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3l1.586-1.586a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8 9V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            <path d="M3 5a2 2 0 012-2h1a1 1 0 000 2H5v6a2 2 0 002 2h6a2 2 0 002-2V5h-1a1 1 0 100-2h1a2 2 0 012 2v6a4 4 0 01-4 4H7a4 4 0 01-4-4V5z"></path>
        </svg>
        {{ __('Eliminar Cuenta') }}
    </button>

    <!-- Modal de confirmación -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <!-- Header del modal -->
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
                    </h2>
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}
                </p>

                <!-- Campo de contraseña -->
                <div class="mb-6">
                    <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full border-red-300 dark:border-red-600 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm bg-white dark:bg-gray-700"
                        placeholder="{{ __('Ingresa tu contraseña para confirmar') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Botones del modal -->
                <div class="flex justify-end space-x-3">
                    <button
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                    >
                        {{ __('Cancelar') }}
                    </button>
                    <button
                        type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        {{ __('Eliminar Cuenta') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
