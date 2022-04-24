<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\Invoice_Details;

class InvoiceDetailsController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:الفواتير المدفوعة', ['only' => ['show_paid_invoices']]);
         $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['ashow_unpaid_invoiceste']]);
         $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['show_partial_paid_invoices']]);
    }

    public function show_paid_invoices()
    {
        $invoices = Invoices::where('Value_Status',1)->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }

    public function show_unpaid_invoices()
    {
        $invoices = Invoices::where('Value_Status',2)->get();
        return view('invoices.unpaid_invoices', compact('invoices'));
    }

    public function show_partial_paid_invoices()
    {
        $invoices = Invoices::where('Value_Status',3)->get();    
        return view('invoices.partially_paid_invoices', compact('invoices'));
    }

}
