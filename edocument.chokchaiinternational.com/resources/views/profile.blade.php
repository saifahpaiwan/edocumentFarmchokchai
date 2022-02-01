@extends('layouts.app')
 
@section('style')    
<link href="{{ asset('css/css.main/style-1.css') }}" rel="stylesheet" type="text/css" />  
<style>
    #signatureArea {
        border: 1px dashed #333;
    }
    .dropzone {
        min-height: 150px;
        border: 2px dashed rgba(0,0,0,0.3);
        background: white;
        padding: 0;
    } 
    .box_signature{
        border: 1px solid #000;
        color: #000;
        padding: 1.5rem 0.5rem;
        text-align: center;
        background: #FFF;
        min-height: 195px; 
    }
    .nav-pills .nav-link {
        background: #f5f5f5;
        margin: 0 0.2rem;
        border-radius: .25rem;
    }
    .box-001 {
        background: #fcfcfc;
        padding: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #ddd;
    }
    .card {
        min-width: 670px;
    }
    .titleright {text-align: right;}
     
    @media (max-width: 767.98px){ 
        .titleright {text-align: left;}
        .card {
            min-width: auto;
        } 
    } 
</style>
@endsection

@section('content')    
        <div class="row mt-3">
            <div class="col-md-12">   
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center"> 
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="text-center box-timeline ml-3 mr-3"> 
                                        <img src="{{ asset('images/icons/administrator.png') }}" alt="" width="55">
                                        <div class="">  จัดการข้อมูลส่วนตัว  </div>    
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <div class="card">
                                <div class="card-header"> 
                                    <form method="POST" action="{{ route('logout_getpassword') }}">
                                        @csrf
                                        <b> <i class="fe-user"></i>  จัดการข้อมูลส่วนตัว  </b> 
                                        <input type="hidden" name="email_getpassword" value="{{$data['users']->email}}"> 
                                        <button type="submit" class="btn btn-sm btn-secondary waves-effect waves-light float-right">
                                            <i class="fe-edit"></i>
                                            <span>แก้ไขรหัสผ่าน</span> 
                                        </button>
                                    </form> 
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('updateUsers.post') }}" method="post" enctype="multipart/form-data" id="formActionUsers">
                                    @csrf
                                    <input type="hidden" name="hdf_typeSignature" id="hdf_typeSignature" value="1">     
                                    <input type="hidden" name="signatureData_image" id="signatureData_image" value="">   
                                        <blockquote class="card-bodyquote">   
                                            <div class="form-group row">
                                                @if(session("success"))
                                                    <div class="col-md-12"> 
                                                        <div class="alert alert-success" role="alert">
                                                            <i class="icon-check"></i> {{session("success")}}
                                                        </div>
                                                    </div> 
                                                @endif 
                                                <label class="col-md-2 col-form-label titleright" for="name">ชื่อ-นามสกุล</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="name"  name="name" class="form-control" value="{{$data['users']->name}}">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <label class="col-md-2 col-form-label titleright" for="email">อีเมล</label>
                                                <div class="col-md-4">
                                                    <input type="email" id="email" name="email" class="form-control" value="{{$data['users']->sender_email}}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>  
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label titleright" for="position">ตำแหน่ง</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="position" name="position" class="form-control" value="{{$data['users']->position}}">
                                                    @error('position')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <label class="col-md-2 col-form-label titleright" for="phone">เบอร์ติดต่อ</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="phone" name="phone" class="form-control" value="{{$data['users']->phone}}">
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>  

                                            <div class="row">
                                                <div class="col-md-12"> 
                                                    @error('output')
                                                        <div class="alert alert-icon alert-danger text-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }}
                                                        </div> 
                                                    @enderror 
                                                    @error('file_upload')
                                                        <div class="alert alert-icon alert-danger text-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <i class="mdi mdi-block-helper mr-2"></i>
                                                            <strong>ผิดผลาด!</strong> {{ $message }}
                                                        </div> 
                                                    @enderror 
                                                    
                                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                                        <li class="nav-item">
                                                            <a href="#bnt-status-1" data-toggle="tab" aria-expanded="false" data-id="1" class="nav-link active"> 
                                                                <span> ลายเซ็นของคุณ </span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="#bnt-status-2" data-toggle="tab" aria-expanded="false" data-id="2" class="nav-link"> 
                                                                <span>ลายเซ็นอิเล็กทรอนิกส์</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="#bnt-status-3" data-toggle="tab" aria-expanded="true" data-id="3" class="nav-link">
                                                                <span>อัพเดทรูปลายเซ็น</span>
                                                            </a>
                                                        </li> 
                                                    </ul> 
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="bnt-status-1">
                                                            @if(!empty($data['users']->signature))
                                                            <div class="box-001 text-center">  
                                                                <div style="padding: 0.5rem; border-radius: 0.25rem;"> 
                                                                    <img src="{{ asset('images/signature/create_sing_user/'.$data['users']->signature) }}" alt="" width="280" height="100"> 
                                                                </div> 
                                                                <div style="font-weight: 300;"> <b>ชื่อ-นามสกุล</b> {{$data['users']->name}}  </div> 
                                                                <div style="font-weight: 300;"> <b>ตำแหน่ง</b> {{$data['users']->position}} </div>
                                                                <div style="font-weight: 300;"> <b>อัพเดทล่าสุด</b> {{Carbon\Carbon::parse($data['users']->updated_at)->diffForHumans()}} </div>
                                                            </div> 
                                                            @else
                                                                <div class="box-001 text-center">  
                                                                    <div> ยังไม่มีรูปลายเซ็นของคุณ กรุณาอัพโหลดลายเซ็น! </div>
                                                                </div> 
                                                            @endif
                                                        </div>
                                                        <div class="tab-pane" id="bnt-status-2">
                                                            <div id="signatureArea" class="mb-1">
                                                                <div style="height:auto;">
                                                                    <canvas id="signaturePad"></canvas>
                                                                    <input type="hidden" name="output" class="output">
                                                                </div>
                                                            </div>  
                                                            <button type="button" class="btn btn-sm btn-secondary waves-effect width-md" id="clearsignature"> รีเซ็ตลายเซ็น </button> 
                                                        </div>
                                                        <div class="tab-pane" id="bnt-status-3">
                                                            <div class="text-dark">  
                                                                <label for="file_upload" class="custom-file_upload">  
                                                                    <div class="file_ui d-flex pb-1 justify-content-center img-file-upload"> 
                                                                        <img src="{{ asset('images/signature-img.png') }}" alt="" width="50">
                                                                    </div>
                                                                    <h4 class="mt-2">อัพโหลดลายเซ็น</h4>
                                                                    <span class="text-muted">ขนาดรูปไม่ควรเกิน 1 MB เฉพาะไฟล์ .jpg และ .png เท่านั้น </span> </span> 
                                                                </label>
                                                                <input id="file_upload" name="file_upload[]" type="file"/>   
                                                            </div>  
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div> 
                                        </blockquote> 

                                        <div class="row mt-2" style="background: #edeff1; padding: 0.5rem; border-radius: 0.25rem;">
                                            <div class="col-md-12 text-center"> 
                                                <button type="submit" class="btn btn-dark waves-effect waves-light" id="button_001"> 
                                                    <i class="icon-note"></i> อัพเดทข้อมูล
                                                </button>
                                                <button type="button" class="btn btn-dark waves-effect waves-light" id="button_002"> 
                                                    <i class="icon-note"></i> อัพเดทข้อมูล
                                                </button> 
                                            </div> 
                                        </div> 
                                    </form>
                                </div> 
                            </div>  
                        </div> 
                    </div> 
                </div>  
            </div>
        <div>  
