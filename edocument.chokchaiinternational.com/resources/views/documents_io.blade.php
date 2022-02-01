@extends('layouts.app_io')
 
@section('style')   
<link href="{{ asset('libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<style>
    .blink_me {
        color: #FFF;
        animation: blinker 1s linear infinite;
    }
    @keyframes blinker {  
        50% { opacity: 0; }
    }  
</style>
@endsection

@section('content')   
        @if(session("success"))
            <div class="alert alert-success" role="alert">
                <i class="icon-check"></i> {{session("success")}}
            </div>
        @endif
        <div class="row mt-3"> 
            <div class="col-md-8">
                <h4 class="">
                    <?php echo $data['title']; ?>
                </h4>
            </div>
            <div class="col-md-4">
                <input type="hidden" name="get_id" id="get_id" value="{{$data['get_id']}}"> 
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="ค้นหาเลขที่เอกสาร." id="search" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-dark waves-effect waves-light" type="button" id="btnSearch"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div> 
            <div class="col-md-12 pt-2"> 
                <div class="box-table">
                    <div class="table-responsive"> 
                        <table class="table table-borderless  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-document">
                            <thead>
                                <tr>
                                    <th>เลขที่เอกสาร</th>
                                    <th>เรื่อง</th>
                                    <th>สร้างโดย</th>
                                    <th>สถานะ</th>
                                    <th>เมื่อ</th> 
                                </tr>
                            </thead> 
                        </table>
                    </div>
                </div>
            </div>
        <div>
@endsection 
@section('script')
<script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('libs/datatables/responsive.bootstrap4.min.js') }}"></script>

<script>
        setTimeout(function(){ $('.alert-success').fadeOut(); }, 2000); 

        $(document).on('click', '#btnSearch', function(event) {   
            var code=$('#search').val();
            $('#tbl-document').DataTable().destroy();
            datatable(code);
        });
        datatable();
        function datatable(code){
            var get_id=$('#get_id').val();
            var code=code;
            var table = $('#tbl-document').DataTable({
                "processing":false,  
                "serverSide":false,  
                "searching": false,
                "lengthChange": true, 
                ajax: {
                    url:"{{ route('datatableDocuments_io.post') }}", 
                    data:{ 
                        get_id: get_id,
                        code: code
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
</script>
@endsection