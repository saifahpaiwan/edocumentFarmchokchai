<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestaccessController; 
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GenSignaturePDFController;
use App\Http\Controllers\LineMessageController;

 
use Org_Heigl\Ghostscript\Ghostscript;
use Symfony\Component\HttpFoundation\Response;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Auth::routes();  
Route::get('line_app', [RequestaccessController::class, 'line_app'])->name('line_app');


Route::get('/', function (Request $request) { 
    $request->session()->invalidate();  
    $request->session()->regenerateToken(); 
    return view('auth.login');
});  
Route::get('/register_ac', function () {
    return view('auth.register_ac');
});  

Route::get('/Mail_appUsers', function () {
    return view('email.Mail_appUsers');
});  

Route::get('/test_line', [LineMessageController::class,'test_line'])->name('test_line');
Route::get('/registerNotification', [LineMessageController::class,'registerNotification'])->name('registerNotification');
Route::post('liffNotification', [LineMessageController::class, 'liffNotification'])->name('liffNotification.post'); 
Route::post('check_liff', [LineMessageController::class, 'check_liff'])->name('check_liff.post'); 

// Route::get('/Mail_sender', function () {
//     $data=array();
//     return view('email.Mail_sender', compact('data'));
// }); 

Route::post('register_users', [RequestaccessController::class, 'register_users'])->name('register_users');
// Route::middleware(['is_CheckAdmin'])->group(function () {   
// });
 
