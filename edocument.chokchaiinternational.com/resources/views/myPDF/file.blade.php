<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title> เอกสารเลขที่ {{$data['first']->document_code}} </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
 
        body {
            font-family: "THSarabunNew";
            font-size: 20px;
            color: #000;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 0;
        }
        .table-bordered {
            border: 0;
        }  
        .line-height {line-height: 1;}
    </style>
</head>
<body>

  <div class="container"> 
    <div style="margin-top: 10px">
        <table class="table table-bordered">
            <tr>
                <td class="text-center"> -2- </td>
            </tr>
            <tr>
                <td>
                    <div class="line-height"> เลขที่ {{$data['first']->document_code}} </div>
                    <div class="line-height"> เรื่อง {{$data['first']->document_title}} </div>
                </td>
            </tr> 
        </table> 


        <table class="table table-bordered" style="margin-top: 50px"> 
                @if(isset($data['documentGet']))
                    <?php 
                        $n=1; 
                        $count=count($data['documentGet']); 
                        $txt=""; 
                    ?>
                    @foreach($data['documentGet'] as $row) 
                        @if($row->signing_rights==1)
                        <?php 
                            if($n==1){
                                echo '<tr>';
                            }
                        ?>
                            <td class="text-center" style="width: 50%;"> 
                                <div style="border: 1px solid #000; padding: 1rem 2rem;">
                                    <div style="position: relative; top: 30px; left: 45px;"> 
                                        @if($row->signing_type==1) 
                                            <img src="{{ public_path('images/signature/create_sing_user/'.$row->signing_name) }}" alt="" height="50"> 
                                        @else
                                            <img src="{{ public_path('images/signature/create_sing/'.$row->signing_name) }}" alt="" height="50">  
                                        @endif
                                    </div>
                                    <?php   
                                        if($row->signing_prefix==1){
                                            $txt="ลงชื่อเพื่อทราบ";
                                        } else if($row->signing_prefix==2){
                                            $txt="ลงชื่อเพื่ออนุมัติ";
                                        } 
                                    ?>
                                    <div> {{$txt}} ...................................................... </div> 
                                    <div class="line-height"> ( {{$row->usersname}} ) </div> 
                                    <div class="line-height"> {{$row->position}} </div> 
                                    <div class="line-height"> 
                                        <div style="line-height: 1;"><?php echo date("d / m / Y", strtotime($row->updated_at)); ?> </div>
                                        <div style="line-height: 0;"> .................................  </div>
                                    </div> 
                                </div>
                            </td>
                        <?php 
                            if($count==1){
                                
                            } else {
                                if($n==2){
                                    echo '</tr>';
                                    $n=1;
                                }  else {
                                    $n++;
                                }
                            } 
                        ?>
                        @endif
                    @endforeach
                @endif  
        </table> 
    </div>


  </div>
</body>
</html>