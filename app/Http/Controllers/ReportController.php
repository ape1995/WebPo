<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SalesOrder;

class ReportController extends Controller
{
    public function index(){

        $customers = Customer::where('Type', 'CU')->get();

        return view('reports.sales_order', compact('customers'));

    }

    public function view(Request $request){

        $input = $request->all();

        // dd($input['date_2']);

        if($input['customer_id'] == 'All'){
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::whereBetween('order_date',[$input['date_1'],$input['date_2']])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->whereBetween('order_date',[$input['date_1'],$input['date_2']])->get();
            }
        } else {
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::where('customer_id', $input['customer_id'])->whereBetween('order_date',array($input['date_1'],$input['date_2']))->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->where('customer_id', $input['customer_id'])->whereBetween('order_date',array($input['date_1'],$input['date_2']))->get();
            }
        }

        $date1 = $input['date_1'];
        $date2 = $input['date_2'];
        $status = $input['status'];
        $customer_id = $input['customer_id'];

        $customers = Customer::where('Type', 'CU')->get();

        return view('reports.sales_order', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id'));

    }
}
