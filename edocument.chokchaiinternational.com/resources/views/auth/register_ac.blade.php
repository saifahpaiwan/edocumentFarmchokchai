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
                                    <p class="mb-0">Register to your user account</p>
                                </div>    
                                <div class="account-content mt-1">
                                    <form method="POST" action="{{ route('register_users') }}">
                                        @csrf     
                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <label for="name" class="col-form-label">{{ __('ชื่อ - นามสกุล') }}</label> 
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <label for="email" class="col-form-label">{{ __('อีเมล') }}</label> 
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <label for="phone" class="col-form-label">{{ __('โทรศัพท์') }}</label>
                                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row"> 
                                            <div class="col-md-6">
                                                <label for="password" class="col-form-label">{{ __('รหัสผ่าน') }}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                         
                                            <div class="col-md-6">
                                                <label for="password-confirm" class="col-form-label">{{ __('ยืนยันรหัสผ่าน') }}</label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div> 
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <button type="submit" id="register" class="btn btn-block btn-dark waves-effect waves-light">
                                                    {{ __('ลงทะเบียน') }}
                                                </button>
                                            </div> 
                                        </div>
                                    </form>
                                    <div class="row mt-4  ">
                                        <div class="col-sm-12 text-center">
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