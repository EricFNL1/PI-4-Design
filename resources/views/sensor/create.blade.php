@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Sensor</h1>

    <form action="{{ route('sensor.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome do Sensor</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo de Sensor</label>
            <input type="text" name="tipo" id="tipo" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="estufa_id">Estufa</label>
            <select name="estufa_id" id="estufa_id" class="form-control" required>
                @foreach($estufas as $estufa)
                    <option value="{{ $estufa->id }}">{{ $estufa->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-2">Cadastrar</button>
    </form>

    <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
</div>
@endsection
