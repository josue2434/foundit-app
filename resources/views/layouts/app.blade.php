<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-blue {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        }

        .menu-item {
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }

        .collapsible-content {
            transition: max-height 0.3s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased">
    {{-- Removed global background image from app.blade.php --}}

    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <div class="w-64 sidebar-blue flex flex-col">
            <!-- Logo -->
            <div class="flex flex-col items-center pt-4 pb-4 border-b border-white/10">
                <img src="{{ asset('img/logofound-it.jpg') }}" alt="Logo de Found-It" class="w-48 h-16 mx-auto">
            </div>

            <!-- Menú de navegación -->
            <nav class="mt-5 px-3 overflow-y-auto flex-1">
                <div class="space-y-1">
                    <!-- Panel de Control -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white text-[#2045c2]' : 'text-white hover:bg-white/10' }} transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Panel de Control
                    </a>

                    <!-- Área (Desplegable) -->
                    <div class="mb-1">
                        <button class="collapsible-trigger w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-white hover:bg-white/10 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                            </svg>
                            Área
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 transform transition-transform duration-200 dropdown-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="collapsible-content overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                            <div class="py-2 space-y-1">
                                <a href="{{ route('part.with.material') }}" class="flex items-center px-11 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-150">
                                    Surtido
                                </a>
                                <a href="{{ route('stock.view') }}" class="flex items-center px-11 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-150">
                                    Almacén
                                </a>
                                <a href="{{ route('Inventorystock') }}" class="flex items-center px-11 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-150">
                                    Recibo/Entrada
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Productos (Desplegable) -->
                    <div class="mb-1">
                        <button class="collapsible-trigger w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-white hover:bg-white/10 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Productos
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto h-4 w-4 transform transition-transform duration-200 dropdown-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="collapsible-content overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                            <div class="py-2 space-y-1">
                                <a href="{{ route('critical.products') }}" class="flex items-center px-11 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-150">
                                    Bajo Inventario
                                </a>
                                <a href="{{ route('total.products') }}" class="flex items-center px-11 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-150">
                                    Materiales Totales
                                </a>
                                <a href="{{ route('expensive.products') }}" class="flex items-center px-11 py-2 text-sm font-medium text-white hover:bg-white/10 rounded-lg transition-all duration-150">
                                    Materiales Alto Valor
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (session_user()->tipo === 'admin')

                    <!-- Reportes -->
                    <a href="{{ route('getReporte') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('getReporte') ? 'bg-white text-[#2045c2]' : 'text-white hover:bg-white/10' }} transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2-2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Reportes
                    </a>

                 <!-- Almacenes -->
                    <a href="{{ route('getallAlmacenes') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('workers') ? 'bg-white text-[#2045c2]' : 'text-white hover:bg-white/10' }} transition-all duration-150">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                            </svg>
                        Almacenes
                    </a>

                    <!-- Trabajadores -->
                    
                    <a href="{{ route('view_workers') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('workers') ? 'bg-white text-[#2045c2]' : 'text-white hover:bg-white/10' }} transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Trabajadores
                    </a>
                    
                    @endif

                </div>
            </nav>

            <!-- Información del usuario -->
            <div class="border-t border-white/10 bg-white/5">
                <div class="flex items-center p-4">
                    <div class="flex-shrink-0">
                        <a title="Ver perfil" href="{{ route('profile.edit') }}"> {{-- Corrected route to profile.edit --}}
                            <div class="h-10 w-10 rounded-lg bg-white flex items-center justify-center text-[#2045c2]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </a>
                    </div>

                    <div class="ml-3 flex flex-col max-w-[150px]">
                        <div class="text-sm font-medium text-white truncate">{{ session_user()->name ?? 'Usuario' }}</div>
                        <div class="text-xs text-white/70 truncate">{{ session_user()->email ?? '' }}</div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                   @csrf
                        <button type="submit" class="p-1 rounded-lg text-white hover:bg-white/10 transition-all duration-150" title="Cerrar sesión">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Funcionalidad de menús desplegables
            document.querySelectorAll('.collapsible-trigger').forEach(trigger => {
                trigger.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const arrow = this.querySelector('.dropdown-arrow');

                    // Cerrar otros dropdowns
                    document.querySelectorAll('.collapsible-content').forEach(otherContent => {
                        if (otherContent !== content && otherContent.style.maxHeight !== '0px') {
                            otherContent.style.maxHeight = '0px';
                            const otherArrow = otherContent.previousElementSibling.querySelector('.dropdown-arrow');
                            if (otherArrow) {
                                otherArrow.classList.remove('rotate-180');
                            }
                        }
                    });

                    // Toggle del dropdown actual
                    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                        content.style.maxHeight = '0px';
                        arrow.classList.remove('rotate-180');
                    } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                        arrow.classList.add('rotate-180');
                    }
                });
            });

            // Auto-abrir dropdown si estamos en una página de esa sección
            const currentPath = window.location.pathname;

            if (currentPath.includes('products') || currentPath.includes('critical') || currentPath.includes('expensive') || currentPath.includes('total')) {
                const productsTrigger = document.querySelector('.collapsible-trigger:has(+ .collapsible-content a[href*="products"])');
                if (productsTrigger) {
                    const content = productsTrigger.nextElementSibling;
                    const arrow = productsTrigger.querySelector('.dropdown-arrow');
                    content.style.maxHeight = content.scrollHeight + "px";
                    arrow.classList.add('rotate-180');
                }
            }

            // Actualizado para incluir 'part-with-material' y 'gestion-embarques'
            if (currentPath.includes('part-with-material') || currentPath.includes('stock-view') || currentPath.includes('gestion-embarques') || currentPath.includes('inventory-stock')) {
                const areaTrigger = document.querySelector('.collapsible-trigger:has(+ .collapsible-content a[href*="part-with-material"], + .collapsible-content a[href*="stock-view"], + .collapsible-content a[href*="gestion-embarques"])');
                if (areaTrigger) {
                    const content = areaTrigger.nextElementSibling;
                    const arrow = areaTrigger.querySelector('.dropdown-arrow');
                    content.style.maxHeight = content.scrollHeight + "px";
                    arrow.classList.add('rotate-180');
                }
            }
        });
    </script>
</body>
</html>
