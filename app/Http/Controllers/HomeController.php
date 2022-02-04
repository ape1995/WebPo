<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\CustomerTarget;
use App\Models\Add;
use Auth;

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
        $time = date('H:i');
        $date = date('l, d F Y');

        if ($time > '05:30' && $time < '12:00') {
            $greeting = 'Morning';
        } elseif ($time >= '12:00' && $time < '18:00') {
            $greeting = 'Afternoon';
        } else {
            $greeting = 'Evening';
        }

        // tampilkan pesan
        $greeting = 'Good ' . $greeting;

        // get data for dashboard
        $adds = Add::all();
        // $draftOrder = SalesOrder::where('status', 'S')->where('customer_id', Auth::user()->customer_id)->whereMonth('delivery_date', '=', date('m'))->count('id');
        // $submittedOrder = SalesOrder::where('status', 'R')->where('customer_id', Auth::user()->customer_id)->whereMonth('delivery_date', '=', date('m'))->count('id');
        // $processedOrder = SalesOrder::where('status', 'P')->where('customer_id', Auth::user()->customer_id)->whereMonth('delivery_date', '=', date('m'))->count('id');
        // $waitingProcess = SalesOrder::where('status', 'R')->whereMonth('delivery_date', '=', date('m'))->count('id');
        // $totalProcessed = SalesOrder::where('status', 'P')->whereMonth('delivery_date', '=', date('m'))->count('id');

        $draftOrder = SalesOrder::where('status', 'S')->where('customer_id', Auth::user()->customer_id)->count('id');
        $submittedOrder = SalesOrder::where('status', 'R')->where('customer_id', Auth::user()->customer_id)->count('id');
        $processedOrder = SalesOrder::where('status', 'P')->where('customer_id', Auth::user()->customer_id)->count('id');
        $rejectedOrder = SalesOrder::where('status', 'B')->where('customer_id', Auth::user()->customer_id)->count('id');
        $waitingProcess = SalesOrder::where('status', 'R')->count('id');
        $totalProcessed = SalesOrder::where('status', 'P')->count('id');
        $rejectedOrderAdmin = SalesOrder::where('status', 'B')->count('id');

        
        $target = CustomerTarget::where('CustomerID', Auth::user()->customer_id)->where('Year', date('Y'))->pluck(date('F'))->first(); // You must get target here
        // dd($target);
        if($target == null){
            $target = 1;
        }
        
        $processedOrderThisMonth = SalesOrder::where('status', 'P')->whereMonth('delivery_date', date('m'))->where('customer_id', Auth::user()->customer_id)->sum('order_total');
        $sumOrderAmount = $processedOrderThisMonth;
        $percentase = round(($sumOrderAmount * 100)/$target, 2);
        if($percentase > 100){
            $percentase = 100;
        } else {
            $percentase = $percentase;
        }


        return view('home.index', compact('date', 'greeting', 
        'draftOrder', 'submittedOrder', 'processedOrder', 'waitingProcess', 
        'totalProcessed', 'target', 'percentase', 'sumOrderAmount', 'adds', 
        'rejectedOrder', 'rejectedOrderAdmin'));
    }
}
