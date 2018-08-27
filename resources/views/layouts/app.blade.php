<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700%7CPacifico" rel="stylesheet">
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/isotope.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/navigation.min.css') }}">


    <!--For Plugins external css-->
    <link rel="stylesheet" href="{{ asset('/css/plugins.css') }}" />

    <!--Theme custom css -->
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <!--Theme Responsive css-->
    <link rel="stylesheet" href="{{ asset('/css/responsive.css') }}" />

    @yield('extra-css')

</head>

<body>

    @if( basename(Request::url()) !== 'cookie-policy' )
        @include('cookieConsent::index')
    @endif

	<!--[if lt IE 10]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    @include('partials.newsletter_popup')

    @include('partials.topbar')

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- js file start -->
    <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('/js/modernizr.js') }}"></script>
    <script src="{{ asset('/js/plugins.js') }}"></script>
    <script src="{{ asset('/js/Popper.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('/js/vertical-menu.js') }}"></script>
    <script src="{{ asset('/js/tweetie.js') }}"></script>
    <script src="{{ asset('/js/echo.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.waypoints.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCy7becgYuLwns3uumNm6WdBYkBpLfy44k"></script>
    <script src="{{ asset('/js/spectragram.min.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>		<!-- End js file -->

    @yield('extra-js')

</body>
</html>
