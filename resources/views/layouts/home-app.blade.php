<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MCCHST') }}</title>

		{{-- <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">  --}}
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="{{ asset('css/home/linearicons.css') }}">
			<link rel="stylesheet" href="{{ asset('css/home/font-awesome.min.css') }}">
			<link rel="stylesheet" href="{{ asset('css/home/bootstrap.css') }}">
			<link rel="stylesheet" href="{{ asset('css/home/magnific-popup.css') }}">
			<link rel="stylesheet" href="{{ asset('css/home/nice-select.css') }}">							
			<link rel="stylesheet" href="{{ asset('css/home/animate.min.css') }}">
			{{-- <link rel="stylesheet" href="{{ asset('css/home/animate-text.css') }}"> --}}
			<link rel="stylesheet" href="{{ asset('css/home/owl.carousel.css') }}">			
			<link rel="stylesheet" href="{{ asset('css/home/jquery-ui.css') }}">			
			<link rel="stylesheet" href="{{ asset('css/home/main.css') }}">
		</head>
	<body>
        @yield('content')
        <script src="{{ asset('js/home/vendor/jquery-2.2.4.min.js') }}"></script>
		<script src="{{ asset('js/home/vendor/bootstrap.min.js') }}"></script>	
		<script src="{{ asset('js/home/popper.min.js') }}"></script>		
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script> --}}
        <script src="{{ asset('js/home/easing.min.js') }}"></script>			
        <script src="{{ asset('js/home/hoverIntent.js') }}"></script>
        <script src="{{ asset('js/home/superfish.min.js') }}"></script>	
        <script src="{{ asset('js/home/jquery.ajaxchimp.min.js') }}"></script>
        <script src="{{ asset('js/home/jquery.magnific-popup.min.js') }}"></script>	
        <script src="{{ asset('js/home/jquery.tabs.min.js') }}"></script>						
        <script src="{{ asset('js/home/jquery.nice-select.min.js') }}"></script>	
        <script src="{{ asset('js/home/owl.carousel.min.js') }}"></script>									
        {{-- <script src="{{ asset('js/home/mail-script.js') }}"></script>	 --}}
        <script src="{{ asset('js/home/main.js') }}"></script>	
    </body>
</html>