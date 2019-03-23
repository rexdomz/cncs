
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>window.CNCS = { csrfToken: '{{ csrf_token() }}' }</script> 

  <title>CNCS | Login Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!--<link rel="stylesheet"
    href="{{ asset('css/font-awesome.min.css') }}" > -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" > 

  <link rel="stylesheet" 
    href="{{ asset('css/app.css') }}" >

  <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->

  <!-- Google Font 
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        -->

<style>
 td,
 th {
  padding: 0.65em !important;  
 }

 .navbar-default {
    background-color: transparent;
    border-color: none !important;
    color: #000 !important;
}
</style>
        
</head>
<body class="hold-transition login-page">
<!-- Site wrapper -->
    <div id="app" class="wrapper" >     
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
