<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:أرشفة الفواتير', ['only' => ['index','store']]);
         $this->middleware('permission:تعديل الفاتورة', ['only' => ['update']]);
         $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            
        $invoices = Invoices::onlyTrashed()->orderByRaw('id DESC')->get();
        
        return view('invoices.archive_invoices', compact('invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request)
    {

        $id = $request->invoice_id;
        $flight = Invoices::withTrashed()->where('id', $id)->restore();

        session()->flash('restor_invoice_archive');
        return redirect('invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $invoices->forceDelete();

        session()->flash('delete');
        return redirect('Archive_invoices');
    }
}
