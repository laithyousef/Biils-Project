<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Invoices;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
    {
        return view('reports.invoices_report');
    }

    public function Search_invoices(Request $request)
    {

        $rdio = $request->rdio;

        // في حالة البحث بنوع الفاتورة
        if($rdio == 1) {

            // في حالة عدم تحديد تاريخ للفواتير
            if($request->start_at == '' && $request->end_at == '') {

                $invoices = Invoices::select('*')->where('Status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type'))->withDetails($invoices);

            // في حالة تحديد تاريخ للفواتير
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status', $request->type)->get();
                return view('reports.invoices_report', compact('type'))->withDetails($invoices);
            }

        // في حالة البحث برقم الفاتورة
        } else {
            $invoices = Invoices::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_report')->withDetails($invoices);

        }
    }

    public function show_custormers_report()
    {
        $sections = Section::all();
        return view('reports.customers_reports', compact('sections'));
    }

    public function Search_customers_invoices(Request $request)
    {

        $sections = Section::all();

        if($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {

            $invoices = Invoices::select('*')->where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.customers_reports', compact('sections'))->withDetails($invoices);

        } else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = Invoices::select('*')->whereBetween('invoice_Date', [$start_at,$end_at])->where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.customers_reports', compact('sections'))->withDetails($invoices);
        }
    }
}
