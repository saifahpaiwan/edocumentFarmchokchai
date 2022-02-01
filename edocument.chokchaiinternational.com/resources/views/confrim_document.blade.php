@extends('layouts.app')
 
@section('style')   
    <link href="{{ asset('libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('/libs/spinkit/spinkit.css') }}" rel="stylesheet" type="text/css" >
    <style> 
        .box-signature {
            padding: 0.5rem; 
            border: 1px solid #ddd;
            border-bottom: 2px solid #333;
            border-radius: 0.25rem;
            margin: 0.5rem;
            width: 100%;
        }
    </style>
@endsection

@section('content')    
    @if(isset($data['documentGet']))
        @if(count($data['documentGet'])>0)
            @foreach($data['documentGet'] as $row)
                <form action="{{ route('actionFormConfrim.post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}"> 
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center mb-2"> 
                                <div class="row">
                                    <div class="col-4 col-md-4">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/add-file.png') }}" alt="" width="50">
                                            <div class=""> สร้างเอกสาร </div>    
                                        </div>
                                    </div> 
                                    <div class="col-4 col-md-4">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/sign.png') }}" alt="" width="50">
                                            <div class=""> กำหนดผู้เซ็นเอกสาร </div>    
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/accept.png') }}" alt="" width="50">
                                            <div class=""> ตรวจสอบข้อมูล </div>    
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center"> <div class="line"> </div>  </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-8">  
                            @if(isset($data['fileups'])) 
                                @foreach($data['fileups'] as $file_imgRow)   
                                    <object
                                    data="{{ asset('images/document-file/pdf_file/'.$file_imgRow->filename) }}"
                                    type="application/pdf"
                                    width="100%"
                                    height="100%">
                                        <iframe
                                            src="{{ asset('images/document-file/pdf_file/'.$file_imgRow->filename) }}"
                                            width="100%"
                                            height="100%"
                                            style="border: none;"> 
                                        </iframe>
                                    </object> 
                                @endforeach 
                            @endif 
                        </div>
                        <div class="col-md-4">  
                            <div class="card">
                                <div class="card-header" style="background: #333; padding: 1.2rem; border-radius: 0; color: #FFF;">
                                    <i class="mdi mdi-file-document-box-search-outline"></i> ตรวจสอบเอกสาร
                                </div>
                                <div class="card-body">
                                    <blockquote class="card-bodyquote">
                                        <p> ตรวจสอบความถูกต้องเอกสารและรายชื่อผู้รับเอกสาร </p> 
                                        <div class="row"> 
                                            <div class="col-md-6">
                                                <div><b>เลขที่ {{$row['document_code']}}</b></div>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <div><b>วันที่  <?php echo date("d/m/Y", strtotime($row['created_at'])); ?></b></div>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <label class="col-md-12 col-form-label" for="sender">ชื่อผู้ส่งเอกสาร</label>
                                            <div class="col-md-12">
                                                <input type="text" id="sender" class="form-control" value="{{$row['sender_name']}}" disabled>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <label class="col-md-12 col-form-label" for="sender_email">อีเมล</label>
                                            <div class="col-md-12">
                                                <input type="text" id="sender_email" class="form-control" value="{{$row['sender_email']}}" disabled>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <label class="col-md-12 col-form-label" for="topic_email">หัวเรื่องการส่ง </label>
                                            <div class="col-md-12">
                                                <input type="text" id="topic_email" name="topic_email" class="form-control" value="{{$row['document_title']}}" disabled>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <label class="col-md-12 col-form-label" for="detail_email">รายละเอียดการส่ง </label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="3" id="detail_email" name="detail_email" disabled>{{$row['document_detail']}}</textarea>
                                            </div>
                                        </div> 
                                    </blockquote> 
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-danger waves-effect waves-light" id="closeDoc" data-id="{{$data['get_id']}}">
                                                <div class="closeDoc_text"><i class="icon-close"></i>  <span>ยกเลิกรายการ</span></div> 
                                            </button>
                                            <button type="submit" class="btn btn-success waves-effect width-md waves-light">
                                                <i class="icon-check"></i>
                                                <span>ยืนยันการสร้างเอกสาร </span> 
                                            </button>
                                        </div>
                                    </div>  
                                </div> 
                            </div>
                            <div class="card">
                                <div class="card-header" style="background: #333; padding: 1.2rem; border-radius: 0; color: #FFF;">
                                    <i class="fe-edit-1"></i> รายชื่อผู้เซ็นเอกสาร
                                </div>
                                <div class="card-body"> 
                                    <?php $n=1; ?>
                                    @if(isset($row['UserSignature'])) 
                                        @foreach($row['UserSignature'] as $usersRow)  
                                            <div class="box-signature">  
                                                <div>  <b>ลำดับที่ {{ $n++ }}</b> 
                                                    @if($usersRow['signing_rights']==1)
                                                    <div class="float-right"> <span class="badge badge-warning"><i class="fe-edit-1"></i> สิทธ์การเซ็น</span></span>  </div> 
                                                    @else
                                                    <div class="float-right"> <span class="badge badge-purple"><i class="mdi mdi-file-document-box-search-outline"></i> สิทธ์การดูอย่างเดียว  </div> 
                                                    @endif 
                                                </div> 
                                                <div class="">   ชื่อผู้เซ็น :  {{$usersRow['ReceiversName']}}  </div>
                                                <div> ตำแหน่ง :  {{$usersRow['position']}} </div>
                                                <div> อีเมล :  {{$usersRow['ReceiversEmail']}} </div> 
                                            </div>
                                        @endforeach 
                                    @endif  
                                </div> 
                            </div>
                        </div>
                    </div>   
                </form>
            @endforeach
        @else 
            <div class="d-flex justify-content-center mt-5"> 
                <div class="text-center"> 
                    <img src="{{ asset('images/icons/question.png') }}" alt="" width="30%" style="filter: grayscale(1);">
                    <div class="mt-2 h4"> ไม่พบข้อมูล </div>     
                </div>
            </div>
        @endif
    @endif 


    <div class="modal fade modal_loadeing" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
                <div class="modal-body text-center"> 
                    <div class="sk-cube-grid" style="margin: 40px auto 0;">
                        <div class="sk-cube sk-cube1"></div>
                        <div class="sk-cube sk-cube2"></div>
                        <div class="sk-cube sk-cube3"></div>
                        <div class="sk-cube sk-cube4"></div>
                        <div class="sk-cube sk-cube5"></div>
                        <div class="sk-cube sk-cube6"></div>
                        <div class="sk-cube sk-cube7"></div>
                        <div class="sk-cube sk-cube8"></div>
                        <div class="sk-cube sk-cube9"></div>
                    </div>
                    <div class="mt-1"> loading.... </div>
                    <div class="h4"> ตรวจสอบข้อมูลสำเร็จ </div>
                    <div class=""> ระบบกำลังทำการสร้างเอกสาร กรุณารอสักครู่..... </div>
                </div>
            </div> 
        </div> 
    </div> 
