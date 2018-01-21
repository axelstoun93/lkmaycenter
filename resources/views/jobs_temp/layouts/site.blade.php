<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
    <meta name="description" content="">

    <title>{{$title}}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/bootstrap.min.css" >
    <link rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/icofont.css">
    <link rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/slidr.css">
    <link id="preset" rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/presets/preset1.css">
    <link rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/main.css">
    <link rel="stylesheet" href="{{asset(env('THEME_JOBS'))}}/css/responsive.css">

    <!-- font -->
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,700,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700' rel='stylesheet' type='text/css'>

    <!-- icons -->
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset(env('THEME_JOBS'))}}/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset(env('THEME_JOBS'))}}/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset(env('THEME_JOBS'))}}/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset(env('THEME_JOBS'))}}/images/ico/apple-touch-icon-57-precomposed.png">
    <!-- icons -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Template Developed By ThemeRegion -->
</head>
<body>
<!-- header -->
<header id="header" class="clearfix">
    <!-- navbar -->
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('jobs.index')}}"><img class="img-responsive" src="{{asset(env('THEME_JOBS'))}}/images/logo.png" alt="Logo"></a>
            </div>
            <!-- /navbar-header -->


        </div><!-- container -->
    </nav><!-- navbar -->
</header><!-- header -->


<br><br>
@yield('content')
<!-- download -->


<!-- footer -->
<footer id="footer" class="clearfix">


    <div class="footer-bottom clearfix text-center">
        <div class="container">
            <p>Академия "МАЙ" <a href="#">вакансии</a> 2017.</p>
        </div>
    </div><!-- footer-bottom -->
</footer><!-- footer -->



<!-- JS -->
<script src="{{asset(env('THEME_JOBS'))}}/js/jquery.min.js"></script>
<script src="{{asset(env('THEME_JOBS'))}}/js/bootstrap.min.js"></script>
<script src="{{asset(env('THEME_JOBS'))}}/js/price-range.js"></script>
<script src="{{asset(env('THEME_JOBS'))}}/js/main.js"></script>
<script src="{{asset(env('THEME_JOBS'))}}/js/switcher.js"></script>
</body>
</html>