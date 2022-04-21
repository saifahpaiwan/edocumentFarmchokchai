@extends('layouts.app_io')
 
@section('style')       
<link href="{{ asset('libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/libs/spinkit/spinkit.css') }}" rel="stylesheet" type="text/css" >
<style>
    #signatureArea {
        border: 1px dashed #333;
    }
    .tilte-receiver {
        background: #333;
        color: #FFF;
        padding: 0.5rem; 
        font-weight: 500;
    }
    .nav-pills .nav-link {
        background: #f5f5f5;
        margin: 0 0.2rem;
        border-radius: .25rem;
    }
    .dropzone {
        min-height: 150px;
        border: 2px dashed rgba(0,0,0,0.3);
        background: white;
        padding: 0;
    } 
    .badge {
        font-size: 13px;
    }
    .box_signature{
        border: 1px solid #000;
        color: #000;
        padding: 0.5rem 0.5rem;
        text-align: center;
        background: #FFF;
        min-height: 170px;
    }
    .box_footer_signature {
        padding: 5px; 
        color: #000;
        border-top: 0;
        border-bottom: 1px solid #000;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    } 
    .box-dow {
        background: #d6f2ff;
        padding: 0.5rem;
        border-radius: 0.25rem;
    }
    .custom-control {
        position: relative;
        display: block;
        min-height: 1.2rem;
        padding-top: 1rem; 
        padding-left: 2.5rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }

    .custom-file_upload {
        border: 1px dashed #000;
        display: inline-block;
        padding: 0.5rem;
        min-height: 138px;
        cursor: pointer;
        width: 100%;
        text-align: center;
        color: #fff;
        border-radius: .25rem;
    }
    input[type="file"] {
        display: none;
    }

    button, input {
        overflow: visible;
    }
    button, input, optgroup, select, textarea {
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
    }
    *, ::after, ::before {
        box-sizing: border-box;
    }

    .box-singviwe {
        background: #add0ff;
        color: #004eb4;
        font-weight: 400;
        border-bottom: 2px solid #4489e4;
        border-radius: 0.25rem; 
    } 
    .msg-1{
        background: #ddd;
        color: #000;
        padding: 0.5rem;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    .msg-2{
        border: 1px solid #ddd;
        padding: 0.2rem;
    }
    .blink_me {
        color: #333;
        animation: blinker 1s linear infinite;
    }
    .box-close-dd {
        background: #ffefef;
        border: 1px solid #f44336;
        border-radius: 0.25rem;
        color: #000;
    }
   
    @keyframes blinker {  
        50% { opacity: 0; }
    }  
     
</style>
@endsection

@section('content') 
    @if(isset($data['documentGet']))
        @if(count($data['documentGet'])>0)
            @foreach($data['documentGet'] as $row) 
                <div class="row mt-3"> 
                    <div class="col-md-12">
                        <h4 class=""> 
                            <i class="mdi mdi-file-document-box-search-outline"></i> รายละเอียดเอกสาร 
                        </h4>
                    </div>  
                </div>
                <div class="row mt-2">  
                    <div class="col-md-8">  
                        @if(isset($data['fileups'])) 
                            @foreach($data['fileups'] as $file_Row) 
                                <div class="d-block d-sm-none"> 
                                    <a href="{{ asset('images/document-file/pdf_file/'.$file_Row->filename) }}" download style="color: #4253ce;">
                                        <div class="text-center"> 
                                            <div class="card-box widget-box-three" style="border: 1px solid #4253ce; background: #f1f3ff;">
                                                <img style="width: 30%;" src="{{ asset('images/icons/download-pdf.png') }}" title="download-pdf.png">
                                                <div class="mt-1 text-uppercase font-weight-medium">ดาวน์โหลดเอกสาร</div>
                                                <span> ดาวน์โหลดเอกสารเพื่อตรวจสอบ </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>  
                                <iframe src="{{ asset('images/document-file/pdf_file/'.$file_Row->filename) }}" 
                                title="{{ $file_Row->filename }}" height="100%" width="100%" style="border: none;" class="d-none d-sm-block"> </iframe>  
                            @endforeach 
                        @endif 
                    </div>
                    <div class="col-md-4"> 
                        <div class="card">
                            <div class="card-header" style="background: #333; padding: 1.2rem; border-radius: 0; color: #FFF;">
                                <div class="row"> 
                                    <div class="col-6 col-md-6">
                                        <b>เลขที่ {{$row['document_code']}} </b>
                                    </div>
                                    <div class="col-6 col-md-6 text-right">
                                        <b>วันที่  <?php echo date("d/m/Y", strtotime($row['created_at'])); ?></b>
                                    </div>
                                </div> 
                            </div>
                            <div class="card-body">  
                                <div class="row">   
                                    <div class="col-md-12 pb-1"> 
                                        @if($row['document_status']==1)
                                            <span class="badge badge-warning"> 
                                                <i class="mdi mdi-account-clock-outline"></i> รอดำเนินการ 
                                            </span>
                                        @elseif($row['document_status']==2)
                                            <span class="badge badge-success"> 
                                                <i class="icon-check"></i>  เสร็จสมบูรณ์ 
                                            </span>
                                        @elseif($row['document_status']==3)
                                            <span class="badge badge-dark">
                                                <i class="icon-note"></i>  ส่งกลับ/แก้ไข 
                                            </span>
                                        @elseif($row['document_status']==4)
                                            <span class="badge badge-danger"> 
                                                <i class="icon-close"></i> ไม่อนุมัติเอกสาร	 
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-0"> ผู้ส่งเอกสาร </label>
                                        <div> {{$row['sender_name']}} </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-0"> อีเมล </label>
                                        <div> {{$row['sender_email']}} </div>  
                                    </div>
                                </div> 
                                @if(isset($row['UserSignature']))  
                                    @foreach($row['UserSignature'] as $usersRow)
                                        @if($usersRow['UserReceiversid']==$data['users']->id)
                                            <div class="row"> 
                                                <div class="col-md-6">
                                                    <label class="mb-0 mt-1"> ถึง </label>
                                                    <div> {{ $usersRow['ReceiversName'] }} </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="mb-0 mt-1"> อีเมล </label>
                                                    <div> {{ $usersRow['ReceiversEmail'] }} </div>
                                                </div>
                                            </div>   
                                        @endif
                                    @endforeach
                                @endif 
                            </div> 
                        </div>

                        <div class="row"> 
                            <div class="col-md-12 text-center">
                                <div class="mb-3" style="padding: 1.5rem; padding: 1.5rem; background: #333; border-radius: 0.25rem;box-shadow: 0 0 35px 0 rgb(154 161 171 / 15%);">  
                                    @if($row['document_status']==1 || $row['document_status']==2)
                                        @if(isset($row['UserSignature'])) 
                                            @foreach($row['UserSignature'] as $usersRow)
                                                @if($usersRow['UserReceiversid']==$data['users']->id) 
                                                    @if($usersRow['signing_rights']==1)
                                                        @if($usersRow['status_approve']==1) 
                                                        <div class="d-flex justify-content-center">
                                                            <form action="{{ route('actionFormapprove.post') }}" method="post" enctype="multipart/form-data" class="ml-1 from1">  
                                                            @csrf
                                                                <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
                                                                <input type="hidden" name="hdf_typeSignature" id="hdf_typeSignature" value="1">     
                                                                <input type="hidden" name="signatureData_image" id="signatureData_image" value="">  
                                                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked value="Y">
                                                                <input type="hidden" name="redirect_hid" id="redirect_hid" value="viwe_io">  
                                                                <div class="mt-1 mb-2">  
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light btn-lg" id="submit"
                                                                    style="padding: 1.5rem; background: #32c861;"> 
                                                                        <span class="save_text">อนุมัติเอกสาร</span>    
                                                                    </button> 
                                                                </div>
                                                            </form> 
                                                            <form action="{{ route('actionFormCloseDocument.post') }}" method="post" enctype="multipart/form-data" class="ml-1 from2">  
                                                            @csrf
                                                                <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">    
                                                                <input type="hidden" name="note" id="note" value="ไม่อนุมัติเอกสาร">  
                                                                <input type="hidden" name="redirect_hid" id="redirect_hid" value="viwe_io">  
                                                                <div class="mt-1 mb-2">  
                                                                    <button type="submit" class="btn btn-danger waves-effect waves-light btn-lg" id="save_note"
                                                                    style="padding: 1.5rem; background: #ff4d4d;"> 
                                                                        <span class="save_note_text">ไม่อนุมัติเอกสาร</span>    
                                                                    </button> 
                                                                </div>
                                                            </form>  
                                                        </div>
                                                        @elseif($usersRow['status_approve']==2)
                                                            <div class="col-md-12 text-center"> 
                                                                <img src="{{ asset('images/icons/checked.png') }}" alt="" width="50">
                                                                <div class="mt-2 h4" style="color: #FFF;"> คุณได้อนุมัติเอกสารเรียบร้อยแล้ว </div> 
                                                                <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </div> 
                                                            </div> 
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif 
                                    @endif
                                </div> 
                            </div>
                        </div>    
                        @if($row['sender_id']==$data['users']->id)
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <?php $n=1; ?>
                                    @if(isset($row['UserSignature'])) 
                                        @foreach($row['UserSignature'] as $usersRow)
                                            @if($usersRow['signing_rights']==2) 
                                                <div class="text-left mb-2 p-1 box-singviwe">  
                                                    <div class=""> {{$n}}. ชื่อ-นามสกุล : {{$usersRow['ReceiversName']}}  
                                                        @if($usersRow['status_approve']==2)
                                                            <span class="badge badge-success float-right" style="font-size: 10px;">
                                                                <i class="icon-check"></i> อ่านแล้ว
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning float-right" style="font-size: 10px;">
                                                                <i class="icon-question"></i> ยังไม่อ่าน
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class=""> ตำแหน่ง : {{$usersRow['position']}} 
                                                        <span class="badge badge-blue float-right"><i class="icon-magnifier"></i> สิทธิ์การดูเอกสาร </span> 
                                                    </div> 
                                                </div> 
                                                <?php $n++; ?>
                                            @endif 
                                        @endforeach
                                    @endif 
                                </div> 
                            </div>  
                        @endif 
                        <div class="row">    
                            @if(isset($row['UserSignature'])) 
                                <?php 
                                    $count_ec=count($row['UserSignature']); 
                                    $text_ec=""; $num_ec=1;
                                ?> 
                                @foreach($row['UserSignature'] as $usersRow)
                                    @if($usersRow['signing_rights']==1)
                                        <div class="col-md-6"> 
                                            @if($row['sender_id']==$data['users']->id) 
                                                @if($usersRow['send_email']=="N")
                                                    <div class="text-right"> 
                                                        <button type="button" class="btn btn-block btn-secondary waves-effect waves-light btn-xs" style="border-radius: 0;"
                                                        data-usersid="{{ $usersRow['UserReceiversid'] }}" id="btn-sendemail"> 
                                                            <span class="class_sendemail{{$usersRow['UserReceiversid']}}"><i class="icon-cursor"></i> คลิกเพื่อส่งข้อมูล</span>
                                                        </button> 
                                                    </div>
                                                @elseif($usersRow['send_email']=="Y")
                                                    <div class="text-right"> 
                                                        <button type="button" class="btn btn-block btn-success waves-effect waves-light btn-xs" style="border-radius: 0;"> 
                                                            <i class="mdi mdi-email-check-outline"></i> ส่งข้อมูลสำเร็จ 
                                                            <span> เมื่อ {{Carbon\Carbon::parse($usersRow['send_email_date'])->diffForHumans()}} </span>
                                                        </button> 
                                                    </div>
                                                @endif 
                                            @endif 
                                            <div class="box_signature">  
                                                @if($usersRow['status_approve']==2)
                                                    @if($usersRow['signing_type']==1)
                                                        <img src="{{ asset('images/signature/create_sing_user/'.$usersRow['createSigning_name']) }}" alt="" height="50" class=""> 
                                                    @else
                                                        <img src="{{ asset('images/signature/create_sing/'.$usersRow['createSigning_name']) }}" alt="" height="50" class=""> 
                                                    @endif 
                                                    <div style="position: relative; top: -10px;"> .......................................................................... </div> 
                                                @else 
                                                    <?php  if($num_ec==$count_ec){ $text_ec="ลงชื่อเพื่ออนุมัติ"; } else { $text_ec="ลงชื่อเพื่อทราบ"; } ?>
                                                    <div class="mb-1 pt-3"> {{$text_ec}} ...................................................... </div> 
                                                @endif 

                                                <div class="mb-1"> ( {{$usersRow['ReceiversName']}} ) </div>
                                                <div class="mb-1"> {{$usersRow['position']}} </div>
                                                <div class="mb-1"> <span style="border-bottom: 1px dotted #000;"> 
                                                @if($usersRow['status_approve']==2)
                                                    <span class="ml-1 mr-1">  <?php echo date("d / m / Y", strtotime($usersRow['signature_date'])); ?> </span></span> 
                                                @else 
                                                    <span class="ml-1 mr-1"> </span> / <span class="ml-1 mr-1"> </span> / <span class="ml-1 mr-1"> </span></span> 
                                                @endif 
                                                </div>
                                            </div>
                                            <div class="mb-2 box_footer_signature">  
                                                @if($usersRow['status_approve']==1)
                                                    <span style="font-size: 10px;" class="badge badge-warning"> 
                                                    <i class="icon-hourglass"></i> รอดำเนินการ </span> 
                                                @elseif($usersRow['status_approve']==2)
                                                    <span style="font-size: 10px;" class="badge badge-success"> 
                                                    <i class="icon-check"></i> อนุมัติสำเร็จ </span>  
                                                @elseif($usersRow['status_approve']==3)
                                                    <span style="font-size: 10px;" class="badge badge-danger"> 
                                                    <i class="icon-close"></i> ไม่อนุมัติ </span> 
                                                @endif 
                                                
                                                
                                                @if($row['sender_id']==$data['users']->id) 
                                                    <?php $count=0; $arr_status_document=[]; ?>
                                                    @if(isset($row['comments_list'])) 
                                                        @foreach($row['comments_list'] as $row_msg)
                                                            @if($row_msg['comments_usersid']==$usersRow['UserReceiversid'])
                                                                <?php 
                                                                    $count++;
                                                                    $arr_status_document[]=$row_msg['status_document'];
                                                                ?> 
                                                            @endif
                                                        @endforeach
                                                    @endif  

                                                    @if($count>0)
                                                    <span class="float-right @if(in_array(1, $arr_status_document)) blink_me @endif ml-1">  
                                                        <a class="text-dark" href="#" data-usersid="{{$usersRow['UserReceiversid']}}" id="btn-comments"> 
                                                            <span class="badge badge-primary" style="font-size: 10px;"><i class="icon-bubbles"></i> {{$count}}</span>
                                                        </a>
                                                    </span>
                                                    @endif
                                                    @if($usersRow['status_approve']==2)
                                                    <span style=" font-size: 10px; color: #9e9e9e; margin-top: 2px;" class="float-right"> 
                                                    เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </span>
                                                    @endif
                                                @else 
                                                    @if($usersRow['status_approve']!=2)
                                                        <?php $count=0; $arr_status_document=[]; ?>
                                                        @if(isset($row['comments_list'])) 
                                                            @foreach($row['comments_list'] as $row_msg)
                                                                @if($row_msg['comments_usersid']==$usersRow['UserReceiversid'])
                                                                    <?php 
                                                                        $count++;
                                                                        $arr_status_document[]=$row_msg['status_document'];
                                                                    ?> 
                                                                @endif
                                                            @endforeach
                                                        @endif  
                                                        @if($count>0) 
                                                            <span class="ml-2 float-right">  
                                                                <i class="icon-bubbles"></i> {{$count}} 
                                                            </span>
                                                        @endif
                                                        <span style=" font-size: 10px; color: #9e9e9e; margin-top: 2px;" class="float-right"> 
                                                        เมื่อ {{Carbon\Carbon::parse($row['created_at'])->diffForHumans()}} </span>
                                                    @else 
                                                        <span style=" font-size: 10px; color: #9e9e9e; margin-top: 2px;" class="float-right"> 
                                                        เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </span>
                                                    @endif
                                                @endif
                                            </div> 
                                        </div>  
                                        <?php $num_ec++; ?>
                                    @endif
                                @endforeach 
                            @endif  
                        </div> 

                        @if(isset($data['send_commentsGet']))
                            @if(count($data['send_commentsGet'])>0)
                                <div class="">
                                    <div class="p-2" style="background: #64c5b1; color: #fff; font-weight: 500;border-radius: 0.25rem;"> 
                                        <i class="icon-speech"></i> แสดงความคิดเพิ่มเติมของผู้เกี่ยวข้อง
                                    </div> 
                                    @foreach($data['send_commentsGet'] as $row_com)
                                        <div class="mt-1" style="border: 1px solid #64c5b1; border-radius: 0.25rem; color: #333;"> 
                                            <div class="p-2" style="background: #62c2ae42; color: #069e7f;">  
                                                <div class=""> 
                                                    ผู้ส่ง : {{$row_com->senderName}} 
                                                    <span class="float-right" style="font-size: 10px;"> เมื่อ {{Carbon\Carbon::parse($row_com->created_at)->diffForHumans()}} </span>
                                                </div>
                                                <div class="">  <i class="icon-speech"></i> {{$row_com->detail}} </div>
                                            </div>  
                                            @if($row_com->status=="Y")
                                                <div class="p-2"> 
                                                    <div class="mb-1">  
                                                        <div class=""> 
                                                            ผู้รับ : {{$row_com->receiverName}}
                                                            <span class="float-right" style="font-size: 10px;"> เมื่อ {{Carbon\Carbon::parse($row_com->updated_at)->diffForHumans()}} </span>
                                                        </div>
                                                        <div class="mt-1">  <i class="icon-speech"></i> {{$row_com->feedback}} </div>
                                                    </div>  
                                                </div> 
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif 
                        @endif
                    </div>   
                </div>   
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
<script src="{{ asset('js/html2canvas.js') }}"></script>  
<script src="{{ asset('js/jquery.signaturepad.js') }}"></script>   
<script src="{{ asset('libs/select2/select2.min.js') }}"></script>
<script>  
    // ============================== // 
    $( ".from1" ).submit(function( event ) { 
        $( '#submit' ).prop( "disabled", true );
        $( '.save_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');  
    });

    $( ".from2" ).submit(function( event ) {    
        $( '#save_note' ).prop( "disabled", false );
        $( '.save_note_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...'); 
    }); 

    // ============================== //

    setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
    setTimeout(function(){ $('.alert-danger').fadeOut(); }, 3000);  
     
    $('.signature_ui').modal({
        backdrop: 'static',
        show: false, 
    }); 
</script>    
@endsection