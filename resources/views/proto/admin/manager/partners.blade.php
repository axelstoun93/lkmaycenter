@extends(env('THEME').'.layouts.admin')
@section('specific-css')
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/css/table/style.css" />
    <link rel="stylesheet" href="{{asset(env('THEME'))}}/assets/vendor/elusive-icons/css/elusive-webfont.css" />
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
    <script src="{{asset(env('THEME'))}}/assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="{{asset(env('THEME'))}}/assets/vendor/nanoscroller/nanoscroller.js"></script>


    <!-- Specific Page Vendor -->







    <!-- Theme Base, Components and Settings -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="{{asset(env('THEME'))}}/assets/javascripts/theme.init.js"></script>


    <!-- Examples -->




    <script src="{{asset(env('THEME'))}}/js/jquery-latest.js"></script>
    <script src="{{asset(env('THEME'))}}/js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="{{asset(env('THEME'))}}/js/jquery.tablesorter.pager.js"></script>
    <script type="text/javascript" src="{{asset(env('THEME'))}}/js/PassGenJS.js"></script>
    <script type="text/javascript" src="{{asset(env('THEME'))}}/js/modal.js"></script>
    <script src="{{asset(env('THEME'))}}/js/manager/clientsScript.js"></script>
@endsection