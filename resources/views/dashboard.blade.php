<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Monitoramento</title>
    
    <!-- Incluindo Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Incluindo Chart.js -->
    <link rel="stylesheet" href="styledashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">

</head>
<body>
    <div class="container page1">
        <h1 class="text-center my-4">Dashboard de Monitoramento</h1>

        <!-- Container para os gráficos -->
        <div class="row">
            <div class="col-md-4 chart-container">
                <canvas id="temperatureChart"></canvas>
            </div>
            <div class="col-md-4 chart-container">
                <canvas id="humidityChart"></canvas>
            </div>
            <div class="col-md-4 chart-container">
                <canvas id="airHumidityChart"></canvas>
            </div>
        </div>

        <!-- Botão Voltar -->
        <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
    </div>

    <script>
        // Dados simulados para os gráficos
        const temperatureData = [30, 32, 33, 29, 35, 31, 30]; // Temperatura simulada
        const humidityData = [70, 72, 75, 68, 74, 71, 73]; // Umidade simulada
        const airHumidityData = [65, 67, 69, 70, 71, 72, 73]; // Umidade no Ar simulada

        // Gráfico de Temperatura
        const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
        new Chart(ctxTemp, {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7'],
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: temperatureData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false,
                }]
            }
        });

        // Gráfico de Umidade
        const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
        new Chart(ctxHumidity, {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7'],
                datasets: [{
                    label: 'Umidade (%)',
                    data: humidityData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false,
                }]
            }
        });

        // Gráfico de Umidade no Ar
        const ctxAirHumidity = document.getElementById('airHumidityChart').getContext('2d');
        new Chart(ctxAirHumidity, {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7'],
                datasets: [{
                    label: 'Umidade no Ar (%)',
                    data: airHumidityData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false,
                }]
            }
        });
    </script>

<script src="script.js"></script>

    <!-- Script para gerenciar tema e salvar no localStorage -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDarkThemeEnabled = localStorage.getItem('dark-theme-enabled') === 'true';

            if (isDarkThemeEnabled) {
                document.body.classList.add('dark-theme');
            }
        });
    </script>

    <!-- Incluindo Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
