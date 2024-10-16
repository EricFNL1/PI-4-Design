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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block  sidebar p-0">
                <div class="position-sticky">
                    <!-- Logo -->
                    <div class="sidebar-header text-center p-3">
                        <img src="img/fundologin.jpg" class="img-fluid rounded-circle" alt="Logo Estufa">
                    </div>
                    <!-- Menu Items -->
                    <ul class="nav flex-column text-center">
                        <li class="nav-item">
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

                    <div class="text-center mt-3 clock-container">
        <h3>Horário Local:</h3>
        <div class="time-display" id="localTime"></div>
    </div>
                    <div class="text-center mt-5">
                        <a href="{{ route('advanced.settings')}}" class="text-dark">Configurações Avançadas<i class="bi bi-gear-fill"></i></a>
                        <a  class="btn btn-danger w-75 mt-3" href="{{ url('/weather-from-ip') }}" class="btn btn-info">Obter Informações pelo IP</a>
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
                            <li><a class="dropdown-item" href="#" data-action="themeToggle">Alternar Tema</a></li>
                            <li><a class="dropdown-item" href="#" data-action="lightsOn">Ligar Luzes</a></li>
                            <li><a class="dropdown-item" href="#" data-action="lightsOff">Desligar Luzes</a></li>
                            <li><a class="dropdown-item" href="#" data-action="fanToggle">Ligar/Desligar Ventoinha</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Home</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Detalhamento</a></li>
                            <li><a class="dropdown-item" href="{{ route('logs') }}">Log & Histórico</a></li>
                            <li><a class="dropdown-item" href="{{ route('status') }}">Status</a></li>
                            <li class="text-center mt-3"><a href="#" class="btn btn-danger w-75" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Sair <i class="bi bi-box-arrow-right"></i>
</a></li>
                        </ul>
                        
                    </div>
    </div>
                <!-- Cards de Conteúdo -->
                <div class="row">
    <div class="col-md-8">
        <div class="row">
            <!-- Relatório de Temperatura -->
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-center">Relatório de Temperatura</h3>
                        <div class="thermometer-container">
                            <div class="thermometer">
                                <div class="thermometer-fill" style="height: 50%;"></div>
                                <div class="thermometer-bulb"></div>
                            </div>
                            <p class="text-center mt-3">Temperatura Atual: <span id="temperature-value">25°C</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Relatório de Umidade -->
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-center">Relatório de Umidade</h3>
                        <div class="aquarium-container">
                            <div class="aquarium">
                                <div class="water-level" style="height: 50%;"></div>
                            </div>
                            <p class="text-center mt-3">Umidade Atual: <span id="humidity-value">50%</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Relatório de Umidade do Ar -->
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-center">Relatório de Umidade do Ar</h3>
                        <div class="humidity-meter">
                            <div class="gauge">
                                <div class="gauge-cover"></div>
                                <div class="gauge-needle"></div>
                            </div>
                            <p class="text-center mt-3">Umidade Atual: <span id="humidity-air-value">50%</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Configurações -->
    <div class="col-md-4">
    <div class="card mb-4" style="width: 100%;">
        <div class="card-body text-center">
            <h5 class="card-title">Configurações</h5>
            <div class="d-flex justify-content-around">
                <div>
                    <button id="themeToggle" class="theme-toggle-btn"></button>
                </div>
                <div class="icon-container">
                    <a href="#" id="lightsOn" class="icon-light-on" style="display: block;">
                        <span class="iconify" data-icon="mdi:lightbulb-on" data-width="40" data-height="40"></span>
                    </a>
                    <a href="#" id="lightsOff" class="icon-light-off" style="display: none;">
                        <span class="iconify" data-icon="mdi:lightbulb-off" data-width="40" data-height="40"></span>
                    </a>
                </div>
                <div>
                    <button id="fanToggle" class="btn btn-info rounded-circle" style="width: 50px; height: 50px;">
                        <i class="fas fa-fan" id="fanIcon"></i>
                    </button>
                </div>
                <div class="icon-container">
                    <a href="#" id="waterPumpOn" class="icon-waterpump-on" style="display: block;">
                        <span class="iconify" data-icon="mdi:water-pump" data-width="40" data-height="40"></span>
                    </a>
                    <a href="#" id="waterPumpOff" class="icon-waterpump-off" style="display: none;">
                        <span class="iconify" data-icon="mdi:water-pump-off" data-width="40" data-height="40"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
    <div class="card mb-4" id="weatherCard" style="width: 100%; height: auto;">
        <div class="card-body text-center">
            <h5 class="card-title">Informações do Clima</h5>
            <p class="card-text">Temperatura: <span id="temperature">N/A</span> °C</p>
            <p class="card-text">Descrição: <span id="weatherDescription">N/A</span></p>
            <p class="card-text">Localização: <span id="latitude">N/A</span>, <span id="longitude">N/A</span></p>
        </div>
    </div>
</div>



                    
            </main>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkThemeEnabled = localStorage.getItem('dark-theme-enabled') === 'true';

        if (isDarkThemeEnabled) {
            document.body.classList.add('dark-theme');
            document.querySelector('#themeToggle').classList.add('dark');
        }
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <script src="{{ asset('js/app.js') }}?v={{ time() }}"></script>
</body>
</html>