@endsection 
@section('script')  
<script src="{{ asset('js/html2canvas.js') }}"></script>  
<script src="{{ asset('js/jquery.signaturepad.js') }}"></script>   
<script> 
    setTimeout(function(){ $('.alert-success').fadeOut(); }, 2000);  

    $('#button_002').hide();
    $(document).on('click', '[data-toggle=tab]', function(event) {  
        var id=$(this)[0].dataset.id; 
        if(id==2){
            $('#button_001').hide();
            $('#button_002').show();
        }else{
            $('#button_001').show();
            $('#button_002').hide();
        } 
        $('#hdf_typeSignature').val(id); 
    });  
 
    $(document).on('change', '#file_upload', function(event) {  
        var url="{{ asset('images/signature-img.png') }}";
        var html='<img src="'+url+'" alt="" width="50">'; 
        var Images = $('#file_upload'); 
        if ( Images[0].files[0] ){ 
            url=window.URL.createObjectURL(Images[0].files[0]);
            html='<img src="'+url+'" alt="" width="120" width="80">'; 
        }
        $('.img-file-upload').html(html);
    });

    (function(window) {  
        var height=200;
        var width=615;
        if(window.innerWidth<=450){
            height=200;
            width=310;
        }
        var $canvas,
        onResize = function(event) {
          $canvas.attr({
            height: height,
            width: width
          });
        }; 
        $(document).ready(function() {
            $canvas = $('canvas');
            // window.addEventListener('orientationchange', onResize, false);
            // window.addEventListener('resize', onResize, false);
            onResize();  
            $('#signatureArea').signaturePad({
                drawOnly: true,
                defaultAction: 'drawIt',
                validateFields: false,
                lineWidth: 0,  
                output:'.output',
                sigNav: null,
                name: null,
                typed: null,
                clear: 'input[type=reset]',
                typeIt: null,
                drawIt: null,
                typeItDesc: null,
                drawItDesc: null,  
                penColour: '#0254a8', 
            });
        });
 
        $('#clearsignature').on('click', function(){
            $('#signatureArea').signaturePad().clearCanvas();
        });

        $("#button_002").click(function(e){ 
            html2canvas([document.getElementById('signaturePad')], {
                onrendered: function (canvas) {
                    var canvas_img_data = canvas.toDataURL('image/png');
                    var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, ""); 
                    $('#signatureData_image').val(img_data);    
                    $( "#formActionUsers" ).submit();
                    // document.getElementById("").submit.click(); 
                }
            }); 
        }); 
    }(this)); 
</script>   
@endsection