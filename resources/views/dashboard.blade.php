<x-app-layout>
    <div class="mb-6">
        <div class="bg-white bg-opacity-90 inline-block px-6 py-3 rounded-lg shadow-md">
            <h1 class="text-xl font-semibold text-[#2045c2]">PANEL DE CONTROL</h1>
        </div>
    </div>
    
    <div class="bg-white bg-opacity-95 rounded-lg shadow-lg overflow-hidden p-6">
        <style>
            /* Estilos del código original para mantener la apariencia */
            .container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            .box {
                border: 1px solid #007BFF;
                border-radius: 10px;
                padding: 15px;
                margin: 20px auto;
                max-width: 400px;
                background-color: #ffffff;
            }
            button {
                background-color: #007BFF;
                color: white;
                padding: 10px 20px;
                margin: 5px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
            input {
                padding: 5px;
                margin: 5px;
                width: 60px;
            }
        </style>
        
        <div class="container">
            {{-- <div class="box">
                <h2>Consulta de Ubicación</h2>
                <input type='number' id='celda' min='0' max='11' value="0">
                <button onclick='controlLed("on")'>Buscar</button>
                <button onclick='controlLed("off")'>Limpiar</button>
            </div> --}}

            <div class="box bg-blue-50 shadow-md flex flex-col items-center">
                <h2 class="text-lg font-semibold text-blue-700 flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Datos Ambientales
                </h2>
                <div class="flex flex-col items-center gap-2">
                    <div class="flex items-center gap-2 text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>
                        <span class="font-bold">Temperatura:</span>
                        <span id='temp' class="text-xl font-mono">--</span>°C
                    </div>
                    <div class="flex items-center gap-2 text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" /></svg>
                        <span class="font-bold">Humedad:</span>
                        <span id='hum' class="text-xl font-mono">--</span>%
                    </div>
                </div>
            </div>
            
            {{-- <div class="box">
                <h2>Autenticación por Huella</h2>
                <p>Usuario: <span id='user'>Esperando</span></p>
                <button onclick='checkFingerprint()'>Validar Huella</button>
            </div> --}}
            
            <div class="box bg-yellow-50 shadow-md flex flex-col items-center">
                <h2 class="text-lg font-semibold text-yellow-700 flex items-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7v-2a4 4 0 00-8 0v2a4 4 0 00-2 3.5V17a2 2 0 002 2h8a2 2 0 002-2v-6.5a4 4 0 00-2-3.5z" /></svg>
                    Zona de seguridad
                </h2>
                <div class="flex gap-4 mt-2">
                    <button onclick='controlServo(0)' class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded shadow transition">Bloqueado</button>
                    <button onclick='controlServo(180)' class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow transition">Desbloqueado</button>
                </div>
                <p class="mt-3 text-sm text-yellow-700">Solo personal autorizado puede desbloquear esta zona.</p>
            </div>
        </div>
    </div>

    <div id="background-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('img/dash.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -9999;
        pointer-events: none;
    "></div>

    <script>
        // URL base de tu API de Node.js
        const apiUrl = 'http://4.208.84.82:3000/';

        document.addEventListener('DOMContentLoaded', function() {
            // ... (Toda la lógica de fondo y efectos de hover)
            const overlay = document.getElementById('background-overlay');
            document.body.prepend(overlay);
            
            const mainContainer = document.querySelector('.min-h-screen');
            if (mainContainer) {
                mainContainer.style.backgroundColor = 'rgba(19, 18, 18, 0.4)';
            }
            
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.classList.add('bg-gray-50');
                });
                row.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-gray-50');
                });
            });

            // Llamada inicial a la función para mostrar los datos
            updateData();
            // Actualizar datos cada 3 segundos
            setInterval(updateData, 3000);
        });

        // Funciones para interactuar con la API de Node.js
        function updateData() {
            fetch(apiUrl + 'api/dht')
                .then(res => res.json())
                .then(data => {
                    console.log('Datos recibidos:', data); // Log para depuración
                    document.getElementById('temp').innerText = data.temperature;
                    document.getElementById('hum').innerText = data.humidity;
                })
                .catch(error => console.error('Error al obtener datos DHT:', error));
        }

        function controlLed(state) {
            const ledId = document.getElementById('celda').value;
            fetch(apiUrl + 'api/led/control', { //url de la api
                method: 'POST', //metodo 
                headers: {
                    'Content-Type': 'application/json' //header encabezado
                },
                body: JSON.stringify({ ledId: ledId, state: state }) //cuerpo de la peticion body
            })
            .then(res => res.json())
            .then(data => console.log('Comando de LED enviado:', data))
            .catch(error => console.error('Error al enviar comando de LED:', error));
        }

        function controlServo(pos) {
            fetch(apiUrl + 'api/servo/control', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ position: pos })
            })
            .then(res => res.json())
            .then(data => console.log('Comando de Servo enviado:', data))
            .catch(error => console.error('Error al enviar comando de Servo:', error));
        }

        function checkFingerprint() {
            fetch(apiUrl + 'api/fingerprint/validate') 
                .then(res => res.json())
                .then(data => {
                    console.log('Comando para escanear huella enviado:', data);
                    document.getElementById('user').innerText = 'Revisando...';
                })
                .catch(error => console.error('Error al iniciar validación de huella:', error));
        }
    </script>
</x-app-layout>