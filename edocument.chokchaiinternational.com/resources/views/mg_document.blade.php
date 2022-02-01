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

<body class="bg-login">
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card-box"> 
                    <div class="row mt-1 mb-1">
                        <div class="col-md-8">
                            <h4 class="">
                                <i class="fe-file-text"></i> รายการเอกสารทั้งหมด  
                            </h4>
                            <p class="mb-1"> หน้าแสดงรายการเอกสารทั้งหมดของทุกฝ่ายที่เกี่ยวข้อง สามารถตรวจสอบข้อมูลเอกสารได้ตามรายการที่ระบุ. </p>
                        </div>
                        <div class="col-md-4 text-right">
                            @if($data['check']=="A")
                            <a class="btn btn-info btn-rounded width-md waves-effect waves-light" href="{{ route('mg_users') }}">      
                            <i class="icon-people"></i> รายชื่อผู้ขอเข้าใช้งาน</a>
                            @endif

                            <a class="btn btn-secondary btn-rounded width-md waves-effect waves-light" href="{{ route('dashboard') }}">     
                            ย้อนกลับ <i class="icon-arrow-right-circle"></i></a>
                        </div>
                    </div> 
                     
                    <div class="row">
                        <div class="col-md-3"> 
                            <div class="input-group mb-1">
                                <input type="date" class="form-control" id="date" name="date">
                                <div class="input-group-append">
                                    <button class="btn btn-dark waves-effect waves-light" type="button" id="btnSearch_date"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"> 
                            <div class="input-group mb-1">
                                <select id="status" name="status" class="form-control"> 
                                    <option value="0"> เลือกข้อมูล </option>
                                    <option value="1"> รอดำเนินการ </option>
                                    <option value="2">เสร็จสมบูรณ์</option>
                                    <option value="3">ส่งกลับ/แก้ไข</option>
                                    <option value="4">ยกเลิกเอกสาร</option>
                                    <option value="5">ไม่อนุมัติเอกสาร</option>
                                    <option value="6">เอกสารยังไม่สมบูรณ์</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-dark waves-effect waves-light" type="button" id="btnSearch_status"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pb-1"> 
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" placeholder="ค้นหาชื่อ." id="users" name="users">
                                <div class="input-group-append">
                                    <button class="btn btn-dark waves-effect waves-light" type="button" id="btnUsers"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pb-1"> 
                            <div class="input-group mb-1">
                                <input type="text" class="form-control" placeholder="ค้นหาเลขที่เอกสาร." id="search" name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-dark waves-effect waves-light" type="button" id="btnSearch"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-table">
                                <div class="table-responsive"> 
                                    <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-document">
                                        <thead>
                                            <tr>
                                                <th width="10%">เลขที่เอกสาร</th>
                                                <th width="30%">เรื่อง</th>
                                                <th width="20%">ผู้ส่ง</th>
                                                <th width="10%">สถานะ</th>
                                                <th width="15%"> สร้าง </th> 
                                                <th width="15%"> เมื่อ </th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">   
                            <p class=" mb-0" style="color: #333;">Copyright ©2021 All Rights Reserved by chokchaiinternational</p>
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
    <script src="{{ asset('libs/datatables/responsive.bootstrap4.min.js') }}"></script>1
    <script>
        $(document).on('click', '#btnSearch_status', function(event) {   
            var status=$('#status').val();
            $('#tbl-document').DataTable().destroy();
            datatable(null,status,null,null);
        });
        $(document).on('click', '#btnSearch_date', function(event) {   
            var date=$('#date').val();
            $('#tbl-document').DataTable().destroy();
            datatable(null,null,date,null);
        });
        $(document).on('click', '#btnSearch', function(event) {   
            var code=$('#search').val();
            $('#tbl-document').DataTable().destroy();
            datatable(code,null,null,null);
        });
        $(document).on('click', '#btnUsers', function(event) {   
            var users=$('#users').val();
            $('#tbl-document').DataTable().destroy();
            datatable(null,null,null,users);
        }); 

        datatable();
        function datatable(code, status, date, users){
            var get_id=3;
            var code=code;
            var table = $('#tbl-document').DataTable({
                "processing":false,  
                "serverSide":false,  
                "searching": false,
                "lengthChange": true,  
                ajax: {
                    url:"{{ route('datatableDocuments_all.post') }}", 
                    data:{ 
                        get_id: 1,
                        code: code,
                        status: status,
                        date: date,
                        users, users
                    }
                },  
                columns: [ 
                    {data: 'document_code', name: 'document_code'},  
                    {data: 'document_title', name: 'document_title'}, 
                    {data: 'userName', name: 'userName'},
                    {data: 'document_status', name: 'document_status'},
                    {data: 'date', name: 'date'}, 
                    {data: 'created_at', name: 'created_at'}, 
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