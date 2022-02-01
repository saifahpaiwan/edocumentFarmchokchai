<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class storeMail_sender extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id; 
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {     
        $id=$this->id;
        $data=$this->Query_document($id);    
        return $this->subject('แจ้งเตือนการเซ็นเอกสาร ประจำวันที่ '.date('Y/m/d'))
        ->view('email.Mail_sender', compact('data'));
    }

    public function Query_document($id)
    {
        $data = DB::table('document_receivers')
        ->leftJoin('users', 'document_receivers.users_id', '=', 'users.id')
        ->leftJoin('document_creates', 'document_receivers.document_id', '=', 'document_creates.id') 
        ->leftJoin('users as sender', 'document_creates.sender_id', '=', 'sender.id')
        ->select('document_creates.document_title as document_title', 'document_creates.document_detail as document_detail',
        'users.name as name', 'document_receivers.email as email', 'document_receivers.position as position', 
        'document_receivers.updated_at as updated_at', 'document_receivers.status_approve as status_approve', 
        'document_creates.document_status as document_status',
        'sender.liff_usersid as sender_liffID', 'sender.name as senderName')
        ->where('document_receivers.id', $id)
        ->where('document_creates.create_status', 3) 
        ->where('document_creates.deleted_at', NULL) 
        ->first(); 

        if(!empty($data->sender_liffID)){
            $toppic=""; $liffUsersid=null;  $name=""; $detail=""; $email=""; 
            if($data->status_approve==2){
              $detail="คุณ ".$data->name." ได้ทำการอนุมัติการเซ็น ".$data->document_title." เรียบร้อยแล้ว"; 
            }
            
            if($data->document_status==1 && $data->status_approve==1){
              $detail="คุณ ".$data->name." ได้ทำการส่งกลับ/แก้ไขเอกสาร ".$data->document_title." กรุณาตรวจสอบข้อมูลเอกสาร!"; 
            }
            
            if($data->document_status==4){
              $detail="คุณ ".$data->name." ได้ทำการไม่อนุมัติเอกสาร ".$data->document_title." กรุณาตรวจสอบข้อมูล และยกเลิกเอกสาร!"; 
            }
            
            $liffUsersid=$data->sender_liffID;
            $toppic= "แจ้งเตือนการเซ็นเอกสาร";  
            $name=$data->name;
            $sender=$data->senderName; 
            $url="login?username=".$data->email; 
            $this->lineNotification($liffUsersid, $toppic, $detail, $name, $sender, $url);
        }

        return $data;
    }

    public function lineNotification($liffUsersid, $toppic, $detail, $name, $sender, $url)
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
                                "text": "'.$toppic.'", 
                                "size": "md",
                                "weight": "bold",
                                "color": "#790101",
                                "wrap": true
                            },
                            {
                                "type": "text",
                                "text": "ผู้เซ็นเอกสาร '.$name.'",
                                "weight": "bold",
                                "contents": []
                            },
                            {
                                "type": "text",
                                "text": "'.$detail.'",
                                "align": "start",
                                "margin": "md",
                                "wrap": true,
                                "style": "italic",
                                "contents": []
                            },
                            {
                                "type": "text",
                                "text": "ผู้สร้างเอกสาร : '.$sender.'",
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
                            "label": "ล็อกอิน",
                            "uri": "https://edocument.chokchaiinternational.com/'.$url.'"
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
        $messages['to'] = $liffUsersid;
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

        return $datasReturn;
	}

}
