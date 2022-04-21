@extends('layouts.app')
 
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
        padding: 1.5rem 0.5rem;
        text-align: center;
        background: #FFF;
        min-height: 195px; 
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
                    <div class="col-md-7">  
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
                    <div class="col-md-5"> 
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
                                    <label class="col-md-12 col-form-label" for="sender">
                                        ผู้ส่งเอกสาร 
                                        @if($row['document_status']==1)
                                            <span class="badge badge-warning float-right"> 
                                                <i class="mdi mdi-account-clock-outline"></i> รอดำเนินการ 
                                            </span>
                                        @elseif($row['document_status']==2)
                                            <span class="badge badge-success float-right"> 
                                                <i class="icon-check"></i>  เสร็จสมบูรณ์ 
                                            </span>
                                        @elseif($row['document_status']==3)
                                            <span class="badge badge-dark float-right">
                                                <i class="icon-note"></i>  ส่งกลับ/แก้ไข 
                                            </span>
                                        @elseif($row['document_status']==4)
                                            <span class="badge badge-danger float-right"> 
                                                <i class="icon-close"></i> ไม่อนุมัติเอกสาร	 
                                            </span>
                                        @endif
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" id="sender" class="form-control mb-1" value="{{$row['sender_name']}}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="sender" class="form-control mb-1" value="{{$row['sender_email']}}" disabled>
                                    </div>
                                </div> 
                                @if(isset($row['UserSignature'])) 
                                    @foreach($row['UserSignature'] as $usersRow)
                                        @if($usersRow['UserReceiversid']==$data['users']->id)
                                            <div class="row">
                                                <label class="col-md-12 col-form-label" for="sender_email">ถึง</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="sender_email" class="form-control mb-1" value="{{ $usersRow['ReceiversName'] }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="sender" class="form-control mb-1" value="{{ $usersRow['ReceiversEmail'] }}" disabled>
                                                </div>
                                            </div>   
                                        @endif
                                    @endforeach
                                @endif
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="topic_email">เรื่อง </label>
                                    <div class="col-md-12">
                                        <input type="text" id="topic_email" name="topic_email" class="form-control" value="{{$row['document_title']}}" disabled>
                                    </div>
                                </div> 
                                <div class="row">
                                    <label class="col-md-12 col-form-label" for="detail_email">รายละเอียด </label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="4" id="detail_email" name="detail_email" disabled>{{$row['document_detail']}}</textarea>
                                    </div>
                                </div>  
                               
                                <!-- //========================== ปุ่มจัดการเอกสาร ==========================// -->
                                    @if($row['sender_id']==$data['users']->id)
                                        @if($row['document_status']!=2)
                                            <div class="row mt-2">  
                                                <div class="col-md-12 text-center"> 
                                                    @if(session("error")) 
                                                        <div class="alert alert-icon alert-warning text-warning alert-dismissible fade show mb-0" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button> 
                                                            <i class="mdi mdi-alert"></i> {{session("error")}}
                                                        </div>
                                                    @endif  
                                                   
                                                    @if($row['document_status']==4 && $row['create_status']==4)
                                                        <div class="row mt-3 mb-1">  
                                                            <div class="col-md-12 text-center"> 
                                                                <img src="{{ asset('images/icons/Cancel.png') }}" alt="" width="55">
                                                                <div class="mt-2 h2">  เอกสารถูกยกเลิกเเล้ว </div>  
                                                                <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}} </div>  
                                                            </div> 
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-center">  
                                                            <a href="{{ url('edit_document/'.$data['get_id']) }}" class="btn btn-warning btn-rounded width-md waves-effect waves-light mt-2">
                                                            <i class="icon-note"></i> แก้ไขเอกสาร </a> 
                                                            <form action="{{ route('actionFormConfrimDocument.post') }}" method="post" enctype="multipart/form-data" class="ml-1" id="actionFormConfrimDocument">
                                                                @csrf
                                                                <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">  
                                                                <button type="button" class="btn btn-success btn-rounded width-md waves-effect waves-light mt-2" id="btn_ConfrimDocument"
                                                                @if($row['document_status']==3 || $row['document_status']==4) disabled @endif>  
                                                                <i class="icon-check"></i> ยืนยันการตรวจสอบเอกสารเสร็จสมบูรณ์ </button>
                                                            </form> 
                                                        </div>
                                                        <div class="mt-2 h4"> สิทธิ์การจัดการเอกสารของคุณ </div> 
                                                        <div class="mt-1 mb-1">  สร้างเมื่อ {{Carbon\Carbon::parse($row['created_at'])->diffForHumans()}} ที่แล้ว </div>
                                                    @endif
                                                    @if($row['document_status']==4)
                                                        <div class="p-2 text-left box-close-dd">
                                                            <div> <b><i class="icon-close"></i> หมายเหตุการ ไม่อนุมัติเอกสาร </b> </div>
                                                            <p>{{ $row['note'] }}</p>
                                                            <span> ลงชื่อผู้ไม่อนุมัติ : {{ $row['users_closeducoment_name'] }} </span>
                                                        </div>
                                                    @endif

                                                </div> 
                                            </div>
                                        <!-- @else
                                            <div class="row mt-3">  
                                                <div class="col-md-12 text-center"> 
                                                    <img src="{{ asset('images/icons/checked.png') }}" alt="" width="70">
                                                    <div class="mt-2 h4"> อนุมัติและตรวจสอบเอกสารสำเร็จ </div>
                                                    <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}} </div> 
                                                    <button type="button" class="btn btn-info btn-rounded width-md waves-effect waves-light mt-2" data-toggle="modal" data-target=".downloade_ui"> 
                                                    <i class="icon-arrow-down-circle"></i> ดาวน์โหลดเอกสาร </button>
                                                </div> 
                                            </div> -->
                                        @endif 
                                    @else 
                                         
                                        @if($row['document_status']==1)
                                            @if(isset($row['UserSignature'])) 
                                                @foreach($row['UserSignature'] as $usersRow)
                                                    @if($usersRow['UserReceiversid']==$data['users']->id) 
                                                        @if($usersRow['signing_rights']==1)
                                                            @if($usersRow['status_approve']==1) 
                                                                <div class="row mt-2">  
                                                                    @if(session("success"))
                                                                        <div class="col-md-12"> 
                                                                            <div class="alert alert-success" role="alert">
                                                                                <i class="icon-check"></i> {{session("success")}}
                                                                            </div>
                                                                        </div> 
                                                                    @endif 
                                                                    @error('note')
                                                                        <div class="col-md-12"> 
                                                                            <div class="alert alert-icon bg-transparent text-danger alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">×</span>
                                                                                </button>
                                                                                <i class="mdi mdi-block-helper mr-2"></i>
                                                                                <strong>ผิดผลาด!</strong> {{ $message }} 
                                                                            </div> 
                                                                        </div> 
                                                                    @enderror 

                                                                    <div class="col-md-12 text-center mt-2">
                                                                        <img src="{{ asset('images/icons/search.png') }}" alt="" width="50">
                                                                        <div class="mt-2 mb-2 h5"> กรุณาตรวจสอบเอกสารก่อนอนุมัติ </div> 
                                                                        <button type="button" class="mb-1 btn btn-success waves-effect width-md waves-light" data-toggle="modal" data-target=".signature_ui"> 
                                                                        <i class="fe-edit-1"></i> ลงนามเซ็นเอกสาร </button>
                                                                        <button type="button" class="mb-1 btn btn-warning waves-effect width-md" data-toggle="modal" data-target=".comment_ui"> 
                                                                        <i class="icon-bubble"></i> ส่งกลับ/แก้ไข </button> 
                                                                        <button type="button" class="mb-1 btn btn-danger waves-effect width-md waves-light" data-toggle="modal" data-target=".closeApp_ui"> 
                                                                        <i class="icon-close"></i> ไม่อนุมัติเอกสาร </button>

                                                                        <button type="button" class="mb-1 btn btn-primary waves-effect width-md waves-light" data-toggle="modal" data-target=".sendcomment_ui"> 
                                                                        <i class="icon-speech"></i> ขอความคิดเห็นเพิ่มเติม </button>

                                                                    </div> 
                                                                </div> 
                                                            @elseif($usersRow['status_approve']==2)
                                                                <div class="row mt-2">  
                                                                    <div class="col-md-12 text-center"> 
                                                                        <img src="{{ asset('images/icons/checked.png') }}" alt="" width="50">
                                                                        <div class="mt-2 h4"> คุณได้อนุมัติเอกสารเรียบร้อยแล้ว </div> 
                                                                        <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </div> 
                                                                    </div> 
                                                                </div> 
                                                            @endif 
                                                        @else
                                                            <div class="row mt-3">  
                                                                <div class="col-md-12 text-center"> 
                                                                    <img src="{{ asset('images/icons/search.png') }}" alt="" width="50">
                                                                    <div class="mt-2 h4"> คุณได้สิทธิ์ดูและตรวจสอบเอกสาร </div>
                                                                    <form action="{{ route('actionFormapprove.post') }}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
                                                                        <input type="hidden" name="hdf_typeSignature" id="hdf_typeSignature" value="1">   
                                                                        <input type="hidden" name="signing_rights" id="signing_rights" value="2">   
                                                                        @if($usersRow['status_approve']==1)   
                                                                            <button type="submit" class="btn btn-success btn-rounded width-md waves-effect waves-light"> 
                                                                            <i class="icon-check"></i> ยืนยัน </button>  
                                                                        @elseif($usersRow['status_approve']==2)   
                                                                            <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </div> 
                                                                        @endif
                                                                    </form>
                                                                </div> 
                                                            </div>  
                                                        @endif
                                                    @endif 
                                                @endforeach
                                            @endif

                                            @error('mag_feedback') 
                                                <div class="mt-1 alert alert-icon alert-danger text-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <i class="mdi mdi-block-helper mr-2"></i>
                                                    <strong>ผิดผลาด!</strong> {{ $message }} 
                                                </div>
                                            @enderror   
                                            @if(session("success_feedback"))
                                                <div class="mt-1 alert alert-icon alert-success text-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <i class="icon-check"></i> {{session("success_feedback")}}
                                                </div> 
                                            @endif 

                                        @elseif($row['document_status']==2)  
                                            <!-- @if(isset($row['UserSignature'])) 
                                                @foreach($row['UserSignature'] as $usersRow)
                                                    @if($usersRow['UserReceiversid']==$data['users']->id) 
                                                        @if($usersRow['signing_rights']==1) 
                                                            <div class="row mt-2">  
                                                                <div class="col-md-12 text-center"> 
                                                                    <img src="{{ asset('images/icons/checked.png') }}" alt="" width="50">
                                                                    <div class="mt-2 h4"> คุณได้อนุมัติเอกสารเรียบร้อยแล้ว </div> 
                                                                    <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </div> 
                                                                    <button type="button" class="btn btn-info btn-rounded width-md waves-effect waves-light mt-2" data-toggle="modal" data-target=".downloade_ui"> 
                                                                    <i class="icon-arrow-down-circle"></i> ดาวน์โหลดเอกสาร </button>
                                                                </div> 
                                                            </div>
                                                        @elseif($usersRow['signing_rights']==2)
                                                            <div class="row mt-3">  
                                                                <div class="col-md-12 text-center"> 
                                                                    <img src="{{ asset('images/icons/search.png') }}" alt="" width="50">
                                                                    <div class="mt-2 h4"> คุณได้สิทธิ์ดูและตรวจสอบเอกสาร </div>
                                                                    <form action="{{ route('actionFormapprove.post') }}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
                                                                        <input type="hidden" name="hdf_typeSignature" id="hdf_typeSignature" value="1">   
                                                                        <input type="hidden" name="signing_rights" id="signing_rights" value="2">   
                                                                        @if($usersRow['status_approve']==1)   
                                                                            <button type="submit" class="btn btn-success btn-rounded width-md waves-effect waves-light"> 
                                                                            <i class="icon-check"></i> ยืนยัน </button>  
                                                                        @elseif($usersRow['status_approve']==2)   
                                                                            <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </div> 
                                                                        @endif
                                                                    </form>
                                                                </div> 
                                                            </div>  
                                                        @endif 
                                                    @else
                                                        @if($data['check_users']>0)
                                                            <div class="row mt-2">  
                                                                <div class="col-md-12 text-center"> 
                                                                    <img src="{{ asset('images/icons/checked.png') }}" alt="" width="50">
                                                                    <div class="mt-2 h4"> ทำการอนุมัติเอกสารเรียบร้อยแล้ว </div> 
                                                                    <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}} </div> 
                                                                    <button type="button" class="btn btn-info btn-rounded width-md waves-effect waves-light mt-2" data-toggle="modal" data-target=".downloade_ui"> 
                                                                    <i class="icon-arrow-down-circle"></i> ดาวน์โหลดเอกสาร </button>
                                                                </div> 
                                                            </div>
                                                        @endif
                                                    @endif 
                                                @endforeach
                                            @endif  -->
                                            <div class="row mt-2">  
                                                <div class="col-md-12 text-center"> 
                                                    <img src="{{ asset('images/icons/checked.png') }}" alt="" width="50">
                                                    <div class="mt-2 h4"> ทำการอนุมัติเอกสารเรียบร้อยแล้ว </div> 
                                                    <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}} </div> 
                                                    <button type="button" class="btn btn-info btn-rounded width-md waves-effect waves-light mt-2" data-toggle="modal" data-target=".downloade_ui"> 
                                                    <i class="icon-arrow-down-circle"></i> ดาวน์โหลดเอกสาร </button>
                                                </div> 
                                            </div>
                                        @elseif($row['document_status']==3)
                                            <div class="row mt-3">  
                                                <div class="col-md-12 text-center"> 
                                                    <img src="{{ asset('images/icons/documentation.png') }}" alt="" width="50">
                                                    <div class="mt-2 h2"> รอการแก้ไขเอกสาร </div>  
                                                    <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}} </div>  
                                                </div> 
                                            </div>
                                        @elseif($row['document_status']==4) 
                                            <div class="row mt-3">  
                                                <div class="col-md-12 text-center"> 
                                                    <img src="{{ asset('images/icons/Cancel.png') }}" alt="" width="55">
                                                    <div class="mt-2 h2">  เอกสารถูกยกเลิกเเล้ว </div>  
                                                    <div class="mt-1">  เมื่อ {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}} </div>  
                                                </div> 
                                            </div>
                                        @endif 
                                    @endif
                                <!-- //==================================================================// -->
 
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
                                                                <i class="icon-check"></i> อ่านและตรวจสอบแล้ว
                                                            </span>
                                                        @else 
                                                            @if($usersRow['send_email']=="N")
                                                                <button type="button" style="border-radius: 0; float: right;" class="btn btn-purple btn-rounded width-md waves-effect waves-light btn-xs"
                                                                data-usersid="{{ $usersRow['UserReceiversid'] }}" id="btn-sendemail"> 
                                                                    <span class=""><i class="icon-cursor"></i> คลิกเพื่อส่งข้อมูล</span>
                                                                </button> 
                                                            @elseif($usersRow['send_email']=="Y")
                                                                <span class="badge badge-warning float-right" style="font-size: 10px;">
                                                                    <i class="icon-check"></i> รอการตรวจสอบเอกสาร
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="mt-2"> ตำแหน่ง : {{$usersRow['position']}} 
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
                            @if(session("info"))
                                <div class="col-md-12"> 
                                    <div class="alert alert-icon alert-info text-info alert-dismissible fade show" role="alert"> 
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button> 
                                        <div class="text-center">  
                                            <strong><i class="mdi mdi-information mr-1"></i> ทำการสร้างเอกสารสำเร็จ !</strong> 
                                            <div> กรุณาตรวจสอบการส่งข้อมูลไปยังอีเมลของผู้เซ็นให้ครบทุกท่านตามลำดับการเซ็น. </div>
                                        </div> 
                                    </div> 
                                </div> 
                            @endif   
                            @if(isset($row['UserSignature']))  
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
                                                    <?php  
                                                        $text_ec="";
                                                        if($usersRow['signing_prefix']==1){
                                                            $text_ec="ลงชื่อเพื่อทราบ";
                                                        } else if($usersRow['signing_prefix']==2){
                                                            $text_ec="ลงชื่อเพื่ออนุมัติ";
                                                        } 
                                                    ?>
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
                                                    @if($data['users']->id==$row_com->receiverId) 
                                                        <div class="float-right">  
                                                            <button type="button" class="btn btn-warning waves-effect waves-light btn-xs" 
                                                            data-receiver_id="{{$row_com->receiverId}}" data-id="{{$row_com->id}}" id="edit_feedback" style="padding: 0 0.2rem;">
                                                                [แก้ไข]
                                                            </button>
                                                        </div>
                                                    @endif
                                                    @if(!empty($row_com->filename))
                                                        <div class="mt-1">   
                                                            <a href="{{ asset('images/file_comments/'.$row_com->filename) }}" download>
                                                                <i class="icon-arrow-down-circle"></i> คลิกเพื่อดาวน์โหลดไฟล์
                                                            </a>
                                                        </div>
                                                    @endif 
                                                </div>
                                            @else 
                                                @if($data['users']->id==$row_com->receiverId) 
                                                    <div class="p-1"> 
                                                        <div class="text-center"> 
                                                            <button type="button" class="btn btn-primary btn-rounded width-md waves-effect waves-light bnt_feedback"
                                                            data-toggle="modal" data-target=".feedback_ui" data-id="{{ $row_com->id }}">
                                                                <i class="icon-note"></i> ตอบรับ
                                                            </button>
                                                        </div> 
                                                    </div>
                                                @else 
                                                    <div class="p-2"> 
                                                        <div class="mb-1">  
                                                            <div class="text-center"> 
                                                                <i class="icon-clock"></i> รอการตอบรับ...
                                                            </div> 
                                                        </div>  
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif 
                        @endif
                    </div>   
                </div> 

            <form action="{{ route('actionFormCommentsDocument.post') }}" method="post" enctype="multipart/form-data"> 
            @csrf
            <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
                <div class="modal fade comment_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0">ส่งกลับ/แก้ไขเอกสาร</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row"> 
                                    <div class="col-md-12 pb-1"> <b>รายละเอียด</b> </div>
                                    <div class="col-md-12 pb-1">
                                        <textarea class="form-control" rows="5" id="mag" name="mag"></textarea>
                                    </div> 
                                    <div class="col-md-12"> 
                                        <div class="mb-1"> กล่องข้อความของคุณ </div>
                                        @if(isset($row['comments_list'])) 
                                            <?php $n=1; ?>
                                            @foreach($row['comments_list'] as $row_msg)
                                                @if($row_msg['comments_usersid']==$data['users']->id)
                                                    <div class="mb-2"> 
                                                        <div class="msg-1 d-flex">
                                                            <div class="mr-auto"> 
                                                                ลำดับที่ <?php echo $n++; ?>
                                                            </div>
                                                            <div class="float-right">  
                                                                @if($row_msg['status_document']==1)
                                                                    <span class="badge badge-warning"> 
                                                                    <i class="icon-hourglass"></i> รอการตอบรับ </span>
                                                                @elseif($row_msg['status_document']==2)
                                                                    <span class="badge badge-success"> 
                                                                    <i class="mdi mdi-file-eye"></i> อ่านแล้ว </span>
                                                                @endif 
                                                                <span class="ml-2" style="font-size: 10px;">  
                                                                    เมื่อ {{Carbon\Carbon::parse($row_msg['comments_created_at'])->diffForHumans()}}
                                                                </span> 
                                                            </div> 
                                                        </div>
                                                        <div class="msg-2">
                                                            <div class="">  
                                                                <i class="icon-bubble"></i> 
                                                                {{ $row_msg['comments_detail'] }}  
                                                            </div>  
                                                            @if($row_msg['status_document']==1)
                                                                <div class="mt-1"> 
                                                                    <a href="#" class="text-danger" id="msg_close" 
                                                                    onclick="return confirm('ยืนยันการลบข้อความหรือไม่?');"
                                                                    data-comments_id="{{ $row_msg['comments_id'] }}"> 
                                                                    <i class="icon-close"></i> ยกเลิกข้อความ </a>    
                                                                </div>
                                                            @endif 
                                                        </div> 
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif  
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> ยกเลิก </button>
                                <button type="submit" class="btn btn-dark waves-effect waves-light save_mag"> 
                                    <span class="save_mag_text">ส่งข้อมูล</span>    
                                </button>
                            </div>
                        </div> 
                    </div> 
                </div>
            </form>
  
            <form action="{{ route('actionFormapprove.post') }}" method="post" enctype="multipart/form-data" id="formActionSignature"> 
            @csrf
            <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
            <input type="hidden" name="hdf_typeSignature" id="hdf_typeSignature" value="1">     
            <input type="hidden" name="signatureData_image" id="signatureData_image" value="">  
                <div class="modal fade signature_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0">ลงนามเซ็นเอกสาร</h4> 
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills navtab-bg nav-justified">
                                            <li class="nav-item">
                                                <a href="#bnt-status-1" data-toggle="tab" aria-expanded="false" data-id="1" class="nav-link active"> 
                                                    <span>เลือกลายเซ็นที่มีอยู่</span>
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
                                                @if(isset($row['UserSignature'])) 
                                                    @foreach($row['UserSignature'] as $usersRow)
                                                        @if($usersRow['UserReceiversid']==$data['users']->id)
                                                            @if($usersRow['status_approve']==1) 
                                                                @if(!empty($usersRow['signature']))
                                                                <div class=""> 
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked value="Y">
                                                                        <label class="custom-control-label" for="customRadio1">
                                                                            <div class="mb-1"> เลือกลายเซ็นที่มีอยู่ </div>
                                                                            <div style="font-weight: 300;"> <b>ชื่อ-นามสกุล</b> {{$usersRow['ReceiversName']}} <b>ตำแหน่ง</b> {{$usersRow['position']}} </div>
                                                                            <div style="font-weight: 300;"> <b>อัพเดทล่าสุด</b> {{Carbon\Carbon::parse($usersRow['signature_date'])->diffForHumans()}} </div>
                                                                            <div class="mb-1 d-flex" style="padding: 0.5rem; border-radius: 0.25rem;"> 
                                                                                <img src="{{ asset('images/signature/create_sing_user/'.$usersRow['signature']) }}" alt="" width="100" style="padding-bottom: 5px; border-bottom: 1px solid #333;"> 
                                                                            </div> 
                                                                        </label>
                                                                    </div>  
                                                                </div> 
                                                                @else
                                                                    <div class="text-center">  
                                                                        <div> 
                                                                            ยังไม่มีรูปลายเซ็นของคุณ กรุณาอัพโหลดลายเซ็น! 
                                                                        </div>
                                                                    </div> 
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endforeach 
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> ยกเลิก </button>
                                <button type="submit" class="btn btn-dark waves-effect waves-light save_signature1" id="submit"> 
                                    <span class="save_signature1_text">บันทึกข้อมูล</span>    
                                </button> 
                                <button type="button" class="btn btn-dark waves-effect waves-light save_signature2_text" id="btnSaveSignature"> 
                                    <span class="save_signature2_text">บันทึกข้อมูล</span>        
                                </button>
                            </div>
                        </div> 
                    </div> 
                </div>  
            </form>
 
                <div class="modal fade downloade_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0"><i class="icon-arrow-down-circle"></i>  ดาวน์โหลดเอกสาร </h4> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row"> 
                                    <div class="col-md-6">
                                        <div><b>เลขที่ {{$row['document_code']}} </b></div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div><b>วันที่  <?php echo date("d/m/Y", strtotime($row['created_at'])); ?></b></div>
                                    </div>
                                    <div class="col-md-12 pt-2"> 
                                        @if(isset($data['fileups'])) 
                                            @foreach($data['fileups'] as $file_Row)  
                                                <div class="d-flex mb-2 pb-1"> 
                                                    <img src="{{ asset('images/icons/pdf.svg') }}" alt="" width="40">
                                                    <div class="ml-1"> 
                                                        เอกสารรายละเอียดการอนุมัติ<br>
                                                        สร้างเมื่อ : {{Carbon\Carbon::parse($file_Row->created_at)->diffForHumans()}}    
                                                    </div>
                                                    <div class="h3 ml-auto"> 
                                                        <a href="{{ asset('images/document-file/pdf_file/'.$file_Row->filename) }}" download>
                                                            <i class="icon-arrow-down-circle"></i> 
                                                        </a> 
                                                    </div>
                                                </div> 
                                            @endforeach
                                        @endif 

                                        <div class="d-flex mb-2 pb-1"> 
                                            <img src="{{ asset('images/icons/pdf.svg') }}" alt="" width="40">
                                            <div class="ml-1"> 
                                                เอกสารอนุมัติลายเซ็น<br>
                                                สร้างเมื่อ : {{Carbon\Carbon::parse($row['updated_at'])->diffForHumans()}}
                                            </div>
                                            <div class="h3 ml-auto"> 
                                                <a href="{{ url('/signatureViwepdf/'.$data['get_id']) }}" target="_blank">
                                                    <i class="icon-arrow-down-circle"></i> 
                                                </a>    
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div>

                <div class="modal fade modal-comments" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0">รายการส่งกลับ/แก้ไขเอกสาร</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">  
                                    <div class="col-md-12"> 
                                        <div class="mb-1"> กล่องข้อความส่งกลับ </div> 
                                        <div class="mb-2 box-comments"> 
                                            <!-- // --------- HTML --------- // -->
                                        </div>  
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                </div>

            <form action="{{ route('actionFormCloseDocument.post') }}" method="post" enctype="multipart/form-data"> 
            @csrf
            <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
                <div class="modal fade closeApp_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0"><i class="icon-close"></i> ไม่อนุมัติเอกสาร</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row"> 
                                    <div class="col-md-12 pb-1"> <b>กรุณาใส่หมายเหตุการไม่อนุมัติเอกสาร </b> </div>
                                    <div class="col-md-12 pb-1">
                                        <textarea class="form-control" rows="5" id="note" name="note" ></textarea> 
                                    </div>  
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> ยกเลิก </button>
                                <button type="submit" class="btn btn-dark waves-effect waves-light save_note"> 
                                    <span class="save_note_text">ยืนยันการ ไม่อนุมัติเอกสาร</span>  
                                </button>
                            </div>
                        </div> 
                    </div> 
                </div>
            </form>


            <form action="{{ route('actionFormSendcomment.post') }}" method="post" enctype="multipart/form-data"> 
            @csrf
            <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">     
                <div class="modal fade sendcomment_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0"><i class="icon-speech"></i> ขอความคิดเห็นเพิ่มเติม </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row"> 
                                    <div class="col-md-12 pb-1"> 
                                        <select id="users_id_comments" name="users_id_comments" class="form-control" data-toggle="select2" required>
                                            <option value=""> ระบุผู้รับข้อความ </option>
                                            @if(isset($data['usersGet']))
                                                @foreach($data['usersGet'] as $row_users)
                                                    <option value="{{$row_users->id}}"> {{$row_users->name}} </option>
                                                @endforeach 
                                            @endif
                                        </select>    
                                    </div>
                                    <div class="col-md-12 pb-1"> <b>รายละเอียด</b> </div>
                                    <div class="col-md-12 pb-1">
                                        <textarea class="form-control" rows="5" id="send_comments" name="send_comments" required></textarea>
                                    </div>  
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> ยกเลิก </button> 
                                <button type="submit" class="btn btn-dark waves-effect waves-light save_comments"> 
                                    <span class="save_comments_text">ส่งข้อมูล</span>
                                </button>
                            </div>
                        </div> 
                    </div> 
                </div>
            </form>

            <form action="{{ route('actionFormFeedback.post') }}" method="post" enctype="multipart/form-data"> 
            @csrf
            <input type="hidden" name="document_id" id="document_id" value="{{$data['get_id']}}">  
            <input type="hidden" name="send_comments_id" id="send_comments_id" value="">     
                <div class="modal fade feedback_ui" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0"><i class="icon-speech"></i> แสดงความคิดเห็น </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">  
                                    <div class="col-md-12 pb-1"> <b>รายละเอียด</b> </div>
                                    <div class="col-md-12 pb-1">
                                        <textarea class="form-control" rows="5" id="mag_feedback" name="mag_feedback"></textarea>
                                    </div>  
                                    <div class="col-md-12"> 
                                        <label for="myfile">อัพโหลดไฟล์ประกอบ (ถ้ามี)</label>
                                        <input type="file" id="file_upload_feedback" name="file_upload_feedback[]" style="display: block;"> 
                                        <div class="text-muted mt-1">อัพโหลดไฟล์เป็น .PDF เท่านั้น </div>   
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> ยกเลิก </button>
                                <button type="submit" class="btn btn-dark waves-effect waves-light save_feedback"> 
                                    <span class="save_feedback_text">ส่งข้อมูล</span>
                                </button>
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
 
