<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <!-- Primary Meta Tags -->
    <title> edocument.chokchaiinternational </title> 
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <link rel="shortcut icon" href="{{ asset('images/x.v.png') }}">
    <!-- Styles -->   
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
    <style>
        @font-face {
            font-family: Copper Penny DTP;
            src: url({{ asset('/fonts/Copper Penny DTP.otf') }});
        }
        @font-face {
            font-family: WDB_Bangna;
            src: url({{ asset('/fonts/WDB_Bangna.ttf') }});
        }  
        body, .btn,li  {
            font-family: 'Kanit' ;  
            font-weight: 300;
        }
        .Kanit, h1, h2, h3, h4, .sub-header,.btn {
            font-family: 'Kanit' ; 
        } 
        .bg-login{
            background-image: linear-gradient(rgb(0 0 0 / 50%), rgb(0 0 0 / 50%)), url({{ asset('images/SH-Main-05.jpg') }});
            background-position: bottom;
        }
        .card { background-color: #000000a3;}
    </style>
</head>

<body class="authentication-bg bg-login authentication-bg-pattern d-flex align-items-center pb-0 vh-100">
 
    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container">  
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mb-0"> 
                        <div class="card-body p-4"> 
                            <div class="account-box">
                                <div class="account-logo-box"> 
                                    <h4 class="text-uppercase mb-1" style="color: #FFF;">ลงชื่อเข้าใช้งานระบบ</h4>
                                    <p class="mb-0">Login to your user account</p>
                                </div>  
                                @if (session('status'))
                                    <div class="alert alert-success mt-1" role="alert">
                                        <i class="icon-check"></i> {{ session('status') }} 
                                    </div>
                                @endif 
                                @if (session('error')) 
                                    <div class="alert alert-danger mt-1" role="alert">
                                        <strong> <i class="mdi mdi-alert-circle-outline"> </i> {{ session('error') }}  </strong>
                                    </div>
                                @endif 
                                <div class="account-content mt-3">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf    
                                        @if(isset($_GET['feedback']))
                                            <input type="hidden" name="document_id" id="document_id" value="@if(isset($_GET['feedback'])) {{ $_GET['feedback'] }} @endif">
                                        @endif  
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="emailaddress">Email address</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
                                                value="{{ old('email') }} @if(isset($_GET['username'])) {{ $_GET['username'] }} @endif  {{ Cookie::get('email') }}" required autocomplete="email" autofocus placeholder="john@deo.com">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                @if (Route::has('password.request')) 
                                                    <a href="{{ route('password.request') }}" class="text-muted float-right"><small>Forgot your password?</small></a>
                                                @endif 
                                                <label for="password">Password</label>
                                                <input class="form-control" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">

                                                <div class="checkbox checkbox-success">
                                                    <input name="remember" id="remember" type="checkbox"  {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember">
                                                        Remember me
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row text-center mt-2">
                                            <div class="col-12"> 
                                                <button class="btn btn-md btn-block btn-dark waves-effect waves-light" type="submit">Sign In</button>
                                            </div>
                                        </div>

                                    </form>  
                                    <div class="row mt-4  ">
                                        <div class="col-sm-12 text-center">
                                            <a class="mb-1" style="color: #FFF;" href="{{ route('register') }}"> <i class="mdi mdi-login"></i> ลงทะเบียนขอเข้าใช้งาน </a>
                                            <p class=" mb-0" style="color: #FFF;">Copyright ©2021 All Rights Reserved by chokchaiinternational</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
        </div> 
    </div> 
    </div>  
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>  
    <script src="{{ asset('admin/js/app.min.js') }}"></script> 
</body>

</html>