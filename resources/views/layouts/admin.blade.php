<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Sistema de Gestion sindical para la UOM seccional Avellaneda">
    <meta name="Juan Carlos Barrios - Axyonar - 2020">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sindical</title>
    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link href="{{ asset('img/logo_avellaneda.png') }}" rel="icon" type="image/png">
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15"></div>
                <div class="sidebar-brand-text mx-3">SINDICAL AVELLANEDA<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Afiliados
            </div>
            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('consultar afiliado'))
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('afiliado.index') }}">
                    <i class="far fa-address-book"></i>
                    <span>Ficha de Afiliados</span></a>
            </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Empresas
            </div>
            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('consultar empresas'))
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('empresa.index') }}">
                    <i class="fas fa-city"></i>
                    <span>Fichas empresas</span></a>
            </li>
            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider">


            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('consultar denuncias'))
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('denuncia.index') }}">
                    <i class="fas fa-balance-scale"></i>
                    <span>Denuncias</span></a>
            </li>
            @endcan
            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('informes'))
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('informes.index') }}">
                    <i class="fas fa-file-invoice"></i>
                    <span>Informes</span></a>
            </li>
            @endcan
            <!-- Nav Item - Tables -->
            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('padron secretariado'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#opsecretariado" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-fw fa-cog"></i>
                    <span>Padron secretariado</span>
                </a>
                <div id="opsecretariado" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Menu:</h6> -->
                        <a class="collapse-item" href="{{ route('secretariado.importar') }}">Importar padron</a>
                        <a class="collapse-item" href="{{ route('secretariado.informes') }}">Informes</a>
                    </div>
                </div>
            </li>
            @endcan
            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('seguridad consultas'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#opadmin" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-fw fa-cog"></i>
                    <span>Seguridad</span>
                </a>
                <div id="opadmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Menu:</h6> -->
                        <a class="collapse-item" href="{{ route('usuario.index') }}">Usuarios</a>
                        <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
                        <a class="collapse-item" href="{{ route('permisos.index') }}">Permisos</a>
                    </div>
                </div>
            </li>
            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <img src="/img/logo_avellaneda.png" width="100px" alt="">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            @auth
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                               <img alt="foto" src="{{Storage::disk("usuarios")->url(Auth::user()->foto)}}" class="rounded-circle" width="60px" alt=""> 

                            </a>
                            @else
                            <img src="/img/usuario.png" class="rounded-circle" width="45px" alt="">
                            @endauth
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('main-content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Union Obrera Metalúrgica seccional Avellaneda 2020</span>
                        <span class="float-right" style="padding-right: 30px; font-size: 10px">v1.1.3</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terminar Sesion</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Confirmar" para cerrar la session.</div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); 
                document.getElementById('logout-form').submit();">Confirmar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(function() {
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        })
    </script>
</body>

</html>