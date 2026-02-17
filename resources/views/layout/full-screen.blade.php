<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>{{ config('app.name') }}</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.png') }}">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
	      rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/vendors.css') }}">
	@stack('plugins-styles')

	{{--@if(!eventHasEnded('interview_booking'))--}}
		{{--<link rel="stylesheet" href="{{ asset('css/pages/coming-soon.css') }}">--}}
	{{--@endif--}}
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-gradient.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/simple-line-icons/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/icheck/icheck.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/toastr.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/extensions/toastr.css') }}">
	<script src="{{ asset('vendors/js/vendors.min.js') }}" type="text/javascript"></script>
</head>
<body data-open="click" data-menu="vertical-menu-modern" data-col="1-column"
      class="vertical-layout vertical-menu-modern 1-column @yield('bg-image') menu-expanded blank-page blank-page">

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">

		</div>
		<div class="content-body">
			@yield('content')
		</div>
	</div>
</div>


@stack('modals')
{{--<script src="{{ asset('js/core/app.js') }}" type="text/javascript"></script>--}}
<script src="{{ asset('vendors/js/forms/validation/jqBootstrapValidation.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/scripts/forms/form-login-register.js') }}" type="text/javascript"></script>

{{--@if(!eventHasEnded('interview_booking'))--}}
	{{--@php $event = applicationEvent('interview_booking');  @endphp--}}

		{{--<script src="{{ asset('vendors/js/coming-soon/jquery.countdown.min.js') }}"></script>--}}
		{{--<script>--}}
            {{--$(document).ready(function() {--}}
                {{--$('#count_down').countdown('{{ $event->end_date->format('Y/m/d H:i:s') }}').on('update.countdown', function(event) {--}}
                    {{--var $this = $(this).html(event.strftime('<span class="text-bold-700">{{ title_case($event->display_name) }} closes in %d Day%!d %H Hour%!H %M Minute%!M %S Second%!S</span>'));--}}
                {{--});--}}
            {{--});--}}
		{{--</script>--}}
{{--@endif--}}
@stack('plugins-scripts')
@if(session()->has('notifications'))
	@component('components.toast-notification')
	@endcomponent
@endif
</body>
</html>