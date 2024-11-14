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

        <div class="text-center my-4 mt-5">
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
        const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
        const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
        const ctxAirHumidity = document.getElementById('airHumidityChart').getContext('2d');

        let temperatureChart, humidityChart, airHumidityChart;

        function createChart(ctx, label, borderColor) {
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: label,
                        data: [],
                        borderColor: borderColor,
                        fill: false,
                    }]
                }
            });
        }

        function fetchData(days) {
            fetch(`/api/sensor-data?days=${days}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(entry => new Date(entry.created_at).toLocaleDateString());
                    const temperatureData = data.map(entry => entry.temperature);
                    const humidityData = data.map(entry => entry.humidity);
                    const airHumidityData = data.map(entry => entry.soil_moisture);

                    updateChart(temperatureChart, labels, temperatureData);
                    updateChart(humidityChart, labels, humidityData);
                    updateChart(airHumidityChart, labels, airHumidityData);
                })
                .catch(error => console.error('Erro ao buscar dados do banco:', error));
        }

        function updateChart(chart, labels, data) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();
        }

        document.getElementById('periodSelect').addEventListener('change', function () {
            const selectedPeriod = this.value;
            fetchData(selectedPeriod);
        });

        // Inicializar gráficos e buscar dados para a última semana
        temperatureChart = createChart(ctxTemp, 'Temperatura (°C)', 'rgba(255, 99, 132, 1)');
        humidityChart = createChart(ctxHumidity, 'Umidade (%)', 'rgba(54, 162, 235, 1)');
        airHumidityChart = createChart(ctxAirHumidity, 'Umidade no Ar (%)', 'rgba(75, 192, 192, 1)');

        // Carregar dados iniciais
        fetchData(7);
    </script>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
