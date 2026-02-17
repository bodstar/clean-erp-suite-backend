<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>{{ config('app.name') }}</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link nonce="{{ csp_nonce() }}" rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
	<link nonce="{{ csp_nonce() }}" rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.png') }}">
	<link nonce="{{ csp_nonce() }}" href="{{ asset('css/montserrat.css') }}" rel="stylesheet">

	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/vendors.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/unslider.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('vendors/css/weather-icons/climacons.min.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('fonts/meteocons/style.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/selects/select2.min.css') }}">
	{{--<style nonce="{{ csp_nonce() }}">--}}
		{{--@import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');--}}
		{{--body {--}}
			{{--font-family: 'Montserrat', sans-serif !important;--}}
		{{--}--}}
	{{--</style>--}}
	@stack('stylesheets')
	<!-- END VENDOR CSS-->
	<!-- BEGIN STACK CSS-->

	<!-- END STACK CSS-->
	<!-- BEGIN Page Level CSS-->

	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-gradient.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('fonts/simple-line-icons/style.css') }}">
	<!-- END Page Level CSS-->

	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/toastr.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/plugins/extensions/toastr.css') }}">
	<link nonce="{{ csp_nonce() }}" rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-tooltip.css') }}">
	<style nonce="{{ csp_nonce() }}">
		.app-content {
			margin-right: 20px;
			margin-left: 20px;
		}

	</style>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
<!-- fixed-top-->
@if(session('display') == 'onlycase')

@else
	@include('layout.top-navigation')
@endif

@if(session('display') == 'onlycase')
	{{--@include('layout.case-sidebar')--}}
@else
	@include('layout.sidebar')
@endif
	<div class="app-content{{-- @if(session('display') == 'onlycase') app-content @else content @endif--}} content">
		@yield('content')
	</div>

@if(session('display') == 'onlycase')

@else
	@include('layout.footer')
@endif
<script nonce="{{ csp_nonce() }}" src="{{ asset('vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
@stack('modals')
<!-- BEGIN VENDOR JS-->
<script nonce="{{ csp_nonce() }}" src="{{ asset('vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- BEGIN VENDOR JS-->

<!-- BEGIN PAGE VENDOR JS-->
<script nonce="{{ csp_nonce() }}" src="{{ asset('vendors/js/extensions/unslider-min.js') }}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('vendors/js/timeline/horizontal-timeline.js') }}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" type="text/javascript" src="{{asset('vendors/js/ui/jquery.sticky.js')}}"></script>
<script nonce="{{ csp_nonce() }}" type="text/javascript" src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
<script nonce="{{ csp_nonce() }}" src="{{asset('vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{asset('vendors/js/extensions/sweetalert.min.js')}}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{asset('vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
@stack('vendor-script')




<!-- BEGIN STACK JS-->
<script nonce="{{ csp_nonce() }}" src="{{ asset('js/core/app-menu.js') }}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('js/core/app.js') }}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{asset('js/scripts/customizer.js')}}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{asset('js/scripts/forms/checkbox-radio.js')}}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}">
    $('.select2').select2({
        "language": {
            "noResults": function () {
                return "{{__('No results found')}}";
            },
            "searching": function () {
                return "{{__('Searching')}}…";
            },
            "loadingMore": function () {
                return '{{__('Loading more results')}}…';
            },
            "errorLoading": function () {
                return '{{__('The results could not be loaded')}}.';
            },
        }
	});
    $(".select2-placeholder").select2({
        placeholder: "{{__('Select an option')}}",
        allowClear: true,
        "language": {
            "noResults": function () {
                return "{{__('No results found')}}";
            },
            "searching": function () {
                return "{{__('Searching')}}…";
            },
            "loadingMore": function () {
                return '{{__('Loading more results')}}…';
            },
            "errorLoading": function () {
                return '{{__('The results could not be loaded')}}.';
            },
        }
    });
</script>
@stack('end-script')
<!-- END STACK JS-->

<!-- BEGIN PAGE LEVEL JS-->
<script nonce="{{ csp_nonce() }}" src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('js/helpers.js') }}" type="text/javascript"></script>

<!-- END PAGE LEVEL JS-->
<script nonce="{{ csp_nonce() }}" src="{{ asset('js/scripts/tooltip/tooltip.js') }}" type="text/javascript"></script>
@stack('scripts')
@if(session()->has('notifications'))
	@component('components.toast-notification')
	@endcomponent
@endif

</body>
</html>