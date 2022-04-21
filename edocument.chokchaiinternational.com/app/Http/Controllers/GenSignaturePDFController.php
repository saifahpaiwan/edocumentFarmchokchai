<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Auth;
use App\Models\Document_Create;
use Illuminate\Support\Facades\DB; 
use PDF;

class GenSignaturePDFController extends Controller
{

    public function signatureViwepdf($id)
    {    
        $first=DB::table('document_creates')
        ->select('*')
        ->where('document_creates.id', $id) 
        ->where('document_creates.document_status', 2)
        ->where('document_creates.create_status', 3)
        ->where('document_creates.deleted_at', NULL)  
        ->first(); 

        $data=array(
            'first'       => $first,
            'documentGet' => $this->documentGet($id)
        ); 
        if($id){
            $pdf = PDF::loadView('myPDF.file', compact('data'));
            return $pdf->download('เลขที่ '.$first->document_code.'.pdf');
        } 
        return view('myPDF.file',compact('data'));
    } 
 
    public function documentGet($id)
    {
        $data = DB::table('document_receivers')
        ->leftJoin('users', 'document_receivers.users_id', '=', 'users.id')  
        ->select('document_receivers.signing_rights as signing_rights', 'document_receivers.signing_type as signing_type',
        'document_receivers.signing_name as signing_name', 'document_receivers.status_approve as status_approve',
        'document_receivers.position as position', 'users.name as usersname', 'users.signature as userssignature',
        'document_receivers.updated_at as updated_at', 'document_receivers.signing_prefix as signing_prefix')
        ->where('document_receivers.document_id', $id) 
        ->where('document_receivers.status_approve', 2) 
        ->where('document_receivers.deleted_at', NULL)  
        ->orderBy('document_receivers.id')
        ->get();  
        return $data;
    }

}
