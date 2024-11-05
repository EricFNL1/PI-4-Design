<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Estufas e Sensores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Gerenciador de Estufas e Sensores</h1>

        <!-- Estufas -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3>Estufas</h3>
            </div>
            <div class="card-body">
                @if($estufas->isEmpty())
                    <p class="text-center">Nenhuma estufa cadastrada.</p>
                @else
                    <div class="accordion" id="estufaAccordion">
                        @foreach($estufas as $index => $estufa)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                        {{ $estufa->nome }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#estufaAccordion">
                                    <div class="accordion-body">
                                        <h5>Sensores:</h5>
                                        <ul class="list-group">
                                            @foreach($sensores->where('estufa_id', $estufa->id) as $sensor)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $sensor->nome }}
                                                    <form action="{{ route('sensor.destroy', $sensor->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="mt-3">
                                            <form action="{{ route('estufa.destroy', $estufa->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Excluir Estufa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
