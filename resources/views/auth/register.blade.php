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
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Nome" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Senha" id="password" required>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Sua senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas e números.
                    </small>
                    <div id="passwordFeedback" class="invalid-feedback">
                        A senha deve conter no mínimo 8 caracteres, com ao menos uma letra maiúscula, uma minúscula e um número.
                    </div>
                </div>
                <div class="mb-4">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirme a Senha" id="password_confirmation" required>
                    <div id="passwordMatchFeedback" class="invalid-feedback">
                        As senhas não coincidem.
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg" id="registerButton">REGISTRAR</button>
                </div>
                <div class="mt-3">
                    <a href="{{ route('login') }}" class="btn btn-secondary">Voltar para Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Função para validar a senha
    function validatePassword(password) {
        const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return passwordRegex.test(password);
    }

    document.getElementById('registerForm').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const passwordField = document.getElementById('password');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const passwordMatchFeedback = document.getElementById('passwordMatchFeedback');

        let valid = true;

        // Verifica se a senha atende aos critérios
        if (!validatePassword(password)) {
            passwordField.classList.add('is-invalid');
            passwordFeedback.style.display = 'block';
            valid = false;
        } else {
            passwordField.classList.remove('is-invalid');
            passwordFeedback.style.display = 'none';
        }

        // Verifica se as senhas coincidem
        if (password !== passwordConfirmation) {
            document.getElementById('password_confirmation').classList.add('is-invalid');
            passwordMatchFeedback.style.display = 'block';
            valid = false;
        } else {
            document.getElementById('password_confirmation').classList.remove('is-invalid');
            passwordMatchFeedback.style.display = 'none';
        }

        // Se não for válido, impede o envio do formulário
        if (!valid) {
            event.preventDefault();
        }
    });
</script>
@endsection
