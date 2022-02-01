<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;  
use Image;

class HomeController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth');
    }
 
    // public function Intervention()
    // {    
    //    Image::configure(array('driver' => 'imagick')); 
    //     // and you are ready to go ...
    //     $image = Image::make('public/foo.jpg')->resize(300, 200);
    // } 
  
    public function profile(){   
        $id=Auth::user()->id;
        $users=User::find($id);   
        $data = array(
            'users' => $users,
        );
        return view('profile', compact('data'));
    } 
     
    function updateUsers(Request $request)
    {  
        if(isset($request)){
            $id=Auth::user()->id;
            if($request->hdf_typeSignature==1){
                $validatedData = $request->validate([
                    'name' => ['required', 'string', 'max:255'], 
                    'email' => ['required', 'string', 'max:100'],  
                    'position' => ['required', 'string', 'max:100'],   
                    'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:10'], 
                ]);  
                $data=array(
                    'name'         => $request->name, 
                    'sender_email' => $request->email, 
                    'position'     => $request->position, 
                    'phone'        => $request->phone,
                    'is_users'     =>  1, 

                    "updated_at"         => new \DateTime(),    
                );  
            } else if($request->hdf_typeSignature==2){ 
                $validatedData = $request->validate([
                    'name' => ['required', 'string', 'max:255'], 
                    'email' => ['required', 'string', 'max:100'],  
                    'position' => ['required', 'string', 'max:100'],   
                    'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:10'],  
                    'output' => ['required']
                ],
                [  
                    'output.required' => 'กรุณาระบุลายเซ็นอิเล็กทรอนิกส์ !',    
                ]);  

                $row=DB::table('users')->select('*')->where('users.id', $id)->first();   
                if(!empty($row->signature)){
                    unlink('images/signature/create_sing_user/'.$row->signature);
                }

                $imagedata = base64_decode($request->signatureData_image);
                $filename = hexdec(uniqid()); 
                $file_name = 'images/signature/create_sing_user/'.$filename.'.png';
                file_put_contents($file_name, $imagedata); 
                $img = Image::make(public_path($file_name))->resize(280, 100);
                $img->save($file_name); 
                $data=array(
                    'name'         => $request->name, 
                    'sender_email' => $request->email, 
                    'position'     => $request->position, 
                    'phone'        => $request->phone,
                    'is_users'     =>  1, 
                    "signature"  => $filename.'.png',  

                    "updated_at"         => new \DateTime(),    
                );  
            } else if($request->hdf_typeSignature==3){
                $validatedData = $request->validate([
                    'name' => ['required', 'string', 'max:255'], 
                    'email' => ['required', 'string', 'max:100'],  
                    'position' => ['required', 'string', 'max:100'],   
                    'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:10'],
                    'file_upload'    => 'required', 
                    'file_upload.*'  => 'mimes:jpg,bmp,png|max:20000', 
                ],
                [   
                    'file_upload.required'=>' กรุณาอัพโหลดลายเซ็นให้ถูกต้อง!',
                    'file_upload.*.mimes'=>' กรุณาระบุไฟล์เป็น jpg,bmp,png เท่านั้น !',  
                    'file_upload.*.max'=>' จำกัดขนาดลายเซ็นไม่เกิน 2MB !',  
                ]);
                if(!empty($request->file('file_upload'))){
                    $uploade_location = 'images/signature/create_sing_user/'; 
                    $row=DB::table('users')->select('*')->where('users.id', $id)->first();   
                    if(!empty($row->signature)){
                        unlink('images/signature/create_sing_user/'.$row->signature);  
                    }
                    foreach($request->file('file_upload') as $key=>$row){
                        $file = $request->file('file_upload')[$key];
                        $file_gen = hexdec(uniqid());
                        $file_ext = strtolower($file->getClientOriginalExtension()); 
                        $file_name = "up-".$file_gen.'.'.$file_ext;
                        //============ Data Insert =============//  
                        $file->move($uploade_location, $file_name);  
                        $file_name_make = 'images/signature/create_sing_user/'.$file_name;
                        $img = Image::make(public_path($file_name_make))->resize(280, 100);
                        $img->save($file_name_make); 
                        $data=array(
                            'name'         => $request->name, 
                            'sender_email' => $request->email, 
                            'position'     => $request->position, 
                            'phone'        => $request->phone,
                            'is_users'     =>  1, 
                            "signature"  => $file_name,  
        
                            "updated_at"         => new \DateTime(),    
                        );  
                    } 
                }
            }   
            DB::table('users')->where('id', $id)->update($data);
        }
        return redirect()->route('profile')->with('success', 'อัพเดทข้อมูลส่วนตัวสำเร็จ');
    }
 
    public function logout_getpassword(Request $request)
    { 
        $request->session()->invalidate();  
        $request->session()->regenerateToken();  
        return redirect('/password/reset?email='.$request->email_getpassword);
    }
    
    public function file_signature(Request $request)
    {
        dd($request); 
    }
}
