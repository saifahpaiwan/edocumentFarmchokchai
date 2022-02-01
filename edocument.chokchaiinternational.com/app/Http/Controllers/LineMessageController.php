<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class LineMessageController extends Controller
{

    public function registerNotification()
    { 
        return view('auth.registerNotification');
    }

    public function check_liff(Request $request)
    {
        $data=null;
        if(isset($request)){
            $count=DB::table('users') 
            ->where('users.is_users', 1) 
            ->where('users.liff_usersid', $request->liff_usersid) 
            ->count(); 
            if($count>0){
                $data=2;
            } else {
                $data=1;
            }
        }
        return $data; 
    }

    public function liffNotification(Request $request)
    { 
        $validatedData = $request->validate(
            [  
                'email'    => 'required', 'email', 
            ]
        );    

        if(isset($request)){
            $msg=0;
            $count=DB::table('users') 
            ->where('users.is_users', 1) 
            ->where('users.email', $request->email) 
            ->count(); 
            if($count>0){
                $first=DB::table('users')
                ->select('users.liff_usersid as liff_usersid', 'users.email as email')
                ->where('users.is_users', 1) 
                ->where('users.email', $request->email) 
                ->first(); 
                if($first->liff_usersid==""){ 
                    $data=array( 
                        "liff_usersid" => $request->liff_usersid, 
                    ); 
                    DB::table('users')
                    ->where('users.is_users', 1) 
                    ->where('users.email', $request->email) 
                    ->update($data); 
                    $msg=1;
                } 
            } else {
                $msg=0;
            }
        }
        return redirect()->route('registerNotification')->with('info', $msg); 
    }
 
    public function test_line()
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
                                "text": "แจ้งเตือนการแสดงความคิดเห็น", 
                                "size": "md",
                                "weight": "bold",
                                "color": "#790101",
                                "wrap": true
                            },
                            {
                                "type": "text",
                                "text": "จาก มาร์คสักเบิก",
                                "weight": "bold",
                                "contents": []
                            },
                            {
                                "type": "text",
                                "text": "ขออนุมัติค่าใช้จ่ายยิงแอด Page Umm!..Milk ขายสินค้าออนไลน์ ผ่าน Inter Express",
                                "align": "start",
                                "margin": "md",
                                "wrap": true,
                                "style": "italic",
                                "contents": []
                            },
                            {
                                "type": "text",
                                "text": "อีเมล : dev.saifah8953@gmail.com",
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
                            "uri": "https://edocument.chokchaiinternational.com/"
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
        $messages['to'] = "U16fdad997d36061c99ca8a42518897e9";
        $messages['messages'][] = $flexDataJsonDeCode;
        $encodeJson = json_encode($messages);
        $data=$this->sentMessage($encodeJson,$datas);
        echo '<pre>'; print_r($data);
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
        // dd($response);
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
