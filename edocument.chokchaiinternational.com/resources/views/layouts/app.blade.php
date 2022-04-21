<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <!-- Primary Meta Tags -->
    <title> edocument.chokchaiinternational </title> 
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <link rel="shortcut icon" href="/a">
    <!-- Styles -->   
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
    <link href="{{ asset('/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
        .box-fileter{
            background: #f3f3f3;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px dashed #9e9e9e;
            border-radius: 5px;
        }
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #f8f9fa; 
        }
            
        ::-webkit-scrollbar-thumb {
            background: #0000007a; 
            border-radius: 1rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }

        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 2px 2px 4px #ddd;
        }
        .logo-box {
            height: 80px;
        }
        .navbar-custom .topnav-menu .nav-link {
            color: #343c49;
        }
        .box-table{
            background: #fff;
            padding: 0.5rem; 
            border-radius: 0.25rem;
        }
        a {
            color: #03a9f4;
            text-decoration: none;
            background-color: transparent;
        }
        a:hover {
            color: #136eb6;
            text-decoration: none;
        }
        .page-item.active .page-link {
            background: #2196f3;
            border-color: #2196f3;
        }
        .box-timeline {
            background: #f9f9f9;
            padding: 0.5rem;
            border-radius: 1rem;
            /* border: 1px solid #ddd; */
            min-width: 131px;
            z-index: 1;
        }
        .line {
            border-bottom: 3px solid #9e9e9e;
            position: relative;
            width: 80%;
            top: -50px;
            z-index: -1;
            margin: 0 auto;
        }
        .pagination { margin-bottom: 0; }
        .page-item:first-child .page-link {
            margin-left: 0;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .page-item:last-child .page-link {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .page-item.active .page-link {
            background: #333333;
            border-color: #333333;
        }
        .badge {
            font-size: 12px;
            font-weight: 400;
            font-family: 'Kanit';
        }
        .table-borderless tbody+tbody, .table-borderless td, .table-borderless th, .table-borderless thead th {
            white-space: nowrap;
        }  
        @media (max-width: 767.98px){
            .content-page, .enlarged .content-page { 
                padding: 0;
            } 
        } 
    </style> 
    @yield('style')
</head>
<body>
     
        <!-- Begin page -->
        <div id="wrapper"> 
            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right mb-0">  
                    @guest

                    @else
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="icon-user"></i>
                                <span class="pro-user-name ml-1">
                                    {{ Auth::user()->name }}<i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0"> จัดการข้อมูล</h6>
                                </div> 
                                <!-- item-->
                                <a href="{{ route('profile') }}" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>ข้อมูลส่วนตัว</span>
                                </a> 
                                <!-- item-->
                                <a href="{{ route('mg_document') }}" class="dropdown-item notify-item">
                                    <i class="icon-notebook"></i>
                                    <span>ตรวจสอบเอกสาร</span>
                                </a> 
                                @if(Auth::user()->roles==1)
                                    <!-- item-->
                                    <a href="{{ route('roles.list') }}" class="dropdown-item notify-item">
                                        <i class="fe-lock"></i>
                                        <span>จัดการสิทธ์ผู้ใช้งาน</span>
                                    </a> 
                                @endif
                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fe-log-out"></i>
                                    <span>ออกจากระบบ</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li> 
                    @endguest 
                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{ route('dashboard') }}" class="logo text-center">
                        <span class="logo-lg">
                            <span style="font-size: 1.3rem;font-weight: 100; position: relative; bottom: 3px; color: #FFF;">FARM <span style="color: #FFF;font-weight: bold;">CHOKCHAI</span></span>
                        </span>
                        <span class="logo-sm">
                            <span style="color: #fff; font-size: 1rem; font-weight: 700;">FARM.C</span>
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu" style="color: #343c49;"></i>
                        </button>
                    </li> 
                </ul>
            </div>
          
            <div class="left-side-menu"> 
                <div class="slimscroll-menu">  
                    <div id="sidebar-menu"> 
                        <ul class="metismenu" id="side-menu"> 
                            <li class="menu-title">Navigation</li> 
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i class="fe-airplay"></i> 
                                    <span> หน้าหลัก </span>
                                </a> 
                            </li>  
                            <li>
                                <a href="{{ route('create_document') }}">
                                    <i class="fe-plus-square"></i> 
                                    <span> สร้างเอกสาร </span>
                                </a> 
                            </li>
                            <li>
                                <a href="{{ url('/documents/1') }}">
                                    <i class="fe-file-plus"></i> 
                                    <span> เอกสารที่สร้าง </span>
                                </a> 
                            </li>
                            <li>
                                <a href="{{ url('/documents/2') }}">
                                    <i class="fe-edit-1"></i> 
                                    <span> เอกสารที่ต้องเซ็น </span>
                                </a> 
                            </li>  
                            <li>
                                <a href="{{ url('/documents/3') }}">
                                    <i class="fe-file-text"></i> 
                                    <span> เอกสารทั้งหมด </span>
                                </a> 
                            </li>  
                            <li>
                                <a href="{{ url('/documents/4') }}">
                                    <i class="fe-x-circle"></i> 
                                    <span> เอกสารที่ยกเลิก </span>
                                </a> 
                            </li>  
                            <li>
                                <a href="{{ url('/documents/5') }}">
                                    <i class=" fas fa-file-signature"></i> 
                                    <span> เอกสารที่ร่าง </span>
                                </a> 
                            </li> 
                            <li>
                                <a href="{{ url('/documents/6') }}">
                                    <i class="fas fa-comment"></i> 
                                    <span> ส่งกลับ/แก้ไข </span>
                                </a> 
                            </li> 
                            <li>
                                <a href="{{ route('profile') }}">
                                    <i class="fe-user"></i> 
                                    <span> จัดการข้อมูลส่วนตัว </span>
                                </a> 
                            </li>   
                            <li>
                                <a href="javascript: void(0);" aria-expanded="false">
                                    <i class="fas fa-book"></i> 
                                    <span>คู่มือการใช้งาน</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul class="nav-second-level mm-collapse" aria-expanded="false">
                                    <li><a href="{{ asset('images/manual.pdf') }}" download> คู่มือใช้งานระบบ </a></li>
                                    <li><a href="{{ asset('images/manual2.pdf') }}" download> วิธีรวมไฟล์ PDF</a></li>
                                    <li><a href="https://www.ilovepdf.com/th/compress_pdf"> วิธีบีบอัดไฟล์ PDF</a></li>
                                </ul>
                            </li> 
                            <hr style="margin-top: unset; margin-bottom: unset; border: 0; margin: 0.5rem 1.5rem; border-top: 1px solid #95a4b5;">
                            <li>
                                <a href="{{ route('mg_document') }}">
                                    <i class="icon-notebook"></i> 
                                    <span> ตรวจสอบเอกสาร </span>
                                </a> 
                            </li>   
                            @if(Auth::user()->roles==1)
                                <li>
                                    <a href="{{ route('roles.list') }}">
                                        <i class="fe-lock"></i> 
                                        <span> จัดการสิทธ์ผู้ใช้งาน </span>
                                    </a> 
                                </li> 
                            @endif   
                        </ul> 
                    </div>  
                </div>  
            </div> 
            <div class="content-page"> 
                <div class="content">  
                    <div class="container-fluid">  
                        @yield('content') 
                    </div>  
                </div>  
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                Copyright ©2021 All Rights Reserved by chokchaiinternational.
                            </div>
                        </div>
                    </div>
                </footer> 
            </div> 
        </div>   
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>  
    <script src="{{ asset('admin/js/app.min.js') }}"></script> 
    <script src="{{ asset('/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    @yield('script')
</body>
</html>