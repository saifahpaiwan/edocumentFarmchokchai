@extends('layouts.app')
 
@section('style')   
    <link href="{{ asset('libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style> 
        .custom-control-input:checked~.custom-control-label::before {
            color: #333;
            border-color: #333;
            background-color: #333;
        }
    </style>
@endsection

@section('content')     
    @if(isset($data['documentGet']))
        @if(count($data['documentGet'])>0)
            @foreach($data['documentGet'] as $row)
            <form action="{{ route('actionFormReceiver.post') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">  
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center"> 
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
                                        <img src="{{ asset('images/icons/accept.png') }}" alt="" width="50" style="filter: grayscale(1);">
                                        <div class=""> ตรวจสอบข้อมูล </div>    
                                    </div>
                                </div>
                                <div class="col-md-12 text-center"> <div class="line"> </div>  </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-4">  
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center"> 
                                    <div class="card">
                                        <div class="card-header">
                                            <b><i class="fe-user"></i> สร้างผู้รับเอกสาร</b>
                                            <div class="float-right"><b>เลขที่ {{$row['document_code']}}</b></div>  
                                        </div>
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote">
                                                <p> สร้างผู้รับเอกสารและจัดการสิทธ์ในการเข้าถึงเอกสาร สามารถสร้างผู้รับเอกสารได้มากกว่าหนึ่งคน. </p> 
                                                <div class="form-group row"> 
                                                    <div class="col-md-12">
                                                        <label class="col-form-label text-right" for="sender">ชื่อผู้ส่งเอกสาร</label>
                                                        <input type="text" id="sender" class="form-control" value="{{$row['sender_name']}}" disabled>
                                                    </div> 
                                                    <div class="col-md-12">
                                                        <label class="col-form-label text-right" for="sender">อีเมล</label>
                                                        <input type="text" id="sender" class="form-control" value="{{$row['sender_email']}}" disabled>
                                                    </div> 
                                                    <div class="col-md-12">
                                                        <label class="col-form-label text-right" for="sender"> หัวเรื่อง </label>
                                                        <input type="text" id="sender" class="form-control" value="{{$row['document_title']}}" disabled>
                                                    </div> 
                                                    <div class="col-md-12">
                                                        <label class="col-form-label text-right" for="sender"> รายละเอียด </label>
                                                        <textarea class="form-control" rows="3" id="detail_email" name="detail_email" disabled>{{$row['document_detail']}}</textarea>
                                                    </div> 
                                                </div>
                                            </blockquote> 
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-8">   
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="d-flex" style="background: #edeff1; padding: 0.5rem; margin-bottom: 5px; border-radius: 0.25rem;"> 
                                    <div class="flex-grow-1"> 
                                        @if($row['document_type']==2)
                                            <button type="button" class="btn btn-primary btn-rounded width-md waves-effect waves-light" id="addUsers">
                                                <i class="icon-plus"></i> เพิ่มผู้รับเอกสาร
                                            </button>
                                        @endif
                                    </div>
                                    <div class=""> 
                                        <button type="button" class="btn btn-danger waves-effect waves-light" id="closeDoc" data-id="{{$data['get_id']}}">
                                            <div class="closeDoc_text"><i class="icon-close"></i>  <span>ยกเลิกรายการ</span></div> 
                                        </button>
                                        <button type="submit" class="btn btn-dark waves-effect waves-light">
                                            <span>ขั้นตอนถัดไป</span> <i class="icon-arrow-right-circle"></i>  
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        @if(session("error"))
                                            <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <i class="mdi mdi-block-helper mr-2"></i>
                                                <strong>ผิดผลาด!</strong> {{session("error")}}
                                            </div> 
                                        @endif
                                    </div> 
                                </div>
                            </div> 
                            <div class="col-md-12">  
                                @error('receiver') 
                                    <div class="alert alert-icon bg-transparent text-danger alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <i class="mdi mdi-block-helper mr-2"></i>
                                        <strong>ผิดผลาด!</strong> {{ $message }} 
                                    </div>
                                @enderror
                                <div class="box-receiver"> 
                                    @if(isset($row['UserSignature']))
                                        @foreach($row['UserSignature'] as $rowReceiver)
                                            <div class="d-flex justify-content-center" id="list-receiver-{{ $rowReceiver['receivers_id'] }}" data-id="{{ $rowReceiver['receivers_id'] }}"> 
                                                <div class="card" style="border-bottom: 4px solid #64c5b1;"> 
                                                    <div class="card-header" style="background: #64c5b1;color: #FFF;">
                                                        <b> <i class="icon-paper-plane"></i> ผู้รับเอกสาร </b> 
                                                        @if($row['document_type']==1) <span class=""> (กรณีผู้เซ็นคนเดียว) </span> @endif
                                                        <div class="d-flex float-right"> 
                                                            <input type="hidden" name="receiver[{{ $rowReceiver['receivers_id'] }}][id_hdf]" id="id_hdf{{ $rowReceiver['receivers_id'] }}" value="{{$rowReceiver['receivers_id']}}">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="receiver_customRadio-{{ $rowReceiver['receivers_id'] }}-1" name="receiver[{{ $rowReceiver['receivers_id'] }}][receiver_customRadio]" class="custom-control-input" value="1" 
                                                                @if($rowReceiver['signing_rights']==1) checked @endif>
                                                                <label class="custom-control-label mr-2" for="receiver_customRadio-{{ $rowReceiver['receivers_id'] }}-1">มีสิทธิ์การเซ็น</label>
                                                            </div>
                                                            @if($row['document_type']==2)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="receiver_customRadio-{{ $rowReceiver['receivers_id'] }}-2" name="receiver[{{ $rowReceiver['receivers_id'] }}][receiver_customRadio]" class="custom-control-input" value="2"
                                                                @if($rowReceiver['signing_rights']==2) checked @endif>
                                                                <label class="custom-control-label mr-2" for="receiver_customRadio-{{ $rowReceiver['receivers_id'] }}-2">ดูอย่างเดียว</label>
                                                            </div> 
                                                            @endif
                                                            <button type="button" class="btn btn-xs waves-effect waves-light btn-danger" 
                                                            style="position: absolute; top: 0; right: 0;" id="remove_receiver" data-id="{{ $rowReceiver['receivers_id'] }}"> 
                                                                <i class="fas fa-times"></i> 
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body" style="padding: 0.5rem;">
                                                        <div> 
                                                            <div class=" row">
                                                                <label class="col-md-2 col-form-label text-right" for="users_id{{ $rowReceiver['receivers_id'] }}">ชื่อ-นามสกุล</label>
                                                                <div class="col-md-4">
                                                                    <select id="users_id_R{{ $rowReceiver['receivers_id'] }}" name="receiver[{{ $rowReceiver['receivers_id'] }}][users_id]" class="form-control" data-toggle="select2" data-val="{{ $rowReceiver['receivers_id'] }}">
                                                                        <option value=""> ระบุผู้รับเอกสาร </option>
                                                                        @if(isset($data['usersGet']))
                                                                            @foreach($data['usersGet'] as $row_users)
                                                                                <option value="{{$row_users->id}}"> {{$row_users->name}} </option>
                                                                            @endforeach 
                                                                        @endif
                                                                    </select>    
                                                                </div>
                                                                <label class="col-md-2 col-form-label text-right" for="users_email-{{ $rowReceiver['receivers_id'] }}">อีเมล์</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="users_email-{{ $rowReceiver['receivers_id'] }}" name="receiver[{{ $rowReceiver['receivers_id'] }}][users_email]"  class="form-control form-control-sm" value="{{ $rowReceiver['ReceiversEmail'] }}">  
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="col-md-2 col-form-label text-right" for="users_id1"> เลือกคำนำหน้า </label>
                                                                <div class="col-md-4"> 
                                                                    <select class="form-control form-control-sm" name="receiver[{{ $rowReceiver['receivers_id'] }}][signing_prefix]">
                                                                        <option selected value="1">ลงชื่อเพื่อทราบ</option> 
                                                                        <option value="2">ลงชื่อเพื่ออนุมัติ</option> 
                                                                    </select>
                                                                </div> 
                                                                <label class="col-md-2 col-form-label text-right" for="users_position-{{ $rowReceiver['receivers_id'] }}"> ตำแหน่ง </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="users_position-{{ $rowReceiver['receivers_id'] }}" name="receiver[{{ $rowReceiver['receivers_id'] }}][users_position]"  class="form-control form-control-sm" value="{{ $rowReceiver['position'] }}">  
                                                                </div>
                                                                <div class="offset-md-2 col-md-10"> <span style="font-size: 10px; color: #f44336;"> <i class="mdi mdi-alert-circle"></i>  โปรดเลือกคำนำหน้า การลงลายเซ็น ลงชื่อเพื่อทราบ หรือ ลงชื่อเพื่ออนุมัติ  </span> </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div> 
                                        @endforeach
                                    @else 
                                    <div class="d-flex justify-content-center" id="list-receiver-1" data-id="1"> 
                                        <div class="card" style="border-bottom: 4px solid #64c5b1;"> 
                                            <div class="card-header" style="background: #64c5b1;color: #FFF;">
                                                <b> <i class="icon-paper-plane"></i> ผู้รับเอกสาร </b> 
                                                @if($row['document_type']==1) <span class=""> (กรณีผู้เซ็นคนเดียว) </span> @endif
                                                <div class="d-flex float-right"> 
                                                    <input type="hidden" name="receiver[1][id_hdf]" id="id_hdf1" value="null">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="receiver_customRadio-1-1" name="receiver[1][receiver_customRadio]" class="custom-control-input" value="1" checked>
                                                        <label class="custom-control-label mr-2" for="receiver_customRadio-1-1">มีสิทธิ์การเซ็น</label>
                                                    </div>
                                                    @if($row['document_type']==2)
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="receiver_customRadio-1-2" name="receiver[1][receiver_customRadio]" class="custom-control-input" value="2">
                                                        <label class="custom-control-label mr-2" for="receiver_customRadio-1-2">ดูอย่างเดียว</label>
                                                    </div> 
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body" style="padding: 0.5rem;">
                                                <div> 
                                                    <div class=" row">
                                                        <label class="col-md-2 col-form-label text-right" for="users_id1">ชื่อ-นามสกุล</label>
                                                        <div class="col-md-4">
                                                            <select id="users_id1" name="receiver[1][users_id]" class="form-control" data-toggle="select2" data-val="1">
                                                                <option value=""> ระบุผู้รับเอกสาร </option>
                                                                @if(isset($data['usersGet']))
                                                                    @foreach($data['usersGet'] as $row_users)
                                                                        <option value="{{$row_users->id}}"> {{$row_users->name}} </option>
                                                                    @endforeach 
                                                                @endif
                                                            </select>  
                                                        </div>
                                                        <label class="col-md-2 col-form-label text-right" for="users_email-1">อีเมล์</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="users_email-1" name="receiver[1][users_email]"  class="form-control form-control-sm" value="">  
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-md-2 col-form-label text-right" for="users_id1"> เลือกคำนำหน้า </label>
                                                        <div class="col-md-4"> 
                                                            <select class="form-control form-control-sm" name="receiver[1][signing_prefix]">
                                                                <option selected value="1">ลงชื่อเพื่อทราบ</option> 
                                                                <option value="2">ลงชื่อเพื่ออนุมัติ</option> 
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 col-form-label text-right" for="users_position-1"> ตำแหน่ง </label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="users_position-1" name="receiver[1][users_position]"  class="form-control form-control-sm" value="">  
                                                        </div>
                                                        <div class="offset-md-2 col-md-10"> <span style="font-size: 10px; color: #f44336;"> <i class="mdi mdi-alert-circle"></i>  โปรดเลือกคำนำหน้า การลงลายเซ็น ลงชื่อเพื่อทราบ หรือ ลงชื่อเพื่ออนุมัติ  </span> </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
