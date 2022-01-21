<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SalesOrder;
use Auth;

class ReportController extends Controller
{
    public function index(){

        if (!\Auth::user()->can('view report sales order')) {
            abort(403);
        }

        $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();

        return view('reports.sales_order', compact('customers'));

    }

    public function view(Request $request){

        $input = $request->all();

        // dd($input['date_2']);

        if($input['customer_id'] == 'All'){
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->whereNotIn('status', ['S'])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->get();
            }
        } else {
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->whereNotIn('status', ['S'])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->get();
            }
        }

        if($salesOrders == null || !$salesOrders || $salesOrders->count() == 0){
            return redirect()->route('reportSalesOrder.index')->with('error', 'Data Not Found');
        }

        $date1 = $input['date_1'];
        $date2 = $input['date_2'];
        $status = $input['status'];
        $customer_id = $input['customer_id'];

        if($customer_id == 'All'){
            $customerCode = $customer_id ;
        } else {
            $customerCode = $salesOrders[0]->customer->AcctCD;
        }

        $reportName = 'Order Rekap'.' - '.$date1.' sd '.$date2. ' - status : '.$status.' - customer : '.$customerCode;

        $customers = Customer::where('Type', 'CU')->get();

        return view('reports.sales_order', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function detailIndex(){

        if (!\Auth::user()->can('view report sales order detail')) {
            abort(403);
        }

        $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();

        return view('reports.sales_order_detail', compact('customers'));

    }

    public function detailView(Request $request){

        $input = $request->all();

        // dd($input['date_2']);

        if($input['customer_id'] == 'All'){
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->get();
            }
        } else {
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->get();
            }
        }
        // dd($salesOrders->count() == 0);
        if($salesOrders == null || !$salesOrders || $salesOrders->count() == 0){
            return redirect()->route('reportSalesOrder.detailIndex')->with('error', 'Data Not Found');
        }

        $date1 = $input['date_1'];
        $date2 = $input['date_2'];
        $status = $input['status'];
        $customer_id = $input['customer_id'];


        if($customer_id == 'All'){
            $customerCode = $customer_id ;
        } else {
            $customerCode = $salesOrders[0]->customer->AcctCD;
        }

        $reportName = 'Order Detail'.' - '.$date1.' sd '.$date2. ' - status : '.$status.' - customer : '.$customerCode;

        $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();

        return view('reports.sales_order_detail', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function report1Index(){

        if (!\Auth::user()->can('view report request 1')) {
            abort(403);
        }

        $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();

        return view('reports.report1', compact('customers'));

    }

    public function report1View(Request $request){

        $input = $request->all();

        // dd($input['date_2']);

        if($input['customer_id'] == 'All'){
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->get();
            }
        } else {
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->get();
            }
        }
        // dd($salesOrders->count() == 0);
        if($salesOrders == null || !$salesOrders || $salesOrders->count() == 0){
            return redirect()->route('reportSalesOrder.detailIndex')->with('error', 'Data Not Found');
        }

        $date1 = $input['date_1'];
        $date2 = $input['date_2'];
        $status = $input['status'];
        $customer_id = $input['customer_id'];


        if($customer_id == 'All'){
            $customerCode = $customer_id ;
        } else {
            $customerCode = $salesOrders[0]->customer->AcctCD;
        }

        $reportName = 'Order Detail F Request'.' - '.$date1.' sd '.$date2. ' - status : '.$status.' - customer : '.$customerCode;

        $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();

        return view('reports.report1', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function reportCustomerIndex(){

        if (!\Auth::user()->can('view report customer')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();
        }

        return view('reports.customer', compact('customers'));

    }

    public function reportCustomerView(Request $request){

        $input = $request->all();

        // dd($input['date_2']);

        if($input['customer_id'] == 'All'){
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->whereNotIn('status', ['S'])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->get();
            }
        } else {
            if($input['status'] == 'All'){
                $salesOrders = SalesOrder::where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->whereNotIn('status', ['S'])->get();
            } else {
                $salesOrders = SalesOrder::where('status', $input['status'])->where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->get();
            }
        }

        if($salesOrders == null || !$salesOrders || $salesOrders->count() == 0){
            return redirect()->route('reportSalesOrder.index')->with('error', 'Data Not Found');
        }

        $date1 = $input['date_1'];
        $date2 = $input['date_2'];
        $status = $input['status'];
        $customer_id = $input['customer_id'];

        if($customer_id == 'All'){
            $customerCode = $customer_id ;
        } else {
            $customerCode = $salesOrders[0]->customer->AcctCD;
        }

        $reportName = 'Order Rekap'.' - '.$date1.' sd '.$date2. ' - status : '.$status.' - customer : '.$customerCode;

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();
        }

        return view('reports.customer', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }
}
