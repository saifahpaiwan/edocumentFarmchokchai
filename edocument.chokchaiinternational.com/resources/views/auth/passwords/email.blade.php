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
        a {
            color: #FFF;
            text-decoration: none;
            background-color: transparent;
        }
        a:hover {
            color: #ddd;
            text-decoration: none;
        }
        .page-item.active .page-link {
            background: #2196f3;
            border-color: #2196f3;
        }
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
                                    <h4 class="text-uppercase mb-1" style="color: #FFF;">
                                        ?????????????????????????????????  
                                    </h4>
                                    <p class="mb-0">Forgot your password</p>
                                </div> 
                                @if (session('status'))
                                    <div class="alert alert-success mt-1" role="alert">
                                        <i class="mdi mdi-email-check-outline"></i> {{ session('status') }} 
                                    </div>
                                @endif 
                                <div class="account-content mt-3">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf  
                                        <div class="form-group row"> 
                                            <div class="col-md-12">
                                                <label for="email" class="col-form-label">{{ __('Email address') }}</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if(isset($_GET['email'])) {{ $_GET['email'] }} @else {{ old('email') }} @endif" required autocomplete="email" autofocus
                                                placeholder="john@deo.com">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-md btn-block btn-dark waves-effect waves-light fontWDB_Bangna">
                                                    {{ __('??????????????????????????????????????????????????????????????????') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mt-4  ">
                                        <div class="col-sm-12 text-center">
                                            <a class="mb-2" href="{{ route('login') }}">???????????????????????????????????????</a>
                                            <p style="color: #FFF;">Copyright ??2021 All Rights Reserved by chokchaiinternational</p> 
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