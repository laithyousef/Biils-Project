<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\Invoice_Attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentsController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:اضافة مرفق', ['only' => ['store']]);
         $this->middleware('permission:عرض المرفق', ['only' => ['showFile']]);
         $this->middleware('permission:تحميل المرفق', ['only' => ['downloadFile']]);
         $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|file'
         ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        if($request->hasFile('file_name')) {


        $image = $request->file_name;
        $file = time() . '.' . $image->getClientOriginalName();
        $path = public_path('Attachments/' . $request->invoice_number);
        $image_name = time() . '.' . $request->file_name->getClientOriginalName();
        $request->file_name->move($path, $image_name);
    }

        $id = Invoices::latest()->first()->id;

        Invoice_Attachments::create([
            'invoice_number' => $request->invoice_number,
            'Created_by' => Auth::user()->name,
            'id_Invoice' => $id,
            'file_name' => $file,
        ]);

        return back()->with('Add', 'تم إضافة المرفق بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_Attachments  $invoice_Attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        Storage::disk('public_uploads')->delete($request->invoice_number .'/'. $request->file_name);

        $invoices_attchments = Invoice_Attachments::findOrFail($request->id_file)->delete();

        return back()->with('delete', 'تم حذف المرفق بنجاح');



    }

    public function showFile($invoice_number, $file_name)
    {
        
        return response()->file(public_path('Attachments/' . '/' . $invoice_number . '/' . $file_name)); 
    }

    public function downloadFile($invoice_number, $file_name)
    {

         return response()->download(public_path('Attachments/' . '/' . $invoice_number . '/' . $file_name));
    }

}
