<!doctype html>
<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>{!! $title !!}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="">
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
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/css/tvstyle.css" />
</head>
<body>
<section class="body">
    <!-- start: header -->
    <!-- end: header -->
   
        <!-- start: sidebar -->
    <!-- end: sidebar -->
        <section role="main" class="content-body">
            <!-- start: page -->
        @yield('content')
        <!-- end: page -->
        
    </div>
</section>
@yield('script')
</body>
</html>