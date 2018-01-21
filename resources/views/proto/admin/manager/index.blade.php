@extends(env('THEME').'.layouts.admin')
@section('specific-css')
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/morris/morris.css" />
@endsection
@section('navigation')
    {!! $navigation !!}
@endsection
@section('userNavigation')
    {!! $userNavigation !!}
@endsection
@section('content')
{!! $content !!}
@endsection
@section('script')
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery/jquery.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <!-- Specific Page Vendor -->
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-appear/jquery.appear.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/flot/jquery.flot.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/flot/jquery.flot.pie.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/flot/jquery.flot.categories.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/flot/jquery.flot.resize.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/raphael/raphael.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/morris/morris.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/gauge/gauge.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/snap-svg/snap.svg.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/liquid-meter/liquid.meter.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/jquery.vmap.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.init.js"></script>


    <!-- Examples -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/dashboard/examples.dashboard.js"></script>
    @endsection