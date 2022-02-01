<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class storeMail_approveUsers extends Mailable
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
        $data=$this->Query($id); 
        return $this->subject('แจ้งเตือนการอนุมัติเข้าใช้งานระบบ ประจำวันที่ '.date('Y/m/d'))
        ->view('email.Mail_appUsers', compact('data'));
    }

    public function Query($id)
    {
        $data = DB::table('users') 
        ->select('*')
        ->where('users.id', $id) 
        ->where('users.deleted_at', NULL) 
        ->first(); 

        return $data;
    }

}
