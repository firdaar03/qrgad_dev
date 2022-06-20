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
  
  <!-- Ajax Jquery -->
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

</head>
  <body data-background-color="bg3">
    <div class="wrapper">
      <div class="main-header">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="blue">
          
          <a href="index.html" class="logo">
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
            <div class="collapse" id="search-nav">
              <form class="navbar-left navbar-form nav-search mr-md-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pr-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input type="text" placeholder="Search ..." class="form-control">
                </div>
              </form>
            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
              <!-- <li class="nav-item toggle-nav-search hidden-caret">
                <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                  <i class="fa fa-search"></i>
                </a>
              </li>
              <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                  <li>
                    <div class="dropdown-title d-flex justify-content-between align-items-center">
                      Messages 									
                      <a href="#" class="small">Mark all as read</a>
                    </div>
                  </li>
                  <li>
                    <div class="message-notif-scroll scrollbar-outer">
                      <div class="notif-center">
                        <a href="#">
                          <div class="notif-img"> 
                            <img src="{{ URL::asset('') }} assets/Atlantis-Lite-master/img/jm_denis.jpg" alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="subject">Jimmy Denis</span>
                            <span class="block">
                              How are you ?
                            </span>
                            <span class="time">5 minutes ago</span> 
                          </div>
                        </a>
                        <a href="#">
                          <div class="notif-img"> 
                            <img src="{{ URL::asset('') }} assets/Atlantis-Lite-master/img/chadengle.jpg" alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="subject">Chad</span>
                            <span class="block">
                              Ok, Thanks !
                            </span>
                            <span class="time">12 minutes ago</span> 
                          </div>
                        </a>
                        <a href="#">
                          <div class="notif-img"> 
                            <img src="{{ URL::asset('') }} assets/Atlantis-Lite-master/img/mlane.jpg" alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="subject">Jhon Doe</span>
                            <span class="block">
                              Ready for the meeting today...
                            </span>
                            <span class="time">12 minutes ago</span> 
                          </div>
                        </a>
                        <a href="#">
                          <div class="notif-img"> 
                            <img src="{{ URL::asset('') }} assets/Atlantis-Lite-master/img/talha.jpg" alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="subject">Talha</span>
                            <span class="block">
                              Hi, Apa Kabar ?
                            </span>
                            <span class="time">17 minutes ago</span> 
                          </div>
                        </a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
                  </li>
                </ul>
              </li> -->
              <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                  <span class="notification">4</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                  <li>
                    <div class="dropdown-title">You have 4 new notification</div>
                  </li>
                  <li>
                    <div class="notif-scroll scrollbar-outer">
                      <div class="notif-center">
                        <a href="#">
                          <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                          <div class="notif-content">
                            <span class="block">
                              New user registered
                            </span>
                            <span class="time">5 minutes ago</span> 
                          </div>
                        </a>
                        <a href="#">
                          <div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
                          <div class="notif-content">
                            <span class="block">
                              Rahmad commented on Admin
                            </span>
                            <span class="time">12 minutes ago</span> 
                          </div>
                        </a>
                        <a href="#">
                          <div class="notif-img"> 
                            <img src="{{ URL::asset('assets/Atlantis-Lite-master/img/profile2.jpg') }} " alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="block">
                              Reza send messages to you
                            </span>
                            <span class="time">12 minutes ago</span> 
                          </div>
                        </a>
                        <a href="#">
                          <div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
                          <div class="notif-content">
                            <span class="block">
                              Farrah liked Admin
                            </span>
                            <span class="time">17 minutes ago</span> 
                          </div>
                        </a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
                  </li>
                </ul>
              </li>
              <!-- <li class="nav-item dropdown hidden-caret">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                  <i class="fas fa-layer-group"></i>
                </a>
                <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                  <div class="quick-actions-header">
                    <span class="title mb-1">Quick Actions</span>
                    <span class="subtitle op-8">Shortcuts</span>
                  </div>
                  <div class="quick-actions-scroll scrollbar-outer">
                    <div class="quick-actions-items">
                      <div class="row m-0">
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <i class="flaticon-file-1"></i>
                            <span class="text">Generated Report</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <i class="flaticon-database"></i>
                            <span class="text">Create New Database</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <i class="flaticon-pen"></i>
                            <span class="text">Create New Post</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <i class="flaticon-interface-1"></i>
                            <span class="text">Create New Task</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <i class="flaticon-list"></i>
                            <span class="text">Completed Tasks</span>
                          </div>
                        </a>
                        <a class="col-6 col-md-4 p-0" href="#">
                          <div class="quick-actions-item">
                            <i class="flaticon-file"></i>
                            <span class="text">Create New Invoice</span>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </li> -->
              <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                  <div class="avatar-sm">
                    <img src="{{ URL::asset('assets/Atlantis-Lite-master/img/profile.jpg') }} " alt="..." class="avatar-img rounded-circle">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="avatar-lg"><img src="{{ URL::asset('assets/Atlantis-Lite-master/img/profile.jpg') }}" alt="image profile" class="avatar-img rounded"></div>
                        <div class="u-text">
                          <h4>{{ $nama = explode(" ", auth()->user()->nama)[0]}}</h4>
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
                      <form action="/logout" method="POST"> 
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
                <img src="{{ URL::asset('assets/Atlantis-Lite-master/img/profile.jpg') }} " alt="..." class="avatar-img rounded-circle">
              </div>
              <div class="info">
                <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                  <span>
                    {{ $nama = explode(" ", auth()->user()->nama)[0]}}
                    <span class="user-level">{{ auth()->user()->divisi }}</span>
                    <!-- <span class="caret"></span> -->
                  </span>
                </a>
                <div class="clearfix"></div>

                <!-- <div class="collapse in" id="collapseExample">
                  <ul class="nav">
                    <li>
                      <a href="#profile">
                        <span class="link-collapse">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a href="#edit">
                        <span class="link-collapse">Edit Profile</span>
                      </a>
                    </li>
                    <li>
                      <a href="#settings">
                        <span class="link-collapse">Settings</span>
                      </a>
                    </li>
                  </ul>
                </div> -->
              </div>
            </div>
            <ul class="nav nav-primary">
              {{-- <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li> --}}
              @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000004")
                
                <li class="nav-item {{ Request::is('jadwal-ruangan*') || Request::is('ruangan*') || Request::is('fasilitas') || Request::is('lokasi')? 'active' : '' }}">
                  <a data-toggle="collapse" href="#meeting-room" class="collapsed" aria-expanded="false">
                    <i class="fas fa-users"></i>
                    <p>Meeting Room</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse {{ Request::is('jadwal-ruangan*') || Request::is('ruangan*') || Request::is('fasilitas') || Request::is('lokasi')? 'show' : '' }}" id="meeting-room">
                    <ul class="nav nav-collapse">
                      
                      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                        <li class="{{ Request::is('ruangan*')? 'active' : '' }}">
                          <a href="/ruangan">
                            <span class="sub-item ">Ruangan</span>
                          </a>
                        </li>
                      @endif
                      
                      @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002")
                        <li class="{{ Request::is('fasilitas')? 'active' : '' }}">
                          <a href="/fasilitas">
                            <span class="sub-item">Fasilitas</span>
                          </a>
                        </li>
                      @endif
                      
                      @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002"|| Auth::user()->level == "LV00000004")
                        <li class="{{ Request::is('jadwal-ruangan*')? 'active' : '' }}">
                          <a href="/jadwal-ruangan">
                            <span class="sub-item ">Meeting Room</span>
                          </a>
                        </li>
                      @endif

                      @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                        <li class="{{ Request::is('lokasi')? 'active' : '' }}">
                          <a href="/lokasi">
                            <span class="sub-item">Lokasi</span>
                          </a>
                        </li>
                      @endif

                    </ul>
                  </div>
                </li>

                <li class="nav-item {{ Request::is('keluhan*') || Request::is('lokasi-maintain')? 'active' : '' }}">
                  <a data-toggle="collapse" href="#keluhan" class="collapsed" aria-expanded="false">
                    <i class="fas fa-flag"></i>
                    <p>Keluhan</p>
                    <span class="caret"></span>
                  </a>
                  <div id="keluhan" class="collapse {{ Request::is('keluhan*') || Request::is('lokasi-maintain')? 'show' : ''  }}">
                    <ul class="nav nav-collapse">
                      
                      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000004" )
                        <li class="{{ Request::is('keluhan*')? 'active' : '' }}">
                          <a href="/ruangan">
                            <span class="sub-item ">Keluhan</span>
                          </a>
                        </li>
                      @endif

                      @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000004")
                        <li class="{{ Request::is('lokasi-maintain')? 'active' : '' }}">
                          <a href="/lokasi-maintain">
                            <span class="sub-item">Lokasi Maintain</span>
                          </a>
                        </li>
                      @endif

                    </ul>
                  </div>
                </li>

              @endif
              

              {{-- @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                <li class="nav-item {{ Request::is('lokasi*')? 'active' : '' }}">
                  <a data-toggle="collapse" href="#lokasi" class="collapsed" aria-expanded="false">
                    <i class="fas fa-layer-group"></i>
                    <p>Master</p>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse {{ Request::is('lokasi*')? 'show' : '' }}" id="lokasi">
                    <ul class="nav nav-collapse">

                      @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                        <li class="{{ Request::is('lokasi*')? 'active' : '' }}">
                          <a href="/lokasi">
                            <span class="sub-item">Lokasi</span>
                          </a>
                        </li>
                      @endif
                      
                    </ul>
                  </div>
                </li>
              @endif --}}
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="content">
          <div class="page-inner">
            <div class="page-header" id="page-header">

              @if (!$breadcrumbs == null)
                @php $c = count($breadcrumbs) @endphp
                @foreach ($breadcrumbs as $bc)
                    @if ($loop->iteration == $c)
                    <h3 class="page-title">{{ $bc }}</h3>
                    @endif
                @endforeach
                
                <ul class="breadcrumbs">
                  <li class="nav-home">
                    <a href="/admin">
                      <i class="flaticon-home"></i>
                    </a>
                  </li>
                  
                  @foreach ($breadcrumbs as $bc)
                    <li class="separator">
                      <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                      <a href="{{ ($loop->iteration == 1)? url()->previous() : '' }}">{{ $bc }}</a>
                    </li>
                  @endforeach
                </ul>
              @endif
              
                
                {{-- <li class="separator">
                  <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Fasilitas</a>
                </li> --}}
            
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

    <!-- Bootstrap Notify -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }} "></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jqvmap/jquery.vmap.min.js') }} "></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/jqvmap/maps/jquery.vmap.world.js') }} "></script>

    <!-- Sweet Alert -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/plugin/sweetalert/sweetalert.min.js') }} "></script>

    <!-- Atlantis JS -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/js/atlantis.js') }} "></script>

    <!-- FullCalendar -->
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ URL::asset('assets/Atlantis-Lite-master/plugins/fullcalendar/locales/id.js') }}"></script>

    {{-- Script Yield --}}
   
    @yield('script')
    
  </body>
</html>