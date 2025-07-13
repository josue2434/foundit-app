<!-- ===== SECCIÓN: INFORMACIÓN DEL PERFIL ===== -->
<section class="bg-white dark:bg-gray-800 bg-opacity-95 rounded-lg shadow-lg p-6 mb-6">
    <!-- Header de la sección -->
    <header class="border-b border-blue-200 dark:border-blue-700 pb-4 mb-6">
        <h2 class="text-xl font-semibold text-[#2045c2] dark:text-blue-400">
            {{ __('Información del Perfil') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Actualiza la información de tu cuenta y dirección de correo electrónico.") }}
        </p>
    </header>

    <!-- Formulario de verificación (oculto) -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulario principal de actualización -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Campo: Nombre -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nombre')" class="text-[#2045c2] dark:text-blue-400 font-medium" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full border-blue-300 dark:border-blue-600 focus:border-[#2045c2] focus:ring-[#2045c2] rounded-lg shadow-sm bg-white dark:bg-gray-700" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('name')" />
        </div>

        <!-- Campo: Email -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[#2045c2] dark:text-blue-400 font-medium" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full border-blue-300 dark:border-blue-600 focus:border-[#2045c2] focus:ring-[#2045c2] rounded-lg shadow-sm bg-white dark:bg-gray-700" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('email')" />

            <!-- Verificación de email -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mt-3">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        {{ __('Tu dirección de correo no está verificada.') }}
                        <button 
                            form="send-verification" 
                            class="underline text-sm text-[#2045c2] dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium ml-1"
                        >
                            {{ __('Haz clic aquí para reenviar el email de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Botones de acción -->
        <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button 
                type="submit"
                class="bg-[#2045c2] hover:bg-blue-800 text-white font-medium py-2 px-6 rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#2045c2] focus:ring-offset-2"
            >
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 dark:text-green-400 font-medium bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-md"
                >
                    {{ __('¡Guardado exitosamente!') }}
                </p>
            @endif
        </div>
    </form>
</section>
