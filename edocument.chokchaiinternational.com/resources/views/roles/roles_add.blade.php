@extends('layouts.app')
@section('style')     
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
                    <h5 class="m-0"> เพิ่มผู้เข้าใช้งานระบบ
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
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">

                  <div class="row"> 
                    <div class="col-md-4 form-group"> 
                      <label class="ml-1" for="name"> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                      <input id="name" type="text" class="form-control form-control-lg @error('name') invalid @enderror" name="name"  
                      value="{{ old('name') }}"
                      required autocomplete="name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('name')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="phone"> หมายเลขโทรศัพท์ <span class="text-danger">*</span></label>
                      <input id="phone" type="text" class="form-control form-control-lg @error('phone') invalid @enderror" name="phone"  
                      value="{{ old('phone') }}"
                      required autocomplete="phone" autofocus placeholder="โปรดระบุข้อมูล..." data-toggle="input-mask" data-mask-format="000-000-0000"> 
                      @error('phone')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="email"> อีเมล <span class="text-danger">*</span></label>
                      <input id="email" type="email" class="form-control form-control-lg @error('email') invalid @enderror" name="email"
                      value="{{ old('email') }}"
                      required autocomplete="email" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('email')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="roles"> เลือกสิทธ์การใช้งาน <span class="text-danger">*</span></label>  
                      <select class="form-control form-control-lg @error('email') invalid @enderror" id="roles" name="roles" required>
                          <option value="2">ผู้ใช้งานระบบ</option>
                          <option value="1">ผู้ดูแลระบบ</option> 
                      </select> 
                      @error('roles')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="password"> รหัสผ่าน  </label>
                      <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="ระบุรหัสผ่านของท่าน" required>
                      @error('password')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="passwordConfirm"> ยืนยันรหัสผ่านอีกครั้ง  </label>
                      <input class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="ระบุรหัสผ่านของท่าน" required>
                      @error('passwordConfirm')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-12 form-group"> 
                      <label class="ml-1" for="status"> สถานะการเข้าใช้งาน <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการเข้าใช้งาน </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการเข้าใช้งาน </label> 
                      </div> 
                    </div> 
                  </div>
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">    
                      <a href="{{ route('roles.list') }}" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
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
<script src="{{ asset('libs/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
<script src="{{ asset('libs/autonumeric/autoNumeric-min.js') }}"></script>
<script src="{{ asset('admin/js/pages/form-masks.init.js') }}"></script> 
<script> 
  $( "form" ).submit(function( event ) { 
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  });  
</script>
@endsection

