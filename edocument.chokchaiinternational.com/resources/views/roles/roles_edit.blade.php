@extends('layouts.app')
@section('style')     
<link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
              <div class="page-title-box"> 
                  <h4 class="page-title"> <i class="fe-users"></i> ผู้เข้าใช้งานระบบ </h4>
              </div>
          </div>
        </div>  
        
        <div class="row">
          <div class="col-md-12"> 
            <div class="card"> 
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-12"> 
                    <h5 class="m-0"> แก้ไขผู้เข้าใช้งานระบบ
                    <a href="{{ route('roles.list') }}" class="float-right"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                    </h5>
                  </div> 
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <form method="POST" action="{{ route('save.roles') }}" id="form" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['User_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-4 form-group"> 
                      <label class="ml-1" for="name"> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                      <input id="name" type="text" class="form-control form-control-lg @error('name') invalid @enderror" name="name"  
                      value="{{ $data['User_find']->name }}"
                      required autocomplete="name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('name')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="phone"> หมายเลขโทรศัพท์ <span class="text-danger">*</span></label>
                      <input id="phone" type="text" class="form-control form-control-lg @error('phone') invalid @enderror" name="phone"  
                      value="{{ $data['User_find']->phone }}"
                      required autocomplete="phone" autofocus placeholder="โปรดระบุข้อมูล..." data-toggle="input-mask" data-mask-format="000-000-0000"> 
                      @error('phone')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="email"> อีเมล <span class="text-danger">*</span></label>
                      <input id="email" type="email" class="form-control form-control-lg @error('email') invalid @enderror" name="email" disabled
                      value="{{ $data['User_find']->email }}"
                      required autocomplete="email" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('email')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="roles"> เลือกสิทธ์การใช้งาน <span class="text-danger">*</span></label>  
                      <select class="form-control form-control-lg @error('email') invalid @enderror" id="roles" name="roles" required>
                          <option @if($data['User_find']->roles==2) {{ __('selected ') }}  @endif value="2">ผู้ใช้งานระบบ</option>
                          <option @if($data['User_find']->roles==1) {{ __('selected ') }}  @endif value="1">ผู้ดูแลระบบ</option> 
                      </select> 
                      @error('roles')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                  </div> 
                  <hr>
                  <div class="row">
                    <div class="col-md-3 pb-2"> 
                      <h4>Change Password</h4> 
                      <div class="custom-control custom-checkbox mt-1">
                          <input type="checkbox" class="custom-control-input" id="changepassCheck1" name="changepassCheck" value="Y">
                          <label class="custom-control-label" for="changepassCheck1"> ติ๊กเพื่อเปลี่ยนรหัสผ่าน </label>
                      </div>
                    </div> 
                    <div class="col-md-3"> 
                      <label class="ml-1" for="old_password"> รหัสผ่านเดิม  </label>
                      <input class="form-control form-control-lg @error('old_password') is-invalid @enderror" type="password" id="old_password" name="old_password" placeholder="ระบุรหัสผ่านของท่าน">
                      @error('old_password')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3"> 
                      <label class="ml-1" for="password"> รหัสผ่านใหม่  </label>
                      <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="ระบุรหัสผ่านของท่าน">
                      @error('password')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3"> 
                      <label class="ml-1" for="passwordConfirm"> ยืนยันรหัสผ่านใหม่อีกครั้ง  </label>
                      <input class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="ระบุรหัสผ่านของท่าน">
                      @error('passwordConfirm')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>  
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="status"> สถานะการเข้าใช้งาน <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ $data['User_find']->deleted_at == true ? $data['User_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" style="color: #FFF; padding: 0.25rem;" for="status1"> เปิดการเข้าใช้งาน </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ $data['User_find']->deleted_at == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" style="color: #FFF; padding: 0.25rem;" for="status2"> ปิดการเข้าใช้งาน </label> 
                      </div> 
                    </div> 
                    <div class="col-md-9 form-group"> 
                      <h4>Roles การอนุมัติเข้าใช้งานระบบ</h4> 
                      <div class="custom-control custom-checkbox mt-1">
                          <input type="checkbox" class="custom-control-input" id="is_users1" name="is_users" value="1" @if($data['User_find']->is_users==1) {{ __('disabled')." ".__('checked') }} @endif>
                          <label class="custom-control-label" for="is_users1"> ติ๊กเพื่ออนุมัติเข้าใช้งานระบบ </label>
                      </div>
                    </div> 
                  </div>
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">    
                      <a href="{{ route('roles.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                      @if(Auth::user()->id!=$data['User_find']->id)
                        <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['User_find']->id }}"> 
                          <i class="mdi mdi-delete"></i> ยกเลิกข้อมูล 
                        </button>
                      @endif
                      <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> 
                        <span class="text-submit"><i class="fe-save"></i> บันทึกข้อมูล </span>
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
@endsection
@section('script')  
<script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>   
<script src="{{ asset('libs/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
<script src="{{ asset('libs/autonumeric/autoNumeric-min.js') }}"></script>
<script src="{{ asset('admin/js/pages/form-masks.init.js') }}"></script> 
<script> 
  $( "form" ).submit(function( event ) { 
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  });  

  $(document).on('click', '#close', function(event) { 
    var id=$(this)[0].dataset.id; 
    var vthis=$(this);
    vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
    Swal.fire({
        title: 'ยืนยันการยกเลิกข้อมูล หรือไม่?',
        text: "ระบบจะทำการยกเลิกข้อมูล และจะไม่สามารถนำกลับได้ !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => { 
        if (result.value) {  
          $.post("{{ route('close.roles') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.href = "{{ route('roles.list') }}";
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            location.reload();
          });  
        } else {
          vthis[0].innerHTML='<i class="mdi mdi-delete"></i> ยกเลิกข้อมูล';  
        }
    }); 
  }); 

  $('#old_password').prop( "disabled", true );
  $('#password').prop( "disabled", true );
  $('#passwordConfirm').prop( "disabled", true ); 
  $(document).on('click', '#changepassCheck1', function(event) { 
    if($(this)[0].checked==true){
      $('#old_password').prop( "disabled", false  );
      $('#password').prop( "disabled", false  );
      $('#passwordConfirm').prop( "disabled", false  ); 
    } else {
      $('#old_password').prop( "disabled", true );
      $('#password').prop( "disabled", true );
      $('#passwordConfirm').prop( "disabled", true ); 
    }
  });
</script>
@endsection

