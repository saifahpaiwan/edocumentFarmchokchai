<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use Hash;
use DataTables;  
use Illuminate\Support\Facades\Mail;
use App\Mail\storeMail_approveUsers;
use App\Models\User;

class RolesController extends Controller
{
    public function roleslist()
    { 
        $data=array();   
        return view('roles.roles_list', compact('data'));
    }
    
    public function rolesadd()
    {
        $data=array(); 
        return view('roles.roles_add', compact('data'));
    }

    public function rolesedit($get_id)
    {
        $data=array( 
            "User_find" => User::find($get_id),
        );  
        return view('roles.roles_edit', compact('data'));
    } 

    // ==========FUNCTION========== //

    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="and users.is_users = 2"; 
        if(isset($keywrod)){
            $keywrod_sql=" and users.name LIKE '%".$keywrod."%'
            or users.email LIKE '%".$keywrod."%'
            or users.phone LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            if($status==2){
                $status_sql=" and users.is_users = 2"; 
            } else {
                $status_sql=" and users.deleted_at = ".$status."";  
            }
        }
 
        $data = DB::select('select * 
        from `users` 
        where users.id != 0
        '.$keywrod_sql.' '.$status_sql.'  
        order by users.id asc'); 

        return $data;
    }

    public function datatableRoles(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('name', function($row){    
                $img='<i class="fe-user"></i> ';
                $tag=$img.$row->name;
                $tag='<a href="'.route('roles.edit', $row->id).'">'.$img.$row->name.'</a>';
                return $tag;
            })   
            ->addColumn('roles', function($row){  
                $roles='<span class="badge badge-info"> ผู้ใช้งานระบบ </span>';
                if($row->roles==1){
                    $roles='<span class="badge badge-primary"> ผู้ดูแลระบบ </span>';
                }  
                return $roles;
            })  
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการเข้าใช้งาน </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการเข้าใช้งาน </span>';
                }  
                if($row->is_users==2){  $deleted_at='<span class="badge badge-dark"> ผู้ขอเข้าใช้งานระบบ </span>'; }

                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){   
                $html='<a href="'.route('roles.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary"> <i class="mdi mdi-pencil"></i> </a>';
                $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                return $html;
            })  
            ->rawColumns(['id','name','roles', 'deleted_at','bntManger'])
            ->make(true);
        } 
    }

    public function saveRoles(Request $request)
    { 
        if(isset($request)){  
            if($request->statusData=="C"){
                $validatedData = $request->validate(
                    [  
                        'name' => ['required', 'string', 'max:255'],
                        'phone' => ['required'],
                        'roles' => ['required'], 
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],   
                        'password' => ['required', 'string', 'min:8', 'same:passwordConfirm'],
                        'passwordConfirm' => 'required',
    
                        'status' => 'required'
                    ] 
                );  

                $dataType="created_at";
                $msg="Save data successfully.";

                $data=array(
                    'name'  => $request->name, 
                    'phone'  => $request->phone, 
                    'email'  => $request->email, 
                    'sender_email' => $request->email,
                    'is_users'  => 1,
                    'password'  => Hash::make($request->password), 
                    'roles'     => $request->roles,
    
                    'deleted_at' => $request->status, 
                    $dataType    => new \DateTime(),  
                );
            } else if($request->statusData=="U"){
                $user=User::find($request->id);
                $userPassword=$user->password;  
                $validatedData = $request->validate(
                    [  
                        'name' => ['required', 'string', 'max:255'],
                        'phone' => ['required'], 
                        'old_password' => ['string', 'min:8'], 
                        'password' => ['string', 'min:8', 'same:passwordConfirm'],
    
                        'status' => 'required'
                    ] 
                );  

                if(isset($request->changepassCheck) && $request->changepassCheck=="Y"){
                    if (!Hash::check($request->old_password, $userPassword)) {
                        return back()->withErrors(['old_password'=>'รหัสผ่านไม่ตรงกัน !']); 
                    }
                }

                $dataType="updated_at";
                $msg="Update data successfully.";

                $data=array(
                    'name'  => $request->name, 
                    'phone'  => $request->phone,  
                    'password'  => Hash::make($request->password), 
                    'roles'     => $request->roles,
                    'is_users'  => (!empty($request->is_users))? $request->is_users : 1,
    
                    'deleted_at' => $request->status, 
                    $dataType    => new \DateTime(),  
                );
            } 
 

            if($request->statusData=="C"){
                $GetId=DB::table('users')->insertGetId($data);   
            } else if($request->statusData=="U"){
                $GetId=$request->id;
                DB::table('users')
                ->where('users.id', $request->id)
                ->update($data);   
            } 

            if($request->statusData=="U"){ 
                if(!empty($GetId)){
                    if(isset($request->is_users) && $request->is_users==1){
                        $row=DB::table('users')  
                        ->select('users.id as id', 'users.email as email')
                        ->where('users.id', $GetId) 
                        ->first(); 
                        if(!empty($row->email)){
                            $data=Mail::to($row->email)->send(new storeMail_approveUsers($row->id)); 
                        } 
                    }
                } 
            }

            if($request->statusData=="C"){ 
                return redirect()->route('roles.add')->with('success', $msg);  
            } else if($request->statusData=="U"){ 
                return redirect()->route('roles.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function closeRoles(Request $request)
    {
        if(isset($request)){  
            $data=DB::table('users')
            ->where('users.id', $request->id)  
            ->delete();
        }  
        return $data;
    }
 

}
