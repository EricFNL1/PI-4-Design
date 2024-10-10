<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Controle de Estufa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/loginstyles.css') }}">
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">

</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row g-0 shadow-lg rounded-4 overflow-hidden">
            <div class="col-lg-6 d-none d-lg-block bg-success p-4 text-center">
                <img src="{{ asset('img/fundologin.jpg') }}" alt="Imagem Estufa" class="img-fluid">
            </div>
            <div class="col-lg-6 bg-light p-5 d-flex flex-column justify-content-center">
                <h2 class="text-success text-center mb-4">SEJA BEM VINDO</h2>
                <p class="text-success text-center mb-4">ao Controle de Estufa</p>
                <form method="POST" action="{{ route('login') }}">

                           <!-- Exibir mensagem de erro -->
                           @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    @csrf
    <div class="mb-3">
        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
    </div>
    <div class="mb-4">
        <input type="password" name="password" class="form-control form-control-lg" placeholder="Senha" required>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-success btn-lg">ENTRAR ➜</button>
    </div>
</form>
<a href="{{ route('password.request') }}" class="text-success">Esqueceu sua senha?</a>


                <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="text-success">CRIAR CONTA</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
