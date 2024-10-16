<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledashboard.css">
    <title>Logs de Monitoramento</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
    <div class="container my-4">
        <h1 class="text-center">Logs de Monitoramento</h1>

        <!-- Filtro por Data -->
        <form method="GET" action="{{ url('/logs') }}">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="dataInicio" class="form-label">Data de Início</label>
                    <input type="date" name="dataInicio" id="dataInicio" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="dataFim" class="form-label">Data de Fim</label>
                    <input type="date" name="dataFim" id="dataFim" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de Logs Simulados -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Temperatura</th>
                    <th>Umidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log['data'] }}</td>
                        <td>{{ $log['hora'] }}</td>
                        <td>{{ $log['temperatura'] }} °C</td>
                        <td>{{ $log['umidade'] }} %</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
