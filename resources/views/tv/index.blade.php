@extends(env('THEME_TV').'.tv')
@section('specific-css')
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/fullcalendar/fullcalendar.print.css" media="print" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/elusive-icons/css/elusive-webfont.css" />
@endsection
@section('content')
    {!! $content !!}
@endsection
@section('script')
    <!-- Vendor -->
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
    <script src="{{asset(env('THEME'))}}/assets/vendor/select2/select2.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.js"></script>
    <!-- Theme Custom -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.custom.js"></script>
    <!-- Theme Initialization Files -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.init.js"></script>
    <!-- Examples -->
    <script src="{{asset(env('THEME'))}}/js/manager/tv.js"></script>

@endsection