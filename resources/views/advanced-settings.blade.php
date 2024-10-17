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

        <!-- Exibição das Fases do Cultivo -->
        <div class="my-4">
            <h2>Fases do Cultivo do Morango</h2>
            <div class="accordion" id="cultivoAccordion">
                @foreach($phases as $fase => $detalhes)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $fase }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $fase }}" aria-expanded="true" aria-controls="collapse{{ $fase }}">
                                {{ $fase }}
                            </button>
                        </h2>
                        <div id="collapse{{ $fase }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $fase }}" data-bs-parent="#cultivoAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li><strong>Luz:</strong> {{ $detalhes['luz'] }}</li>
                                    <li><strong>Água:</strong> {{ $detalhes['agua'] }}</li>
                                    <li><strong>Temperatura:</strong> {{ $detalhes['temperatura'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

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
