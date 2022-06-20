<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in QRGAD</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box" >
        <!-- /.login-logo -->
        <img src="{{ URL::asset('assets/Atlantis-Lite-master/img/qrgad.png') }}" height="100" width="350"/>
        <br>
        <br>
        <div class="card card-outline card-primary">
            
            <div class="card-body">
                <h3 class="login-box-msg">Sign in QRGAD</h3>
        
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
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>