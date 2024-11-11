<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMARTGROW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
<div id="notification" class="notification" style="display: none;">Luzes Desligadas!</div>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block  sidebar p-0">
                <div class="position-sticky">
                    <!-- Logo -->
                    <div class="sidebar-header text-center p-3">
                        <img src="img/fundologin.jpg" class="img-fluid rounded-circle" alt="Logo Estufa">
                    </div>

                    <h3 class="text-center">Menu de Itens</h3>

                    <!-- Menu Items -->
                    <ul class="nav flex-column text-center">
                        <li class="nav-item mt-3">
                            <a class="nav-link active text-dark" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('dashboard') }}">Detalhamento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('logs') }}">Log & Histórico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('status') }}">Status</a>
                        </li>
                    </ul>

                    
                    <div class="text-center mt-1">
                        <a href="{{ route('advanced.settings')}}" class="text-dark">Fases da plantação<i class="bi bi-gear-fill"></i></a>
                    </div>
                    <!-- Botão de Sair -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="text-center mt-3">
<a href="#" class="btn btn-danger w-75" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Sair <i class="bi bi-box-arrow-right"></i>
</a>
</div>
                    
                    </div>
                </div>
            </nav>

            <!-- Conteúdo Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="teste d-flex justify-content-center align-items-center pt-3 pb-2 mb-3">
                    <h1 class="titulo">SMARTGROW <span class="iconify" data-icon="twemoji:strawberry" data-width="30" data-height="30"></span></h1>
                    <div class="dropdown ms-auto d-md-none">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="img/fundologin.jpg" class="img-fluid rounded-circle" style="width: 30px;" alt="Menu">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" id="themeToggle" href="#" onclick="event.preventDefault();  toggleTheme()">Alternar Tema</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Home</a></li>
                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Detalhamento</a></li>
                <li><a class="dropdown-item" href="{{ route('logs') }}">Log & Histórico</a></li>
                <li><a class="dropdown-item" href="{{ route('status') }}">Status</a></li>
                <li><a class="dropdown-item" href="{{ route('advanced.settings')}}">Fases da plantação</a></li>
                <li class="text-center mt-3">
                    <a href="#" class="btn btn-danger w-75" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair <i class="bi bi-box-arrow-right"></i>
                    </a>
                </li>
            </ul>
                        
                    </div>
    </div>

                <!-- Cards de Conteúdo -->
                <div class="row">
    <div class="col-md-8">
        <div class="row">
            <!-- Relatório de Temperatura -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-center">Relatório de Temperatura</h3>
                        <div class="thermometer-container">
                            <div class="thermometer">
                                <div class="thermometer-fill" id="temperature-fill" style="height: 50%; transition: height 0.5s ease;"></div>
                                <div class="thermometer-bulb"></div>
                            </div>
                            <p class="text-center mt-3">Temperatura Atual: <span id="temperature-value">--°C</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Relatório de Umidade -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-center">Relatório de Umidade</h3>
                        <div class="aquarium-container">
                            <div class="aquarium">
                                <div class="water-level" id="humidity-fill" style="height: 50%; transition: height 0.5s ease;"></div>
                            </div>
                            <p class="text-center mt-3">Umidade Atual: <span id="humidity-value">--%</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Relatório de Umidade do Solo -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-center">Relatório de Umidade do Solo</h3>
                        <div class="humidity-meter">
                            <div class="gauge">
                                <div class="gauge-cover" id="soil-moisture-fill" style="height: 50%; transition: height 0.5s ease;"></div>
                            </div>
                            <p class="text-center mt-3">Umidade do Solo: <span id="soil-moisture-value">--%</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <!-- Card de Configurações -->
        <div class="card mb-4" style="width: 100%;">
            <div class="card-body text-center">
                <h5 class="card-title">Configurações</h5>
                <div class="d-flex justify-content-around">
                    <div>
                        <button id="themeToggle" class="theme-toggle-btn"></button>
                    </div>
                    <!-- Controle da Luz -->
                    <div class="icon-container">
                        <a href="#" onclick="controlDevice('/relay/on')" id="lightsOn" class="icon-light-on" style="display: block;">
                            <span class="iconify" data-icon="mdi:lightbulb-on" data-width="40" data-height="40"></span>
                        </a>
                        <a href="#" onclick="controlDevice('/relay/off')" id="lightsOff" class="icon-light-off" style="display: none;">
                            <span class="iconify" data-icon="mdi:lightbulb-off" data-width="40" data-height="40"></span>
                        </a>
                    </div>
                    <!-- Controle da Ventilação -->
                    <div>
                        <button onclick="toggleFan()" id="fanOn" class="btn btn-info rounded-circle" style="width: 50px; height: 50px;">
                            <i class="fas fa-fan"></i>
                        </button>
                        <button onclick="toggleFan()" id="fanOff" class="btn btn-info rounded-circle" style="width: 50px; height: 50px; display: none;">
                            <i class="fas fa-fan"></i>
                        </button>
                    </div>
                    <!-- Controle da Bomba de Água -->
                    <div class="icon-container">
                        <a href="#" onclick="controlDevice('/pump/activate')" id="waterPumpOn" class="icon-waterpump-on" style="display: block;">
                            <span class="iconify" data-icon="mdi:water-pump" data-width="40" data-height="40"></span>
                        </a>
                        <a href="#" onclick="controlDevice('/pump/activate')" id="waterPumpOff" class="icon-waterpump-off" style="display: none;">
                            <span class="iconify" data-icon="mdi:water-pump-off" data-width="40" data-height="40"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card de Informações do Clima -->
        <div class="card mb-4" id="weatherCard" style="width: 100%; height: auto;">
            <div class="card-body text-center">
                <h5 class="card-title">Informações do Clima</h5>
                <p class="card-text">Temperatura: <span id="temperature">N/A</span> °C</p>
                <p class="card-text">Descrição: <span id="weatherDescription">N/A</span></p>
               <!-- <p class="card-text none">Localização: <span id="latitude">N/A</span>, <span id="longitude">N/A</span></p>-->
                <div class="text-center">
                    <p class="mb-0"><strong>Horário Local:</strong> <span id="localTime" style="font-size: 1.1em; color: #f44336;"></span></p>
                </div>
            </div>
            
