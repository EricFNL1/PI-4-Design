@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row g-0 shadow-lg rounded-4 overflow-hidden">
        <div class="col-lg-6 d-none d-lg-block bg-success p-4 text-center">
            <img src="img/fundologin.jpg" alt="Imagem Estufa" class="img-fluid">
        </div>
        <div class="col-lg-6 bg-light p-5 d-flex flex-column justify-content-center">
            <h2 class="text-success text-center mb-4">CRIAR CONTA</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Nome" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Senha" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirme a Senha" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">REGISTRAR</button>
                </div>
                <div class="mt-3">
                    <a href="{{ route('login') }}" class="btn btn-secondary">Voltar para Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
