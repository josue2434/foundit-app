<!-- ===== SECCIÓN: ACTUALIZAR CONTRASEÑA ===== -->
<section class="bg-white dark:bg-gray-800 bg-opacity-95 rounded-lg shadow-lg p-6 mb-6">
    <!-- Header de la sección -->
    <header class="border-b border-blue-200 dark:border-blue-700 pb-4 mb-6">
        <h2 class="text-xl font-semibold text-[#2045c2] dark:text-blue-400">
            {{ __('Actualizar Contraseña') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerte seguro.') }}
        </p>
    </header>

    <!-- Formulario de actualización de contraseña -->
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Campo: Contraseña Actual -->
        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-[#2045c2] dark:text-blue-400 font-medium" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full border-blue-300 dark:border-blue-600 focus:border-[#2045c2] focus:ring-[#2045c2] rounded-lg shadow-sm bg-white dark:bg-gray-700" 
                autocomplete="current-password" 
                placeholder="Ingresa tu contraseña actual"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600" />
        </div>

        <!-- Campo: Nueva Contraseña -->
        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-[#2045c2] dark:text-blue-400 font-medium" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full border-blue-300 dark:border-blue-600 focus:border-[#2045c2] focus:ring-[#2045c2] rounded-lg shadow-sm bg-white dark:bg-gray-700" 
                autocomplete="new-password" 
                placeholder="Ingresa tu nueva contraseña"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Campo: Confirmar Contraseña -->
        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="text-[#2045c2] dark:text-blue-400 font-medium" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full border-blue-300 dark:border-blue-600 focus:border-[#2045c2] focus:ring-[#2045c2] rounded-lg shadow-sm bg-white dark:bg-gray-700" 
                autocomplete="new-password" 
                placeholder="Confirma tu nueva contraseña"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <!-- Botones de acción -->
        <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button 
                type="submit"
                class="bg-[#2045c2] hover:bg-blue-800 text-white font-medium py-2 px-6 rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#2045c2] focus:ring-offset-2"
            >
                {{ __('Actualizar Contraseña') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 dark:text-green-400 font-medium bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-md"
                >
                    {{ __('¡Contraseña actualizada!') }}
                </p>
            @endif
        </div>
    </form>
</section>
