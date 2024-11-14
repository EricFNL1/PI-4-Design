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
    function updateSensorData() {
    fetch('/data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            temperature: document.getElementById('temperature-value').textContent,
            humidity: document.getElementById('humidity-value').textContent,
            soil_moisture: document.getElementById('soil-moisture-value').textContent
        }),
    })
    .then(response => response.json())
    .then(data => console.log('Dados enviados:', data))
    .catch(error => console.error('Erro ao enviar dados:', error));
}

// Atualiza os dados a cada 8 segundos
setInterval(updateSensorData, 8000);

</script>
</html>

