<x-app-layout>
    <!-- ===== PÁGINA DE EDICIÓN DE PERFIL ===== -->
    
    <!-- Header de la página -->
    <div class="mb-6">
        <div class="bg-white bg-opacity-90 inline-block px-6 py-3 rounded-lg shadow-md">
            <h1 class="text-xl font-semibold text-[#2045c2] flex items-center">
                <!-- Icono de perfil -->
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                CONFIGURACIÓN DE PERFIL
            </h1>
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Sección: Información del Perfil -->
        @include('profile.partials.update-profile-information-form')

        <!-- Sección: Actualizar Contraseña -->
        @include('profile.partials.update-password-form')

        <!-- Sección: Eliminar Cuenta -->
        @include('profile.partials.delete-user-form')
    </div>
</x-app-layout>
