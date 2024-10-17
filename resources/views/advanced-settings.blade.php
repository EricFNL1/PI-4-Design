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
                        <h2 class="accordion-header" id="heading{{ str_replace(' ', '_', $fase) }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ str_replace(' ', '_', $fase) }}" aria-expanded="false" aria-controls="collapse{{ str_replace(' ', '_', $fase) }}">
                                {{ $fase }}
                            </button>
                        </h2>
                        <div id="collapse{{ str_replace(' ', '_', $fase) }}" class="accordion-collapse collapse" aria-labelledby="heading{{ str_replace(' ', '_', $fase) }}" data-bs-parent="#cultivoAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li><strong>Luz:</strong> {{ $detalhes['luz'] }}</li>
                                    <li><strong>Água:</strong> {{ $detalhes['agua'] }}</li>
                                    <li><strong>Temperatura:</strong> {{ $detalhes['temperatura'] }}</li>
                                </ul>
                                <!-- Botão para Selecionar a Fase -->
                                <form method="POST" action="{{ route('fase.selecionar') }}">
                                    @csrf
                                    <input type="hidden" name="fase" value="{{ $fase }}">
                                    <button type="submit" class="btn btn-success mt-3">Selecionar {{ $fase }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

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
