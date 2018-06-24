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
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @yield('css')

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="top-icon">
                <a class="" href="{{ url('/') }}">
                    <p>pkLinks</p>
                </a>
            </div>
        <?php
        use Jenssegers\Agent\Agent;
            $agent = new Agent();
            
            if ($agent->isMobile()):?>
                <div id="nav-drawer">
                    <input id="nav-input" type="checkbox" class="nav-unshown">
                    <label id="nav-open" for="nav-input"><span></span></label>
                    <label class="nav-unshown" id="nav-close" for="nav-input"></label>
                    <div id="nav-content">
                        <div  class="login-position">
                            @guest
                               <a class="auth-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                               <a class="auth-btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @else

                                <a id="" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <a class="auth-btn" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </div>

                        @guest
                            <a class="sidebar-list" href="/content/">map</a>
                            <a class="sidebar-list" href="">pklinksとは？</a>
                        @else
                            <a class="sidebar-list" href="/content/">map</a>
                            <a class="sidebar-list" href="/content/create">upload</a>
                            <a class="sidebar-list" href="/content/id/editlist">edit</a>
                        @endguest
                    </div>
                </div>
            <?php else:?>

                @guest
                    <a class="auth-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class="auth-btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                @else

                    <a id="" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <a class="auth-btn" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest

                @guest
                    <a class="sidebar-list" href="/content/">map</a>
                    <a class="sidebar-list" href="">pklinksとは？</a>
                @else
                    <a class="sidebar-list" href="/content/">map</a>
                    <a class="sidebar-list" href="/content/create">upload</a>
                    <a class="sidebar-list" href="/content/id/editlist">edit</a>
                @endguest

            <?php endif; ?>


        </nav>

        <main class="py-4">
            <div class="top"></div>
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

    <!-- 各js読み込み -->
    @yield('js')
    <script src="{{asset('js/search.js')}}"></script>
    <script src="{{asset('js/slide.js')}}"></script>

</body>
</html>
