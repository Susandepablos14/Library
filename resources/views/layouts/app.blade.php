<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Neptuno</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/admin/sb-admin.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <div>
        <main>
            <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

                <a class="navbar-brand mr-1" href="/">
                    <img src="{{ asset('img/logo.png') }}" alt="Mi Sitio" style="height:30px; width:auto;">
                </a>

                <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                    <i class="fas fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                    {{-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge badge-danger">9+</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li> --}}
                    {{-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge badge-danger">7</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">Perfil</a>
                            <a class="dropdown-item" href="{{ route('password.index') }}">Contraseña</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Cerrar Sesión</a>
                        </div>
                    </li>
                </ul>

            </nav>
            <div id="wrapper">
                <!-- Sidebar -->
                <ul class="sidebar navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @can('users.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                    @endcan
                    @can('seguridad')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-lock"></i>
                                <span>Seguridad</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                                <h6 class="dropdown-header">Seguridad:</h6>
                                @can('roles.index')
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                                @endcan
                                @can('permissions.index')
                                    <a class="dropdown-item" href="{{ route('permissions.index') }}">Permisos</a>
                                @endcan
                                @can('logs.index')
                                    <a class="dropdown-item" href="{{ route('logs.index') }}">Logs</a>
                                @endcan
                            </div>
                        </li>
                    @endcan
                    @can('config')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs"></i>
                                <span>Configuración</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                                <h6 class="dropdown-header">Configuracion:</h6>
                                @can('countries.index')
                                    <a class="dropdown-item" href="{{ route('countries.index') }}">Países</a>
                                @endcan
                                @can('categories.index')
                                    <a class="dropdown-item" href="{{ route('categories.index') }}">Categorias</a>
                                @endcan
                                @can('authors.index')
                                    <a class="dropdown-item" href="{{ route('authors.index') }}">Autores</a>
                                @endcan
                                @can('editorials.index')
                                    <a class="dropdown-item" href="{{ route('editorials.index') }}">Editoriales</a>
                                @endcan
                                @can('books.index')
                                    <a class="dropdown-item" href="{{ route('books.index') }}">Libros</a>
                                @endcan
                                @can('copies.index')
                                    <a class="dropdown-item" href="{{ route('copies.index') }}">Copias</a>
                                @endcan
                                @can('bookings.index')
                                <a class="dropdown-item" href="{{ route('bookings.index') }}">Reservaciones</a>
                            @endcan
                            </div>
                        </li>
                    @endcan
                </ul>
                <div id="content-wrapper">
                    @yield('content')
                    <footer class="sticky-footer">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright © Neptuno 2024</span>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </main>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo/a para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Seleccione "Cerrar sesión" a continuación si está listo/a para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/admin/sb-admin.min.js') }}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{ asset('js/admin/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('js/admin/demo/chart-area-demo.js') }}"></script>
</body>

</html>
