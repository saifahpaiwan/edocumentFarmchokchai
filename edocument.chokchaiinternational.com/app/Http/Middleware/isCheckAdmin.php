<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class isCheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    { 
        if(auth()->user()){
            $itmes=[];
            $data=DB::table('check_users') 
            ->select('*')
            ->where('check_users.deleted_at', NULL)
            ->get(); 
            
            if(count($data)>0){
                foreach($data as $key=>$row){
                    $itmes[]=$row->users_id;
                }
            } 

            if(in_array(auth()->user()->id, $itmes)){
                return $next($request);
            } 
        }
        return redirect()->route('login')->with("error", "สิทธ์การเข้าใช้งานไม่ถูกต้อง !"); 
    }
}
