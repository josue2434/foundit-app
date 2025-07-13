<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Found It!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animaciones */
        @keyframes slideIn {
            0% { transform: translateY(-100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .slide-in { animation: slideIn 1s ease-out; }
        .fade-in { animation: fadeIn 1s ease-out; }
        
        /* Fondo con imagen */
        body {
            background: url('{{ asset('img/almacen2.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
        
        /* Estilos de la alerta */
        .alerta {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #f8fafc;
            border: 2px solid #f87171;
            color: #991b1b;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            z-index: 1000;
            max-width: 400px;
        }
        .alerta h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #b91c1c;
        }
        .alerta button {
            background: #dc2626;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        .alerta button:hover {
            background: #b91c1c;
        }

        /* Estilos personalizados para inputs */
        .custom-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        .custom-input:focus {
            outline: none;
            ring: 2px;
            ring-color: #3b82f6;
            border-color: #3b82f6;
        }
        .custom-input:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #60a5fa;
        }

        /* Botón personalizado */
        .custom-button {
            width: 100%;
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem;
            border-radius: 0.75rem;
            font-size: 1.125rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            transform: scale(1);
        }
        .custom-button:hover {
            background-color: #2563eb;
            transform: scale(1.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .custom-button:focus {
            outline: none;
            ring: 2px;
            ring-color: #3b82f6;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <main class="w-full h-full flex items-center justify-center">
        <div class="w-full max-w-md bg-white bg-opacity-90 rounded-lg shadow-2xl overflow-hidden transform transition-all duration-1000 scale-95 hover:scale-100 slide-in">
            <!-- Header -->
            <div class="bg-blue-500 text-white p-8">
                <div class="text-center fade-in">
                    <h3 class="text-4xl font-bold mb-3">Bienvenido al sistema Found It!</h3>
                    <p class="italic text-lg">Encuentra lo que necesitas con facilidad</p>
                </div>
            </div>

            <!-- Alertas de error personalizadas -->
            @if ($errors->any())
                <div id="alerta-error" class="alerta fade-in">
                    <h2>¡Atención!</h2>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600">- {{ $error }}</li>
                        @endforeach
                    </ul>
                    <button onclick="document.getElementById('alerta-error').style.display='none'">Entendido</button>
                </div>
            @endif

            <!-- Session Status de Breeze -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center p-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario -->
            <div class="p-8 bg-white rounded-b-lg shadow-lg">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <h2 class="text-2xl font-semibold text-center text-blue-500 fade-in">Inicio de Sesión</h2>
                    
                    <!-- Email Address -->
                    <div>
                        <input 
                            id="email" 
                            class="custom-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Correo electrónico"
                            required 
                            autofocus 
                            autocomplete="username" 
                        />
                        @if ($errors->get('email'))
                            <div class="text-red-500 text-sm mt-1">
                                @foreach ($errors->get('email') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div>
                        <input 
                            id="password" 
                            class="custom-input"
                            type="password"
                            name="password"
                            placeholder="Contraseña"
                            required 
                            autocomplete="current-password" 
                        />
                        @if ($errors->get('password'))
                            <div class="text-red-500 text-sm mt-1">
                                @foreach ($errors->get('password') as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                            name="remember"
                        >
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">
                            Recordarme
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="custom-button">
                        Ingresar
                    </button>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-center mt-4">
                            <a 
                                class="text-sm text-blue-600 hover:text-blue-800 underline transition duration-300" 
                                href="{{ route('password.request') }}"
                            >
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </main>
</body>
</html>
