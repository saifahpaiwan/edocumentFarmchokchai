<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Hash;
use DataTables; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\storeMail_approveUsers;


class RequestaccessController extends Controller
{

    public function mg_document(){  
        $id=Auth::user()->id; 
        $row=DB::table('check_users') 
        ->select('check_users.check as check')
        ->where('check_users.users_id', $id) 
        ->first();  
        // $data_ii=array(
        //     "updated_at"         => new \DateTime(),     
        // );  
        // DB::table('check_users')
        // ->where('check_users.users_id', $id) 
        // ->update($data_ii);
        if(isset($row->check)){
            $check=$row->check;
        } else {
            $check="U";
        }

        $data = array('check' => $check);
        return view('mg_document', compact('data'));
    } 
    public function mg_users(){  
        $data = array();
        return view('mg_users', compact('data'));
    } 
     
    public function register_users(Request $request)
    { 
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'position' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);   
        $message="";
        $data=array(
            'name'  => $request->name,
            'email' => $request->email,
            'sender_email' => $request->email,
            'position' => $request->position,
            'password' => Hash::make($request->password),
            'is_users' => 2,
            'phone'    => $request->phone,
            
            "created_at"      => new \DateTime(),  
        ); 
        if(DB::table('users')->insert($data)){
            $message="คุณ ".$request->name." ตำแหน่ง : ".$request->position." ขอเข้าใช้งานระบบเอกสารออนไลน์ **";
            $this->notify_message($message);
            return redirect()->route('register')->with('success', 'ลงทะเบียนขอเข้าใช้งานสำเร็จ โปรดรอ Admin อนุมัติการเข้าใช้งาน');
        } 
    }

    function notify_message($message){
        define('LINE_API',"https://notify-api.line.me/api/notify?");
        $token = "6gvwYbFOTehrWnkKdiVnASZ9OJ0cpGjp6xXqRXP72d5";  
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData,'','&');
        $headerOptions = array( 
                'http'=>array(
                  'method'=>'POST',
                  'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                          ."Authorization: Bearer ".$token."\r\n"
                          ."Content-Length: ".strlen($queryData)."\r\n",
                  'content' => $queryData
                ),
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents(LINE_API,FALSE,$context);
    }

    public function datatableDocuments_all(Request $request)
    {      
        if ($request->ajax()) {    
            $keyword=""; $status=""; $date=""; $users="";
            if(isset($request->code)){
                $keyword=' and `document_creates`.`document_code` like "%'.$request->code.'%"';
            }   
            if(isset($request->users)){
                $users=' and `users`.`name` like "%'.$request->users.'%"';
            }   
            if(isset($request->status)){
                if($request->status==1){
                    $status=' and `document_creates`.`document_status` = 1  and `document_creates`.`create_status` = 3 ';
                }else if($request->status==2){
                    $status=' and `document_creates`.`document_status` = 2 and `document_creates`.`create_status` = 3';
                }else if($request->status==3){
                    $status=' and `document_creates`.`document_status` = 3 and `document_creates`.`create_status` = 3';
                }else if($request->status==4){
                    $status=' and `document_creates`.`document_status` = 1 and `document_creates`.`create_status` = 4';
                }else if($request->status==5){
                    $status=' and `document_creates`.`document_status` = 4 and `document_creates`.`create_status` = 4';
                }else if($request->status==6){
                    $status=' and `document_creates`.`document_status` = 1 and `document_creates`.`create_status`in (1,2)';
                } 
            }   
            if(isset($request->date)){
                $date='and (`document_creates`.`created_at` BETWEEN "'.$request->date.' 00:00:00" AND "'.$request->date.' 23:59:59")';
            }   
  
            $data = DB::select('select `document_creates`.`id` as `id`, `document_creates`.`document_code` as `document_code`,
            `document_creates`.`document_title` as `document_title`, `users`.`name` as `userName`, 
            `document_creates`.`document_status` as `document_status`, 
            `document_creates`.`created_at` as `created_at`, `document_creates`.`create_status` as `create_status`
            
            from `document_creates` 
            left join `users` on `document_creates`.`sender_id` = `users`.`id`  
     
            where `users`.`is_users` = 1
            
            '.$keyword.' '.$date.' '.$status.' '.$users.' order by `document_creates`.`id` desc');
              

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('document_code', function($row){   
                return $row->document_code;
            })    
            ->addColumn('document_title', function($row){      
                return '<a href="'.url('documents_viwe/'.$row->id).'">'.$row->document_title.'</a>';;
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
                        $document_status='<span style="background: #607d8b;"  class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> เอกสารยังไม่สมบูรณ์ </span>';
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
            ->addColumn('date', function($row){   
                return '<div class="text-center">'.date("d/m/Y", strtotime($row->created_at)).'</div>';
            })   
            ->addColumn('created_at', function($row){   
                return Carbon::parse($row->created_at)->diffForHumans();
            }) 
            ->rawColumns(['document_code', 'document_title', 'userName', 'document_status', 'created_at', 'date'])
            ->make(true);
        }
    }

    public function datatableUsers_all(Request $request)
    {     
        if ($request->ajax()) {    
            $keyword="";
            if(isset($request->name)){
                $keyword=' where `users`.`name` = "'.$request->name.'"';
            }   
            $data = DB::select('select * from `users` where `users`.`is_users` = 2 '.$keyword.' order by `users`.`created_at` desc');

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){   
                return $row->id;
            })    
            ->addColumn('name', function($row){    
                return $row->name;
            })   
            ->addColumn('email', function($row){   
                return $row->email;
            })  
            ->addColumn('position', function($row){   
                return $row->position;
            }) 
            ->addColumn('phone', function($row){   
                return $row->phone;
            })
            ->addColumn('button', function($row){  
                $html='<button type="button" class="btn btn-sm btn-success btn-rounded width-md waves-effect waves-light" id="btnUsers" data-id="'.$row->id.'"> 
                    <span class="txtapp-'.$row->id.'"><i class="mdi mdi-gesture-tap"></i> อนุมัติเข้าใช้</span>
                </button>';
                return $html;
            })
            ->addColumn('created_at', function($row){   
                return Carbon::parse($row->created_at)->diffForHumans();
            }) 
            ->rawColumns(['id', 'name', 'email', 'position', 'phone', 'created_at', 'button'])
            ->make(true);
        }
    }

    public function approveUsers(Request $request)
    { 
        if(isset($request)){
            $data=array(
                "is_users"  => 1, 
                "updated_at"         => new \DateTime(),     
            );  
            DB::table('users')
            ->where('users.id', $request->id) 
            ->update($data);

            $row=DB::table('users')  
            ->select('users.sender_email as sender_email')
            ->where('users.id', $request->id) 
            ->first();
            Mail::to($row->sender_email)->send(new storeMail_approveUsers($request->id)); 
        }
        return "success";
    }


    public function line_app()
    {
        $get=DB::table('users')  
        ->select('*') 
        ->where('users.is_users', 1) 
        ->get(); 
        foreach($get as $row){ 
            $this->lineNotification($row->liff_usersid);
        }


    }

    public function lineNotification($liffUsersid)
    {    
        $flexDataJson = '{
            "type": "flex",
            "altText": "Flex Message",
            "contents": {
                "type": "carousel",
                "contents": [{
                    
                    "type": "bubble", 
                    "hero": {
                        "type": "image",
                        "url": "https://ci6.googleusercontent.com/proxy/20wdSWfWzRXgzY_KyOxMVEGMxl9zsEz3-mW2fZfxSnQyHBjZP9ErbHEZc9Z1dRANcIxjzMAgZB4_mI3EbrZqBPucWm_9P09BGJ8XdXknEV4psMzNkmjyHHE2NQ=s0-d-e1-ft#https://www.chokchaisteakhouse.com/asset/images/front/banner/Logo-01.png",
                        "align": "center",
                        "gravity": "center",
                        "size": "xl",
                        "aspectRatio": "20:15",
                        "action": {
                          "type": "uri",
                          "label": "Line",
                          "uri": "https://linecorp.com/"
                        }
                      },
                    "body": {
                        "type": "box",
                        "layout": "vertical",
                        "spacing": "sm",
                        "contents": [  
                            {
                                "type": "box",
                                "layout": "vertical",
                                "contents": [{
                                "type": "text",
                                "text": "แบบสอบถามการใช้งานโปรแกรมเอกสารออนไลน์", 
                                "size": "md",
                                "weight": "bold",
                                "color": "#790101",
                                "wrap": true
                            },
                            {
                                "type": "text",
                                "text": "กรุณาทำเครื่องหมายเลือกในช่องที่ต้องการ",
                                "margin": "xl",
                                "contents": []
                            } 
                        ]
                    }
                ]
            },
                "footer": {
                    "type": "box",
                    "layout": "vertical",
                    "spacing": "sm",
                    "contents": [{
                        "type": "button",
                        "action": {
                            "type": "uri",
                            "label": "ทำแบบสอบถาม",
                            "uri": "https://forms.gle/hKVL9UkWKT2ZcYov9"
                        },
                        "color": "#F05A22",
                        "style": "primary"
                    }]
                }
            }]
            }
        }';

        $flexDataJsonDeCode = json_decode($flexDataJson,true);
        $datas['url'] = "https://api.line.me/v2/bot/message/push";
        $datas['token'] = "QUI9+kj0tT7Ldn7gPOIiQlPBddsfMv3c/a97RGfhbk6jaZs37iTbTzkCa0bX6v/Q3Qr6+Ah3dwZ5tjbgP1oEpctx5UrKoWigVk5sPeglgugp1hQIybarcxbwaRYJ0Ek6wqgfaRfTLWbUFphbJJDkcAdB04t89/1O/w1cDnyilFU=";
        $messages['to'] = "U505819e66b7a3cccc7264707f9fe98c5";
        $messages['messages'][] = $flexDataJsonDeCode;
        $encodeJson = json_encode($messages);
        $this->sentMessage($encodeJson,$datas); 
    } 


    function sentMessage($encodeJson,$datas)
	{
		$datasReturn = [];
      	$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $datas['url'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $encodeJson,
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".$datas['token'],
            "cache-control: no-cache",
            "content-type: application/json; charset=UTF-8",
          ),
        ));

        $response = curl_exec($curl); 
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $err;
        } else {
            if($response == "{}"){
                $datasReturn['result'] = 'S';
                $datasReturn['message'] = 'Success';
            }else{
                $datasReturn['result'] = 'E';
                $datasReturn['message'] = $response;
            }
        }
        dd($datasReturn);
        return $datasReturn;
	}
    
}
