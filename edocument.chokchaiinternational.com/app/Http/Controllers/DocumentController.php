<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\department_code;

use Org_Heigl\Ghostscript\Ghostscript;
use Symfony\Component\HttpFoundation\Response;
use Spatie\PdfToImage\Pdf;
use Image;

use App\Mail\storeMail;
use App\Mail\storeMail_sender;
use App\Mail\storeMail_comments;

use Illuminate\Support\Facades\Mail;
use DataTables; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {   
        $id=Auth::user()->id;
        $data = array( 
            'count2'  => count($this->documentQuery2($id, "")),
            'count3'  => count($this->documentQuery3($id, "")),
            'count6'  => count($this->documentQuery6($id, "")), 
        ); 
        return view('dashboard', compact('data'));
    } 

    public function create_document(){   
        $id=Auth::user()->id;
        $users=User::find($id);   
        $department_code=department_code::all();
        $data = array(
            'users' => $users,
            'department_code' => $department_code,
        ); 
        return view('create_document', compact('data'));
    } 

    public function edit_document($get_id){   
        $id=Auth::user()->id;
        $users=User::find($id);   
        $document_edit=DB::table('document_creates')
        ->leftJoin('document_fileups', 'document_creates.id', '=', 'document_fileups.document_id')  
        ->select('*', 'document_fileups.filename as filename')
        ->where('document_creates.id', $get_id)
        ->first(); 
        $data = array(
            'get_id' => $get_id,
            'users' => $users,
            'document_edit' => $document_edit,
        ); 
        return view('edit_document', compact('data'));
    } 
     
    public function create_receiver($get_id){    
        $id=Auth::user()->id;   
        // $users=DB::table('users')->where('users.id', '!=', $id)->where('users.deleted_at', 0)->get();
        $users=DB::table('users')->where('users.deleted_at', 0)->get();
        $data = array(
            'get_id'      => $get_id,
            'documentGet' => $this->documentGet($get_id),
            'usersGet'    => $users,
        );   
        return view('create_receiver', compact('data'));
    }  

    public function create_signature($get_id){  
        $fileups=DB::table('document_fileups') 
        ->where('document_fileups.document_id', $get_id)
        ->where('document_fileups.deleted_at', NULL)
        ->where('document_fileups.type', 'm')
        ->paginate(1);    
        $data = array(
            'get_id'      => $get_id,
            'documentGet' => $this->documentGet($get_id), 
            'fileups'      => $fileups,
        );     
        return view('create_signature', compact('data'));
    } 

    public function confrim_document($get_id){   
        $fileups=DB::table('document_fileups') 
        ->where('document_fileups.document_id', $get_id)
        ->where('document_fileups.deleted_at', NULL)
        ->where('document_fileups.type', 'p')
        ->get();  
        $data = array(
            'get_id'      => $get_id,
            'documentGet' => $this->documentGet($get_id), 
            'fileups'     => $fileups,
        );  
        return view('confrim_document', compact('data'));
    } 

    public function documentsuccess($get_id){   
        $first=DB::table('document_creates')
        ->select('document_creates.document_code as document_code')
        ->where('document_creates.id', $get_id) 
        ->first(); 
        $data = array(
            'document_code' => $first->document_code,
            'get_id'      => $get_id,
            'documentGet' => $this->documentGet($get_id),  
        );  
        return view('documentsuccess', compact('data'));
    }  

    public function documents($get_id)
    {   
        $id=Auth::user()->id;
        $users=User::find($id);   
        $title="";
        if($get_id==1){
            $title='<i class="fe-file-plus"></i> <span> เอกสารที่สร้าง </span>';
        } else if($get_id==2){
            $title='<i class="fe-edit-1"></i> <span>  เอกสารที่ต้องเซ็น  </span>';
        } else if($get_id==3){
            $title='<i class="fe-file-text"></i> <span> เอกสารทังหมด </span>';
        } else if($get_id==4){
            $title='<i class="fe-x-circle"></i> <span> เอกสารที่ยกเลิก </span>';
        } else if($get_id==5){
            $title='<i class="fas fa-file-signature"></i> <span>  เอกสารที่ร่าง </span>';
        } else if($get_id==6){
            $title='<i class="fas fa-comment"></i> <span>   ส่งกลับ/แก้ไข </span>';
        }
        $data = array(
            'users'  => $users,
            'title'  => $title,
            'get_id' => $get_id, 
        ); 
        return view('documents', compact('data'));
    } 

    public function documents_viwe($get_id){   
        $id=Auth::user()->id;
        $users=User::find($id);
        $fileups=DB::table('document_fileups') 
        ->where('document_fileups.document_id', $get_id)
        ->where('document_fileups.deleted_at', NULL)
        ->where('document_fileups.type', 'p')
        ->get();   
        $check_users=DB::table('check_users')  
        ->where('check_users.users_id', $id) 
        ->count(); 
        $usersGet=DB::table('users')->where('users.id', '!=', $id)->where('users.deleted_at', 0)->get();    
        $data = array(
            'users'  => $users, 
            'get_id' => $get_id,
            'documentGet' => $this->documentGet_viwe($get_id),
            'fileups'     => $fileups,
            'usersGet'    => $usersGet,
            'check_users' => $check_users,
            'send_commentsGet' => $this->send_commentsGet($get_id),
        );    
        return view('documents_viwe', compact('data'));
    }  

    public function send_commentsGet($get_id)
    {
        $data=DB::table('send_comments')
        ->leftJoin('users as sender', 'send_comments.sender_id', '=', 'sender.id')
        ->leftJoin('users as receiver', 'send_comments.receiver_id', '=', 'receiver.id')
        ->select('send_comments.id as id', 'sender.id as senderId', 'sender.name as senderName', 'receiver.name as receiverName',
        'receiver.id as receiverId',
        'send_comments.detail as detail', 'send_comments.feedback as feedback', 'send_comments.filename as filename',
        'send_comments.status as status', 'send_comments.created_at as created_at', 'send_comments.updated_at as updated_at')

        ->where('send_comments.document_id', $get_id)
        ->where('send_comments.deleted_at', NULL)
        ->groupBy('send_comments.id')->get();   
        return $data; 
    }

    //===========================================================================//
    public function documentGet($id)
    {
        $data = DB::table('document_creates')
        ->leftJoin('users', 'document_creates.sender_id', '=', 'users.id')
        ->leftJoin('document_receivers', 'document_creates.id', '=', 'document_receivers.document_id') 
        ->leftJoin('users as usersReceivers', 'document_receivers.users_id', '=', 'usersReceivers.id')  
        
        ->select('document_creates.id as id', 'document_creates.document_code as document_code', 'document_creates.document_type as document_type', 
        'document_creates.create_status as create_status', 'users.id as sender_id', 'users.name as sender_name', 'users.sender_email as sender_email',
        'document_receivers.id as receivers_id', 'document_receivers.signing_rights as signing_rights', 


        'usersReceivers.id as UserReceiversid', 'usersReceivers.name as ReceiversName', 
        'document_receivers.email as ReceiversEmail', 'document_receivers.position as position', 'document_receivers.signing_prefix as signing_prefix',


        'document_receivers.passwrod_is as Receiverspasswrod_is', 'document_receivers.passwrod as Receiverspasswrod', 'document_creates.created_at as created_at',
        'document_creates.document_title as document_title', 'document_creates.document_detail as document_detail', )
        ->where('document_creates.id', $id)
        ->whereIn('document_creates.create_status', [1, 2]) 
        ->where('document_creates.deleted_at', NULL)  
        ->get(); 
        $items=[];
        foreach($data as $key=>$row){
            $items[$row->id]['id']=$row->id;
            $items[$row->id]['document_code']=$row->document_code;
            $items[$row->id]['document_title']=$row->document_title;
            $items[$row->id]['document_detail']=$row->document_detail; 
            $items[$row->id]['sender_id']=$row->sender_id;
            $items[$row->id]['document_type']=$row->document_type;
            $items[$row->id]['create_status']=$row->create_status;
            $items[$row->id]['sender_id']=$row->sender_id;
            $items[$row->id]['sender_name']=$row->sender_name;
            $items[$row->id]['sender_email']=$row->sender_email;
            $items[$row->id]['created_at']=$row->created_at;
            if(!empty($row->receivers_id)){
                $items[$row->id]['UserSignature'][$row->receivers_id]['receivers_id']=$row->receivers_id;
                $items[$row->id]['UserSignature'][$row->receivers_id]['UserReceiversid']=$row->UserReceiversid;
                $items[$row->id]['UserSignature'][$row->receivers_id]['ReceiversName']=$row->ReceiversName; 
                $items[$row->id]['UserSignature'][$row->receivers_id]['position']=$row->position;
                $items[$row->id]['UserSignature'][$row->receivers_id]['ReceiversEmail']=$row->ReceiversEmail;
                $items[$row->id]['UserSignature'][$row->receivers_id]['signing_rights']=$row->signing_rights;
                $items[$row->id]['UserSignature'][$row->receivers_id]['passwrod_is']=$row->Receiverspasswrod_is;
                $items[$row->id]['UserSignature'][$row->receivers_id]['Receiverspasswrod']=$row->Receiverspasswrod;
            }  
        }   
        return $items;
    }

    public function documentGet_viwe($id)
    {
        $data = DB::table('document_creates')
        ->leftJoin('users', 'document_creates.sender_id', '=', 'users.id')
        ->leftJoin('document_receivers', 'document_creates.id', '=', 'document_receivers.document_id')
        ->leftJoin('document_comments', 'document_receivers.id', '=', 'document_comments.receiver_id')
        ->leftJoin('users as usersReceivers', 'document_receivers.users_id', '=', 'usersReceivers.id') 
        ->leftJoin('users as users_closeducoment', 'document_creates.users_closeducoment', '=', 'users_closeducoment.id') 
        
        ->select('document_creates.id as id', 'document_creates.document_code as document_code', 'document_creates.document_type as document_type', 
        'document_creates.create_status as create_status', 'users.id as sender_id', 'users.name as sender_name', 'users.sender_email as sender_email',
        'document_receivers.id as receivers_id', 'document_receivers.signing_rights as signing_rights', 'document_creates.document_status as document_status',


        'usersReceivers.id as UserReceiversid', 'usersReceivers.name as ReceiversName', 'document_receivers.updated_at as signature_date',
        'document_receivers.email as ReceiversEmail', 'document_receivers.position as position', 'document_receivers.status_approve as status_approve',
 

        'document_receivers.passwrod_is as Receiverspasswrod_is', 'document_receivers.passwrod as Receiverspasswrod', 'document_creates.created_at as created_at', 
        'document_creates.updated_at as updated_at',
        'document_creates.document_title as document_title', 'document_creates.document_detail as document_detail', 'usersReceivers.signature as signature',
        'document_receivers.signing_name as createSigning_name', 'document_receivers.signing_type as signing_type',
        
        'document_comments.id as comments_id', 'document_comments.users_id as comments_usersid', 
        'document_comments.status_document as status_document', 'document_comments.detail as comments_detail',
        'document_comments.created_at as comments_created_at', 'document_creates.note as note', 'users_closeducoment.name as users_closeducoment_name',
        'document_receivers.send_email as send_email', 'document_receivers.send_email_date as send_email_date', 'document_receivers.signing_prefix as signing_prefix')
        ->where('document_creates.id', $id) 
        // ->where('document_creates.create_status', 3)
        // ->where('document_creates.deleted_at', NULL)  
        ->orderBy('document_receivers.id', 'asc')
        ->get(); 
        $items=[];
        foreach($data as $key=>$row){
            $items[$row->id]['id']=$row->id;
            $items[$row->id]['document_code']=$row->document_code;
            $items[$row->id]['document_title']=$row->document_title;
            $items[$row->id]['document_detail']=$row->document_detail; 
            $items[$row->id]['sender_id']=$row->sender_id;
            $items[$row->id]['document_type']=$row->document_type;
            $items[$row->id]['create_status']=$row->create_status;
            $items[$row->id]['document_status']=$row->document_status; 
            $items[$row->id]['sender_id']=$row->sender_id;
            $items[$row->id]['sender_name']=$row->sender_name;
            $items[$row->id]['sender_email']=$row->sender_email;
            $items[$row->id]['created_at']=$row->created_at;
            $items[$row->id]['updated_at']=$row->updated_at;
            $items[$row->id]['note']=$row->note;
            $items[$row->id]['users_closeducoment_name']=$row->users_closeducoment_name;
            
            if(!empty($row->receivers_id)){
                $items[$row->id]['UserSignature'][$row->receivers_id]['receivers_id']=$row->receivers_id;
                $items[$row->id]['UserSignature'][$row->receivers_id]['UserReceiversid']=$row->UserReceiversid;
                $items[$row->id]['UserSignature'][$row->receivers_id]['ReceiversName']=$row->ReceiversName; 
                $items[$row->id]['UserSignature'][$row->receivers_id]['position']=$row->position;
                $items[$row->id]['UserSignature'][$row->receivers_id]['ReceiversEmail']=$row->ReceiversEmail;
                $items[$row->id]['UserSignature'][$row->receivers_id]['signing_rights']=$row->signing_rights;
                $items[$row->id]['UserSignature'][$row->receivers_id]['passwrod_is']=$row->Receiverspasswrod_is;
                $items[$row->id]['UserSignature'][$row->receivers_id]['Receiverspasswrod']=$row->Receiverspasswrod;
                $items[$row->id]['UserSignature'][$row->receivers_id]['status_approve']=$row->status_approve;
                $items[$row->id]['UserSignature'][$row->receivers_id]['signature_date']=$row->signature_date; 
                $items[$row->id]['UserSignature'][$row->receivers_id]['signature']=$row->signature;  
                $items[$row->id]['UserSignature'][$row->receivers_id]['signing_prefix']=$row->signing_prefix; 
                
                $items[$row->id]['UserSignature'][$row->receivers_id]['signing_type']=$row->signing_type;  
                $items[$row->id]['UserSignature'][$row->receivers_id]['createSigning_name']=$row->createSigning_name;   
                $items[$row->id]['UserSignature'][$row->receivers_id]['send_email']=$row->send_email;
                $items[$row->id]['UserSignature'][$row->receivers_id]['send_email_date']=$row->send_email_date;  
            } 
            if(!empty($row->comments_id)){
                $items[$row->id]['comments_list'][$row->comments_id]['comments_id']=$row->comments_id;
                $items[$row->id]['comments_list'][$row->comments_id]['comments_usersid']=$row->comments_usersid;  
                $items[$row->id]['comments_list'][$row->comments_id]['status_document']=$row->status_document; 
                $items[$row->id]['comments_list'][$row->comments_id]['comments_detail']=$row->comments_detail;  
                $items[$row->id]['comments_list'][$row->comments_id]['comments_created_at']=$row->comments_created_at; 
            }
        }      
        return $items;
    }

    public function upfileDocument(Request $request)
    {
        $validatedData = $request->validate(
            [  
                'topic_email'    => 'required', 'string', 'max:100',   
                'detail_email'   => 'required', 'string', 'max:255',    
                'file_upload'    => 'required', 
                'file_upload.*'  => 'mimes:pdf|max:50000',  
                'documentType'   => 'required',  
                'number'   => 'required',  
            ],
            [   
                'file_upload.required'=>' กรุณาอัพโหลดไฟล์เอกสารให้ถูกต้อง!',
                'file_upload.*.mimes'=>' กรุณาระบุไฟล์เป็น PDF เท่านั้น !',  
                'file_upload.*.max'=>' จำกัดขนาดไฟล์เอกสารไม่เกิน 30MB !',  
                'documentType.required' => 'กรุณาระบุรูปแบบการเซ็นของเอกสาร !', 
                'number.required' => 'กรุณาระบุเลขที่ !', 
            ]
        );    

        $code=""; $departmentCode=""; $number="";
        if($request){
            $sender_id=Auth::user()->id;  
            $check_code = DB::table('gen_code')
            ->where('gen_code.code', $request->number)
            ->where('gen_code.status', 2)
            ->count();
            if($check_code>0){
                return redirect()->route('create_document')->with('error', 'เลขที่เอกสารนี้ถูกใช้แล้ว !'); 
            } else {
                $check_code_1 = DB::table('gen_code')
                ->where('gen_code.code', $request->number)
                ->where('gen_code.status', 1)
                ->count();
                if($check_code_1>0){
                    $data=array( 
                        "status"   => 2, 
                    ); 
                    DB::table('gen_code')
                    ->where('gen_code.code', $request->number) 
                    ->update($data);
                    $explode1=explode(" ", $request->number);  
                    if(isset($explode1[1])){
                        $explode2=explode("/", $explode1[1]);  
                        if(isset($explode2)){
                            $number=$explode2[0];
                            $code=$explode1[0]." ".$explode2[0]."/".$explode2[1];
                            $departmentCode=$explode1[0];
                        }
                    }
                } else { 
                    $code=$request->number;  
                } 
            }
 
            $data=array(
                "number"          => $number,
                "document_code"   => $code,
                "department_code" => $departmentCode,
                "document_type"   => $request->documentType,
                "document_title"  => $request->topic_email,
                "document_detail"   => $request->detail_email, 

                "sender_id"       => $sender_id,
                "create_status"   => 1,
                 
                "created_at"      => new \DateTime(),   
            );    
            $last_id=DB::table('document_creates')->insertGetId($data);
            
            if(!empty($request->file('file_upload'))){
                $uploade_location = 'images/document-file/pdf_file/';  
                $index=2; $itmes=[];
                foreach($request->file('file_upload') as $key=>$row){
                    $file = $request->file('file_upload')[$key];
                    $file_gen = hexdec(uniqid());
                    $file_ext = strtolower($file->getClientOriginalExtension()); 
                    $file_name = "pdf_file-".$last_id."-".$file_gen.'.'.$file_ext;
                    //============ Data Insert =============// 
                    $file->move($uploade_location, $file_name);  
                    $itmes[$index]['document_id']   =  $last_id; 
                    $itmes[$index]['filename']      =  $file_name;  
                    $itmes[$index]['type']          =  "p";  
                    $itmes[$index]['created_at']    =  new \DateTime();
                    $index++;
                }
                DB::table('document_fileups')->insert($itmes); 
            }

            // if(!empty($request->file('file_upload_detail'))){
            //     $uploade_location = 'images/document-file/pdf_file/';  
            //     $index=2; $itmes=[];
            //     foreach($request->file('file_upload_detail') as $key=>$row){
            //         $file = $request->file('file_upload_detail')[$key];
            //         $file_gen = hexdec(uniqid());
            //         $file_ext = strtolower($file->getClientOriginalExtension()); 
            //         $file_name = "PDF-".$last_id."-".$file_gen.'.'.$file_ext;
            //         //============ Data Insert =============// 
            //         $file->move($uploade_location, $file_name);  
            //         $itmes[$index]['document_id']   =  $last_id; 
            //         $itmes[$index]['filename']      =  $file_name;  
            //         $itmes[$index]['type']          =  "p";  
            //         $itmes[$index]['created_at']    =  new \DateTime();
            //         $index++;
            //     } 
            //     DB::table('document_fileups')->insert($itmes); 
            // } 
            // $this->converterPDFToimg($last_id); // แปลงไฟล์จาก PDF TO images //
        } 

        return redirect()->route('create_receiver', [$last_id])->with('success', 'success'); 
    }

    public function userGet(Request $request)
    { 
        $users=[];
        if($request->users_id){
            // $users=DB::table('users')
            // ->where('users.id', $request->users_id) 
            // ->get();
            $users=User::find($request->users_id);
        }
        return $users;
    }
     
    public function actionFormReceiver(Request $request)
    {      
        $itmes=[];
        if(isset($request)){    
            if(isset($request->receiver)){ 
                DB::table('document_receivers')
                ->where('document_receivers.document_id', $request->document_id) 
                ->delete();
                foreach($request->receiver as $key=>$row){ 
                    $passwrod_is=2; $password_document=null;
                    if(isset($row['password_document_check'])){
                        $passwrod_is=1;
                    }
                    if(isset($row['password_document'])){
                        $password_document=$row['password_document'];
                    }    
                    if(!empty($row['users_id'])){
                        $itmes[$row['users_id']]['document_id']     =  $request->document_id; 
                        $itmes[$row['users_id']]['users_id']        =  $row['users_id']; 
                        $itmes[$row['users_id']]['signing_rights']  =  $row['receiver_customRadio'];
                        $itmes[$row['users_id']]['passwrod_is']     =  $passwrod_is;
                        $itmes[$row['users_id']]['passwrod']        =  $password_document;  
                        $itmes[$row['users_id']]['signing_prefix']        =  $row['signing_prefix'];  
                         
                        $itmes[$row['users_id']]['email']        =  $row['users_email']; 
                        $itmes[$row['users_id']]['position']     =  $row['users_position']; 
                        
                        $itmes[$row['users_id']]['created_at']    =  new \DateTime();  
                    }
                }  
                if(count($itmes)>0){
                    if(DB::table('document_receivers')->insert($itmes)){
                        $check=DB::table('document_creates')
                        ->where('document_creates.id', $request->document_id)
                        ->first();
                        if($check->create_status!=3){
                            $data=array( 
                                "create_status"   => 2, 
                            ); 
                            DB::table('document_creates')
                            ->where('document_creates.id', $request->document_id) 
                            ->update($data); 
                        }
                    }
                } else {
                    return redirect()->route('create_receiver', [$request->document_id])->with('error', 'กรุณาระบุชื่อผู้เซ็นเอกสาร!'); 
                }
            } 
        }
        return redirect()->route('confrim_document', [$request->document_id])->with('success', 'success'); 
    }

    public function actionFormSignature(Request $request)
    {
        if(isset($request)){    
            if(isset($request->list)){
                foreach($request->list as $key=>$row){
                    if($row['users_receiver']!=null){
                        $data=array(
                            "signing_position"   => $row['signaturePositionleft'].",".$row['signaturePositionTop'],
                            "area_size"          => $request->area_size, 
                            "updated_at"         => new \DateTime(),   
                        ); 
                        DB::table('document_receivers')
                        ->where('document_receivers.id', $row['users_receiver']) 
                        ->update($data);
                    }
                }
            }
        }
        return redirect()->route('confrim_document', [$request->document_id])->with('success', 'success'); 
    }

    // public function converterPDFToimg($get_id)
    // {
    //     $Query_file=DB::table('document_fileups')
    //     ->select('*')
    //     ->where('document_fileups.document_id', $get_id)
    //     ->where('document_fileups.deleted_at', NULL)
    //     ->where('document_fileups.convert', 'N')
    //     ->where('document_fileups.type', 'm')
    //     ->get();
            
    //     if(isset($Query_file)){
    //         foreach($Query_file as $row){
    //             Ghostscript::setGspath("C:\Program Files\gs\gs9.54.0\bin\gswin64c.exe");
    //             $pdf_file=public_path('images/document-file/pdf_tmp/'.$row->filename); 
    //             $pdf = new Pdf($pdf_file);  
    //             $pages = $pdf->getNumberOfPages(); 
    //             foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
    //                 $filename_new='img-'.$get_id.'-'.uniqid().'.png';
    //                 $pdf->setOutputFormat('png')->saveImage(public_path('images/document-file/img_tmp/'.$filename_new));
    //             }
    //             unlink(public_path('images/document-file/pdf_tmp/'.$row->filename));
    //             DB::table('document_fileups')->where('document_fileups.id', $row->id)
    //             ->update(['filename' => $filename_new]); 
                
    //             $Query_file_new=DB::table('document_fileups')->where('document_fileups.id', $row->id)->first(); 
    //             $img = Image::make(public_path('images/document-file/img_tmp/'.$Query_file_new->filename))
    //             ->resize(670,937);
    //             $img->save(public_path('images/document-file/img_tmp/'.$Query_file_new->filename));
    //         }
    //     } 
    //     return 'success';
    // }

    public function actionFormConfrim(Request $request)
    {  
        if(isset($request)){
            $data=array(
                "document_status"  => 1,
                "create_status"    => 3, 
                
                "created_at"         => new \DateTime(),     
            ); 
            DB::table('document_creates')
            ->where('document_creates.id', $request->document_id) 
            ->update($data); 
            return redirect()->route('documents_viwe', [$request->document_id])->with('info', 'ทำการสร้างเอกสารสำเร็จ กรุณาส่งข้อมูลไปยังอีเมลของผู้เซ็นให้ครบทุกคนตามลำดับการเซ็น.'); 
        } 
    }

    public function actionFormCloseDocument(Request $request)
    { 
        $validatedData = $request->validate(
            [    
                'note'   => 'required', 'string', 'max:255',     
            ],
            [  
                'note.required' => 'กรุณาระบุหมายเหตุ !',  
                'note.max'      => 'จำนวนตัวอักษรไม่เกิน 255 ตัวอักษร !',  
            ]
        );    
        $id=Auth::user()->id; 
        $data=array(
            "document_status"       => 4,
            "note"                  => trim($request->note),
            "users_closeducoment"   => $id,
            "updated_at"    => new \DateTime(),  
        );
        if(DB::table('document_creates')
        ->where('document_creates.id', $request->document_id) 
        ->update($data)){
            $row=DB::table('document_receivers') 
            ->select('document_receivers.id as id')
            ->where('document_receivers.document_id', $request->document_id) 
            ->where('document_receivers.users_id', $id) 
            ->first();  
            $row_dc=DB::table('document_creates') 
            ->leftJoin('users', 'document_creates.sender_id', '=', 'users.id')
            ->select('users.sender_email as sender_email')
            ->where('document_creates.id', $request->document_id) 
            ->first();  
            if(isset($row_dc->sender_email)){
                Mail::to($row_dc->sender_email)->send(new storeMail_sender($row->id));   
            }
        }

        $url="documents"; $url_get=3;
        if(isset($request->redirect_hid)){
            if($request->redirect_hid=="viwe_io"){ 
                $url="documents_io"; $url_get=2;
            }  
        } 
        return redirect()->route($url, [$url_get])->with('success', 'success'); 
    }

    public function actionFormCommentsDocument(Request $request)
    { 
        $id=Auth::user()->id; 
        if(isset($request)){
            $first=DB::table('document_receivers')
            ->select('document_receivers.id as rev_id')
            ->where('document_receivers.document_id', $request->document_id)
            ->where('document_receivers.users_id', $id)
            ->first();
            $data=array(
                "document_id"        => $request->document_id, 
                "receiver_id"        => $first->rev_id, 
                "users_id"           => $id, 
                "status_document"    => 1, 
                "detail"             => trim($request->mag), 
                "created_at"         => new \DateTime(),  
            ); 
            DB::table('document_comments')->insert($data); 
            $row_dc=DB::table('document_creates') 
            ->leftJoin('users', 'document_creates.sender_id', '=', 'users.id')
            ->select('users.sender_email as sender_email')
            ->where('document_creates.id', $request->document_id) 
            ->first();  
            if(isset($row_dc->sender_email)){
                Mail::to($row_dc->sender_email)->send(new storeMail_sender($first->rev_id));   
            }
        }
        return redirect()->route('documents_viwe', [$request->document_id])->with('success', 'ส่งกลับรายการแก้ไขสำเร็จ'); 
    }

    public function documentComments(Request $request)
    {  
        $html="";
        $id=Auth::user()->id;
        if(isset($request)){
            $data=DB::table('document_comments')
            ->leftJoin('users', 'document_comments.users_id', '=', 'users.id') 
            ->leftJoin('document_creates', 'document_comments.document_id', '=', 'document_creates.id') 
            ->select('document_comments.id as id', 'users.name as users_name', 
            'document_comments.status_document as status', 'document_comments.created_at as created_at',
            'document_comments.detail as detail', 'document_creates.sender_id as sender_id')
            ->where('document_comments.document_id', $request->document_id)
            ->where('document_comments.users_id', $request->user_id)
            ->get();

            // -------------------------- // 
            foreach($data as $row){
                $html.='<div class="msg-1 d-flex">';
                $html.='     <div class="mr-auto"> ';
                $html.='     ผู้ส่ง : '.$row->users_name;
                $html.='    </div>';
                $html.='    <div class="float-right"> ';
                
                if($row->status==1){
                    $html.='            <span class="badge badge-warning"> ';
                    $html.='            <i class="icon-hourglass"></i> รอการตอบรับ </span>';
                } else if($row->status==2){
                    $html.='            <span class="badge badge-success"> ';
                    $html.='            <i class="mdi mdi-file-eye"></i> อ่านแล้ว </span>';
                } 
                        
                $html.='        <span class="ml-2" style="font-size: 10px;"> '; 
                $html.= 'เมื่อ '.Carbon::parse($row->created_at)->diffForHumans();
                $html.='        </span> ';
                $html.='    </div> ';
                $html.='</div>';
                $html.='<div class="msg-2 d-flex">';
                $html.='    <div class="mr-auto"> ';
                $html.='        <span> <i class="icon-bubble"></i> </span> ';
                $html.='        <span>  '.$row->detail.' </span>';
                $html.='   </div>';

                if($id==$row->sender_id){
                    $html.='    <div class="ml-1">  ';
                    if($row->status==1){
                        $html.='       <a href="#" data-usersid="'.$request->user_id.'" id="btn-answer"> [คลิก] ตอบรับข้อความ </a>';  
                    } else if($row->status==2){
                        $html.=' <span class="text-success"> <i class="icon-check"></i> ตอบรับแล้ว </span>';  
                    }    
                }

                $html.='    </div>';
                $html.='</div>'; 
            } 
        }
        return $html;
    }

    public function documentComments_answer(Request $request)
    {  
        $result=0;
        if(isset($request)){
            $data1=array(
                "status_document" => 2,
                "updated_at"      => new \DateTime(),
            ); 
            DB::table('document_comments')
            ->where('document_comments.document_id', $request->document_id) 
            ->where('document_comments.users_id', $request->user_id) 
            ->update($data1);
            $data2=array(
                "document_status" => 3, 
            ); 
            if(DB::table('document_creates')
            ->where('document_creates.id', $request->document_id) 
            ->update($data2)){
                $result=200;
            }
        } 
        return $result;
    }

    public function documentComments_close(Request $request)
    {  
        if(isset($request)){
            if(DB::table('document_comments')
            ->where('document_comments.id', $request->comments_id)
            ->where('document_comments.document_id', $request->document_id)
            ->delete()){
                return "success";
            }
        }
    }
      
    public function closeDocument(Request $request)
    { 
        $data=[];
        if(isset($request)){
            if($request->status==1){
                $data=array(
                    "create_status" => 4,
                    "deleted_at"    => $request->status,  
                ); 
                if(DB::table('document_creates')
                ->where('document_creates.id', $request->id) 
                ->update($data)){
                    $data=array('status'=>200);
                }
            }
        }
        return $data;
    }

    public function datatableDocuments(Request $request)
    {    
        if ($request->ajax()) {   
            $user_id=Auth::user()->id;
            $keyword="";
            if(isset($request->code)){
                $keyword=' and `document_creates`.`document_code` like "%'.$request->code.'%"';
            }   
            if($request->get_id==1){
                $data=$this->documentQuery1($user_id, $keyword);
            }else if($request->get_id==2){
                $data=$this->documentQuery2($user_id, $keyword);
            }else if($request->get_id==3){
                $data=$this->documentQuery3($user_id, $keyword); 
            }else if($request->get_id==4){
                $data=$this->documentQuery4($user_id, $keyword);
            }else if($request->get_id==5){
                $data=$this->documentQuery5($user_id, $keyword);
            }else if($request->get_id==6){
                $data=$this->documentQuery6($user_id, $keyword);
            }else if($request->get_id==7){
                $data=$this->documentQuery7($user_id, $keyword);
            } 

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('document_code', function($row){   
                $status_approve=''; $span='';
                if(isset($row->status_approve)){
                    $status_approve=$row->status_approve;
                }
                if($status_approve==2){
                    $span='<span class="mr-1" style="color: #FFF;
                    background: #32c861;
                    padding: 0.1rem 0.2rem; 
                    border-radius: 0.25rem;font-size: 10px;"> <i class="icon-check"></i>  เซ็นแล้ว </span> ';
                }
                return $span.$row->document_code;
            })    
            ->addColumn('document_title', function($row){    
                if($row->document_status==1){
                    if($row->create_status==1){
                        return '<a href="'.url('create_receiver/'.$row->id).'">'.$row->document_title.'</a>';
                    } else if($row->create_status==2){
                        return '<a href="'.url('confrim_document/'.$row->id).'">'.$row->document_title.'</a>';
                    } else if($row->create_status==3){
                        return '<a href="'.url('documents_viwe/'.$row->id).'">'.$row->document_title.'</a>';
                    } else if($row->create_status==4){
                        return $row->document_title;
                    } 
                }else if($row->document_status==3){
                    if($row->create_status==4){
                        return $row->document_title;
                    } else {
                        return '<a href="'.url('documents_viwe/'.$row->id).'">'.$row->document_title.'</a>';
                    }
                } else {
                    return '<a href="'.url('documents_viwe/'.$row->id).'">'.$row->document_title.'</a>';
                }
            })   
            ->addColumn('userName', function($row){   
                return $row->userName;
            })  
            ->addColumn('document_status', function($row){   
                $document_status="";
                if($row->document_status==1){
                    if($row->create_status==3){
                        $document_status='<span class="badge badge-warning"><i class="icon-clock"></i>  รอดำเนินการ </span>';
                    }else if($row->create_status==4){
                        $document_status='<span class="badge badge-danger"><i class="icon-close"></i>  ยกเลิกเอกสาร </span>'; 
                    }else{
                        $document_status='<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> เอกสารยังไม่สมบูรณ์ </span>';
                    } 
                }else if($row->document_status==2){
                    $document_status='<span class="badge badge-success"><i class="icon-check"></i>  เสร็จสมบูรณ์ </span>'; 
                }else if($row->document_status==3){
                    if($row->create_status==3){
                        $document_status='<span class="badge badge-dark"><i class="icon-note"></i>  ส่งกลับ/แก้ไข </span>';  
                    }else if($row->create_status==4){
                        $document_status='<span class="badge badge-danger"><i class="icon-close"></i>  ยกเลิกเอกสาร </span>'; 
                    }  
                }else if($row->document_status==4){
                    $document_status='<span class="badge badge-danger"><i class="icon-close"></i>  ไม่อนุมัติเอกสาร </span>';  
                }
                return $document_status;
            })      
            ->addColumn('created_at', function($row){  
                $delete_box="";
                if(in_array($row->document_status, [1,3,4])){
                    if(in_array($row->create_status, [1,2,4])){
                        $delete_box='<div class="float-right"> <button type="button" class="btn btn-secondary waves-effect waves-light btn-xs" id="delete_all"
                        data-id="'.$row->id.'">
                        <i class="mdi mdi-delete-outline"></i> ลบ</button> </div>';
                    }
                } 
                return Carbon::parse($row->created_at)->diffForHumans().$delete_box;
            }) 
            ->rawColumns(['document_code', 'document_title', 'userName', 'document_status', 'created_at'])
            ->make(true);
        }
    }

    public function actionFormapprove(Request $request)
    {   
        $id=Auth::user()->id;
        $users=User::find($id); 
        if(isset($request)){ 

            if($request->hdf_typeSignature==1){
                if($request->customRadio=="Y"){ 
                    if($users->signature!=NULL){
                        $data=array(
                            "status_approve"=> 2,
                            "signing_type"  => $request->hdf_typeSignature,
                            "signing_name"  => $users->signature,  
                            "updated_at"         => new \DateTime(),    
                        );  
                    }
                }
                if(isset($request->signing_rights)){
                    if($request->signing_rights==2){
                        $data=array(
                            "status_approve"=> 2,
                            "signing_type"  => $request->hdf_typeSignature, 
                            "updated_at"         => new \DateTime(),    
                        );  
                    }
                }
            }else if($request->hdf_typeSignature==2){  
                $imagedata = base64_decode($request->signatureData_image);
                $filename = hexdec(uniqid()); 
                $file_name = 'images/signature/create_sing/'.$filename.'.png';
                file_put_contents($file_name, $imagedata); 
                $img = Image::make(public_path($file_name))->resize(280, 100);
                $img->save($file_name);
                $data=array(
                    "status_approve"=> 2,
                    "signing_type"  => $request->hdf_typeSignature,
                    "signing_name"  => $filename.'.png',  
                    "updated_at"         => new \DateTime(),    
                );  

            }else if($request->hdf_typeSignature==3){
                if(!empty($request->file('file_upload'))){
                    $uploade_location = 'images/signature/create_sing/';   
                    foreach($request->file('file_upload') as $key=>$row){
                        $file = $request->file('file_upload')[$key];
                        $file_gen = hexdec(uniqid());
                        $file_ext = strtolower($file->getClientOriginalExtension()); 
                        $file_name = "up-".$file_gen.'.'.$file_ext;
                        //============ Data Insert =============//  
                        $file->move($uploade_location, $file_name);  
                        $file_name_make = 'images/signature/create_sing/'.$file_name;
                        $img = Image::make(public_path($file_name_make))->resize(280, 100);
                        $img->save($file_name_make); 
                        $data=array(
                            "status_approve"=> 2,
                            "signing_type"  => $request->hdf_typeSignature,
                            "signing_name"  => $file_name, 
                            "updated_at"    => new \DateTime(),    
                        );  
                    } 
                }
            }

            DB::table('document_receivers')
            ->where('document_receivers.document_id', $request->document_id) 
            ->where('document_receivers.users_id', $id) 
            ->update($data);
            
            $row=DB::table('document_receivers') 
            ->select('document_receivers.id as id')
            ->where('document_receivers.document_id', $request->document_id) 
            ->where('document_receivers.users_id', $id) 
            ->first();  
            $row_dc=DB::table('document_creates') 
            ->leftJoin('users', 'document_creates.sender_id', '=', 'users.id')
            ->select('users.sender_email as sender_email')
            ->where('document_creates.id', $request->document_id) 
            ->first();  
            if(isset($row_dc->sender_email)){
                Mail::to($row_dc->sender_email)->send(new storeMail_sender($row->id));   
            }
        }

        $url="documents_viwe";
        if(isset($request->redirect_hid)){
            if($request->redirect_hid=="viwe_io"){ 
                $url="viwe_io";
            } 
        } 
        return redirect()->route($url, [$request->document_id])->with('success', 'success'); 
    }

    public function actionFormDocumentEdit(Request $request)
    {
        dd($request);
    }
    
    public function actionFormConfrimDocument(Request $request)
    {
       $Query_receivers = DB::table('document_receivers')
        ->select('document_receivers.id as id', 'document_receivers.status_approve as status_approve')
        ->leftJoin('document_creates', 'document_receivers.document_id', '=', 'document_creates.id')
        ->where('document_receivers.document_id', $request->document_id) 
        ->where('document_creates.deleted_at', NULL) 
        ->where('document_creates.document_status', 1) 
        ->where('document_receivers.signing_rights', 1) 
        ->groupBy('document_receivers.id')
        ->get();

        $receiversArr=[]; $receiversCount=count($Query_receivers);
        foreach($Query_receivers as $key=>$row){
            $receiversArr[] = $row->status_approve;
        }
        
        // echo count($receiversArr)." = ".$receiversCount." <br>";
        if(count($receiversArr)==$receiversCount){
            if(!in_array(1, $receiversArr)){
                // echo " ====>>> อนุมัติหมดทุกคน ";
                $data=array(
                    "document_status"=> 2,  
                    "updated_at"    => new \DateTime(),    
                );  
                DB::table('document_creates')
                ->where('document_creates.id', $request->document_id)  
                ->update($data);
                return redirect()->route('documents_viwe', [$request->document_id])->with('success', 'success'); 
            } else {
                // echo " ====>>> ยังมีคนที่ไม่อนุมัติ ";
                return redirect()->route('documents_viwe', [$request->document_id])->with('error', 'ผู้เซ็นเอกสารยังไม่ครบ! ไม่สามารถยืนยันการตรวจสอบเอกสารเสร็จสมบูรณ์ได้.'); 
            }
            // dd($receiversArr);
        }     
    }

    public function documentQuery1($user_id, $keyword)
    {
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status`
        
        from `document_creates` 
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_creates`.`sender_id` = '.$user_id.'
        and `document_creates`.`document_status` in (1,2,3,4)
        and `document_creates`.`create_status` = 3
        '.$keyword.' order by `document_creates`.`id` desc');
        return $data;
    }

    public function documentQuery2($user_id, $keyword)
    {
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status`
        
        from `document_receivers` 
        left join `document_creates` on `document_receivers`.`document_id` = `document_creates`.`id`  
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_receivers`.`users_id` = '.$user_id.'
        and `document_creates`.`document_status` in (1,3)
        and `document_creates`.`create_status` = 3
        and `document_receivers`.`status_approve` = 1
        and `document_receivers`.`send_email` = "Y"
        '.$keyword.' order by `document_creates`.`id` desc');
        return $data;
    }

    public function documentQuery3($user_id, $keyword)
    {
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status`,
        `document_receivers`.`status_approve` as `status_approve`
        
        from `document_receivers` 
        left join `document_creates` on `document_receivers`.`document_id` = `document_creates`.`id`  
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_receivers`.`users_id` = '.$user_id.' 
        and `document_receivers`.`status_approve` in (1,2,3,4)
        and `document_receivers`.`send_email` = "Y"
        '.$keyword.' order by `document_creates`.`id` desc'); 
        return $data;
    }


    public function documentQuery4($user_id, $keyword)
    {
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status` 
        
        from `document_creates` 
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_creates`.`sender_id` = '.$user_id.'
        and `document_creates`.`create_status` = 4
        '.$keyword.' order by `document_creates`.`id` desc');
        return $data;
    }

    public function documentQuery5($user_id, $keyword)
    { 
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status` 
        
        from `document_creates` 
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_creates`.`sender_id` = '.$user_id.'
        and `document_creates`.`create_status` in (1,2)
        '.$keyword.' order by `document_creates`.`id` desc');
        return $data;
    }

    public function documentQuery6($user_id, $keyword)
    { 
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status` 
        
        from `document_creates` 
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_creates`.`sender_id` = '.$user_id.'
        and `document_creates`.`document_status` = 3
        and `document_creates`.`create_status` = 3
        '.$keyword.' order by `document_creates`.`id` desc');
        return $data;
    }

    public function documentQuery7($user_id, $keyword)
    {
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status`,
        `document_receivers`.`status_approve` as `status_approve`
        
        from `document_receivers` 
        left join `document_creates` on `document_receivers`.`document_id` = `document_creates`.`id`  
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_receivers`.`users_id` = '.$user_id.'  
        and (`document_creates`.`created_at` BETWEEN "'.date('Y-m-d').' 00:00:00" AND "'.date('Y-m-d').' 23:59:59")
        and `document_receivers`.`status_approve` in (1,2,3,4)
        and `document_receivers`.`send_email` = "Y"
        '.$keyword.' order by `document_creates`.`id` desc'); 
        return $data;
    }
    

    public function actionFormEditDocument(Request $request)
    {
        $validatedData = $request->validate(
            [ 
                'topic_email'    => 'required', 'string', 'max:100',   
                'detail_email'   => 'required', 'string', 'max:255',   
            ]
        );    
 
        if($request){ 
            $data=array(  
                "document_title"    => $request->topic_email,
                "document_detail"   => $request->detail_email, 
                "document_status"   => 1,
                 
                "updated_at"      => new \DateTime(),   
            ); 
            DB::table('document_creates')
            ->where('document_creates.id', $request->document_id) 
            ->update($data);  
            
            if(!empty($request->file('file_upload'))){
                $uploade_location = 'images/document-file/pdf_file/';  
                $row=DB::table('document_fileups') 
                ->select('*')
                ->where('document_fileups.document_id', $request->document_id) 
                ->first();  
                DB::table('document_fileups')
                ->where('document_fileups.document_id', $request->document_id) 
                ->delete();
                unlink($uploade_location.$row->filename);
                $index=2; $itmes=[];
                foreach($request->file('file_upload') as $key=>$row){
                    $file = $request->file('file_upload')[$key];
                    $file_gen = hexdec(uniqid());
                    $file_ext = strtolower($file->getClientOriginalExtension()); 
                    $file_name = "pdf_file-".$request->document_id."-".$file_gen.'.'.$file_ext;
                    //============ Data Insert =============// 
                    $file->move($uploade_location, $file_name);  
                    $itmes[$index]['document_id']   =  $request->document_id; 
                    $itmes[$index]['filename']      =  $file_name;  
                    $itmes[$index]['type']          =  "p";  
                    $itmes[$index]['created_at']    =  new \DateTime();
                    $index++;
                }
                DB::table('document_fileups')->insert($itmes); 
            } 
        } 

        return redirect()->route('documents_viwe', [$request->document_id])->with('success', 'แก้ไขเอกสารสำเร็จ'); 
    }


    public function users_sendemail(Request $request)
    { 
        if(isset($request)){  
            $row=DB::table('document_receivers')
            ->select('*')
            ->where('document_receivers.document_id', $request->document_id) 
            ->where('document_receivers.users_id', $request->user_id) 
            ->first(); 
            $data=array(  
                "send_email"        => "Y",  
                "send_email_date"      => new \DateTime(),   
            ); 
            if(DB::table('document_receivers')
            ->where('document_receivers.id', $row->id) 
            ->update($data)){
                if(isset($row->email)){
                    Mail::to($row->email)->send(new storeMail($row->id));  
                }
            }
        }  
    }

 
    public function actionFormSendcomment(Request $request)
    {

        $validatedData = $request->validate(
            [ 
                'users_id_comments'        => 'required', 
            ],
            [  
                'users_id_comments.required'      => 'กรุณาระบุผู้รับข้อความ!',   
                'send_comments.required' => 'กรุณาระบุข้อมูล!',    
            ]
        );    
 
        $id=Auth::user()->id;
        if(isset($request)){
            $data=array(   
                "document_id"            => $request->document_id,    
                "sender_id"              => $id,  
                "receiver_id"            => $request->users_id_comments, 
                "detail"                 => $request->send_comments,   
                "status"                 => "N",   
                "created_at"   => new \DateTime(), 
            );  
            $last_id = DB::table('send_comments')->insertGetId($data);
            $row_comments=DB::table('send_comments') 
            ->leftJoin('users', 'send_comments.receiver_id', '=', 'users.id')
            ->select('users.sender_email as sender_email')
            ->where('send_comments.id', $last_id) 
            ->first(); 
            if(!empty($row_comments)){
                Mail::to($row_comments->sender_email)->send(new storeMail_comments($last_id));
            }  
        }
        return redirect()->route('documents_viwe', [$request->document_id])->with('success', 'ส่งข้อมูลสำเร็จ.'); 
    }

    public function actionFormFeedback(Request $request)
    { 
        $validatedData = $request->validate(
            [ 
                'mag_feedback'   => 'required', 'string', 
            ],
            [  
                'mag_feedback.required' => 'กรุณาระบุข้อมูลแสดงความคิด!',    
            ]
        );    
 
        $user_id=Auth::user()->id;
        if(isset($request)){
            $data=array(  
                "feedback"          => $request->mag_feedback,  
                "status"            => "Y",   
                "updated_at"   => new \DateTime(), 
            ); 
            DB::table('send_comments')
            ->where('send_comments.id', $request->send_comments_id) 
            ->where('send_comments.document_id', $request->document_id)
            ->where('send_comments.receiver_id', $user_id) 
            ->update($data);
            
            if(!empty($request->file('file_upload_feedback'))){
                $uploade_location = 'images/file_comments/';   
                $row_unlink=DB::table('send_comments') 
                ->select('*')
                ->where('send_comments.id', $request->send_comments_id) 
                ->where('send_comments.document_id', $request->document_id) 
                ->where('send_comments.receiver_id', $user_id) 
                ->first();  
                if(!empty($row_unlink->filename)){
                    unlink($uploade_location.$row_unlink->filename);
                }
                foreach($request->file('file_upload_feedback') as $key=>$row){
                    $file = $request->file('file_upload_feedback')[$key];
                    $file_gen = hexdec(uniqid());
                    $file_ext = strtolower($file->getClientOriginalExtension()); 
                    $file_name = $file_gen.'.'.$file_ext;
                    //============ Data Insert =============//  
                    $file->move($uploade_location, $file_name);   
                    $data=array( 
                        "filename"  => $file_name,  
                    );  
                    DB::table('send_comments')
                    ->where('send_comments.id', $request->send_comments_id) 
                    ->where('send_comments.document_id', $request->document_id) 
                    ->where('send_comments.receiver_id', $user_id) 
                    ->update($data);
                } 
            }
            $row_comments=DB::table('send_comments') 
            ->leftJoin('users', 'send_comments.sender_id', '=', 'users.id')
            ->select('users.sender_email as sender_email', 'send_comments.id as id')
            ->where('send_comments.id', $request->send_comments_id) 
            ->where('send_comments.document_id', $request->document_id)
            ->where('send_comments.receiver_id', $user_id) 
            ->first(); 
            if(!empty($row_comments)){
                Mail::to($row_comments->sender_email)->send(new storeMail_comments($row_comments->id));
            } 
        }
        return redirect()->route('documents_viwe', [$request->document_id])->with('success_feedback', 'แสดงความคิดเพิ่มเติมสำเร็จ.'); 
    }

    public function feedbackGet(Request $request)
    {  
        $data=[];
        if(isset($request)){
            $data=DB::table('send_comments')
            ->select('*')
            ->where('send_comments.id', $request->id) 
            ->where('send_comments.document_id', $request->document_id) 
            ->where('send_comments.receiver_id', $request->user_id) 
            ->get(); 
        }
        return $data;
    }

    public function run_numberCode(Request $request)
    {
        $number=0;
        if(isset($request)){
            
            $data=DB::table('document_creates')
            ->select('document_creates.number as runNumber', 'document_creates.document_code as document_code')
            ->where('document_creates.department_code', $request->code)  
            ->orderBy('document_creates.number', 'desc')  
            ->first(); 
           
            if(empty($data)){
                $number=1;
            }else {
                $explode = explode("/", $data->document_code); 
                $year=date('Y')+543;  
                if($year==intval($explode[1])){
                    $number=intval($data->runNumber)+1;
                } else {
                    $number=1;
                }
            }
        } 
        return $number;
    } 

    public function actionFormGenCode(Request $request)
    { 
        $number=0;
        if(isset($request)){ 
            
            $count=DB::table('gen_code')->select('*')->where('gen_code.dp_code', $request->val)->count('gen_code.id'); 
            $data_d=DB::table('department_codes')
            ->select('*')->where('department_codes.id', $request->val)->first(); 
            $year=date('Y')+543;
            $id=Auth::user()->id;
            if($count<=0){    
                $number=$data_d->name." 1/".$year; 
            }else {  
                $number=$data_d->name." ".($count+1)."/".$year;  
            } 
            $data=array(    
                "code"      => $number,   
                "dp_code"   => $request->val,   
                "users_id"  => $id,   
                "created_at" => new \DateTime(), 
            );  
            DB::table('gen_code')->insert($data);
        } 
        return $number;
    }

    public function datatableGen_code(Request $request)
    {    
        if ($request->ajax()) {   
            $data = DB::select('select *,gen_code.created_at as created_at, users.name as usersName
            from `gen_code` 
            left join `users` on `gen_code`.`users_id` = `users`.`id`  
            where `gen_code`.`dp_code` = '.$request->id.' 
            group by `gen_code`.`code`
            order by `gen_code`.`created_at` desc');
 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('code', function($row){   
                return $row->code;
            })    
            ->addColumn('users', function($row){    
                return $row->usersName;
            })   
            ->addColumn('status', function($row){   
                $status='';
                if($row->status==1){
                    $status='<span class="badge badge-warning"> รอนำไปใช้ </span>';
                }else if($row->status==2){
                    $status='<span class="badge badge-success"> นำไปใช้แล้ว </span>'; 
                }
                return $status;
            })   
            ->addColumn('created_at', function($row){   
                return Carbon::parse($row->created_at)->diffForHumans();
            }) 
            ->rawColumns(['code', 'users', 'status', 'created_at'])
            ->make(true);
        }
    }

    public function checkcode(Request $request)
    {
        $data=NULL;
        if(isset($request)){ 
            $check_code = DB::table('gen_code')
            ->where('gen_code.code', $request->code)
            ->where('gen_code.status', 2)
            ->count();
            if($check_code>0){
                $data="Y";
            } else {
                $data="N";
            }
        }
        return $data;
    }


    public function datatable_dashboard_comments(Request $request)
    { 
        if ($request->ajax()) {  
            $status=' and `send_comments`.`status` = "N"';
            $date_comments="";
            if(isset($request->status)){
                $status=' and `send_comments`.`status` = "'.$request->status.'"';
            }   

            if(isset($request->date_comments)){
                $date_comments='and (`send_comments`.`created_at` BETWEEN "'.$request->date_comments.' 00:00:00" AND "'.$request->date_comments.' 23:59:59")';
            }   
 
            $id=Auth::user()->id; 
            $data = DB::select('select document_creates.document_code as code, users.name as users, document_creates.id as id,
            send_comments.status as status, send_comments.created_at as created_at,
            send_comments.detail as title
            from `send_comments` 
            left join `document_creates` on `send_comments`.`document_id` = `document_creates`.`id`  
            left join `users` on `send_comments`.`sender_id` = `users`.`id`  
            where `send_comments`.`receiver_id` = '.$id.'  
            '.$status.' '.$date_comments.'
            group by `send_comments`.`id`
            order by `send_comments`.`created_at` desc');
 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('code', function($row){   
                return $row->code;
            })   
            ->addColumn('title', function($row){   
                return '<a href="'.url('documents_viwe/'.$row->id).'">'.$row->title.'</a>';;
            })    
            ->addColumn('users', function($row){    
                return $row->users;
            })   
            ->addColumn('status', function($row){   
                $status='';
                if($row->status=="Y"){
                    $status='<span class="badge badge-success"> ตอบรับแล้ว </span>';
                }else if($row->status=="N"){
                    $status='<span class="badge badge-warning"> รอการตอบรับ </span>'; 
                }
                return $status;
            })   
            ->addColumn('created_at', function($row){   
                return Carbon::parse($row->created_at)->diffForHumans();
            }) 
            ->rawColumns(['code', 'title', 'users', 'status', 'created_at'])
            ->make(true); 
        }
    }

    public function check_lineUserid(Request $request)
    {
        $result='';
        if(isset($request)){
            $id=Auth::user()->id; 
            $count=DB::table('users') 
            ->where('users.is_users', 1) 
            ->where('users.liff_usersid', '!=', null) 
            ->where('users.id', $id) 
            ->count(); 
            if($count>0){
                $result=1;
            } else {
                $result=2;
            }
        }
        return $result;
    }

    public function deleteDocument(Request $request)
    { 
        if(isset($request)){
            $row=DB::table('document_creates')
            ->select('*')
            ->where('document_creates.id', $request->document_id)   
            ->first(); 

            $count_gen_code=DB::table('gen_code') 
            ->where('gen_code.code', $row->document_code)   
            ->count();
            if($count_gen_code>0){
                DB::table('gen_code')
                ->where('gen_code.code', $row->document_code)
                ->delete();
            }
            
            $count_send_comments=DB::table('send_comments') 
            ->where('send_comments.document_id', $request->document_id)   
            ->count();
            if($count_send_comments>0){
                DB::table('send_comments')
                ->where('send_comments.document_id', $request->document_id)
                ->delete();
            }

            $count_document_comments=DB::table('document_comments') 
            ->where('document_comments.document_id', $request->document_id)   
            ->count();
            if($count_document_comments>0){
                DB::table('document_comments')
                ->where('document_comments.document_id', $request->document_id)
                ->delete();
            }

            $count_document_fileups=DB::table('document_fileups') 
            ->where('document_fileups.document_id', $request->document_id)   
            ->count();
            if($count_document_fileups>0){ 
                $uploade_location = 'images/document-file/pdf_file/';  
                $row_file=DB::table('document_fileups') 
                ->select('document_fileups.filename as filename')
                ->where('document_fileups.document_id', $request->document_id) 
                ->first();  
                DB::table('document_fileups')
                ->where('document_fileups.document_id', $request->document_id) 
                ->delete();
                unlink($uploade_location.$row_file->filename); 
            }
            
            if(!empty($row->id)){
                DB::table('document_creates')
                ->where('document_creates.id', $request->document_id)
                ->delete();

                $get_receivers=DB::table('document_receivers') 
                ->select('document_receivers.id as receiversID', 'document_receivers.signing_name as signing_name',
                'document_receivers.signing_type as signing_type')
                ->where('document_receivers.document_id', $request->document_id) 
                ->get();  
                foreach($get_receivers as $row_receivers){
                    if(!empty($row_receivers->signing_name)){
                        if($row_receivers->signing_type==1){
                            $uploade_location = 'images/signature/create_sing_user/';   
                        } else {
                            $uploade_location = 'images/signature/create_sing/';   
                        }
                        unlink($uploade_location.$row_receivers->signing_name); 
                    }
                    DB::table('document_receivers')
                    ->where('document_receivers.id', $row_receivers->receiversID)
                    ->delete();
                } 
            } 
        }

    }

    // =======================================================================================================================//
    
    public function documents_io($get_id){
        $id=Auth::user()->id;
        $users=User::find($id);  
        $title='<i class="fe-edit-1"></i> <span>  เอกสารที่ต้องเซ็น  </span>';
        $data = array(
            'users'  => $users,
            'title'  => $title,
            'get_id' => $get_id, 
        ); 
        return view('documents_io', compact('data'));
    }

    public function viwe_io($get_id){
        $id=Auth::user()->id;
        $users=User::find($id);
        $fileups=DB::table('document_fileups') 
        ->where('document_fileups.document_id', $get_id)
        ->where('document_fileups.deleted_at', NULL)
        ->where('document_fileups.type', 'p')
        ->get();   
        $check_users=DB::table('check_users')  
        ->where('check_users.users_id', $id) 
        ->count(); 
        $usersGet=DB::table('users')->where('users.id', '!=', $id)->where('users.deleted_at', 0)->get();    
        $data = array(
            'users'  => $users, 
            'get_id' => $get_id,
            'documentGet' => $this->documentGet_viwe($get_id),
            'fileups'     => $fileups,
            'usersGet'    => $usersGet,
            'check_users' => $check_users,
            'send_commentsGet' => $this->send_commentsGet($get_id),
        );    
        return view('viwe_io', compact('data'));
    }

    public function documentQuery3_io($user_id, $keyword)
    {
        $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
        `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
        `document_creates`.`document_status` as `document_status`, 
        `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status`,
        `document_receivers`.`status_approve` as `status_approve`
        
        from `document_receivers` 
        left join `document_creates` on `document_receivers`.`document_id` = `document_creates`.`id`  
        left join `users` on `document_creates`.`sender_id` = `users`.`id`  

        where `document_receivers`.`users_id` = '.$user_id.' 
        and `document_receivers`.`status_approve` in (1,2,3,4)
        and `document_receivers`.`send_email` = "Y"
        '.$keyword.' order by `document_creates`.`id` desc'); 
        return $data;
    }

    public function datatableDocuments_io(Request $request)
    {    
        if ($request->ajax()) {   
            $user_id=Auth::user()->id;
            $keyword="";
            if(isset($request->code)){
                $keyword=' and `document_creates`.`document_code` like "%'.$request->code.'%"';
            }  
            
            if($request->get_id==2){
                $data=$this->documentQuery2($user_id, $keyword);
            }else{
                $data=$this->documentQuery3_io($user_id, $keyword); 
            }  

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('document_code', function($row){   
                $status_approve=''; $span='';
                if(isset($row->status_approve)){
                    $status_approve=$row->status_approve;
                }
                if($status_approve==2){
                    $span='<span class="mr-1" style="color: #FFF;
                    background: #32c861;
                    padding: 0.1rem 0.2rem; 
                    border-radius: 0.25rem;font-size: 10px;"> <i class="icon-check"></i>  เซ็นแล้ว </span> ';
                }
                return $span.$row->document_code;
            })    
            ->addColumn('document_title', function($row){    
                if($row->document_status==1){
                    if($row->create_status==3){
                        return '<a href="'.url('viwe_io/'.$row->id).'">'.$row->document_title.'</a>';
                    } else {
                        return $row->document_title;
                    } 
                }else if($row->document_status==3){
                    if($row->create_status==4){
                        return $row->document_title;
                    } else {
                        return '<a href="'.url('viwe_io/'.$row->id).'">'.$row->document_title.'</a>';
                    }
                } else {
                    return '<a href="'.url('viwe_io/'.$row->id).'">'.$row->document_title.'</a>';
                }
            })   
            ->addColumn('userName', function($row){   
                return $row->userName;
            })  
            ->addColumn('document_status', function($row){   
                $document_status="";
                if($row->document_status==1){
                    if($row->create_status==3){
                        $document_status='<span class="badge badge-warning"><i class="icon-clock"></i>  รอดำเนินการ </span>';
                    }else if($row->create_status==4){
                        $document_status='<span class="badge badge-danger"><i class="icon-close"></i>  ยกเลิกเอกสาร </span>'; 
                    }else{
                        $document_status='<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> เอกสารยังไม่สมบูรณ์ </span>';
                    } 
                }else if($row->document_status==2){
                    $document_status='<span class="badge badge-success"><i class="icon-check"></i>  เสร็จสมบูรณ์ </span>'; 
                }else if($row->document_status==3){
                    if($row->create_status==3){
                        $document_status='<span class="badge badge-dark"><i class="icon-note"></i>  ส่งกลับ/แก้ไข </span>';  
                    }else if($row->create_status==4){
                        $document_status='<span class="badge badge-danger"><i class="icon-close"></i>  ยกเลิกเอกสาร </span>'; 
                    }  
                }else if($row->document_status==4){
                    $document_status='<span class="badge badge-danger"><i class="icon-close"></i>  ไม่อนุมัติเอกสาร </span>';  
                }
                return $document_status;
            })      
            ->addColumn('created_at', function($row){  
                return Carbon::parse($row->created_at)->diffForHumans();
            }) 
            ->rawColumns(['document_code', 'document_title', 'userName', 'document_status', 'created_at'])
            ->make(true);
        }
    }
 
}
