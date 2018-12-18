<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sonilab') }}</title>

    <!----------------------Esto no se si se puede meter aqui (jquery)-------------------------------->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/project.css') }}" rel="stylesheet">

    <!--    Otros estilos dentro de la plantilla principal-->
    <style media="screen">
      /*body { padding-top: 70px; }*/
      #connectLogo {
        height: 60px;
        padding: 15px 0 5px 0;
      }
      #logo {
        height: 60px;
        padding: 5px 0 5px 20px;
      }

      .share-link {
        line-height: 60px;
        padding: 0 1em;
        font-size: 2em;
      }
    </style>

</head>
<body>
    <div id="app">

<!--       nova navbar-->

      <nav class="navbar navbar-default navbar-fixed-top fixed-top" style="background-color: #888888">
      <div class="container-fluid">
        <div class="navbar-header">

          <button type="button" class="navbar-toggle collapsed menu-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

<!-- Un altre tipus de boto (original de laravel) que no va
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
-->


          <a class="NOnavbar-brand" href="{{ url('/home') }}">
            <img id="logo" src="http://sonilab.com.mialias.net/wp-content/uploads/2016/11/SONILAB_logo41-300x65-300x75.png" alt="Talk Fusion">
          </a>

        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <span class="glyphicon glyphicon-share hidden-xs pull-right share-link" aria-hidden="true"></span>
          <!-- Collect the nav links, forms, and other content for toggling -->
<!--           <img class="center-block" id="connectLogo" src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg" alt=""> -->
          <!-- <div id="btnShare" style="display: none;"><img src="share.svg" width="22" alt="share"></div> -->
        </div>


<!--
        <button type="button" class="share-link hidden-xs pull-right">
          <span class="sr-only">Share link</span>
          <span class="glyphicon glyphicon-link"></span>
        </button> -->

      </div>
    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Start Bootstrap
                    </a>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Shortcuts</a>
                </li>
                <li>
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
        <!-- /#sidebar-wrapper -->




<!-- Page Content -->

        <main role="main" class="py-4 contenidor-principal">
           <div class="container-fluid">
                @yield('content')
            </div>
        </main>


    </div>

    <!-- Menu Toggle Script -->
        <script>
        $(".menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        </script>
</body>
</html>
