<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        <img src="{{ asset('img/logofound-it.jpg') }}" class="w-64 h-auto mb-6" alt="Found-It Logo">
        
        <h1 class="text-3xl font-bold text-[#2045c2] mb-4">Bienvenido al sistema Found-It</h1>
        <p class="text-lg text-gray-600 mb-8">Por favor, inicia sesión o regístrate para continuar</p>

        <div class="flex space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 border border-[#2045c2] text-[#2045c2] rounded-lg hover:bg-[#2045c2] hover:text-white transition">Iniciar Sesión</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-6 py-3 bg-[#2045c2] text-white rounded-lg hover:bg-[#1a3aa3] transition">Registrarse</a>
            @endif
        </div>
    </div>
</body>
</html>
