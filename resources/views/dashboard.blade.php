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

        <div class="text-center my-4">
    <label for="periodSelect">Selecionar Período:</label>
    <select id="periodSelect" class="form-select w-50 mx-auto">
        <option value="7">Última semana</option>
        <option value="30">Último mês</option>
    </select>
</div>


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
    const dataByDay = {
        7: {
            labels: ['1', '2', '3', '4', '5', '6', '7'],
            temperatureData: [30, 32, 33, 29, 35, 31, 30],
            humidityData: [70, 72, 75, 68, 74, 71, 73],
            airHumidityData: [65, 67, 69, 70, 71, 72, 73]
        },
        30: {
            labels: ['1', '5', '10', '15', '20', '25', '30'],
            temperatureData: [29, 30, 31, 32, 30, 28, 29],
            humidityData: [68, 70, 72, 74, 71, 69, 70],
            airHumidityData: [64, 65, 66, 67, 68, 69, 70]
        }
    };

    const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
    const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
    const ctxAirHumidity = document.getElementById('airHumidityChart').getContext('2d');

    let temperatureChart = createChart(ctxTemp, dataByDay[7].labels, dataByDay[7].temperatureData, 'Temperatura (°C)');
    let humidityChart = createChart(ctxHumidity, dataByDay[7].labels, dataByDay[7].humidityData, 'Umidade (%)');
    let airHumidityChart = createChart(ctxAirHumidity, dataByDay[7].labels, dataByDay[7].airHumidityData, 'Umidade no Ar (%)');

    document.getElementById('periodSelect').addEventListener('change', function () {
        const selectedPeriod = this.value;

        updateChart(temperatureChart, dataByDay[selectedPeriod].labels, dataByDay[selectedPeriod].temperatureData);
        updateChart(humidityChart, dataByDay[selectedPeriod].labels, dataByDay[selectedPeriod].humidityData);
        updateChart(airHumidityChart, dataByDay[selectedPeriod].labels, dataByDay[selectedPeriod].airHumidityData);
    });

    function createChart(ctx, labels, data, label) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false,
                }]
            }
        });
    }

    function updateChart(chart, labels, data) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update();
    }
</script>


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
