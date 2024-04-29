<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Neptuno</title>

    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/admin/sb-admin.css') }}" rel="stylesheet">

</head>

<body style="background-color: #006cff">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div style="text-align: center;">
                <img src="img/Neptuno.png" alt=""
                    style="width: 230px; display: block; margin-left: auto; margin-right: auto;">
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12 text-md-end">
                            <!-- Nombre -->
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="{{ __('Nombre') }}" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 text-md-end">
                            <!-- Email -->
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="{{ __('Correo Electrónico') }}" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 text-md-end">
                            <!-- Contraseña -->
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="{{ __('Contraseña') }}" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 text-md-end">
                            <!-- Confirmar Contraseña -->
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" placeholder="{{ __('Confirmar Contraseña') }}" required autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary btn-block">
                        {{ __('Registrarse') }}
                    </button>
                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" style="color: #5f5f5f" href="{{ route('login') }}">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

</body>

</html>
