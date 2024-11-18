<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledashboard.css">
    <title>Status dos Equipamentos</title>
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4 page3">
        <h1 class="text-center">Status dos Equipamentos</h1>

        <!-- Status dos Equipamentos -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sensor de Temperatura</h5>
                        <p class="card-text">
                            Status: <span id="temperature-status" class="badge">Aguardando...</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sensor de Umidade</h5>
                        <p class="card-text">
                            Status: <span id="humidity-status" class="badge">Aguardando...</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sensor de Umidade do Solo</h5>
                        <p class="card-text">
                            Status: <span id="soil-moisture-status" class="badge">Aguardando...</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center my-4">
        <a href="/" class="back-button">Voltar para Home</a>
    </div>

    <script>
        // Função para atualizar o status dos equipamentos
        function updateEquipmentStatus() {
            fetch('/dados-esp32')
                .then(response => response.json())
                .then(data => {
                    // Seletores para os elementos de status
                    const temperatureStatus = document.getElementById('temperature-status');
                    const humidityStatus = document.getElementById('humidity-status');
                    const soilMoistureStatus = document.getElementById('soil-moisture-status');

                    // Lógica para o Sensor de Temperatura
                    if (data.temperature > 35) {
                        temperatureStatus.textContent = 'Alto';
                        temperatureStatus.className = 'badge bg-danger';
                    } else if (data.temperature >= 15 && data.temperature <= 35) {
                        temperatureStatus.textContent = 'Normal';
                        temperatureStatus.className = 'badge bg-success';
                    } else {
                        temperatureStatus.textContent = 'Baixo';
                        temperatureStatus.className = 'badge bg-warning';
                    }

                    // Lógica para o Sensor de Umidade
                    if (data.humidity > 80) {
                        humidityStatus.textContent = 'Alta';
                        humidityStatus.className = 'badge bg-danger';
                    } else if (data.humidity >= 30 && data.humidity <= 80) {
                        humidityStatus.textContent = 'Normal';
                        humidityStatus.className = 'badge bg-success';
                    } else {
                        humidityStatus.textContent = 'Baixa';
                        humidityStatus.className = 'badge bg-warning';
                    }

                    // Lógica para o Sensor de Umidade do Solo
                    if (data.soil_moisture > 70) {
                        soilMoistureStatus.textContent = 'Úmido';
                        soilMoistureStatus.className = 'badge bg-success';
                    } else if (data.soil_moisture >= 30 && data.soil_moisture <= 70) {
                        soilMoistureStatus.textContent = 'Moderado';
                        soilMoistureStatus.className = 'badge bg-warning';
                    } else {
                        soilMoistureStatus.textContent = 'Seco';
                        soilMoistureStatus.className = 'badge bg-danger';
                    }
                })
                .catch(error => {
                    console.error('Erro ao obter dados do ESP32:', error);
                    // Atualiza os status para indicar erro
                    document.getElementById('temperature-status').textContent = 'Erro';
                    document.getElementById('temperature-status').className = 'badge bg-danger';
                    document.getElementById('humidity-status').textContent = 'Erro';
                    document.getElementById('humidity-status').className = 'badge bg-danger';
                    document.getElementById('soil-moisture-status').textContent = 'Erro';
                    document.getElementById('soil-moisture-status').className = 'badge bg-danger';
                });
        }

        // Atualiza o status dos equipamentos a cada 5 segundos
        setInterval(updateEquipmentStatus, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
