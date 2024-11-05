@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Redefinir Senha</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password">Nova Senha</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password-confirm">Confirme a Nova Senha</label>
            <input type="password" name="password_confirmation" id="password-confirm" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Redefinir Senha</button>
    </form>
</div>
@endsection
