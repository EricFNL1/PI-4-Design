<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dados do Sensor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center">Dados do Sensor</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Temperatura (°C)</th>
                    <th>Umidade (%)</th>
                    <th>Umidade do Solo (%)</th>
                    <th>Data e Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sensorData as $data)
                    <tr>
                        <td>{{ $data->temperature }}</td>
                        <td>{{ $data->humidity }}</td>
                        <td>{{ $data->soil_moisture }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    function updateSensorData() {
        const temperatureElement = document.getElementById('temperature-value');
        const humidityElement = document.getElementById('humidity-value');
        const soilMoistureElement = document.getElementById('soil-moisture-value');

        // Verifica se os elementos existem antes de acessar `textContent`
        const temperature = temperatureElement ? temperatureElement.textContent.replace('°C', '').trim() : null;
        const humidity = humidityElement ? humidityElement.textContent.replace('%', '').trim() : null;
        const soilMoisture = soilMoistureElement ? soilMoistureElement.textContent.replace('%', '').trim() : null;

        if (temperature && humidity && soilMoisture) {
            fetch('/data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    temperature: parseFloat(temperature),
                    humidity: parseFloat(humidity),
                    soil_moisture: parseFloat(soilMoisture)
                }),
            })
            .then(response => response.json())
            .then(data => console.log('Dados enviados:', data))
            .catch(error => console.error('Erro ao enviar dados:', error));
        } else {
            console.warn('Um ou mais elementos do DOM não foram encontrados ou possuem valores inválidos.');
        }
    }

    // Atualiza os dados a cada 8 segundos
    setInterval(updateSensorData, 8000);
});


</script>
</html>

