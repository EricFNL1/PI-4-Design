@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Estufa</h1>

    <form action="{{ route('estufa.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome da Estufa</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Criar</button>
    </form>

    <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
</div>
@endsection
