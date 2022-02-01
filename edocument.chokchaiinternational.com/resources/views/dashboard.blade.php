@extends('layouts.app')
 
@section('style')   
<link href="{{ asset('libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')  
        <div class="row mt-3"> 
             
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom" style="border: 1px solid #34d3eb; background: #ecfcff;">
                    <a href="{{ route('create_document') }}">
                        <div class="media">
                            <div class="avatar-lg rounded-circle bg-info widget-two-icon align-self-center">
                                <i class=" mdi mdi-file-document-box-plus avatar-title font-30 text-white"></i>
                            </div> 
                            <div class="wigdet-two-content media-body">
                                <p class="m-0 text-uppercase font-weight-medium text-truncate text-muted" title="Statistics">สร้างเอกสารใหม่</p>
                                <h3 class="font-weight-medium my-2 text-truncate"> สร้างเอกสาร</h3>
                                <p class="m-0 text-muted">ไฟล์ .PDF </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div> 

            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom" style="border: 1px solid #ffa91c; background: #fff5e4;">
                    <a href="{{ url('/documents/3') }}">
                        <div class="media">
                            <div class="avatar-lg rounded-circle bg-warning widget-two-icon align-self-center">
                                <i class="fe-file-text avatar-title font-30 text-white"></i>
                            </div>

                            <div class="wigdet-two-content media-body">
                                <p class="m-0 text-uppercase font-weight-medium text-truncate text-muted" title="Statistics"> จำนวนเอกสารทั้งหมด </p>
                                <h3 class="font-weight-medium my-2"><span data-plugin="counterup">{{ $data['count3'] }}</span> เอกสาร</h3>
                                <p class="m-0 text-muted">Date : <?php echo date('Y/m/d'); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div> 

            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom" style="border: 1px solid #f96a74; background: #ffe1e3;">
                    <a href="{{ url('/documents/2') }}">
                        <div class="media">
                            <div class="avatar-lg rounded-circle bg-danger widget-two-icon align-self-center">
                                <i class=" mdi mdi-file-document-edit-outline  avatar-title font-30 text-white"></i>
                            </div>

                            <div class="wigdet-two-content media-body">
                                <p class="m-0 text-uppercase font-weight-medium text-truncate text-muted" title="Statistics">เอกสารที่ต้องเซ็น</p>
                                <h3 class="font-weight-medium my-2">  <span data-plugin="counterup"> {{ $data['count2'] }} </span> เอกสาร</h3>
                                <p class="m-0 text-muted">คลิกเพื่อเซ็นเอกสาร</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom" style="border: 1px solid #6c757d; background: #e8e8e8;">
                    <a href="{{ url('/documents/6') }}">
                        <div class="media">
                            <div class="avatar-lg rounded-circle bg-secondary widget-two-icon align-self-center">
                                <i class="fe-message-square  avatar-title font-30 text-white"></i>
                            </div>

                            <div class="wigdet-two-content media-body">
                                <p class="m-0 text-uppercase font-weight-medium text-truncate text-muted" title="Statistics">ส่งกลับ/แก้ไข</p>
                                <h3 class="font-weight-medium my-2">  <span data-plugin="counterup"> {{ $data['count6'] }} </span> เอกสาร </h3>
                                <p class="m-0 text-muted">คลิกเพื่อดูเอกสาร</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        @if(session("success"))
            <div class="alert alert-success" role="alert">
                <i class="icon-check"></i> {{session("success")}}
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <h4 class="">
                    <i class="fe-file-text"></i> เอกสารล่าสุด ประจำวันที่ <?php echo date('d/m')."/".(date('Y')+543); ?>
                </h4>
            </div>
            <div class="col-md-4 pb-1"> 
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="ค้นหาเลขที่เอกสาร." id="search" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-dark waves-effect waves-light" type="button" id="btnSearch"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box-table">
                    <div class="table-responsive"> 
                        <table class="table table-borderless  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-document">
                            <thead>
                                <tr>
                                    <th width="5%">เลขที่เอกสาร</th>
                                    <th width="85%">เรื่อง</th>
                                    <th width="10%">ผู้ส่ง</th>
                                    <th width="10%">สถานะ</th>
                                    <th width="10%">วัน - เวลา</th> 
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
            <div class="col-md-8">
                <h4 class="">
                    <i class="icon-bubbles"></i> รายการขอความคิดเห็นเพิ่มเติม
                </h4>
            </div> 
            <div class="col-md-4 pb-1">  
                <div class="input-group">
                    <input class="form-control" type="date" id="date_comments" name="date">
                    <select class="custom-select" id="status" name="status"> 
                        <option value="N">รอการตอบรับ</option>
                        <option value="Y">ตอบรับแล้ว</option> 
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-dark waves-effect waves-light" type="button" id="btnComments"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div> 
            <div class="col-md-12">
                <div class="box-table">
                    <div class="table-responsive"> 
                        <table class="table table-borderless  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-comments">
                            <thead>
                                <tr>
                                    <th width="5%">เลขที่เอกสาร</th>
                                    <th width="85%">รายการ</th>
                                    <th width="10%">ผู้ขอความคิดเห็น</th>
                                    <th width="10%">สถานะ</th>
                                    <th width="10%">วัน - เวลา</th> 
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade Notification_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mt-0"><i class="mdi mdi-qrcode-scan"></i> รับการแจ้งเตือนผ่าน Line </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">  
                            <div class="col-md-12 text-center"> 
                                <img src="{{ asset('images/QR-liff.png') }}" alt="" width="40%">
                                <div class="h4"> โปรดสแกนเพื่อแอดไลน์ (edocument system)</div>
                                <div class=""> เพื่อรับการแจ้งเตือนผ่าน Line เมื่อรับการแจ้งเตือนแล้วระบบจะทำการส่งข้อมูลการแจ้งเตือนมาที่ Line "edocument system" ของคุณเอง </div> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div>
