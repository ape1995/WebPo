<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\SalesOrderPromo;
use App\Models\PrePaymentH;
use App\Models\PrePaymentD;
use App\Models\User;
use App\Models\SOOrder;
use App\Models\CustomerBalance;
use App\Models\BundlingGimmick;
use App\Models\BundlingProduct;
use App\Models\PacketDiscount;
use App\Exports\ReportBalanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DB;

class ReportController extends Controller
{
    public function index(){

        if (!\Auth::user()->can('view report sales order')) {
            abort(403);
        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        

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

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
      
        return view('reports.sales_order', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function detailIndex(){

        if (!\Auth::user()->can('view report sales order detail')) {
            abort(403);
        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('reports.sales_order_detail', compact('customers'));

    }

    public function detailView(Request $request){

        $input = $request->all();

        $soOrder = SOOrder::select('OrderNbr')->whereYear('RequestDate', date('Y', strtotime($input['date_2'])))->whereMonth('RequestDate', date('m', strtotime($input['date_2'])))->pluck('OrderNbr')->toArray();

        if($input['customer_id'] == 'All'){
            $salesOrders = SalesOrder::leftJoin('sales_order_details', 'sales_order_details.sales_order_id', '=', 'sales_orders.id')
            ->select('sales_orders.order_nbr_merge', 'sales_orders.customer_id', 'sales_orders.delivery_date', 'sales_order_details.inventory_id', 'sales_order_details.inventory_name', DB::raw('sum(sales_order_details.qty) as qty'))
            ->whereBetween('sales_orders.delivery_date', array($input['date_1'],$input['date_2']))
            ->whereNotIn('sales_orders.order_nbr', $soOrder)
            ->whereNotIn('sales_orders.order_nbr_merge', $soOrder)
            ->where('sales_orders.status', 'P')
            ->groupBy(['sales_orders.order_nbr_merge', 'sales_orders.customer_id', 'sales_orders.delivery_date', 'sales_order_details.inventory_id', 'sales_order_details.inventory_name'])
            ->get();
        } else {
            $salesOrders = SalesOrder::leftJoin('sales_order_details', 'sales_order_details.sales_order_id', '=', 'sales_orders.id')
            ->select('sales_orders.order_nbr_merge', 'sales_orders.customer_id', 'sales_orders.delivery_date', 'sales_order_details.inventory_id', 'sales_order_details.inventory_name', DB::raw('sum(sales_order_details.qty) as qty'))
            ->whereBetween('sales_orders.delivery_date', array($input['date_1'],$input['date_2']))
            ->whereNotIn('sales_orders.order_nbr', $soOrder)
            ->whereNotIn('sales_orders.order_nbr_merge', $soOrder)
            ->where('sales_orders.customer_id', $input['customer_id'])
            ->where('sales_orders.status', 'P')
            ->groupBy(['sales_orders.order_nbr_merge', 'sales_orders.customer_id', 'sales_orders.delivery_date', 'sales_order_details.inventory_id', 'sales_order_details.inventory_name'])
            ->get();
        }

        // dd($salesOrders);
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

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('reports.sales_order_detail', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function detailPromoIndex(){

        if (!\Auth::user()->can('view report sales order detail')) {
            abort(403);
        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('reports.sales_order_detail_promo', compact('customers'));

    }

    public function detailPromoView(Request $request){
        
        $input = $request->all();

        $soOrder = SOOrder::select('OrderNbr')->whereYear('RequestDate', date('Y', strtotime($input['date_2'])))->whereMonth('RequestDate', date('m', strtotime($input['date_2'])))->pluck('OrderNbr')->toArray();

        if($input['customer_id'] == 'All'){
            if($input['status'] == 'All'){
                $salesOrders = SalesOrderPromo::whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->whereNotIn('order_nbr', $soOrder)->get();
            } else {
                $salesOrders = SalesOrderPromo::where('status', $input['status'])->whereBetween('delivery_date',[$input['date_1'],$input['date_2']])->whereNotIn('order_nbr', $soOrder)->get();
            }
        } else {
            if($input['status'] == 'All'){
                $salesOrders = SalesOrderPromo::where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->whereNotIn('order_nbr', $soOrder)->get();
            } else {
                $salesOrders = SalesOrderPromo::where('status', $input['status'])->where('customer_id', $input['customer_id'])->whereBetween('delivery_date',array($input['date_1'],$input['date_2']))->whereNotIn('order_nbr', $soOrder)->get();
            }
        }
        // dd($salesOrders->count() == 0);
        if($salesOrders == null || !$salesOrders || $salesOrders->count() == 0){
            return redirect()->route('reportSalesOrder.detailPromoIndex')->with('error', 'Data Not Found');
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

        $reportName = 'Order Detail Promo'.' - '.$date1.' sd '.$date2. ' - status : '.$status.' - customer : '.$customerCode;

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('reports.sales_order_detail_promo', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function report1Index(){

        if (!\Auth::user()->can('view report request 1')) {
            abort(403);
        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
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
            return redirect()->route('reportSalesOrder.report1Index')->with('error', 'Data Not Found');
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

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('reports.report1', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function reportCustomerIndex(){

        if (!\Auth::user()->can('view report customer')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }

        return view('reports.customer', compact('customers'));

    }

    public function reportCustomerView(Request $request){

        $input = $request->all();


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
            return redirect()->route('reportSalesOrder.reportCustomerIndex')->with('error', 'Data Not Found');
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

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
       }

        return view('reports.customer', compact('customers', 'salesOrders', 'date1', 'date2', 'status', 'customer_id', 'reportName'));

    }

    public function reportBalanceIndex(){

        if (!\Auth::user()->can('view report balance')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }

        return view('reports.balance', compact('customers'));

    }

    public function reportBalanceView(Request $request){

        $input = $request->all();

        $customer_id = $input['customer_id'];
        
        if($input['customer_id'] == 'All'){

            $prePayments = PrePaymentH::orderBy('CustomerCD', 'ASC')->orderBy('TransferDate', 'DESC')->get();

        } else {

            $prePayments = PrePaymentH::where('CustomerCD', $customer_id)->orderBy('TransferDate', 'DESC')->get();
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }

        $customer = Customer::where('AcctCD', $customer_id)->get()->first();

        
        $customerCode = $customer->AcctCD;
        $customerName = $customer->AcctName;
        // $totalAdjust = 0;
        // foreach($prePayments as $header){
        //     $totalAdjust+=$header->detail->sum('TotalPayment'); 
        // }
        // $totalPayment = $prePayments->sum('TransferAmount');
        // $balance = $totalPayment - $totalAdjust;
        $balance = CustomerBalance::where('CustomerCD', $customerCode)->get()->first();
        // dd($balance);

        if(isset($request->view)){
            return view('reports.balance', compact('customers', 'customer_id', 'prePayments', 'customerCode', 'customerName', 'balance'));
        }
        
        return Excel::download(new ReportBalanceExport($prePayments, $customerCode, $customerName, $balance), "Report Balance.xlsx");

    }

    public function rekapBalances(){

        if (!\Auth::user()->can('view report balance rekap')) {
            abort(403);
        }

        $customerBalances = CustomerBalance::all();

        $reportName = "Report Recap Balance All Customer";

        return view('reports.balance_rekap', compact('customerBalances', 'reportName'));

    }

    public function reportBGimmickIndex(){

        if (!\Auth::user()->can('view report bundling gimmick')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }

        return view('reports.bundling_gimmick', compact('customers'));

    }

    public function reportBGimmickView(Request $request){
        
        if (!\Auth::user()->can('view report bundling gimmick')) {
            abort(403);
        }
        
        $input = $request->all();
        $date_1_selected = $input['date_1'];
        // $date_2_selected = $input['date_2'];
        $customer_id_selected = $input['customer_id'];
        

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }
        
        if($input['customer_id'] == 'All'){

            $salesOrders = SalesOrder::where('order_type', 'G')->where('status', 'P')->whereBetween('delivery_date', [$date_1_selected, $date_1_selected])->get();

        } else {

            $salesOrders = SalesOrder::where('customer_id', $customer_id_selected)->where('order_type', 'G')->where('status', 'P')->whereBetween('delivery_date', [$date_1_selected, $date_1_selected])->get();

        }

        $gimmick = BundlingGimmick::whereRaw("(start_date <= '$date_1_selected' AND (end_date IS NULL OR end_date >= '$date_1_selected'))")->get()->first();

    
        // dd($gimmick);

        return view('reports.bundling_gimmick', compact('gimmick', 'customers', 'date_1_selected', 'customer_id_selected', 'salesOrders'));

    }

    public function reportBProductIndex(){

        if (!\Auth::user()->can('view report bundling gimmick')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }

        return view('reports.bundling_product', compact('customers'));

    }

    public function reportBProductView(Request $request){

        if (!\Auth::user()->can('view report bundling product')) {
            abort(403);
        }

        $input = $request->all();
        $date_1_selected = $input['date_1'];
        // $date_2_selected = $input['date_2'];
        $customer_id_selected = $input['customer_id'];

        

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }
        
        if($input['customer_id'] == 'All'){

            $salesOrders = SalesOrder::where('order_type', 'P')->where('status', 'P')->whereBetween('delivery_date', [$date_1_selected, $date_1_selected])->get();

        } else {

            $salesOrders = SalesOrder::where('customer_id', $customer_id_selected)->where('order_type', 'P')->where('status', 'P')->whereBetween('delivery_date', [$date_1_selected, $date_1_selected])->get();

        }

        

        // dd($salesOrders);

        return view('reports.bundling_product', compact('customers', 'date_1_selected', 'customer_id_selected', 'salesOrders'));

    }

    public function reportBDiscountIndex(){

        if (!\Auth::user()->can('view report bundling gimmick')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }

        return view('reports.bundling_discount', compact('customers'));

    }

    public function reportBDiscountView(Request $request){

        if (!\Auth::user()->can('view report bundling product')) {
            abort(403);
        }

        $input = $request->all();
        $date_1_selected = $input['date_1'];
        $date_2_selected = $input['date_2'];
        $customer_id_selected = $input['customer_id'];

        

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers' ){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id )->get();
        } else {
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
            $customers = Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        }
        
        if($input['customer_id'] == 'All'){

            $salesOrders = SalesOrder::where('order_type', 'C')->where('status', 'P')->whereBetween('delivery_date', [$date_1_selected, $date_2_selected])->get();

        } else {

            $salesOrders = SalesOrder::where('customer_id', $customer_id_selected)->where('order_type', 'C')->where('status', 'P')->whereBetween('delivery_date', [$date_1_selected, $date_2_selected])->get();

        }

        // dd($gimmick);

        return view('reports.bundling_discount', compact( 'customers', 'date_2_selected', 'date_1_selected', 'customer_id_selected', 'salesOrders'));

    }

    
}
