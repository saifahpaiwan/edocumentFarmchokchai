@extends('layouts.app')
 
@section('style')    
<link href="{{ asset('css/css.main/style-1.css') }}" rel="stylesheet" type="text/css" />  
@endsection

@section('content')    
        <div class="row mt-3">
            <div class="col-md-12">  
                <form action="{{ route('actionFormEditDocument.post') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">  
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center"> 
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="text-center box-timeline"> 
                                            <img src="{{ asset('images/icons/DocumentEdit.png') }}" alt="" width="50">
                                            <div class=""> แก้ไขเอกสาร / ส่งกลับแก้ไข </div>    
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <div class="card">
                                    <div class="card-header">
                                        <b> <i class="fe-file-plus"></i> แก้ไขเอกสาร / ส่งกลับแก้ไข </b> 
                                        <div class="float-right"> <b>เลขที่เอกสาร {{ $data['document_edit']->document_code }}</b> </div>
                                    </div>
                                    <div class="card-body">
                                        <blockquote class="card-bodyquote">
                                            <div class="mb-2"> 
                                                อัพโหลดเอกสารขนาดรูปไม่ควรเกิน 2 MB เฉพาะไฟล์ .PDF เท่านั้น เลือกรูปแบบการเซ็นบุคคลเดียวหรือหลายคน.   
                                            </div>   
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label text-right" for="sender">ชื่อผู้ส่งเอกสาร</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="sender" class="form-control" value="{{ $data['users']->name }}" disabled>
                                                </div>
                                                <label class="col-md-1 col-form-label text-right" for="sender">อีเมล</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="sender" class="form-control" value="{{ $data['users']->email }}" disabled>
                                                </div>
                                            </div>  
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label text-right" for="topic_email">หัวเรื่องการส่ง</label>
                                                <div class="col-md-9"> 
                                                    <input id="topic_email" type="text" class="form-control @error('topic_email') is-invalid @enderror" name="topic_email" required autocomplete="topic_email" autofocus
                                                    value="@if($data['document_edit']->document_title) {{ $data['document_edit']->document_title }}  @else {{ old('topic_email') }} @endif"> 
                                                    @error('topic_email') 
                                                        <div class="alert alert-icon bg-transparent text-danger alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label text-right" for="detail_email">รายละเอียดการส่ง</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control @error('detail_email') is-invalid @enderror" rows="3" id="detail_email" name="detail_email" required autocomplete="detail_email" autofocus>@if($data['document_edit']->document_detail) {{ $data['document_edit']->document_detail }}  @else {{ old('detail_email') }} @endif</textarea> 
                                                    @error('detail_email') 
                                                        <div class="alert alert-icon bg-transparent text-danger alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>  

                                            <div class="row">  
                                                <div class="offset-md-3 col-md-9"> 
                                                    <div class="text-dark">  
                                                        <label for="file_upload" class="custom-file_upload">  
                                                            <div class="file_ui d-flex pb-1 justify-content-center"> 
                                                                <div class="box-div-filename text-center"> 
                                                                    <img class="mr-1" src="{{ asset('images/icons/pdf.svg') }}" width="40"><br> 
                                                                    <span style="font-size: 10px;color: #9e9e9e;"> {{ $data['document_edit']->filename }} </span> 
                                                                </div>
                                                            </div>
                                                            <h4 class="mt-2">อัพโหลดไฟล์รายละเอียดเอกสาร</h4>
                                                            <span class="text-muted">ไฟล์รายละเอียดเอกสารที่เกียวกับการประกอบการอนุมัติเอกสาร <br>ไฟล์ .PDF เท่านั้น <small class="text-danger">*บังคับอัพโหลดไฟล์ </small></span> </span> 
                                                        </label>
                                                        <input id="file_upload" name="file_upload[]" type="file"/>   
                                                    </div> 
                                                    @error('file_upload')
                                                        <div class="alert alert-icon bg-transparent text-danger alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div> 
                                                    @enderror  
                                                </div> 
                                                <div class="offset-md-3 col-md-9">   
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="closeDoc" data-id="{{$data['get_id']}}">
                                                        <div class="closeDoc_text"><i class="icon-close"></i>  <span>ยกเลิกเอกสาร</span></div> 
                                                    </button>
                                                    <button type="submit" class="btn btn-dark waves-effect waves-light">
                                                        <i class="icon-note"></i> <span>ยืนยันการแก้ไขเอกสาร</span>
                                                    </button>
                                                    <a href="{{ url('/documents_viwe/'.$data['get_id']) }}" class="btn btn-secondary waves-effect waves-light float-right">
                                                        ย้อนกลับ <i class="icon-arrow-right-circle"></i>
                                                    </a>
                                                </div> 
                                            </div> 
                                        </blockquote> 
                                    </div> 
                                </div>  
                            </div> 
                        </div> 
                    </div>  
                </form>
            </div>
        <div>  
@endsection 
@section('script')  
<script> 
    setTimeout(function(){ $('.alert-success').fadeOut(); }, 2000);  
    $(document).on('change', '#file_upload', function(event) {   
        $('.file_ui').html("");
        var fileUI = $('#file_upload'); 
        var length=fileUI[0].files.length;
        var html="";
        for(var i=0; i<=(length-1); i++){
            if(fileUI[0].files[i]){ 
                var icon = "{{ asset('images/icons/pdf.svg') }}";
                html+='<div class="box-div-filename text-center"> <img class="mr-1" src="'+icon+'" width="40"><br> <span style="font-size: 10px;color: #9e9e9e;"> '+fileUI[0].files[i].name+' </span> </div>';
            }
        } 
        $('.file_ui').html(html);
    });

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
                                location.replace("{{ url('/documents/4') }}");
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