<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledashboard.css">
    <title>Status dos Equipamentos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center">Status dos Equipamentos</h1>

        <!-- Status Simulado dos Equipamentos -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sensor de Temperatura</h5>
                        <p class="card-text">
                            Status: <span class="badge bg-success">Funcionando</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Sensor de Umidade</h5>
                        <p class="card-text">
                            Status: <span class="badge bg-warning">Atenção</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Atuador de Ventilação</h5>
                        <p class="card-text">
                            Status: <span class="badge bg-danger">Desligado</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
