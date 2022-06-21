<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>QRGAD - Quick Response General Affair Dept</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ URL::asset('assets/Atlantis-Lite-master/img/icon.ico') }} " type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/webfont/webfont.min.js') }} "></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{  URL::asset('assets/Atlantis-Lite-master/css/fonts.min.css') }}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

	<!-- CSS Files -->
  {{-- D:\POLMAN\6-PRAKTEK KERJA INDUSTRI\TUGAS AKHIR\qrgad\public\assets\Atlantis-Lite-master\css\bootstrap.min.css --}}
	<link rel="stylesheet" href="{{ URL::asset('assets/Atlantis-Lite-master/css/bootstrap.min.css') }} ">
	<link rel="stylesheet" href="{{ URL::asset('assets/Atlantis-Lite-master/css/atlantis.css') }} ">
  
  <!-- FullCalendar -->
	<link rel="stylesheet" href="{{ URL::asset('assets/Atlantis-Lite-master/plugins/fullcalendar/main.css') }} ">
  
  <!-- Chosen -->
	<link rel="stylesheet" href="{{ URL::asset('assets/Atlantis-Lite-master/plugins/chosen/chosen.css') }} ">
  
  <!-- Ajax Jquery -->
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

</head>
  <body data-background-color="bg3">
    <div class="wrapper">
      <div class="main-header">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="blue">
          
          <a href="{{ url('/dashboard') }}" class="logo">
            <img src="{{ URL::asset('assets\Atlantis-Lite-master\img\qrgad.png') }} " alt="navbar brand" class="navbar-brand img-fluid">
          </a>
          <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
              <i class="icon-menu"></i>
            </span>
          </button>
          <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="icon-menu"></i>
            </button>
          </div>
        </div>
        <!-- End Logo Header -->

        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
          
          <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
              
              {{-- notification --}}
              @include('Qrgad/layout/notification')

              {{-- profile --}}
              @php
                  $nama = explode(" ", auth()->user()->nama);
                  if(count($nama) < 2){
                    $namauser = $nama[0];
                  } else {
                    $namauser = $nama[0]." ".$nama[1];
                  }
                  $arr = explode(" ", $namauser);
                  $singkatan = "";
                  foreach($arr as $kata)
                  {
                    $singkatan .= substr($kata, 0, 1);
                  }
              @endphp

              <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                  <div class="avatar">
                    <span class="avatar-title rounded-circle border border-white text-uppercase text-white">{{ $singkatan }}</span>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="avatar">
                          <span class="avatar-title rounded-circle border border-white text-uppercase text-white">{{ $singkatan }}</span>
                        </div>
                        <div class="u-text">
                          <h4 class="text-uppercase">{{ $nama2 =  explode(" ", auth()->user()->nama)[0] }}</h4>
                          <p class="text-muted">{{ auth()->user()->divisi }}</p>
                          <!-- <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a> -->
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">My Profile</a>
                      <!-- <a class="dropdown-item" href="#">My Balance</a>
                      <a class="dropdown-item" href="#">Inbox</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Account Setting</a> -->
                      <div class="dropdown-divider"></div>
                      <form action="{{ url('/logout') }}" method="POST"> 
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                      </form>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <!-- Sidebar -->
      <div class="sidebar sidebar-style-2">			
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <div class="user">
              <div class="avatar-sm float-left mr-2">
                <span class="avatar-title rounded-circle border border-white text-uppercase text-white" >{{ $singkatan }}</span>
              </div>
              <div class="info">
                <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                  <span class="text-uppercase">
                    {{ $nama2 =  explode(" ", auth()->user()->nama)[0] }}
                    <span class="user-level">{{ auth()->user()->divisi }}</span>
                  </span>
                </a>
                <div class="clearfix"></div>
              </div>
            </div>
            
            {{-- sidebar --}}
            @include('Qrgad/layout/sidebar')

          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="content">
          <div class="page-inner">
            <div class="page-header" id="page-header">

              {{-- breadcrumbs --}}
              @include('Qrgad/layout/breadcrumb')
            
            </div>
            <div class="row">
              <div class="col-md-12">
                @yield('content')
              </div>
            </div>
          </div>
          
      </div>
      
      
      <!-- End Custom template -->
    </div>

    <!--   Core JS Files   -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/core/jquery.3.2.1.min.js') }} "></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/core/popper.min.js') }} "></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/core/bootstrap.min.js') }} "></script>

    <!-- jQuery UI -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }} "></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }} "></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }} "></script>


    <!-- Chart JS -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/chart.js/chart.min.js') }} "></script>

    <!-- jQuery Sparkline -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }} "></script>

    <!-- Chart Circle -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/chart-circle/circles.min.js') }} "></script>

    <!-- Datatables -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/datatables/datatables.min.js') }} "></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script>


    <!-- Bootstrap Notify -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }} "></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jqvmap/jquery.vmap.min.js') }} "></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jqvmap/maps/jquery.vmap.world.js') }} "></script>

    <!-- Sweet Alert -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/sweetalert/sweetalert.min.js') }} "></script>
    
    <!-- FullCalendar -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/fullcalendar/locales/id.js') }}"></script>

    <!-- Chosen -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/chosen/chosen.jquery.js') }}"></script>

    <!-- HTML5 Scanner -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    {{-- <script src="https://raw.githubusercontent.com/mebjas/html5-qrcode/master/minified/html5-qrcode.min.js"></script> --}}
    
    <!-- Atlantis JS -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/atlantis.js') }} "></script>

    {{-- Script Yield --}}
   
    @yield('script')
    
  </body>
</html>