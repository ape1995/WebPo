<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
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
        $draftOrder = SalesOrder::where('status', 'S')->where('customer_id', Auth::user()->customer_id)->get();
        $submittedOrder = SalesOrder::where('status', 'R')->where('customer_id', Auth::user()->customer_id)->get();
        $processedOrder = SalesOrder::where('status', 'P')->where('customer_id', Auth::user()->customer_id)->get();
        $waitingProcess = SalesOrder::where('status', 'R')->get();
        $totalProcessed = SalesOrder::where('status', 'P')->get();

        
        $target = 500000; // You must get target here
        $processedOrderThisMonth = SalesOrder::where('status', 'P')->whereMonth('delivery_date', date('m'))->where('customer_id', Auth::user()->customer_id)->get();
        $sumOrderAmount = $processedOrderThisMonth->sum('order_amount');
        $percentase = round(($sumOrderAmount * 100)/$target, 2);


        return view('home.index', compact('date', 'greeting', 'draftOrder', 'submittedOrder', 'processedOrder', 'waitingProcess', 'totalProcessed', 'target', 'percentase', 'sumOrderAmount'));
    }
}