@endsection 
@section('script')   
<script src="{{ asset('js/html2canvas.js') }}"></script>  
<script src="{{ asset('js/jquery.signaturepad.js') }}"></script>   
<script src="{{ asset('libs/select2/select2.min.js') }}"></script>
<script>  
    // ============================== //
    $( "form" ).submit(function( event ) {  
        $( '.save_feedback' ).prop( "disabled", true );
        $( '.save_feedback_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...'); 

        $( '.save_comments' ).prop( "disabled", true );
        $( '.save_comments_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...'); 

        $( '.save_mag' ).prop( "disabled", true );
        $( '.save_mag_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...'); 
        
        $( '.save_signature1' ).prop( "disabled", true );
        $( '.save_signature1_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
        $( '.save_signature2' ).prop( "disabled", true );
        $( '.save_signature2_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
 
        $( '.save_note' ).prop( "disabled", true );
        $( '.save_note_text' ).html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');  
    }); 
    // ============================== //

    setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
    setTimeout(function(){ $('.alert-danger').fadeOut(); }, 3000);  
    $('#users_id').select2(); 
    $('#users_id_comments').select2(); 
    
    
    $(document).on('click', '.bnt_feedback', function(event) { 
        var id = $(this)[0].dataset.id;
        $('#send_comments_id').val(id);
    });


    $(document).on('click', '#edit_feedback', function(event) {   
       var user_id=$(this)[0].dataset.receiver_id;
       var id=$(this)[0].dataset.id;
       var document_id = $('#document_id').val();
        $.post("{{ route('feedbackGet.post') }}", {
            _token: "{{ csrf_token() }}", 
            document_id: document_id, 
            user_id: user_id,
            id: id,
        })
        .done(function(data, status, error){   
            if(error.status==200){   
                $('.feedback_ui').modal({ 
                    show: true, 
                });
                $('#mag_feedback').val(data[0].feedback);
                $('#send_comments_id').val(id);
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        });    
    });
    
    //===================================================================//
        $(document).on('click', '#btn-sendemail', function(event) {  
            var user_id=$(this)[0].dataset.usersid;
            var document_id = $('#document_id').val();
            Swal.fire({
                title: 'ยืนยันการการส่งข้อมูล หรือไม่?',
                text: "ระบบจะทำการส่งข้อมูลไปยังอีเมลของผู้เซ็น !",
                type:"question",
                showCancelButton:!0,
                confirmButtonText:"Yes",
                cancelButtonText:"No",
                confirmButtonClass:"btn btn-success mt-2",
                cancelButtonClass:"btn btn-danger ml-2 mt-2",
                buttonsStyling:!1
            }).then((result) => { 
                if (result.value) {  
                    $('#btn-sendemail').prop( "disabled", true );
                    $('.class_sendemail'+user_id).html('<i class="mdi mdi-spin mdi-loading"></i> กำลังส่งข้อมูล..');
                    $.post("{{ route('users_sendemail.post') }}", {
                        _token: "{{ csrf_token() }}", 
                        document_id: document_id, 
                        user_id: user_id,
                    })
                    .done(function(data, status, error){   
                        if(error.status==200){  
                            location.reload();
                        }
                    })
                    .fail(function(xhr, status, error) { 
                        alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
                    });  
                }
            });
        });
    //===================================================================//
    
    $(document).on('click', '#msg_close', function(event) {  
        var comments_id=$(this)[0].dataset.comments_id; 
        var document_id = $('#document_id').val(); 
        $.post("{{ route('documentComments_close.post') }}", {
            _token: "{{ csrf_token() }}", 
            comments_id: comments_id, 
            document_id: document_id,
        })
        .done(function(data, status, error){   
            if(error.status==200){  
                location.reload();
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        });   
    });

    $(document).on('click', '#btn-answer', function(event) {  
        var user_id=$(this)[0].dataset.usersid; 
        var document_id = $('#document_id').val();
        $.post("{{ route('documentComments_answer.post') }}", {
            _token: "{{ csrf_token() }}", 
            user_id: user_id, 
            document_id: document_id,
        })
        .done(function(data, status, error){   
            if(error.status==200){   
                location.reload();
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        });   
    });

    $(document).on('click', '#btn-comments', function(event) {  
        var user_id=$(this)[0].dataset.usersid; 
        var document_id = $('#document_id').val();
        post_documentComments(user_id, document_id);
    });
 
    function post_documentComments(user_id, document_id){
        $.post("{{ route('documentComments.post') }}", {
            _token: "{{ csrf_token() }}", 
            user_id: user_id, 
            document_id: document_id,
        })
        .done(function(data, status, error){   
            if(error.status==200){    
                $('.modal-comments').modal({
                    backdrop: 'static',
                    show: true, 
                });
                $('.box-comments').html(data); 
            }
        })
        .fail(function(xhr, status, error) { 
            alert('เกิดข้อผิดผลาดโปรดทำรายการใหม่อีกครั้ง'); 
        });    
    }

    (function(window) { 
        var height=200;
        var width=465;
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

        $("#btnSaveSignature").click(function(e){ 
            html2canvas([document.getElementById('signaturePad')], {
                onrendered: function (canvas) {
                    var canvas_img_data = canvas.toDataURL('image/png');
                    var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, ""); 
                    $('#signatureData_image').val(img_data);    
                    document.getElementById("formActionSignature").submit.click(); 
                }
            }); 
        }); 
    }(this)); 

    $('.signature_ui').modal({
        backdrop: 'static',
        show: false, 
    });

    $('#btnSaveSignature').hide();
    $(document).on('click', '[data-toggle=tab]', function(event) {  
        var id=$(this)[0].dataset.id; 
        if(id==2){
            $('#submit').hide();
            $('#btnSaveSignature').show();
        }else{
            $('#submit').show();
            $('#btnSaveSignature').hide();
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


    $(document).on('click', '#btn_ConfrimDocument', function(event) {  
        Swal.fire({
            title: 'ยืนยัน !',
            text: "การตรวจสอบเอกสารเสร็จสมบูรณ์ หรือไม่!",
            type:"question",
            showCancelButton:!0,
            confirmButtonText:"Yes",
            cancelButtonText:"No",
            confirmButtonClass:"btn btn-success mt-2",
            cancelButtonClass:"btn btn-danger ml-2 mt-2",
            buttonsStyling:!1 
        }).then((result) => { 
            if (result.value) {  
                $( "#btn_ConfrimDocument" ).prop( "disabled", true );
                $( "#actionFormConfrimDocument" ).submit();
            }
        });
    });  
</script>    
@endsection