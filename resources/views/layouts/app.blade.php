<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sonilab') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- <script src="{{ asset('js/sidebar.js') }}" defer></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/project.css') }}" rel="stylesheet">

    <style>
    .cursor {
        cursor: pointer;
    }

    /* Usuaris i empleats */
    .card-shadow {
        box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.2), 0px 4px 5px 0px rgba(0, 0, 0, 0.14), 0px 1px 10px 0px rgba(0, 0, 0, 0.12);
        transition: box-shadow 0.3s ease-in-out;
    }
    .card-shadow:hover {
        box-shadow: 10px 10px 5px grey;
        transition: box-shadow 0.4s ease-in-out;
    }

    /* Registre d'entrades */
    .border-success {
        border-left: 10px solid lawngreen !important;
    }
    .border-warning {
        border-left: 10px solid darkorange !important;
    }
    .border-danger {
        border-left: 10px solid red !important;
    }
    .llegenda {
        float: left;
        margin-right: 15px;
    }
    .table-selected:hover {
        background-color: #E3E3E3;
    }
    .table td {
        padding: .50rem !important;
    }

    </style>

</head>

<body>


    <!--navbar-->

    <nav class="navbar navbar-dark sticky-top bg-dark navbar-sonilab flex-md-nowrap p-0">

        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('home') }}"><img src="http://sonilab.com.mialias.net/wp-content/uploads/2016/11/SONILAB_logo41-300x65-300x75.png" width="120" height="30" class="d-inline-block align-top" alt=""></a>
        @auth

        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Tancar la sessió') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        @endguest

    </nav>

   <!--sidebar-->

   @auth
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="{{ Request::is('home') ? 'nav-link active' : 'nav-link' }}" href="{{ route('home') }}"><span class="fas fa-home"></span><span class="sidebar-link underline">Inici</span><span class="sr-only">(current)</span></a>
                        </li>

                        <!-- Desabilitat -->
                        <li class="nav-item">
                            <div class="disabled-link {{ Request::is('calendar*') ? 'nav-link active' : '' }}" href=""><span class="fas fa-calendar"></span><span class="sidebar-link">Calendari</span></div>
                        </li>
                        <!-- Desabilitat -->
                        <li class="nav-item">
                            <a class="{{ Request::is('registreProduccio*') ? 'nav-link active' : 'nav-link' }}" href="{{ route('indexRegistreProduccio') }}"><span class="fas fa-project-diagram"></span><span class="sidebar-link underline">Projectes</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="{{ Request::is('empleats*') ? 'nav-link active' : 'nav-link' }}" href="{{ route('empleatIndex') }}"><span class="fas fa-users"></span><span class="sidebar-link underline">Gestió de Personal</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ Request::is('usuaris*') ? 'nav-link active' : 'nav-link' }}" href="{{ route('indexUsuariIntern')}}"><span class="fas fa-user-plus"></span><span class="sidebar-link underline">Gestió d'Usuaris</span></a>
                        </li>
                        <li class="nav-item">
                                <a class="{{ Request::is('registreEntrada*') ? 'nav-link active' : 'nav-link' }}" href="{{ route('indexRegistreEntrada')}}"><span class="fas fa-atlas"></span><span class="sidebar-link underline">Registre d'entrada</span></a>
                        </li>
                        <li class="nav-item">
                                <a class="{{ Request::is('estadillos*') ? 'nav-link active' : 'nav-link' }}" href="{{ route('indexEstadillos')}}"> <span class="fas fa-clipboard-list"></span><span class="sidebar-link underline">Estadillo</span></a>
                        </li>
                    </ul>

<!--
 Esto es mas menu, en otros estilos, que venia por defecto, esta aqui por si acaso
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
              </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Current month
                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Last quarter
                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Social engagement
                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Year-end sale
                </a>
                        </li>
                    </ul>
-->
                </div>
                <!--sidebar floating button-->
                <!--<a href="#" class="float"><i class="fas fa-arrow-circle-left my-float"></i></a>-->
               <!-- <a class="btn-floating btn-lg purple-gradient"><i class="fa fa-bolt"></i></a>-->

            </nav>
        </div>

    </div>
    @endguest

    <!-- Page Content -->

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <span class="fas fa-check"></span>{{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <span class="fas fa-exclamation-circle"></span>{{ !empty($errors->first('error')) ? $errors->first('error') : 'ERROR. No s\'han introduit correctament les dades.'  }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-warning" role="alert">
                <span class="fas fa-exclamation-triangle"></span>{{ session('alert') }}
            </div>
        @endif
        @yield('content')
    </main>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!--FontAwsome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">



</body>

</html>
