<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Section;
use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\Invoice_Details;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice_Attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:قائمة الفواتير', ['only' => ['index','store']]);
         $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::orderByRaw('id DESC')->get();

        return view('invoices.invoicesDetails' , compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
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

            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_Date'   => 'required|date',
            'Due_date'       => 'required|date',
            'product'        => 'required|max:50|min:2',
            'Amount_collection' => 'required|numeric',
            'Amount_Commission' => 'required|numeric',
            'Discount'         => 'required|numeric',
            'Rate_VAT'        =>  'required|string',
            'Value_VAT'        =>   'required|numeric',
            'Total'           =>    'required|numeric',
            'note'            =>     'required|string',

        ]);

        Invoices::create([
           'invoice_number' => $request->invoice_number,
           'invoice_Date' => $request->invoice_Date,
           'Due_date' => $request->Due_date,
           'section_id' => $request->Section,
           'product' => $request->product,
           'Amount_collection' => $request->Amount_collection,
           'Amount_Commission' => $request->Amount_Commission,
           'Discount' => $request->Discount,
           'Rate_VAT' => $request->Rate_VAT,
           'Value_VAT' => $request->Value_VAT,
           'Total' => $request->Total,
           'note' => $request->note,
           'Status' => 'غير مدفوعة',
           'Value_Status' => '2',
        ]);

        $id = Invoices::latest()->first()->id;

        Invoice_Details::create([

            'id_Invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => '2',
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);



       if($request->hasFile('pic')) {

        $request->validate([
            'pic' => 'required|file'
        ], ['pic.file' => 'تم حفظ الفاتورة ولم يتم حفظ المرفق يرجى التأكد منه ' ]);

        $image = $request->file('pic');
        $filename = time() . '.' . $image->getClientOriginalName();
        $path = public_path('Attachments/' . $request->invoice_number);
        $imageName = time() . '.' . $request->pic->getClientOriginalName();
        $request->pic->move($path, $imageName);



       }
       $invoice_attachments = new Invoice_Attachments;

       $invoice_attachments->file_name = $filename;
       $invoice_attachments->invoice_number = $request->invoice_number;
       $invoice_attachments->Created_by =  Auth::user()->name;
       $invoice_attachments->id_Invoice =  $id;
       $invoice_attachments->save();

    //    $user = User::first();
    //    Notification::send($user, new AddInvoice($id));

    $user = User::get();
    Notification::send($user, new \App\Notifications\Add_new_invoice($id));

    session()->flash('add');
    return redirect('invoices');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoices, $id)
    {
        $invoices = Invoices::find($id);
        $invoice_details = Invoice_Details::find($id);
        $invoice_attachments = Invoice_Attachments::where('id_invoice',$id)->get();

        return view('invoices.invoices_Info', compact('invoices', 'invoice_details', 'invoice_attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoices::findOrFail($id);
        $sections = Section::all();
        
        return view('invoices.edit', compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'invoice_number' => 'required',
            'invoice_Date'   => 'required|date',
            'Due_date'       => 'required|date',
            'Amount_collection' => 'required|numeric',
            'Amount_Commission' => 'required|numeric',
            'Discount'         => 'required|numeric',
            'Value_VAT'        =>   'required|numeric',
            'Total'           =>    'required|numeric',
            'note'            =>     'required|string',
        ]);

        $invoices = Invoices::findOrFail($id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date'   => $request->invoice_Date,
            'Due_date'       => $request->Due_date,
            'section_id'     => $request->Section,
            'product'        => $request->product,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount'         => $request->Discount,
            'Rate_VAT'        =>  $request->Rate_VAT,
            'Value_VAT'        =>   $request->Value_VAT,
            'Total'           =>    $request->Total,
            'note'            =>     $request->note,
        ]);

        session()->flash('update');
        return redirect('invoices');
    }

    public function show_status($id)
    {
        $invoices = Invoices::find($id);

        return view('invoices.update_status', compact('invoices'));
    }


    public function update_status(Request $request, $id)
    {
        $invoices = Invoices::find($id);
        $invoice_details = Invoice_Details::find($id);

        if($request->Status === 'مدفوعة'){

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date'   => $request->invoice_Date,
            'Due_date'       => $request->Due_date,
            'section_id'     => $request->Section,
            'product'        => $request->product,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount'         => $request->Discount,
            'Rate_VAT'        =>  $request->Rate_VAT,
            'Value_VAT'        => $request->Value_VAT,
            'Total'           =>  $request->Total,
            'note'            =>     $request->note,
            'Status'          =>  $request->Status,
            'Value_Status'    => '1',
            'Payment_Date'    =>  $request->Payment_Date,
        ]);

        $invoice_details->update([

            'id_Invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => '1',
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        session()->flash('status_update');
        return redirect('invoices');

    } elseif ($request->Status === 'مدفوعة جزئيا') {

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date'   => $request->invoice_Date,
            'Due_date'       => $request->Due_date,
            'section_id'     => $request->Section,
            'product'        => $request->product,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount'         => $request->Discount,
            'Rate_VAT'        =>  $request->Rate_VAT,
            'Value_VAT'        => $request->Value_VAT,
            'Total'           =>  $request->Total,
            'note'            =>     $request->note,
            'Status'          =>  $request->Status,
            'Value_Status'    => '3',
            'Payment_Date'    =>  $request->Payment_Date,
        ]);

        $invoice_details->update([

            'id_Invoice' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => '3',
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        session()->flash('status_update');
        return redirect('invoices');
    }

    }

    public function getProducts($id)
    {
       $products = DB::table('products')->where('section_id' , $id)->pluck('product_name', 'id');

       return json_encode($products);
    }


    public function print_invoice($id)
    {
        $invoices = Invoices::find($id);

        session()->flash('print_invoice');
        return view('invoices.print_invoices',compact('invoices'));
    }

    public function MarkAsRead_all()
    {

        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id_page)
    {

        $id = $request->invoice_id;


        $invoice_attachments = Invoice_Attachments::where('id_Invoice', $id)->first();

        if($id_page === 2) {

        $invoices = Invoices::find($id)->Delete();

        session()->flash('invoice_archive');
        return redirect('invoices');

        } else {

            if (!empty($invoice_attachments->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($invoice_attachments->invoice_number);
                $invoices = Invoices::find($id)->forceDelete();
    
                session()->flash('delete');
                return redirect('invoices');
    
            }
        }

       
      
        
       
    }




}
