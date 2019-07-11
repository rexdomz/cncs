
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script> 

  <title>CN</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!--<link rel="stylesheet"
    href="{{ asset('css/font-awesome.min.css') }}" > -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" > 

  <link rel="stylesheet" href="{{ asset('css/app.css') }}" >  
  
  <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->

  <!-- Google Font 
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        -->
<!--<script src="{{ asset('js/print/jquery.min.js') }}"></script>
<script src="{{ asset('js/print/jquery.printPage.js') }}"></script>-->

<style>
 td,
 th {
  padding: 0.35em !important;
 }

 .table tr {
  border-bottom: 1px solid #eee;
 }

 select.area {
    text-transform: none;
    font-size: 11pt !important;
    padding: 0 !important;
    height: 30px !important;    
    margin: 0 0 10px -12px !important;
}

input.searchnameinpt {
  height: 30px;
  font-size: 11pt;
  margin: 0 0 10px 0;
}

</style>
        
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CNCS</b>App</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/avatar5.png') }}" class="user-image" alt="User Image">              
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('img/avatar5.png') }}" class="img-circle" alt="User Image">
                @if(Auth::guard('admin')->check())
                <p>{{ Auth::user()->name }} - Administrator</p>
                @else
                <p>{{ Auth::user()->name }} - Member</p>
                @endif
                

              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <!--<a href="#" class="btn btn-default btn-flat">Sign out</a>-->
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Sign out
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            |<!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">      
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- li class="header">MAIN NAVIGATION</li> -->
        <li class="">
          @if(Auth::guard('admin')->check())
            <a href="{{ URL::route('admin.home') }}"><i class="fa fa-dashboard"></i> Home</a>
            <a href="{{ URL::route('admin.registration') }}"><i class="fa fa-edit"></i> New Registration</a>
            <a href="{{ URL::route('admin.user-payment') }}"><i class="fa fa-pie-chart"></i> Customers</a>
            <a href="{{ URL::route('admin.registered-users') }}"><i class="fa fa-table"></i>Registered Users</a>
            <a href="{{ URL::route('admin.quota') }}"><i class="fa fa-th"></i>Collector's Quota</a> 
            <a href="{{ URL::route('admin.area') }}"><i class="fa fa-laptop"></i>Areas</a>    
          @else
            <a href="/home"><i class="fa fa-dashboard"></i> Home</a>        
            <a href="/user-payment"><i class="fa fa-pie-chart"></i> Customers</a>          
            <a href="/quota"><i class="fa fa-th"></i>Collector's Quota</a>         
          @endif
          
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div id="app" class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Dashboard</h3>

          <!--
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->

        </div>
        <div class="box-body">
        
          @yield('content')

        </div>

      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="https://ewebmo.com">eWebMo</a>.</strong> All rights
    reserved.
  </footer>

  

<script src="{{ asset('js/app.js') }}"></script>

<!-- date-range-picker -->
<script src="{{ asset('js/moment.min.js') }}"></script>
<!--<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>-->

<script type="text/javascript">

    $(document).ready(function () {

        $('.btnPrint').printPage();        

        $('#term').change(function() {
          $('#myDate').val();
          $('#myDate2').val('');    
        });

    });

  /*
  $(function () {

    $('#datepickerpay').datepicker('setDate', new Date());         
    
    $('#datepicker').datepicker({
      //autoclose: true,
      onSelect: function() {
        var event = new Event('input');
        this.dispatchEvent(event);
      }
    });
    */
 /*
  $('#datepicker').change(function() {
    var date2 = $('#datepicker').datepicker('getDate'); 
    $('#date_start').val(date2);
      //console.log($('#term').val());
      var numterm = $('#term').val();        
      date2.setDate(date2.getDate()+numterm * 30);       
    $('#datepicker2').datepicker('setDate', date2); 
   
    $('#date_end').val(date2);    
  });

  $('#myDate').change(function() {
    var date2 = $('#myDate').datepicker('getDate'); 
    date2.setDate(date2.getDate()+numterm * 30);
    alert(date2);
  });
  */

</script>

</body>
</html>