<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Monitoramento</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styledashboard.css">
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">
</head>
<body>
    <div class="container page1 my-4">
        <h1 class="text-center mb-5">Dashboard de Monitoramento</h1>

        <!-- Filtro de Período -->
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
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Temperatura (°C)</h5>
                        <canvas id="temperatureChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Umidade Relativa (%)</h5>
                        <canvas id="humidityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Umidade do Solo (%)</h5>
                        <canvas id="soilMoistureChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão Voltar -->
        <div class="text-center mt-4">
            <a href="/" class="btn btn-primary">Voltar para Home</a>
        </div>
    </div>

    <script>
        // Inicialização dos gráficos
        const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
        const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
        const ctxSoilMoisture = document.getElementById('soilMoistureChart').getContext('2d');

        let temperatureChart, humidityChart, soilMoistureChart;

        function createChart(ctx, label, borderColor) {
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Inicialmente vazio
                    datasets: [{
                        label: label,
                        data: [],
                        borderColor: borderColor,
                        backgroundColor: 'rgba(0, 0, 0, 0.05)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Data'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: label
                            }
                        }
                    }
                }
            });
        }

        function fetchData(days) {
            fetch(`/sensor-data?days=${days}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar dados do banco');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.length > 0) {
                        const labels = data.map(entry => new Date(entry.created_at).toLocaleString('pt-BR'));
                        const temperatureData = data.map(entry => entry.temperature);
                        const humidityData = data.map(entry => entry.humidity);
                        const soilMoistureData = data.map(entry => entry.soil_moisture);

                        updateChart(temperatureChart, labels, temperatureData);
                        updateChart(humidityChart, labels, humidityData);
                        updateChart(soilMoistureChart, labels, soilMoistureData);
                    } else {
                        console.error('Nenhum dado disponível.');
                    }
                })
                .catch(error => console.error(error.message));
        }

        function updateChart(chart, labels, data) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();
        }

        // Evento para mudança de período
        document.getElementById('periodSelect').addEventListener('change', function () {
            const selectedPeriod = this.value;
            fetchData(selectedPeriod);
        });

        // Inicialização
        temperatureChart = createChart(ctxTemp, 'Temperatura (°C)', 'rgba(255, 99, 132, 1)');
        humidityChart = createChart(ctxHumidity, 'Umidade Relativa (%)', 'rgba(54, 162, 235, 1)');
        soilMoistureChart = createChart(ctxSoilMoisture, 'Umidade do Solo (%)', 'rgba(75, 192, 192, 1)');

        // Carregar dados iniciais (últimos 7 dias)
        fetchData(7);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
