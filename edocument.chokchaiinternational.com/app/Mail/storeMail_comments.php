<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class storeMail_comments extends Mailable
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
        $data=$this->Query_sendComments($id);    
        return $this->subject('แจ้งเตือนความคิดเห็นเพิ่มเติม ประจำวันที่ '.date('Y/m/d'))
        ->view('email.Mail_comments', compact('data'));
    }

    public function Query_sendComments($id)
    { 
        $data=DB::table('send_comments')
        ->leftJoin('users as sender', 'send_comments.sender_id', '=', 'sender.id')
        ->leftJoin('users as receiver', 'send_comments.receiver_id', '=', 'receiver.id')
        ->select('send_comments.id as id', 'sender.id as senderId', 'sender.name as senderName', 'receiver.name as receiverName',
        'receiver.id as receiverId', 'receiver.sender_email as receiverEmail', 
        'send_comments.detail as detail', 'send_comments.feedback as feedback', 'send_comments.filename as filename',
        'send_comments.status as status', 'send_comments.created_at as created_at', 'send_comments.updated_at as updated_at',
        'send_comments.document_id as document_id', 'sender.sender_email as senderEmail',
        'receiver.liff_usersid as receiver_liffID', 'sender.liff_usersid as sender_liffID')

        ->where('send_comments.id', $id)
        ->where('send_comments.deleted_at', NULL)->first();  
        if($data->receiver_liffID!="" && $data->sender_liffID!=""){
            $toppic=""; $liffUsersid=null;  $name=""; $detail=""; $email="";
            if($data->status=="N"){
                $liffUsersid=$data->sender_liffID;
                $toppic="แจ้งเตือนการขอความคิดเห็นเพิ่มเติม"; 
                $detail=$data->detail;
                $name=$data->senderName;
                $email=$data->senderEmail;
            } else if($data->status=="Y"){ 
                $liffUsersid=$data->receiver_liffID;
                $toppic="แจ้งเตือนการแสดงความคิดเห็น";  
                $detail=$data->feedback;
                $name=$data->receiverName;
                $email=$data->receiverEmail;
            }  

            $url="login?username=".$email."&feedback=".$data->document_id;
 
            $this->lineNotification($liffUsersid, $toppic, $detail, $name, $email, $url);
        }
 
        
        return $data;
    }


    public function lineNotification($liffUsersid, $toppic, $detail, $name, $email, $url)
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
                                "text": "จาก '.$name.'",
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
                                "text": "อีเมล : '.$email.'",
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
