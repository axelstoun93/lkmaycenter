<html class="fixed">
<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Личный кабинет академии май</title>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="{{asset(env('THEME'))}}/assets/vendor/modernizr/modernizr.js"></script>
</head>
<body>
<!-- start: page -->
@yield('content')
<!-- Vendor -->
<script src="{{asset(env('THEME'))}}/assets/vendor/jquery/jquery.js"></script>
<script src="{{asset(env('THEME'))}}/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="{{asset(env('THEME'))}}/assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="{{asset(env('THEME'))}}/assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="{{asset(env('THEME'))}}/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset(env('THEME'))}}/assets/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="{{asset(env('THEME'))}}/assets/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="{{asset(env('THEME'))}}/assets/javascripts/theme.init.js"></script>

</body>
</html>