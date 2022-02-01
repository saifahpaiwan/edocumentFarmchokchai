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
            font-family: 'Kanit', sans-serif;
            font-weight: 300;
        }
        .Kanit, h1, h2, h3, h4, .sub-header,.btn {
            font-family: 'Kanit' ; 
        } 
    </style>
</head>

<body class="">
    
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card-box">  
                    <div class="mt-2"> 
                        <form method="POST" action="{{ route('liffNotification.post') }}">
                            @csrf   
                            <input type="hidden" name="liff_usersid" id="liff_usersid" value="">  
                            <div class="row mt-1 box-001">
                                
                            </div> 

                            <div class="form-group row box-002">
                                <div class="col-12">
                                    <div class="text-center h4"> ยืนยันตัวตนเพื่อรับการแจ้งเตือน </div>
                                    <hr>
                                    <label for="emailaddress">โปรดระบุอีเมลของคุณ</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="john@deo.com">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                                <div class="col-12 text-center"> 
                                    <button type="submit" class="mt-2 btn btn-lg btn-primary btn-rounded width-md waves-effect waves-light">
                                        ยืนยัน
                                    </button>
                                </div>
                            </div>  
 
                            @if(session('info'))  
                                @if(session('info')==0)  
                                    <div class="row mt-1">
                                        <div class="col-12 text-center"> 
                                            <img src="{{ asset('images/icons/Cancel.png') }}" alt="" width="40%">
                                            <div class="mt-1 h1"> ผิดผลาด </div>
                                            <div class="mt-1"> ไม่พบรายชื่ออีเมลในระบบ โปรดระบบอีเมลให้ถูกต้อง </div>
                                        </div>
                                    </div>  
                                @endif   
                            @endif   
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>  
    <script src="{{ asset('admin/js/app.min.js') }}"></script> 
    <script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
</body>
<script> 
    
    $('.box-001').hide();
    $('.box-002').hide();
    function check_liff(liff_usersid){
        $.post("{{ route('check_liff.post') }}", {
            _token: "{{ csrf_token() }}", 
            liff_usersid: liff_usersid,  
        })
        .done(function(data, status, error){   
            if(error.status==200){   
                // console.log(data); 
                if(data==1){
                    $('.box-001').hide();
                    $('.box-002').show();
                }else if(data==2){
                    var html="";
                    var img="{{ asset('images/icons/checked.png') }}";
                    html+='<div class="col-12 text-center">';
                    html+='    <img src="'+img+'" alt="" width="40%">';
                    html+='    <div class="mt-1 h2"> คุณได้รับการแจ้งเตือนแล้ว </div>';
                    html+='    <div class="mt-1"> รับการแจ้งเตือนข้อมูลต่างๆ เกี่ยวกับเอกสารภายในที่ดีกว่าและรวดเร็วกว่า จัดการและค้นหาเอกสารได้ง่ายกว่า </div>';
                    html+='</div>';
                    $('.box-001').show();
                    $('.box-001').html(html);
                    $('.box-002').hide();
                }
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        }); 
    }

    async function getUserProfile() {
        const profile = await liff.getProfile()
        var email = '-';
        if(liff.getDecodedIDToken().email != 'undefined'){
            email = liff.getDecodedIDToken().email;
        }   
        $('#liff_usersid').val(profile.userId);
        check_liff(profile.userId);
    }

    function closed() {
        liff.closeWindow()
    }

    function getEnvironment() {
        var getOS =  liff.getOS();
        var getLanguage = liff.getLanguage();
        var getVersion = liff.getVersion();
        var getAccessToken =  liff.getAccessToken();
        var isInClient = liff.isInClient();
    }
    
    async function main() {
        liff.ready.then(() => { 
            if (liff.isLoggedIn()) {
                getUserProfile()
                getEnvironment()
            } else {
                liff.login()
            }
        })
        await liff.init({ liffId: "1656568838-L3R0yEjd" })
    }
    main();
</script>
</html>