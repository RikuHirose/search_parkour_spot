<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <title>
         @yield('title')pkLinks
    </title>
    <link rel="shortcut icon" href="/item/icon9.png">
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
    <link href="{{ asset('css/notification.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iziModal.min.css') }}" rel="stylesheet">
    @yield('css')

    <!-- Scripts -->
    <!-- bugが出る -->
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b473a663cd9e600119c7b57&product=inline-share-buttons' async='async'></script>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- This makes the current user's id available in javascript -->
    @if(!auth()->guest())
        <script>
            window.Laravel.userId = <?php echo auth()->user()->id; ?>
        </script>
    @endif

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
                               <a id="" class="" href="/login">
                                    <div class="LinkToMyPage linktoLog">
                                      <span class="authlogsign">無料会員登録・ログイン</span>
                                    </div>
                                </a>
                            @else
                                <a id="" class="" href="/user/{{ Auth::user()->id }}">
                                    <div class="LinkToMyPage">
                                      <?php \App\Helpers\Helper::topbar_avatarLogic(Auth::user()->avatar_name) ?>
                                      <span class="auth-name">{{ Auth::user()->name }}</span>
                                    </div>
                                </a>

                            @endguest
                        </div>

                        @guest
                            <p class="sidecan">pkLinksで出来ること</p>
                            <a class="sidebarcan" href="/content/">
                                <i class="fas fa-globe fa-3x sidecolor"></i>
                                <span> Mapから探す</span>
                            </a>
                            <a class="sidebarcan" href="/content/create">
                                <i class="fas fa-upload fa-3x sidecolor"></i>
                                <span>投稿する</span>
                            </a>
                            <a class="sidebarcan" id="markasread" href="/notifications">
                                <i class="fas fa-bell fa-3x  sidecolor"></i>
                                <span>通知</span>
                            </a>
                            <!-- <a class="sidebar-list sidebar-list-last" href="/contact">
                                <i class="far fa-envelope-open fa-3x"></i>
                                contact
                            </a> -->
                        @else
                            <!-- <a class="sidebar-list" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a> -->
                            <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form> -->
                            <p class="sidecan">pkLinksで出来ること</p>
                            <a class="sidebarcan" href="/content/">
                                <i class="fas fa-globe fa-3x sidecolor"></i>
                                <span> Mapから探す</span>
                            </a>
                            <a class="sidebarcan" href="/content/create">
                                <i class="fas fa-upload fa-3x sidecolor"></i>
                                <span>投稿する</span>
                            </a>
                            <a class="sidebarcan" id="markasread" href="/notifications">
                                @if (count(auth()->user()->unreadNotifications) != 0)
                                    <i class="fas fa-bell fa-3x noticerable sidecolor"></i>

                                @elseif (count(auth()->user()->unreadNotifications) == 0)
                                    <i class="fas fa-bell fa-3x  sidecolor"></i>
                                @endif
                                <span>通知</span>
                            </a>
                            <!-- <a class="sidebar-list sidebar-list-last" href="/contact">
                                <i class="fas fa-envelope-open fa-3x"></i>
                                contact
                            </a> -->
                            <!-- <a class="sidebar-list" href="/content/id/editlist">edit</a> -->
                        @endguest
                    </div>
                </div>
                <div class="top-icon">
                    <a class="" href="{{ url('/') }}">
                        <img src="/item/icon11.png" style="width: 80px; height: 30px;">
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
                                <input type="text" name="q" class="topbar-form-input" placeholder="気になるタグから検索する" value="">
                                <!-- <input type="submit" value="検索" class="btn btn-info"> -->
                            </form>
                            <i class="fas fa-search fa-2x input-search-icon"></i>
                        </div>

                        <div id="form-content2" class="form-content2">
                            <form class="" action="/place" method="get" id="form_id">
                                <input id="pac-input" class="topbar-form-input" type="text"  name="q" placeholder="気になる地名から検索する" value="">
                                <input id="lat-input" type="hidden" name="lat" value="">
                                <input id="lng-input" type="hidden" name="lng" value="">
                                <!-- <input type="submit" value="検索" class="btn btn-info"> -->
                            </form>
                            <i class="fas fa-search fa-2x input-search-icon"></i>
                        </div>

                    </div>
                </div>

            <!-- pc -->
            <?php else:?>
                <div class="m-header-inner">
                     <div class="top-icon">
                        <a class="" href="{{ url('/') }}">
                            <img src="/item/icon11.png" style="width: 80px; height: 30px;">
                        </a>
                    </div>
                    <form class="search-icon" action="/place" method="get" id="form_id">
                        <input id="pac-input" type="text"  name="q" placeholder="気になる地名・タグから検索する" class="pac-input" value="<?php echo isset($query) ? $query : '' ;  ?>">
                        <input id="lat-input" type="hidden" name="lat" value="">
                        <input id="lng-input" type="hidden" name="lng" value="">
                        <!-- <input value="" class="m-header-search-button" type="submit" id="btn_id"> -->
                    </form>
                    <i class="fas fa-search nav-search-poosition"></i>

                    @guest
                        <div class="m-header-navi not-login">
                            <!-- <a class="sidebar-list m-header-navi-menu" href="/content/">map</a> -->
                            <!-- <a class="sidebar-list" href="">pklinksとは？</a> -->
                        </div>
                        <div class="m-header-navi">
                            <a class=" m-header-navi-menu" href="/content/">Mapから探す</a>
                            <a class="auth-btn m-header-navi-menu" href="{{ route('register') }}">会員登録</a>
                            <span class="sign">|</span>
                            <a class="auth-btn m-header-navi-menu m-header-navi-menu-left" href="{{ route('login') }}">
                                ログイン
                            </a>
                        </div>
                    @else


                        <div class="dropdown notice-nav" id="markasread">
                            <div class=" " type="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fas fa-bell  bellpos"></i>
                                <?php if (count(auth()->user()->unreadNotifications) !=  0): ?>
                                    <span class="badge-pos" id="badge">
                                        <?php echo count(auth()->user()->unreadNotifications); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <ul class="dropdown-menu dpd-menu" aria-labelledby="dropdownMenu1">
                                @forelse(auth()->user()->Notifications as $notification)
                                    <li class="dpd-menu-li">
                                        @include('layouts.partials.notification.'.snake_case(class_basename($notification->type)))
                                        @empty
                                        <p style="text-align: center;">通知はまだありません</p>
                                    </li>
                                @endforelse

                            </ul>
                        </div>

                        <div class="dropdown m-header-navi">
                            <div class="dropdown-toggle " type="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?php \App\Helpers\Helper::topbar_avatarLogic(Auth::user()->avatar_name) ?>
                            </div>
                            <ul class="dropdown-menu nav-lists dbmenu" aria-labelledby="dropdownMenu1">
                                <li class="acbtn">
                                    <a id="" href="/user/{{ Auth::user()->id }}">
                                        <!-- {{ Auth::user()->name }} -->
                                        マイページをみる
                                    </a>
                                </li>
                               <!-- @guest
                                    <li><a class="sidebar-list" href="/content/">map</a></li>
                                    <li><a class="sidebar-list" href="">pklinksとは？</a></li>
                                    <li><a class="sidebar-list" href="/contact">contact</a></li>
                                @else -->
                                    <li class="acbtn"><a class="sidebar-list" href="/content/">Mapから探す</a></li>
                                    <li class="acbtn"><a class="sidebar-list" href="/content/create">投稿する</a></li>
                                    <li class="acbtn">
                                        <a class="auth-btn" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            ログアウト
                                        </a>
                                    </li>
                                    <!-- <a class="sidebar-list" href="/content/id/editlist">edit</a> -->
                                <!-- @endguest -->
                                <!-- <li class="dropdown">
                                    <a class="dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">
                                        <li class="dropdown-header">No notifications</li>
                                    </ul>
                                </li>
     -->
                            </ul>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <!-- plugin-->
    <script src="{{asset('/slick/slick.min.js')}}"></script>
    <!-- Scripts（bootstrapのjavascript） -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- google map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_rm3M3Ea_44D17eiI3aXuU-vAAACiijQ&libraries=places"></script>

    <!-- 各js読み込み -->
    @yield('js')
    <script src="{{asset('js/slide.js')}}"></script>
    <script src="{{asset('js/message.js')}}"></script>
    <script src="{{asset('js/topbar_search.js')}}"></script>
    <script src="{{asset('js/notification.js')}}"></script>

</body>
</html>