@endsection 
@section('script')  
<script src="{{ asset('libs/select2/select2.min.js') }}"></script>
<script>  
    $( "form" ).submit(function( event ) { 
        $('.modal_loadeing').modal({
            backdrop: 'static',
            show: true, 
        });
        setTimeout(function(){
            $( "form" ).submit();  
        }, 5000); 
    }); 
     
    setTimeout(function(){ $('.alert-success').fadeOut(); }, 2000); 
    $(document).on('click', '#closeDoc', function(event) { 
        var id=$(this)[0].dataset.id;   
        Swal.fire({
            title: 'ยืนยันการยกเลิกเอกสาร หรือไม่?',
            text: "เมื่อยกเลิกแล้วจะไม่สามารถนำรายการกลับมาได้!",
            type:"question",
            showCancelButton:!0,
            confirmButtonText:"Yes",
            cancelButtonText:"No",
            confirmButtonClass:"btn btn-success mt-2",
            cancelButtonClass:"btn btn-danger ml-2 mt-2",
            buttonsStyling:!1
        }).then((result) => { 
            if (result.value) {  
                $.post("{{ route('closeDocument.post') }}", {
                    _token: "{{ csrf_token() }}", 
                    id: id, 
                    status: 1,
                })
                .done(function(data, status, error){   
                    if(error.status==200){  
                        if(data.status==200){
                            var html='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
                            $( "#closeDoc" ).prop( "disabled", true );
                            $('.closeDoc_text').html(html);
                            setTimeout(function(){ 
                                location.replace("{{ route('create_document') }}");
                            }, 2000);
                            
                        }
                    }
                })
                .fail(function(xhr, status, error) { 
                    alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
                });   
            }
        });
    }); 
</script>   
@endsection