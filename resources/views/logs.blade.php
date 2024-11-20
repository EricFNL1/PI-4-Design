<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledashboard.css">
    <title>Logs de Monitoramento</title>
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4 page2">
        <h1 class="text-center mb-5">Logs de Monitoramento</h1>

        <!-- Filtro por Data -->
        <form method="GET" action="{{ url('/logs') }}">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="dataInicio" class="form-label">Data de Início</label>
                    <input type="date" name="dataInicio" id="dataInicio" class="form-control" value="{{ request('dataInicio') }}">
                </div>
                <div class="col-md-4">
                    <label for="dataFim" class="form-label">Data de Fim</label>
                    <input type="date" name="dataFim" id="dataFim" class="form-control" value="{{ request('dataFim') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de Logs -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Temperatura</th>
                    <th>Umidade</th>
                    <th>Umidade do Solo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y') }}</td>
                    <td>{{ $log->created_at->format('H:i:s') }}</td>
                    <td>{{ $log->temperature }} °C</td>
                    <td>{{ $log->humidity }} %</td>
                    <td>{{ $log->soil_moisture }} %</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum log encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Controle de Paginação -->
        <div class="d-flex justify-content-center">
            {{ $logs->appends(request()->query())->links() }}
        </div>

        <div class="text-center my-4">
            <a href="/" class="btn btn-secondary">Voltar para Home</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