<div id="map" style="height: 300px; width: 100%;"></div>
        </div>
    </div>











                    
            </main>
        </div>
    </div>

    
    <script>
    function updateSensorData() {
        fetch('/dados-esp32')
            .then(response => response.json())
            .then(data => {
                if (data.temperature && data.humidity && data.soil_moisture) {
                    document.getElementById('temperature-value').textContent = `${data.temperature} °C`;
                    document.getElementById('humidity-value').textContent = `${data.humidity} %`;
                    document.getElementById('soil-moisture-value').textContent = `${data.soil_moisture} %`;

                    // Define a temperatura máxima esperada
                    const temperaturaMaxima = 45;

                    // Calcula a porcentagem da temperatura em relação ao máximo
                    let porcentagemTemperatura = (data.temperature / temperaturaMaxima) * 100;
                    porcentagemTemperatura = Math.min(porcentagemTemperatura, 100); // Garante que não exceda 100%

                    // Atualiza a altura dos gráficos
                    document.getElementById('temperature-fill').style.height = `${porcentagemTemperatura}%`;
                    document.getElementById('humidity-fill').style.height = `${data.humidity}%`;
                    document.getElementById('soil-moisture-fill').style.height = `${data.soil_moisture}%`;
                } else {
                    console.error('Dados incompletos recebidos do ESP32:', data);
                }
            })
            .catch(error => console.error('Erro ao obter dados do ESP32:', error));
    }

    // Atualiza os dados a cada 2 segundos
    setInterval(updateSensorData, 2000);
</script>


    

<script>
let isFanOn = false;

function toggleFan() {
    const endpoint = isFanOn ? '/ventilation/off' : '/ventilation/on';

    fetch(endpoint)
        .then(response => response.text())
        .then(data => {
            showNotification(data); // Exibe a resposta do servidor na notificação
            isFanOn = !isFanOn; // Alterna o estado do ventilador
            
            // Alterna a exibição dos botões
            document.getElementById('fanOn').style.display = isFanOn ? 'none' : 'inline-block';
            document.getElementById('fanOff').style.display = isFanOn ? 'inline-block' : 'none';
        })
        .catch(error => {
            console.error('Erro ao enviar comando para o servidor:', error);
            showNotification('Erro ao enviar comando para o servidor'); // Notificação de erro
        });
}

// Inicialização para mostrar o estado correto do botão ao carregar
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('fanOn').style.display = isFanOn ? 'none' : 'inline-block';
    document.getElementById('fanOff').style.display = isFanOn ? 'inline-block' : 'none';
});


</script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkThemeEnabled = localStorage.getItem('dark-theme-enabled') === 'true';

        if (isDarkThemeEnabled) {
            document.body.classList.add('dark-theme');
            document.querySelector('#themeToggle').classList.add('dark');
        }
    });
</script>

<script>
    function controlDevice(endpoint) {
        fetch(endpoint)
            .then(response => response.text())
            .then(data => {
            })
            .catch(error => console.error('Erro ao enviar comando:', error));
    }
</script>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <script src="{{ asset('js/app.js') }}?v={{ time() }}"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
