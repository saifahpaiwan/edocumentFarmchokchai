@extends('layouts.app')
 
@section('style')    
<link href="{{ asset('css/css.main/style-1.css') }}" rel="stylesheet" type="text/css" />  
<link href="{{ asset('/libs/spinkit/spinkit.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .blink_me { 
        animation: blinker 1s linear infinite; 
    }
    @keyframes blinker {  
        50% { opacity: 0.1; }
    }  
</style>
@endsection

@section('content')    
        <div class="row mt-3">
            <div class="col-md-12">  
                <form action="{{ route('upfileDocument.post') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row"> 
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
                                            <img src="{{ asset('images/icons/sign.png') }}" alt="" width="50" style="filter: grayscale(1);">
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
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <div class="card">
                                    <div class="card-header">
                                        <b> <i class="fe-file-plus"></i> สร้างเอกสาร </b> 
                                        <div class="float-right"> ประจำวันที่ <?php echo date('Y/m/d'); ?> </div>
                                    </div>
                                    <div class="card-body">
                                        <blockquote class="card-bodyquote">
                                            <div class="mb-2"> 
                                                อัพโหลดเอกสารขนาดรูปไม่ควรเกิน 2 MB เฉพาะไฟล์ .PDF เท่านั้น เลือกรูปแบบการเซ็นบุคคลเดียวหรือหลายคน.   
                                                <button type="button" class="btn btn-dark waves-effect width-md waves-light float-right"
                                                data-toggle="modal" data-target=".modal-genCode">
                                                    <i class="icon-notebook"></i> ออกเลขที่เอกสาร
                                                </button> 
                                            </div>   
                                            @if(session("error"))
                                                <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <strong>ผิดผลาด !</strong> {{session("error")}} 
                                                </div> 
                                            @endif  
                                            <div class="form-group row mt-3">
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
                                                    value="{{ old('topic_email') }}">
                                                    @error('topic_email') 
                                                        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
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
                                                    <textarea class="form-control @error('detail_email') is-invalid @enderror" rows="3" id="detail_email" name="detail_email" required autocomplete="detail_email" autofocus>{{ old('detail_email') }}</textarea> 
                                                    @error('detail_email') 
                                                        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div> 

                                            <!-- <div class="form-group row">
                                                <label class="col-md-3 col-form-label text-right" for="select_type"> ประเภทเอกสาร </label>
                                                <div class="col-md-9">
                                                    <select class="custom-select mb-1" name="select_type" id="select_type" required>
                                                        <option value=""> โปรดระบุข้อมูล </option> 
                                                        <option value="1"> เอกสารประเภท PR </option> 
                                                        <option value="2"> เอกสารประเภทการขออนุมัติ </option> 
                                                    </select>   
                                                    @error('select_type') 
                                                        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div>
                                                    @enderror
                                                </div> 
                                            </div>  -->

                                            <div class="form-group row"> 
                                                <label class="col-md-3 col-form-label text-right" for="number"> เลขที่เอกสาร </label>
                                                <div class="col-md-9">
                                                    <input type="text" id="number" name="number" class="form-control" value="{{ old('number') }}" required autocomplete="number" autofocus placeholder="กรุณาระบุเลขที่เอกสาร"
                                                    onblur="checkcode();"> 
                                                    @error('number') 
                                                        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                        <i class="mdi mdi-block-helper mr-2"></i>
                                                        <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div>
                                                    @enderror
                                                    <div class="sp_parsley"> </div>
                                                </div> 
                                            </div>  

                                            <div class="row">  
                                                <div class="offset-md-3 col-md-9"> 
                                                    <div class="text-dark">  
                                                        <label for="file_upload" class="custom-file_upload">  
                                                            <div class="file_ui d-flex pb-1 justify-content-center"> </div>
                                                            <h4 class="mt-2">อัพโหลดไฟล์รายละเอียดเอกสาร</h4>
                                                            <span class="text-muted">ไฟล์รายละเอียดเอกสารที่เกียวกับการประกอบการอนุมัติเอกสาร <br>ไฟล์ .PDF เท่านั้น <small class="text-danger">*บังคับอัพโหลดไฟล์ </small></span> </span> 
                                                        </label>
                                                        <input id="file_upload" name="file_upload[]" type="file"/>   
                                                    </div> 
                                                    @error('file_upload')
                                                        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }} 
                                                        </div> 
                                                    @enderror  
                                                </div> 
                                                <div class="offset-md-3 col-md-9">  
                                                <span class="text-muted is-img-main">ขนาดไฟล์ไม่ควรเกิน 30MB เฉพาะไฟล์ .PDF เท่านั้น</span> 
                                                    <div class="mt-1 d-flex">
                                                        <div class="custom-control checkbox-dark mr-1">
                                                            <input type="radio" id="documentType1" name="documentType" class="custom-control-input" checked value="1">
                                                            <label class="custom-control-label" for="documentType1"> กรณีผู้เซ็นคนเดียว <i class="mdi mdi-account"></i></label>
                                                        </div>
                                                        <div class="custom-control checkbox-dark ml-1">
                                                            <input type="radio" id="documentType2" name="documentType" class="custom-control-input" value="2">
                                                            <label class="custom-control-label" for="documentType2"> กรณีผู้เซ็นหลายคน <i class="mdi mdi-account-group"></i></label>
                                                        </div>
                                                        <div class="flex-grow-1 text-right">  
                                                            <button type="submit" class="btn btn-dark waves-effect waves-light save">
                                                                <span class="save_text">ขั้นตอนถัดไป <i class="icon-arrow-right-circle"></i>  </span> 
                                                            </button>
                                                        </div>
                                                    </div>
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
  
        <div class="modal fade modal-genCode" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title mt-0"><i class="icon-notebook"></i> ออกเลขที่เอกสาร </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row text-center">   
                            <div class="col-md-12">  
                                <select class="custom-select mb-1" name="departmentCode_genCode" id="departmentCode_genCode" autocomplete="departmentCode_genCode" required autofocus>
                                    <option value=""> โปรดระบุข้อมูล </option>
                                    @if(isset($data['department_code']))
                                        @foreach($data['department_code'] as $row)
                                        <option value="{{$row->id}}"> เลขที่ {{$row->name}}</option> 
                                        @endforeach
                                    @endif
                                </select>   
                                @error('departmentCode_genCode') 
                                    <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <i class="mdi mdi-block-helper mr-2"></i>
                                        <strong>ผิดผลาด!</strong> {{ $message }} 
                                    </div>
                                @enderror
                            </div> 
                            <div class="col-md-12">  
                                <button type="button" class="btn btn-purple  btn-rounded width-md waves-effect waves-light btn-lg mb-2 mt-1"
                                id="btn_genCode">
                                    ออกเลขที่เอกสาร
                                </button>    
                            </div> 
                            <div class="col-md-12">
                                <div class="text-center code_gen_loadeing"> 
                                    <div class="sk-circle" style="margin: 1rem auto;">
                                        <div class="sk-circle1 sk-child"></div>
                                        <div class="sk-circle2 sk-child"></div>
                                        <div class="sk-circle3 sk-child"></div>
                                        <div class="sk-circle4 sk-child"></div>
                                        <div class="sk-circle5 sk-child"></div>
                                        <div class="sk-circle6 sk-child"></div>
                                        <div class="sk-circle7 sk-child"></div>
                                        <div class="sk-circle8 sk-child"></div>
                                        <div class="sk-circle9 sk-child"></div>
                                        <div class="sk-circle10 sk-child"></div>
                                        <div class="sk-circle11 sk-child"></div>
                                        <div class="sk-circle12 sk-child"></div>
                                    </div>
                                    <div> กำลังออกเลขที่เอกสารโปรดรอสักครู่... </div>
                                </div>
                                <div class="h1 code_gen_success"
                                style="background: #333;
                                color: #fff;
                                border-radius: 0.25rem;
                                padding: 0.5rem 0;"> - </div>
                            </div>   
                        </div>
                        <div class="row mt-2 tbl_genCode">   
                            <div class="col-md-12">
                                <div style="
                                    background: #ddd;
                                    color: #333;
                                    padding: 0.2rem;
                                    border-radius: 0.25rem;"> 
                                <i class="icon-notebook"></i> รายการเลขที่เอกสาร </div>
                                <div class="table-responsive"> 
                                    <table class="table mb-0" id="tbl-document">
                                        <thead>
                                            <tr>
                                                <th width="10%">เลขที่</th> 
                                                <th width="20%">ผู้สร้าง</th>
                                                <th width="5%">สถานะ</th>
                                                <th width="5%"> เมื่อ </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                </div>
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
<script src="{{ asset('libs/select2/select2.min.js') }}"></script>
<script> 
    $( "form" ).submit(function( event ) {  
        $( '.save' ).prop( "disabled", true );
        $( '.save_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');  
    });

    $(document).on('change', '#file_upload', function(event) {  
        $( ".custom-file_upload" ).removeClass( "blink_me" ); 
        $(".custom-file_upload").css({"border": "2px dashed #ddd"});
        $('.is-img-main').html('ขนาดไฟล์ไม่ควรเกิน 30MB เฉพาะไฟล์ .PDF เท่านั้น'); 
        var Images = $('#file_upload'); 
        var length = Images[0].files.length;
        for(var i=0; i<=(length-1); i++){   
            if(Images[0].files[i].type!="application/pdf"){
                $('.box-div-filename').html("");
                $( ".custom-file_upload" ).addClass( "blink_me" ); 
                $(".custom-file_upload").css({"border": "2px dashed #f44336"});
                $('.is-img-main').html('<b class="text-danger"><i class="mdi mdi-alert-circle"></i> กรุณากำหนดไฟล์ให้เป็น .PDF </b>');
                $('#file_upload').val(""); 
            }
            checkimg(Images[0].files[i].size, Images[0].files[i], 2);
        } 
    });
    function OnUploadCheck()
	{
		
		file = document.form1.filUpload.value;
		ext = file.split('.').pop().toLowerCase();
		if(parseInt(extall.indexOf(ext)) < 0)
		{
			alert('Extension support : ' + extall);
			return false;
		}
		return true;
	}

    function checkimg(imgsize, imgnew, type){
        var sizeKB = Math.round(imgsize / 1024); 
        if(sizeKB>30720){  
            $( ".custom-file_upload" ).addClass( "blink_me" ); 
            $(".custom-file_upload").css({"border": "2px dashed #f44336"});
            $('.is-img-main').html('<b class="text-danger"><i class="mdi mdi-alert-circle"></i> กรุณากำหนดขนาดไฟล์ .PDF ไม่เกิน 30MB </b>');
            $('#file_upload').val(""); 
            return false;
        } 
    }
    
    $('#departmentCode_genCode').select2();
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
 
    // $(document).on('change', '#select_type', function(event) {
    //     var val = $(this).val(); 
    //     var html ="";
    //     if(val==2){  
    //         html+='<label class="col-md-3 col-form-label text-right" for="departmentCode"> ฝ่าย/แผนกของเอกสาร </label>';
    //         html+='<div class="col-md-5">';
    //         html+='<select class="custom-select mb-1" name="departmentCode" id="departmentCode" autocomplete="departmentCode" required autofocus>';
    //         html+='<option value=""> โปรดระบุข้อมูล </option>';
    //                     @if(isset($data['department_code']))
    //                         @foreach($data['department_code'] as $row)
    //                         html+='<option value="{{$row->name}}"> เลขที่ {{$row->name}}</option> ';
    //                         @endforeach
    //                     @endif
    //                     html+='</select>   ';
    //                 @error('departmentCode') 
    //                 html+='<div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">';
    //                 html+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    //                 html+='<span aria-hidden="true">×</span>';
    //                 html+='</button>';
    //                 html+='<i class="mdi mdi-block-helper mr-2"></i>';
    //                 html+='<strong>ผิดผลาด!</strong> {{ $message }} ';
    //                 html+='</div>';
    //                 @enderror
    //                 html+='</div>';
    //                 html+='<label class="col-md-2 col-form-label text-right" for="number"> เลขที่เอกสาร </label>';
    //                 html+='<div class="col-md-2"> ';
    //                 html+='<input type="number" id="number" name="number" class="form-control" value="{{ old('number') }}" required autocomplete="number" autofocus>'; 
    //                 html+='</div> ';
    //     }else if(val==1){  
    //         html+='<label class="col-md-3 col-form-label text-right" for="detail_email"> เลขที่เอกสาร </label>';
    //         html+='<div class="col-md-9">';
    //         html+='<input type="text" id="number" name="number" class="form-control" value="{{ old('number') }}" required autocomplete="number" autofocus placeholder="กรุณาระบุเลขที่เอกสาร"> ';
    //                 @error('departmentCode') 
    //                 html+='<div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">';
    //                 html+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    //                 html+='<span aria-hidden="true">×</span>';
    //                 html+='</button>';
    //                 html+='<i class="mdi mdi-block-helper mr-2"></i>';
    //                 html+='<strong>ผิดผลาด!</strong> {{ $message }} ';
    //                 html+='</div>';
    //                 @enderror
    //                 html+='</div> ';
    //     }

    //     $('.Code_class').html(html);
    // });
     
    $(document).on('change', '#departmentCode', function(event) {
        var code = $(this).val();  
        $.post("{{ route('run_numberCode.post') }}", {
            _token: "{{ csrf_token() }}", 
            code: code,  
        })
        .done(function(data, status, error){   
            if(error.status==200){  
                $('#number').val(data);
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        });
    });

     
    $(document).on('click', '#btn_genCode', function(event) { 
        var val = $('#departmentCode_genCode').val();
        if(val!=""){
            Swal.fire({
                title: 'ยืนยันการออกเลขที่เอกสาร หรือไม่?',
                text: "เมื่อออกเลขที่เอกสารแล้ว สามารถนำเลขที่ไปสร้างเอกสารได้เลย !",
                type:"question",
                showCancelButton:!0,
                confirmButtonText:"Yes",
                cancelButtonText:"No",
                confirmButtonClass:"btn btn-success mt-2",
                cancelButtonClass:"btn btn-danger ml-2 mt-2",
                buttonsStyling:!1
            }).then((result) => { 
                if (result.value) {  
                    $('.code_gen_loadeing').show();
                    setTimeout(function(){
                        $.post("{{ route('actionFormGenCode.post') }}", {
                            _token: "{{ csrf_token() }}", 
                            val: val,  
                        })
                        .done(function(data, status, error){   
                            if(error.status==200){  
                                $('#tbl-document').DataTable().destroy();
                                datatable(val);
                                $('.code_gen_success').text(data);
                                $('.code_gen_loadeing').hide();
                                $('.code_gen_success').show();
                            }
                        })
                        .fail(function(xhr, status, error) { 
                            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
                        });    
                    }, 2000);   
                }
            });
        } else {
            Swal.fire({
                title: 'โปรดระบุข้อมูล !',
                text: "โปรดระบุข้อมูลฝ่าย/แผนกของเอกสาร",
                type:"warning", 
                confirmButtonText:"OK", 
                confirmButtonClass:"btn btn-lg btn-info mt-2", 
                buttonsStyling:!1
            });
        } 
    });
     
    $('.code_gen_loadeing').hide();
    $('.code_gen_success').hide();
    $('.tbl_genCode').hide();
    $(document).on('change', '#departmentCode_genCode', function(event) {
        var val = $('#departmentCode_genCode').val();
        if(val!=""){
            $('#tbl-document').DataTable().destroy();
            datatable(val);
            $('.tbl_genCode').show();
        } else {
            $('.tbl_genCode').hide();
        }
    });

    
    function datatable(id){  
        var table = $('#tbl-document').DataTable({
            "processing":false,  
            "serverSide":false,  
            "searching": false,
            "lengthChange": true, 
            ajax: {
                url:"{{ route('datatableGen_code') }}", 
                data:{ 
                    id: id, 
                }
            },  
            columns: [ 
                {data: 'code', name: 'code'},  
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

    function checkcode()
    {
        var code=$('#number').val();
        $('[type=submit]').prop( "disabled", false );
        $('.sp_parsley').html("");
        $('#number').removeClass('parsley-error');
        $.post("{{ route('checkcode.post') }}", {
            _token: "{{ csrf_token() }}", 
            code: code,  
        })
        .done(function(data, status, error){   
            if(error.status==200){  
                console.log(data);
                if(data=="Y"){
                    var html='<ul class="parsley-errors-list filled" id="parsley-id-18"><li class="parsley-type"> เลขที่เอกสารนี้ถูกใช้แล้ว </li></ul>';
                    $('[type=submit]').prop( "disabled", true );
                    $('.sp_parsley').html(html);
                    $('#number').addClass('parsley-error');
                } else if(data=="N"){
                    var html='';
                    $('[type=submit]').prop( "disabled", false );
                    $('.sp_parsley').html("");
                    $('#number').removeClass('parsley-error');
                }
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        });    
    }
</script>   
@endsection