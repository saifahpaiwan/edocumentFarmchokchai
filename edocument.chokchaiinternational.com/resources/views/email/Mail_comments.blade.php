<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title>edocument.chokchaiinternational</title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding: 20px 0 20px 0;background:#333;">
                <img src="https://www.chokchaisteakhouse.com/asset/images/front/banner/Logo-01.png" alt="" width="130" style="height:auto;display:block;" />
                <div style="padding-top: 10px;color: #fff;"> edocument.chokchaiinternational </div> 
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
                    <h1 style="font-size:20px;margin:0 0 5px 0;font-family:Kanit;"> 
                      @if($data->status=="N")
                        <span> แจ้งเตือนการขอความคิดเห็นเพิ่มเติม </span>
                      @elseif($data->status=="Y")
                        <span> แจ้งเตือนการแสดงความคิดเห็น </span>
                      @endif 
                    </h1>
                    <h1 style="font-size:20px;margin:0 0 5px 0;font-family:Kanit;"> 
                      @if($data->status=="N")
                        <span> จาก {{ $data->senderName }}  </span>
                      @elseif($data->status=="Y")
                        <span> จาก {{ $data->receiverName }}  </span>
                      @endif  
                    </h1> 
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Kanit;text-indent: 1.5em;">  
                      @if($data->status=="N")
                        <span> {{ $data->detail }}  </span>
                      @elseif($data->status=="Y")
                        <span> {{ $data->feedback }}  </span>
                      @endif  
                    </p>  
                    <?php  
                      $email="";
                      if($data->status=="N"){
                        $email=$data->receiverEmail;
                      } else if($data->status=="Y"){
                        $email=$data->senderEmail;
                      }
                    ?>
                    <a href="https://edocument.chokchaiinternational.com/login?username={{ $email }}&feedback={{ $data->document_id }}" style="color: #ffffff;
                      text-decoration: underline;
                      padding: 0.5rem 1rem;
                      border: 1px solid #f44336;
                      border-radius: 0.25rem;
                      background: #f44336;"> ดูรายละเอียดเพิ่มเติม </a>
                  </td>
                </tr>
                 
              </table>
              <div style="font-family:Kanit;"> 
                @if($data->status=="N")
                  <span> เมื่อ {{Carbon\Carbon::parse($data->created_at)->diffForHumans()}}  </span>
                @elseif($data->status=="Y")
                  <span> เมื่อ {{Carbon\Carbon::parse($data->updated_at)->diffForHumans()}}  </span>
                @endif   
              </div>
              <div style="font-family:Kanit;"> 
                <span> อีเมล : {{ $email }}  </span>    
              </div> 
            </td>
          </tr>
          <tr>
            <td style="padding:30px;background:#333;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Kanit;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Kanit;color:#ffffff;">
                      &reg; Copyright ©2021 All Rights Reserved by .chokchaiinternational
                    </p>
                  </td>
                   
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>