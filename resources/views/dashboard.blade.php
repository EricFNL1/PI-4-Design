<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Monitoramento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .chart-container {
            height: 300px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }
        h1 {
            color: #343a40;
        }
    </style>
</head>
<body class="dark-theme">
    <div class="container my-4">
        <h1 class="text-center mb-4">Dashboard de Monitoramento</h1>

        <!-- Filtro de período -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3 text-center">
                <label for="periodSelect" class="form-label">Selecionar Período:</label>
                <select id="periodSelect" class="form-select">
                    <option value="7" selected>Última semana</option>
                    <option value="30">Último mês</option>
                </select>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body chart-container">
                        <h5 class="card-title text-center">Temperatura (°C)</h5>
                        <canvas id="temperatureChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body chart-container">
                        <h5 class="card-title text-center">Umidade Relativa (%)</h5>
                        <canvas id="humidityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body chart-container">
                        <h5 class="card-title text-center">Umidade do Solo (%)</h5>
                        <canvas id="soilMoistureChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão Voltar -->
        <div class="text-center mt-4">
            <a href="{{ route('index') }}" class="btn btn-primary">Voltar para Home</a>
        </div>
    </div>

    <script>
        const chartData = @json($chartData);

        // Gráfico de Temperatura
        new Chart(document.getElementById('temperatureChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: chartData.temperature,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Data' } },
                    y: { title: { display: true, text: 'Temperatura (°C)' } }
                }
            }
        });

        // Gráfico de Umidade Relativa
        new Chart(document.getElementById('humidityChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Umidade Relativa (%)',
                    data: chartData.humidity,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Data' } },
                    y: { title: { display: true, text: 'Umidade Relativa (%)' } }
                }
            }
        });

        // Gráfico de Umidade do Solo
        new Chart(document.getElementById('soilMoistureChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Umidade do Solo (%)',
                    data: chartData.soil_moisture,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Data' } },
                    y: { title: { display: true, text: 'Umidade do Solo (%)' } }
                }
            }
        });

        // Atualizar dados ao selecionar o período
        document.getElementById('periodSelect').addEventListener('change', function () {
            const days = this.value;

            fetch(`/dashboard-data?days=${days}`)
                .then(response => response.json())
                .then(data => {
                    chartData.labels = data.labels;
                    chartData.temperature = data.temperature;
                    chartData.humidity = data.humidity;
                    chartData.soil_moisture = data.soil_moisture;

                    // Atualizar gráficos
                    temperatureChart.data.labels = chartData.labels;
                    temperatureChart.data.datasets[0].data = chartData.temperature;
                    temperatureChart.update();

                    humidityChart.data.labels = chartData.labels;
                    humidityChart.data.datasets[0].data = chartData.humidity;
                    humidityChart.update();

                    soilMoistureChart.data.labels = chartData.labels;
                    soilMoistureChart.data.datasets[0].data = chartData.soil_moisture;
                    soilMoistureChart.update();
                })
                .catch(error => console.error('Erro ao buscar dados:', error));
        });
    </script>

<script src="script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkThemeEnabled = localStorage.getItem('dark-theme-enabled') === 'true';

        if (isDarkThemeEnabled) {
            document.body.classList.add('dark-theme');
            document.querySelector('#themeToggle').classList.add('dark');
        }
    });
</script>
</body>
</html>
