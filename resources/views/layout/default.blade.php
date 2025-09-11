<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Employee Registration Form</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Favicons-->

    <link href="{{ asset('public/admin/images/logo/favicon.png') }}" rel="apple-touch-icon" sizes="180x180">

    <link href="{{ asset('public/admin/images/logo/favicon.png') }}" rel="icon" sizes="32x32" type="image/png">

    <link href="{{ asset('public/admin/images/logo/favicon.png') }}" rel="icon" sizes="16x16" type="image/png">
    
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/js/sweet-alert.min.js') }}" ></script>
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
</head>

	<body data-base-url="{{ url('/') }}">
    	@yield('content')
	</body>

</html>
