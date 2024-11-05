@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Recuperação de Senha</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar link de redefinição</button>
    </form>
    <div class="mt-3"><a href="{{ route('login') }}" class="btn btn-secondary">
    Voltar para Login
</a></div>


    @if (session('status'))
        <div class="alert alert-success mt-3">
            {{ session('status') }}
        </div>
    @endif
</div>
@endsection