<script>   
    setTimeout(function(){ $('.alert-danger').fadeOut(); }, 2000); 
    @if(isset($row['UserSignature']))
        @if(count($row['UserSignature'])>0)
            @foreach($row['UserSignature'] as $rowReceiver)
                $("#users_id_R{{ $rowReceiver['receivers_id'] }}").select2().select2("val", "{{ $rowReceiver['UserReceiversid'] }}"); 
            @endforeach
        @endif
    @endif

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

    $('#users_id1').select2(); 
    //====================================================================//
    $(document).on('click', '#addUsers', function(event) { 
        var childElementCount = Math.random(parseInt($('.box-receiver')[0].childElementCount));  
        childElementCount=childElementCount.toString();
        childElementCount = childElementCount.split(".")[1]; 
        var html=""; 
        html+='<div class="d-flex justify-content-center" id="list-receiver-'+childElementCount+'" data-id="'+childElementCount+'">';
        html+='    <div class="card" style="border-bottom: 4px solid #64c5b1;"> ';
        html+='        <div class="card-header" style="background: #64c5b1;color: #FFF;">';
        html+='            <b> <i class="icon-paper-plane"></i> ผู้รับเอกสาร </b>';
        html+='            <div class="d-flex float-right">';
        html+='                <input type="hidden" name="receiver['+childElementCount+'][id_hdf]" id="id_hdf'+childElementCount+'" value="null">';
        html+='                <div class="custom-control custom-radio">';
        html+='                    <input type="radio" id="receiver_customRadio-'+childElementCount+'-1" name="receiver['+childElementCount+'][receiver_customRadio]" class="custom-control-input" value="1" checked>';
        html+='                    <label class="custom-control-label mr-2" for="receiver_customRadio-'+childElementCount+'-1">มีสิทธิ์การเซ็น</label>';
        html+='                </div>';
        html+='                <div class="custom-control custom-radio">';
        html+='                    <input type="radio" id="receiver_customRadio-'+childElementCount+'-2" name="receiver['+childElementCount+'][receiver_customRadio]" class="custom-control-input" value="2">';
        html+='                    <label class="custom-control-label mr-2" for="receiver_customRadio-'+childElementCount+'-2">ดูอย่างเดียว</label>';
        html+='                </div>';
        html+='               <button type="button" class="btn btn-xs waves-effect waves-light btn-danger" ';
        html+='                style="position: absolute; top: 0; right: 0;" id="remove_receiver" data-id="'+childElementCount+'"> ';
        html+='                    <i class="fas fa-times"></i> ';
        html+='                </button>';
        html+='            </div>';
        html+='        </div>';
        html+='        <div class="card-body" style="padding: 0.5rem;">';
        html+='            <div> ';
        html+='                <div class=" row">';
        html+='                   <label class="col-md-2 col-form-label text-right" for="users_id'+childElementCount+'">ชื่อ-นามสกุล</label>';
        html+='                    <div class="col-md-4">';
        html+='                        <select id="users_id'+childElementCount+'" name="receiver['+childElementCount+'][users_id]" class="form-control" data-toggle="select2" data-val="'+childElementCount+'">';
                                                html+=' <option value=""> ระบุผู้รับเอกสาร </option>';
                                            @if(isset($data['usersGet']))
                                                @foreach($data['usersGet'] as $row_users)
                                                 html+=' <option value="{{$row_users->id}}"> {{$row_users->name}} </option>';
                                                @endforeach 
                                            @endif
        html+='                        </select>  ';
        html+='                    </div>';
        html+='                    <label class="col-md-2 col-form-label text-right" for="users_email-'+childElementCount+'">อีเมล์</label>';
        html+='                    <div class="col-md-4">';
        html+='                        <input type="text" id="users_email-'+childElementCount+'" name="receiver['+childElementCount+'][users_email]"  class="form-control form-control-sm" value="">  ';
        html+='                    </div>';
        html+='                </div>';
        html+='                <div class=" row">';
        html+='                            <label class="col-md-2 col-form-label text-right" for="users_id1"> เลือกคำนำหน้า </label>';
        html+='                            <div class="col-md-4"> ';
        html+='                                <select class="form-control form-control-sm" name="receiver['+childElementCount+'][signing_prefix]">';
        html+='                                   <option selected value="1">ลงชื่อเพื่อทราบ</option> '; 
        html+='                                    <option value="2">ลงชื่อเพื่ออนุมัติ</option> ';
        html+='                                </select>';
        html+='                            </div> ';
        html+='                    <label class="col-md-2 col-form-label text-right" for="users_position-'+childElementCount+'">ตำแหน่ง</label>';
        html+='                    <div class="col-md-4">';
        html+='                        <input type="text" id="users_position-'+childElementCount+'" name="receiver['+childElementCount+'][users_position]"  class="form-control form-control-sm" value="">  ';
        html+='                    </div>';
        html+='                     <div class="offset-md-2 col-md-10"> <span style="font-size: 10px; color: #f44336;"> <i class="mdi mdi-alert-circle"></i>  โปรดเลือกคำนำหน้า การลงลายเซ็น ลงชื่อเพื่อทราบ หรือ ลงชื่อเพื่ออนุมัติ  </span> </div>';
        html+='                 </div>';
        html+='            </div>'; 
        html+='        </div>';
        html+='    </div>';
        html+='</div>'; 
        $( ".box-receiver" ).append(html); 
        select2_app();
    });

    function select2_app(){ 
        var length = $('.box-receiver')[0].children.length;
        for(var i=0; i<=(length-1); i++){
            var id = $('.box-receiver')[0].children[i].dataset.id;
            if(id!=1){ 
                $('#users_id'+id).select2();
            } 
        }
    } 
    $(document).on('click', '#remove_receiver', function(event) {  
        var id=$(this)[0].dataset.id;
        if (confirm('ยืนยันการลบ หรือไม?')) {
            $('#list-receiver-'+id).remove();
        } 
    });
 
    $(document).on('click', 'input[type="checkbox"]', function(event) {  
        var id = $(this)[0].value;  
        if($(this)[0].checked==true){
            $( "#password_document-"+id).prop( "disabled", false );
        } else {
            $( "#password_document-"+id).val('');
            $( "#password_document-"+id).prop( "disabled", true  );
        } 
    });
 
    $(document).on('change', 'select', function(event) {   
        var id=$(this).val(); 
        var dataset = $(this)[0].dataset.val;
        $.post("{{ route('userGet.post') }}", {
            _token: "{{ csrf_token() }}", 
            users_id: id, 
        })
        .done(function(data, status, error){  
            var val="";
            if(error.status==200){ 
                if(data.sender_email==null){
                    val=data.email;
                }else{
                    val=data.sender_email;
                }
                $('#users_email-'+dataset).val(val);
                $('#users_position-'+dataset).val(data.position);
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        }); 
    });
</script>   
@endsection