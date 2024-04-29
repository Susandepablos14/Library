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
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" id="inputEmail"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email address"
                                required="required" autofocus="autofocus" name="email" value="{{ old('email') }}"
                                required autocomplete="email" autofocus> @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="inputEmail">Correo Electrónico</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" id="inputPassword"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                name="password" required autocomplete="current-password"> @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="inputPassword">Contraseña</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                Recordar Contraseña
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-block">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </form>
                <div class="text-center">
                    {{-- <a class="d-block small" href="{{ route('password.request') }}">Recuperar Contraseña?</a> --}}
                    <a class="d-block small mt-3" style="color: #5f5f5f" href="{{ route('register') }}">Registrarse</a>
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
