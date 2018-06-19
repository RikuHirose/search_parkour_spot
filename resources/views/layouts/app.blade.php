<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @yield('css')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Top') }}
                    </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item dropdown">
                                <a href="/content/">map</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a href="/content/">map</a>
                            </li>
                            <li class="nav-item dropdown">
                                    <a href="/content/create">upload</a>
                            </li>
                            <li class="nav-item dropdown">
                                    <a href="/content/id/editlist">edit</a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <!-- <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li> -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="footer">
        <div class="container container-footer">
            <ul class="footer__item">
              <a href="/rules">利用規約</a>
              <a href="/privacy">プライバシーポリシー</a>
              <a href="/contact">お問い合わせ</a>
            </ul>
            <p class="footer__copy">©2018&nbsp;&nbsp;All&nbsp;Rights&nbsp;Reserved.</p>
        </div>
    </footer>
    <!-- Scripts（Jquery） -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
    <!-- plugin-->
    <script src="{{asset('/slick/slick.min.js')}}"></script>
    <!-- Scripts（bootstrapのjavascript） -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_rm3M3Ea_44D17eiI3aXuU-vAAACiijQ&libraries=places"></script>

    <script src="{{asset('js/script.js')}}"></script>
    <script src="{{asset('js/content.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/route.js')}}"></script>
    <script src="{{asset('js/edit.js')}}"></script>
    <script src="{{asset('js/slide.js')}}"></script>

</body>
</html>
