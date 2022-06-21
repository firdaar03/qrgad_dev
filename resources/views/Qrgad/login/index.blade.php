<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QRGAD - Quick Response General Affair Dept</title>
  <link rel="icon" href="{{ URL::asset('assets/Atlantis-Lite-master/img/icon.ico') }} " type="image/x-icon"/>

  {{-- public\assets\AdminLTE-3.1.0 --}}
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('assets/AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ URL::asset('assets/AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('assets/AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">
  <style>
    *{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana
    }
  </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card shadow card-primary">
            <div class="card-header bg-primary text-center">
                <img src="{{ URL::asset('assets/Atlantis-Lite-master/img/qrgad.png') }}" class="navbar-brand img-fluid"/>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to QRGAD</p>
                <form action="{{ url('/login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control 
                        @error('username') is-invalid @enderror" placeholder="NRP"
                        value="{{ old('username') }}">

                        @error('username')
                            <div class="invalid-feedback">
                                    {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control 
                            @error('password') is-invalid @enderror" placeholder="Password">
                        @error('password')
                            <div class="invalid-feedback">
                                    {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>

                </form>
        
                <br>        

                @if ( session()->has('success'))
                    <div class="alert alert-success  alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ( session()->has('error_msg'))
                    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                        {{ session('error_msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

<!-- jQuery -->
<script src="{{ URL::asset('assets/AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('assets/AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('assets/AdminLTE-3.1.0/dist/js/adminlte.min.js') }}"></script>
</body>
</html>