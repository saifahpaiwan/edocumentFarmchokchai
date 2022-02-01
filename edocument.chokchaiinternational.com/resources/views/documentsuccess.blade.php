@extends('layouts.app')
 
@section('style')     
    <style>
        .box-success {
            background: #FFF;
            padding: 0.5rem;
            border-radius: 0.25rem;
            border: 2px solid #32ba7c;
        }
    </style>
@endsection

@section('content')    

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-center mb-2"> 
                    <div class="text-center box-success">
                        <img src="{{ asset('images/icons/checked.png') }}" alt="" width="20%">
                        <div class="mt-2 h1"> สร้างเอกสารสำเร็จ </div>
                        <div class="mt-2"> เลขที่เอกสาร {{ $data['document_code'] }} </div>  
                        <a href="{{ route('dashboard') }}" class="btn btn-dark waves-effect width-md waves-light mt-2"> กลับหน้าหลัก </a> 
                    </div>  
                </div>
            </div>
        </div> 
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

    
</script>   
@endsection