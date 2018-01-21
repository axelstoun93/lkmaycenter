<!doctype html>
<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>{!! $title !!}</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <!-- Specific Page Vendor CSS -->
    @yield('specific-css')
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/stylesheets/theme.css" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="{{asset(env('THEME'))}}/assets/vendor/modernizr/modernizr.js"></script>
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/css/mystyle.css" />
</head>
<body>
<section class="body">
    <!-- start: header -->
    <header class="header">
        <div class="logo-container">
            <a href="../" class="logo">
                <img src="{{asset(env('THEME'))}}/assets/images/logo.png" height="35" alt="Porto Admin" />
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <!-- start: search & user box -->
           @yield('userNavigation')
        <!-- end: search & user box -->
    </header>
    <!-- end: header -->

    <div class="inner-wrapper">
        <!-- start: sidebar -->
        @yield('navigation')
        <!-- end: sidebar -->
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>{!! $title !!}</h2>

                <div class="right-wrapper pull-right">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="{!! route('home') !!}">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li><span>{!! $page !!}</span></li>
                    </ol>
                    <p class="sidebar-right-toggle"></p>
                </div>
            </header>

            <!-- start: page -->
           @yield('content')
            <!-- end: page -->
        </section>
    </div>

</section>
@yield('script')
</body>
</html>