<?php

namespace App\Http\Controllers;


use App\Models\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

//=================احصائية نسبة تنفيذ الحالات======================



      $count_all =Invoices::count();
      $count_invoices1 = Invoices::where('Value_Status', 1)->count();
      $count_invoices2 = Invoices::where('Value_Status', 2)->count();
      $count_invoices3 = Invoices::where('Value_Status', 3)->count();

      if($count_invoices1 == 0){
          $rate_invoices1 = 0;
      }
      else{
          $rate_invoices1 = $count_invoices1/ $count_all*100;
      }

        if($count_invoices2 == 0){
            $rate_invoice2 = 0;
        }
        else{
            $rate_invoice2 = $count_invoices2/ $count_all*100;
        }

        if($count_invoices3 == 0){
            $rate_invoice3 = 0;
        }
        else{
            $rate_invoice3 = $count_invoices3/ $count_all*100;
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$rate_invoice2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$rate_invoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$rate_invoice3]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$rate_invoice2 , $rate_invoices1 , $rate_invoice3]
                ]
            ])
            ->options([]);

        return view('index', compact('chartjs','chartjs_2'));

    }


}