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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @yield('css')

</head>
<body>
    <div id="app" class="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">

            <?php if(App\Helpers\Helper::isMobile() == true): ?>
            
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

                                <a id="" class="nav-link auth-btn" href="/user/{{ Auth::user()->id }}">
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
                            <a class="sidebar-list" href="">
                                <i class="far fa-question-circle fa-3x"></i>
                                pklinksとは？
                            </a>
                            <a class="sidebar-list" href="/content/">
                                <i class="fas fa-globe fa-3x"></i>
                                map
                            </a>
                            <a class="sidebar-list sidebar-list-last" href="/contact">
                                <i class="far fa-envelope-open fa-3x"></i>
                                contact
                            </a>
                        @else
                            <a class="sidebar-list" href="/content/">
                                <i class="fas fa-globe fa-3x"></i>
                                map
                            </a>
                            <a class="sidebar-list" href="/content/create">
                                <i class="fas fa-camera fa-3x"></i>
                                upload
                            </a>
                            <a class="sidebar-list sidebar-list-last" href="/contact">
                                <i class="far fa-envelope-open fa-3x"></i>
                                contact
                            </a>
                            <!-- <a class="sidebar-list" href="/content/id/editlist">edit</a> -->
                        @endguest
                    </div>
                </div>
                <div class="top-icon">
                    <a class="" href="{{ url('/') }}">
                        <p>pkLinks</p>
                    </a>
                </div>
                <div class="search-icon">
                    <i id="search-icon" class="fas fa-search fa-2x"></i>
                </div>
                <div id="search-content" class="search-content">
                    <header class="m-search-header">
                        <h1 class="m-search-header-title js-search-tabs-title-article is-active">検索</h1>
                        <i class="fas fa-times fa-2x close-icon" id="close-icon"></i>
                    </header>
                    <div class="">
                        <!--↓↓ 検索フォーム ↓↓-->
                        <ul class="topsearch-tab">
                            <li id="tab" class="tab -active">
                                <span class="item">タグから検索する</span>
                            </li>
                            <li id="tab-right" class="tab">
                                <span class="item">地名から検索する</span>
                            </li>
                        </ul>

                        <div id="form-content" class="form-content">
                            <form class="" action="/search" method="get">
                                <input type="text" name="tag" class="topbar-form-input" placeholder="気になるタグから検索する" value="">
                                <!-- <input type="submit" value="検索" class="btn btn-info"> -->
                            </form>
                            <i class="fas fa-search fa-2x input-search-icon"></i>
                        </div>

                        <div id="form-content2" class="form-content2">
                            <form class="" action="/place" method="get" id="form_id">
                                <input id="pac-input" class="topbar-form-input" type="text"  name="place" placeholder="気になる地名から検索する" value="">
                                <input id="lat-input" type="hidden" name="lat" value="">
                                <input id="lng-input" type="hidden" name="lng" value="">
                                <!-- <input type="submit" value="検索" class="btn btn-info"> -->
                            </form>
                            <i class="fas fa-search fa-2x input-search-icon"></i>
                        </div>

                    </div>
                </div>
            <?php else:?>
                <div class="search-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="top-icon">
                    <a class="" href="{{ url('/') }}">
                        <p>pkLinks</p>
                    </a>
                </div>

                @guest
                    <a class="auth-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class="auth-btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                @else

                    <a id="" class="nav-link" href="/user/{{ Auth::user()->id }}">
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
                    <a class="sidebar-list" href="/contact">contact</a>
                @else
                    <a class="sidebar-list" href="/content/">map</a>
                    <a class="sidebar-list" href="/content/create">upload</a>
                    <a class="sidebar-list" href="/content/id/editlist">edit</a>
                    <a class="sidebar-list" href="/contact">contact</a>
                @endguest

            <?php endif; ?>


        </nav>

        <main class="">
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
    <script src="{{asset('js/slide.js')}}"></script>
    <script src="{{asset('js/topbar_search.js')}}"></script>

</body>
</html>
