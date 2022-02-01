@extends('layouts.app')
 
@section('style')   
    <link href="{{ asset('libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <style>
        .signatureClass {
            margin-bottom: 0.2rem;
            padding: 0.5rem; 
            border: 1px dashed #ddd; 
            border-radius: 0.25rem; 
            color: #FFF;
            border-bottom: 2px solid #0065b5;
        }
        .box-sender { 
            padding: 0.5rem; 
        }
        .signatureUse { 
            background: #ddd; 
            padding: 0.5rem;
        }
    </style>
@endsection

@section('content')    
    @if(isset($data['documentGet']))
        @if(count($data['documentGet'])>0)
            @foreach($data['documentGet'] as $row)
                <form action="{{ route('actionFormSignature.post') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}"> 
                    <input type="hidden" name="area_size" id="area_size" value="">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center"> 
                                <div class="row">
                                    <div class="col-3 col-md-3">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/add-file.png') }}" alt="" width="40">
                                            <div class=""> สร้างเอกสาร </div>    
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/receive-mail.png') }}" alt="" width="40">
                                            <div class=""> กำหนดผู้รับเอกสาร </div>    
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/sign.png') }}" alt="" width="40">
                                            <div class=""> ระบุตำแหน่งการเซ็น </div>    
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <div class="text-center box-timeline ml-3 mr-3"> 
                                            <img src="{{ asset('images/icons/accept.png') }}" alt="" width="40" style="filter: grayscale(1);">
                                            <div class=""> ตรวจสอบข้อมูล </div>    
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center"> <div class="line"> </div>  </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-12">  
                            <div class="row">  
                                <div class="col-md-9"> 
                                    <div class="d-flex justify-content-between" style="background: #ddd;"> 
                                        <div class="pl-2 pt-1"><i class="fe-edit-1"></i> ระบุตำแหน่งการเซ็น </div> 
                                        <div style="padding: 2px;"> {{ $data['fileups']->links() }}  </div>
                                        <div class="pt-1 pr-2"> จำนวนหน้า {{$data['fileups']->lastPage() }} หน้า </div> 
                                    </div>
                                    <div class="text-center" id="droppable" style="background: #333; padding: 5px 0;">
                                        @if(isset($data['fileups'])) 
                                            @foreach($data['fileups'] as $file_imgRow)  
                                                <img src="{{ asset('images/document-file/img_tmp/'.$file_imgRow->filename) }}" alt="" style="width: 670px;height: 937px;" class="mb-2">
                                            @endforeach 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card" style="border-radius: 0;"> 
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote"> 
                                                <div class="box-sender"> 
                                                    <b> ผู้ส่งเอกสาร </b> 
                                                    <div> ชื่อ-นามสกุล : {{$row['sender_name']}} </div>
                                                    <div> อีเมล : {{$row['sender_email']}}    </div>
                                                </div>
                                                <div class="mt-1 mb-1"> <b><i class="icon-pin"></i> ระบุตำแหน่งการเซ็นให้ผู้รับเอกสาร</b> </div>
                                            
                                                <!-- //=================================================// --> 
                                                    <div class="signatureUse">
                                                        @if(isset($row['UserSignature'])) 
                                                            @foreach($row['UserSignature'] as $usersRow)  
                                                                <div class="signatureClass mt-1" style="background: #2196f3b3;" data-id="{{$usersRow['receivers_id']}}">
                                                                    <a href="#">  
                                                                        <input type="hidden" name="list[{{$usersRow['receivers_id']}}][users_receiver]" id="users_receiver{{$usersRow['receivers_id']}}" value="{{$usersRow['receivers_id']}}"> 
                                                                        <input type="hidden" name="list[{{$usersRow['receivers_id']}}][signaturePositionTop]" id="signaturePositionTop{{$usersRow['receivers_id']}}" value=""> 
                                                                        <input type="hidden" name="list[{{$usersRow['receivers_id']}}][signaturePositionleft]" id="signaturePositionleft{{$usersRow['receivers_id']}}" value=""> 
                                                                        <span class="" style="color: #FFF;" data-id="{{$usersRow['receivers_id']}}"> 
                                                                            <i class="fe-edit-1"></i> คุณ : {{$usersRow['ReceiversName']}} 
                                                                        </span>
                                                                    </a> 
                                                                </div>  
                                                            @endforeach 
                                                        @endif
                                                    </div>
                                                <!-- //=================================================// -->

                                                <div class="mt-3 text-center">
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="closeDoc" data-id="{{$data['get_id']}}">
                                                        <div class="closeDoc_text"><i class="icon-close"></i>  <span>ยกเลิกรายการ</span></div> 
                                                    </button> 
                                                    <button type="submit" class="btn btn-dark waves-effect width-md waves-light"> 
                                                        <span>ขั้นตอนถัดไป</span> <i class="icon-arrow-right-circle"></i>   
                                                    </button>
                                                </div>
                                            </blockquote>  
                                        </div>
                                    </div>
                                </div>    
                            </div> 
                        </div>
                    <div> 
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
@endsection 
@section('script')  
<script src="{{ asset('libs/select2/select2.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).on('click', '#closeDoc', function(event) { 
        var id=$(this)[0].dataset.id; 
        Swal.fire({
            title: 'ยืนยันการยกเลิกรายการเอกสาร?',
            text: "ยกเลิกรายการแล้วจะไม่สามารถนำกลับมาได้!",
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

    setTimeout(function(){ $('.alert-success').fadeOut(); }, 2000); 
    // =================== // 
    windowWidth=jQuery(window).width();
    $('#area_size').val(windowWidth);
    $( function() {
        $( ".signatureClass" ).draggable();
        $( "#droppable" ).droppable({
            drop: function( event, ui ) {
                console.log(ui);
                var left = ui.offset.left;
                var top = ui.offset.top; 
                $('#signaturePositionTop'+ui.draggable[0].dataset.id).val(top);
                $('#signaturePositionleft'+ui.draggable[0].dataset.id).val(left);
            }
        });
    } );
</script>   
@endsection