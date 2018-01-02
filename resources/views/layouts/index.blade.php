<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
	<!-- begin::Head -->
	<head>
	    @php
			header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', FALSE);
			header('Pragma: no-cache');
	    @endphp	
		<meta charset="utf-8" />
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">    	
	</head>
	<body>		
	<div id="divLogin" style="position:relative;z-index:1;">	
		<v-app style="background: #666">
			<v-container id="divSpiner" fluid fill-height style="position:absolute;z-index:2;">
				<v-layout justify-center align-center>
					<v-progress-circular indeterminate color="indigo lighten-4"></v-progress-circular>
				</v-layout>
			</v-container>
			<v-container id="divApp" fluid fill-height style="display:none;position:relative;z-index:1;">
     			@yield('content')		
			</v-container>
		</v-app>
	</div>
	<script src="{{ asset('js/login/login.js') }}"></script>
	</body>
</html>




