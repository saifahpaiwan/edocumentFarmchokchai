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

    <link href="{{ asset('libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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
        .card { background-color: #FFF;}
    </style>
</head>

<body class="authentication-bg bg-login authentication-bg-pattern d-flex align-items-center pb-0 vh-100">
 
    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container">  
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-10 col-xl-10">
                    <div class="card mb-0"> 
                        <div class="card-body p-4"> 
                            <div class="account-box">   
                                <div class="account-content mt-1">
                                    <form method="POST" action="{{ route('register_users') }}">
                                        @csrf     
                                        @if(session("success")) 
                                            <div class="alert alert-success text-success alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <strong><i class="icon-check"></i></strong>  {{session("success")}}
                                            </div> 
                                        @endif  
                                        <div class="row">   
                                            <div class="col-md-12"> 
                                                 
                                            </div>  
                                        </div>
 
                                    </form>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4 class="">
                                                <i class="icon-user-follow"></i> รายชื่อลงทะเบียนขอเข้าใช้งานระบบ E-document  
                                            </h4>
                                            <p class="mb-0">List of registration requests to use the system</p>
                                        </div>
                                        <div class="col-md-4 pb-1"> 
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="ค้นหารายชื่อ." id="search" name="search">
                                                <div class="input-group-append">
                                                    <button class="btn btn-dark waves-effect waves-light" type="button" id="btnSearch"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="box-table">
                                                <div class="table-responsive"> 
                                                    <table class="table   m-0" id="tbl-document" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th width="20%">ชื่อ-นามสกุล</th>
                                                                <th width="10%">อีเมล</th>
                                                                <th width="20%">ตำแหน่ง</th>
                                                                <th width="10%">เบอร์ติดต่อ</th> 
                                                                <th width="10%">เมื่อ </th> 
                                                                <th width="5%"> # </th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th class="text-left"> 
                                                                    <a href="#">ประกาศ มาตรการปฏิบัติงานสู้สถานการณ์ COVID - 19</a>
                                                                </th>
                                                                <td>
                                                                    <div> คุณสายฟ้า ไพรวรรณ์ </div> 
                                                                </td>
                                                                <td><span class="text-success">เสร็จสมบูรณ์</span></td>
                                                                <td> 27/08/2021 08:41:11</td>
                                                                <td class="text-center"> <i class="fe-message-square"></i> 0</td>
                                                            </tr>  
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12 text-center">
                                            <a class="mb-1" style="color: #FFF;" href="{{ route('mg_document') }}"> 
                                                <i class="icon-docs"></i> รายการเอกสารทั้งหมด 
                                            </a>
                                            <p class=" mb-0" style="color: #333;">Copyright ©2021 All Rights Reserved by chokchaiinternational</p>
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
    <script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).on('click', '#btnUsers', function(event) {   
            var id = $(this)[0].dataset.id;
            Swal.fire({
            title: 'โปรดยืนยันการอนุมัติ !',
            text: "การตรวจสอบเข้าใช้งานระบบ e-ducoment!",
            type:"question",
            showCancelButton:!0,
            confirmButtonText:"Yes",
            cancelButtonText:"No",
            confirmButtonClass:"btn btn-success mt-2",
            cancelButtonClass:"btn btn-danger ml-2 mt-2",
            buttonsStyling:!1 
            }).then((result) => { 
                if (result.value) {  
                    $('.txtapp-'+id).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
                    $.post("{{ route('approveUsers.post') }}", {
                        _token: "{{ csrf_token() }}", 
                        id: id,  
                    })
                    .done(function(data, status, error){   
                        if(error.status==200){  
                            location.reload();
                        }
                    })
                    .fail(function(xhr, status, error) { 
                        alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
                    });   
                }
            });
        });

        $(document).on('click', '#btnSearch', function(event) {   
            var name=$('#search').val();
            $('#tbl-document').DataTable().destroy();
            datatable(name);
        });
        datatable();
        function datatable(name){
            var get_id=3;
            var name=name;
            var table = $('#tbl-document').DataTable({
                "processing":false,  
                "serverSide":false,  
                "searching": false,
                "lengthChange": true, 
                "pageLength": 5,
                ajax: {
                    url:"{{ route('datatableUsers_all.post') }}", 
                    data:{ 
                        get_id: 1,
                        name: name
                    }
                },   
                columns: [ 
                    {data: 'id', name: 'id'},  
                    {data: 'name', name: 'name'}, 
                    {data: 'email', name: 'email'},
                    {data: 'position', name: 'position'},
                    {data: 'phone', name: 'phone'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'button', name: 'button'}, 
                ],
                "order":[], 
                "columnDefs":[  
                        {  
                            "targets":0,  
                            "orderable":false,  
                        },  
                ],
                dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-4 text-center'l><'col-sm-4'p>>",
                buttons: [
                    'copy', 'excel', 'print',
                ], 
            });
            
        } 
    </script>
</body>

</html>