Route::middleware(['is_Users'])->group(function () { 

    Route::get('/mg_document', [RequestaccessController::class,'mg_document'])->name('mg_document');  
    Route::get('/mg_users', [RequestaccessController::class,'mg_users'])->name('mg_users');  
    Route::get('datatableDocuments_all', [RequestaccessController::class, 'datatableDocuments_all'])->name('datatableDocuments_all.post'); 
    Route::get('datatableUsers_all', [RequestaccessController::class, 'datatableUsers_all'])->name('datatableUsers_all.post'); 
    Route::post('approveUsers', [RequestaccessController::class, 'approveUsers'])->name('approveUsers.post'); 

    //=================================================================================================================//
    Route::get('/dashboard', [DocumentController::class,'dashboard'])->name('dashboard'); 
    Route::get('/profile', [HomeController::class,'profile'])->name('profile');  
    Route::post('updateUsers', [HomeController::class, 'updateUsers'])->name('updateUsers.post'); 
    
    Route::post('logout_getpassword', [HomeController::class, 'logout_getpassword'])->name('logout_getpassword'); 
    Route::post('file_signature', [HomeController::class, 'file_signature'])->name('file_signature'); 


    Route::get('/create_document', [DocumentController::class,'create_document'])->name('create_document'); 
    Route::get('/edit_document/{id}', [DocumentController::class,'edit_document'])->name('edit_document');  
    Route::get('/create_receiver/{id}', [DocumentController::class,'create_receiver'])->name('create_receiver'); 
    Route::get('/create_signature/{id}', [DocumentController::class,'create_signature'])->name('create_signature');
    Route::get('/confrim_document/{id}', [DocumentController::class,'confrim_document'])->name('confrim_document');
    
    Route::get('/documents/{id}', [DocumentController::class,'documents'])->name('documents');
    Route::get('/documents_viwe/{id}', [DocumentController::class,'documents_viwe'])->name('documents_viwe');



    // ==========================================VI========================================== //
    Route::get('/documents_io/{id}', [DocumentController::class,'documents_io'])->name('documents_io');
    Route::get('/viwe_io/{id}', [DocumentController::class,'viwe_io'])->name('viwe_io');
    Route::get('datatableDocuments_io', [DocumentController::class, 'datatableDocuments_io'])->name('datatableDocuments_io.post'); 
    // ==========================================VI========================================== // 
     
    Route::post('upfileDocument', [DocumentController::class, 'upfileDocument'])->name('upfileDocument.post');
    Route::post('userGet', [DocumentController::class, 'userGet'])->name('userGet.post'); 
    Route::post('actionFormReceiver', [DocumentController::class, 'actionFormReceiver'])->name('actionFormReceiver.post');
    Route::post('actionFormSignature', [DocumentController::class, 'actionFormSignature'])->name('actionFormSignature.post');
    Route::post('actionFormConfrim', [DocumentController::class, 'actionFormConfrim'])->name('actionFormConfrim.post');
    Route::post('actionFormCloseDocument', [DocumentController::class, 'actionFormCloseDocument'])->name('actionFormCloseDocument.post');
    Route::post('actionFormCommentsDocument', [DocumentController::class, 'actionFormCommentsDocument'])->name('actionFormCommentsDocument.post');
    Route::post('closeDocument', [DocumentController::class, 'closeDocument'])->name('closeDocument.post'); 

    Route::get('datatableDocuments', [DocumentController::class, 'datatableDocuments'])->name('datatableDocuments.post'); 
    Route::post('actionFormapprove', [DocumentController::class, 'actionFormapprove'])->name('actionFormapprove.post'); 
    
    Route::post('actionFormDocumentEdit', [DocumentController::class, 'actionFormDocumentEdit'])->name('actionFormDocumentEdit.post'); 
    Route::post('actionFormConfrimDocument', [DocumentController::class, 'actionFormConfrimDocument'])->name('actionFormConfrimDocument.post'); 
 
    Route::get('/signatureViwepdf/{id}', [GenSignaturePDFController::class, 'signatureViwepdf'])->name('signatureViwepdf');  
    Route::post('documentComments', [DocumentController::class, 'documentComments'])->name('documentComments.post');
    Route::post('documentComments_answer', [DocumentController::class, 'documentComments_answer'])->name('documentComments_answer.post');
    Route::post('documentComments_close', [DocumentController::class, 'documentComments_close'])->name('documentComments_close.post');
    Route::post('actionFormEditDocument', [DocumentController::class, 'actionFormEditDocument'])->name('actionFormEditDocument.post');

    Route::post('users_sendemail', [DocumentController::class, 'users_sendemail'])->name('users_sendemail.post');
 
    Route::post('actionFormSendcomment', [DocumentController::class, 'actionFormSendcomment'])->name('actionFormSendcomment.post');
    Route::post('actionFormFeedback', [DocumentController::class, 'actionFormFeedback'])->name('actionFormFeedback.post');
    Route::post('feedbackGet', [DocumentController::class, 'feedbackGet'])->name('feedbackGet.post');
 
    Route::post('run_numberCode', [DocumentController::class, 'run_numberCode'])->name('run_numberCode.post');


    Route::post('actionFormGenCode', [DocumentController::class, 'actionFormGenCode'])->name('actionFormGenCode.post'); 
    Route::get('datatableGen_code', [DocumentController::class, 'datatableGen_code'])->name('datatableGen_code'); 
    Route::post('checkcode', [DocumentController::class, 'checkcode'])->name('checkcode.post');

    Route::get('datatable_dashboard_comments', [DocumentController::class, 'datatable_dashboard_comments'])->name('datatable_dashboard_comments');
    
    Route::post('check_lineUserid', [DocumentController::class, 'check_lineUserid'])->name('check_lineUserid.post');
    Route::post('deleteDocument', [DocumentController::class, 'deleteDocument'])->name('deleteDocument.post'); 
});
  
Route::get('/Intervention', function()
{   
    // ============1920============ //
    // top => 222.71181869506836
    // left => 615.7118530273438
    // ============1536============ //
    // top  => 226.4305648803711
    // left => 456.3333740234375
    // ============1280============ //
    // top  => 224.3680648803711
    // left => 322.3923645019531

    $top  = ceil(1011.3715362548828-224.3680648803711);
    $left = ceil(756.3854370117188-322.3923645019531);
    $img = Image::make(public_path('images/document-file/001.jpg'))
    ->resize(670,937)
    ->insert(public_path('images/document-file/signature-2.png'), 'top-left', $left, $top);
    header('Content-Type: image/png');
    echo $img->encode('png');
});

Route::get('/Imagick', function()
{      
    Ghostscript::setGspath("C:\Program Files\gs\gs9.54.0\bin\gswin64c.exe");
    $pdf_file=public_path('images/document-file/PDF-001.pdf'); 
    $pdf = new Pdf($pdf_file);  
    $pages = $pdf->getNumberOfPages(); 
    foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
        $pdf->setOutputFormat('png')->saveImage(public_path('images/document-file/img-'.uniqid().'.png'));
    }
    return new Response("All the pages of the PDF were succesfully converted to images");
});