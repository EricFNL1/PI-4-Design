<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações Avançadas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styledashboard.css">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center">Configurações Avançadas</h1>

        <!-- Formulário de controle de velocidade das ventoinhas -->
        <form method="POST" action="{{ route('advanced.settings.update') }}">
            @csrf
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="fan_speed" class="form-label">Velocidade da Ventoinha (%)</label>
                    <input type="number" name="fan_speed" id="fan_speed" class="form-control" min="1" max="100" required value="50">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Configuração</button>
        </form>

        <!-- Mensagem de sucesso -->
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Botão de Voltar -->
        <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDarkThemeEnabled = localStorage.getItem('dark-theme-enabled') === 'true';

            if (isDarkThemeEnabled) {
                document.body.classList.add('dark-theme');
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