@endsection 
@section('script')
<script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('libs/datatables/responsive.bootstrap4.min.js') }}"></script>

<script>    
        check_lineUserid();
        function check_lineUserid()
        {
            $.post("{{ route('check_lineUserid.post') }}", {
                _token: "{{ csrf_token() }}",  
            })
            .done(function(data, status, error){   
                if(error.status==200){    
                    if(data==1){
                        console.log(data);
                        $('.Notification_ui').modal({
                            backdrop: 'static',
                            show: false, 
                        });
                    } else if(data==2){
                        $('.Notification_ui').modal({
                            backdrop: 'static',
                            show: true, 
                        });
                    }
                }
            })
            .fail(function(xhr, status, error) { 
                alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
            }); 
        }

        setTimeout(function(){ $('.alert-success').fadeOut(); }, 2000);
        // ===============SELECT2=============== //
        
        $(document).on('click', '#btnSearch', function(event) {   
            var code=$('#search').val();
            $('#tbl-document').DataTable().destroy();
            datatable(code);
        });

        datatable();
        function datatable(code){ 
            var get_id=7;
            var code=code;
            var table = $('#tbl-document').DataTable({
                "processing":false,  
                "serverSide":false,  
                "searching": false,
                "lengthChange": true, 
                ajax: {
                    url:"{{ route('datatableDocuments.post') }}", 
                    data:{  
                        code: code,
                        get_id: get_id
                    }
                },  
                columns: [   
                    {data: 'document_code', name: 'document_code'},  
                    {data: 'document_title', name: 'document_title'}, 
                    {data: 'userName', name: 'userName'},
                    {data: 'document_status', name: 'document_status'},
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
  
        $(document).on('click', '#btnComments', function(event) {   
            var status=$('#status').val();
            var date_comments=$('#date_comments').val();
            $('#tbl-comments').DataTable().destroy();
            datatable_comments(status, date_comments);
        });
         
        datatable_comments();
        function datatable_comments(status, date_comments){ 
            var table = $('#tbl-comments').DataTable({
                "processing":false,  
                "serverSide":false,  
                "searching": false,
                "lengthChange": true, 
                ajax: {
                    url:"{{ route('datatable_dashboard_comments') }}", 
                    data:{ 
                        status: status ,
                        date_comments : date_comments   
                    }
                },  
                columns: [  
                    {data: 'code', name: 'code'},  
                    {data: 'title', name: 'title'}, 
                    {data: 'users', name: 'users'},
                    {data: 'status', name: 'status'},
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
@endsection