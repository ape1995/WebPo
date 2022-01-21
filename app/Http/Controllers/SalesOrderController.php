<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderRequest;
use App\Http\Requests\UpdateSalesOrderRequest;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesOrderDetailRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailSubmit;
use App\Models\User;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SalesPrice;
use App\Models\Location;
use App\Models\SalesOrder;
use App\Models\Parameter;
use App\Models\SalesOrderDetail;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Flash;
use Response;
use Auth;
use DataTables;
use PDF;

class SalesOrderController extends AppBaseController
{
    /** @var  SalesOrderRepository */
    private $salesOrderRepository;
    private $salesOrderDetailRepository;

    public function __construct(SalesOrderRepository $salesOrderRepo, SalesOrderDetailRepository $salesOrderDetailRepo)
    {
        $this->salesOrderRepository = $salesOrderRepo;
        $this->salesOrderDetailRepository = $salesOrderDetailRepo;
    }

    /**
     * Display a listing of the SalesOrder.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('list sales order')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers'  || \Auth::user()->role == 'Staff Customers'){
            $salesOrders = SalesOrder::where('customer_id', \Auth::user()->customer_id)->latest()->get();
        } else {
            $salesOrders = SalesOrder::latest()->get();
        }

        // dd($salesOrders);

        return view('sales_orders.index')
            ->with('salesOrders', $salesOrders);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {

            if(\Auth::user()->role == 'Customers'){
                $datas = SalesOrder::where('customer_id', \Auth::user()->customer_id)->latest()->get();
            } else {
                $datas = SalesOrder::latest()->get();
            }

            return DataTables::of($datas)
                ->addColumn('customer', function (SalesOrder $salesOrder) {
                    return $salesOrder->customer->AcctName.' - '.$salesOrder->customer->AcctCD;
                })
                ->addColumn('order_type', function (SalesOrder $salesOrder) {
                    return $salesOrder->order_type == 'R' ? 'Regular' : 'Direct Selling';
                })
                ->addColumn('created_name', function (SalesOrder $salesOrder) {
                    return $salesOrder->createdBy->name;
                })
                ->editColumn('order_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d F Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d F Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('tax', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->tax, 2, ',', '.');
                })
                ->editColumn('order_total', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_total, 2, ',', '.');
                })
                ->editColumn('status', function (SalesOrder $salesOrder) 
                {
                    if($salesOrder->status == "S"){
                        $status = 'Draft';
                    } else if ($salesOrder->status == "R"){
                        $status = 'Submitted';
                    } else if ($salesOrder->status == "C"){
                        $status = 'Canceled';
                    } else if ($salesOrder->status == "B"){
                        $status = 'Rejected';
                    } else {
                        $status = 'Processed';
                    }

                    return $status;
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('sales_orders.action')->with('salesOrder',$data)->render();
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new SalesOrder.
     *
     * @return Response
     */
    public function create()
    {

        if (!\Auth::user()->can('create sales order')) {
            abort(403);
        }
        
        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
        } else {
            $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();
        }

        $date = Carbon::now();
        $date->addDays(3);

        $minDeliveryDate = $date->toDateString();

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->get();

        return view('sales_orders.create', compact('customers', 'products', 'minDeliveryDate'));
    }

    /**
     * Store a newly created SalesOrder in storage.
     *
     * @param CreateSalesOrderRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_id' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'order_qty' => 'required',
            'order_amount' => 'required',
            'tax' => 'required',
            'order_total' => 'required',
        ]);
        
        $input = $request->all();

        $cekOrder = SalesOrder::where('customer_id', $input['customer_id'])->where('delivery_date', $input['delivery_date'])->latest()->first();
        $thisCustomer = Customer::where('BAccountID', $input['customer_id'])->get()->first();
        // dd($thisCustomer);

        if($cekOrder == null || !$cekOrder || $cekOrder->count() == 0){
            $orderNbr = $thisCustomer->AcctReferenceNbr.date('ymd',strtotime($input['delivery_date'])).'-01-'.$input['order_type'];
        } else {
            $parseNo = explode("-", $cekOrder->order_nbr);
            $newID = $parseNo[1] + 1;
            $orderNbr = $parseNo[0].'-'.sprintf("%02s", $newID).'-'.$input['order_type'];
        }


        $input['order_nbr'] = $orderNbr;
        $input['order_amount'] = str_replace('.','',$input['order_amount']);
        $input['order_amount'] = str_replace(',','.',$input['order_amount']);
        $input['tax'] = str_replace('.','',$input['tax']);
        $input['tax'] = str_replace(',','.',$input['tax']);
        $input['order_total'] = str_replace('.','',$input['order_total']);
        $input['order_total'] = str_replace(',','.',$input['order_total']);
        $input['created_by'] = \Auth::user()->id;
        $input['status'] = 'S';

        $carts = Cart::where('customer_id', $input['customer_id'])->get();
        // dd($carts);


        // Store To Sales Order DB
        $salesOrder = $this->salesOrderRepository->create($input);

        // Get All Carts Item

        // Resave all carts item into sales order detail
        foreach($carts as $data){
            $detailData['sales_order_id'] = $salesOrder->id;
            $detailData['inventory_id'] = $data->inventory_id;
            $detailData['inventory_name'] = $data->inventory_name;
            $detailData['qty'] = $data->qty;
            $detailData['uom'] = $data->uom;
            $detailData['unit_price'] = $data->unit_price;
            $detailData['amount'] = $data->amount;
            $detailData['created_by'] = \Auth::user()->id;

            $salesOrderDetail = SalesOrderDetail::create($detailData);
        }

        // Delete All Carts from customer
        Cart::where('customer_id', $request->customer_id)->delete();

        return redirect(route('salesOrders.show', $salesOrder->id))->with('success', 'Order saved successfully.');
    }

    /**
     * Display the specified SalesOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $salesOrder = $this->salesOrderRepository->find($id);

        if(\Auth::user()->role == 'Customers'  || \Auth::user()->role == 'Staff Customers'){
            if($salesOrder->customer_id != \Auth::user()->customer_id){
                abort(403);
            }
        }

        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id )->get();
        $customers = Customer::where('BAccountID', $salesOrder->customer_id)->get();

        $parameter = Parameter::where('name','Maximum Time Order')->get()->first();
        $parameterNow = Carbon::now()->toTimeString();

        // dd($parameter->parameter_hour, $parameterNow);

        if (empty($salesOrder)) {

            return redirect(route('salesOrders.index'))->with('error', 'Order not found');
        }

        return view('sales_orders.show', compact('salesOrder', 'salesOrderDetails', 'customers', 'parameter', 'parameterNow'));
    }

    /**
     * Show the form for editing the specified SalesOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        if (!\Auth::user()->can('edit sales order')) {
            abort(403);
        }

        $salesOrder = $this->salesOrderRepository->find($id);

        if (empty($salesOrder)) {
            Flash::error('Order not found');

            return redirect(route('salesOrders.index'));
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
        } else {
            $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();
        }

        $date = Carbon::now();
        $date->addDays(3);

        $minDeliveryDate = $date->toDateString();

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->get();

        return view('sales_orders.edit', compact('salesOrder', 'customers', 'products', 'minDeliveryDate'));
    }

    /**
     * Update the specified SalesOrder in storage.
     *
     * @param int $id
     * @param UpdateSalesOrderRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $salesOrder = $this->salesOrderRepository->find($id);

        $input = $request->all();

        if( $input['order_type'] == $salesOrder->order_type && $input['delivery_date'] == $salesOrder->delivery_date->format('Y-m-d') ){
            
            $input['order_nbr'] = $salesOrder->order_nbr;

        } else if ($input['order_type'] != $salesOrder->order_type && $input['delivery_date'] == $salesOrder->delivery_date->format('Y-m-d')){

            $parseNo = explode("-", $input['order_nbr']);
            $orderNbr = $parseNo[0].'-'.$parseNo[1].'-'.$input['order_type'];

            $input['order_nbr'] = $orderNbr;

        } else {

            $cekOrder = SalesOrder::where('customer_id', $input['customer_id'])->where('delivery_date', $input['delivery_date'])->latest()->first();
            $thisCustomer = Customer::where('BAccountID', $input['customer_id'])->get()->first();

            if($cekOrder == null || !$cekOrder || $cekOrder->count() == 0){
                $orderNbr = $thisCustomer->AcctReferenceNbr.date('ymd',strtotime($input['delivery_date'])).'-01-'.$input['order_type'];
            } else {
                $parseNo = explode("-", $cekOrder->order_nbr);
                $newID = $parseNo[1] + 1;
                $orderNbr = $parseNo[0].'-'.sprintf("%02s", $newID).'-'.$input['order_type'];
            }

            $input['order_nbr'] = $orderNbr;

        }

        $input['order_amount'] = str_replace('.','',$input['order_amount']);
        $input['order_amount'] = str_replace(',','.',$input['order_amount']);
        $input['tax'] = str_replace('.','',$input['tax']);
        $input['tax'] = str_replace(',','.',$input['tax']);
        $input['order_total'] = str_replace('.','',$input['order_total']);
        $input['order_total'] = str_replace(',','.',$input['order_total']);

        if (empty($salesOrder)) {
            Flash::error('Sales Order not found');

            return redirect(route('salesOrders.index'));
        }

        $salesOrder = $this->salesOrderRepository->update($input, $id);

        return redirect(route('salesOrders.show', $id))->with('success', 'Order Updated Sucessfully');
    }

    /**
     * Remove the specified SalesOrder from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesOrder = $this->salesOrderRepository->find($id);

        if (empty($salesOrder)) {
            Flash::error('Sales Order not found');

            return redirect(route('salesOrders.index'));
        }

        $this->salesOrderRepository->delete($id);

        Flash::success('Sales Order deleted successfully.');

        return redirect(route('salesOrders.index'));
    }

    public function getCPriceClass($id){

        $location = Location::where('BAccountID', $id)->get()->first();
        $priceClass = $location->CPriceClassID;

        return $priceClass;

    }

    public function getInventoryID($id){
        $product = Product::where('InventoryCD', $id)->get()->first();

        return $product;
    }

    public function getPrice($code, $customer){
        // dd($code, $customer);

        $priceClass = $this->getCPriceClass($customer);
        $inventory = $this->getInventoryID($code);
        $inventoryID = $inventory->InventoryID;
        $inventoryName = $inventory->Descr;
        $time = Carbon::now();
        $now = $time->toDateTimeString();

        $salesPrice = SalesPrice::where('CustPriceClassID', $priceClass)->where('InventoryID', $inventoryID)->where('EffectiveDate', "<=", $now)->where('ExpirationDate', NULL)->get()->first();
        $data['unit_price'] = number_format($salesPrice->SalesPrice,2,',','.');
        $data['uom'] = $salesPrice->UOM;
        $data['inventory_name'] = $inventoryName;

        return $data;
    }

    public function submitOrder($id)
    {

        if (!\Auth::user()->can('submit sales order')) {
            abort(403);
        }

        $salesOrder = SalesOrder::find($id);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        // Cek Jam Submit
        $parameter = Parameter::where('name','Maximum Time Order')->get()->first();
        $parameterNow = Carbon::now()->toTimeString();

        // dd($parameter->parameter_hour, $parameterNow);

        $salesOrder = SalesOrder::find($id);
        $salesOrder['status'] = 'R';
        $salesOrder['submitted_by'] = \Auth::user()->id;
        $salesOrder['submitted_at'] = Carbon::now()->toDateTimeString();
        $salesOrder->save();

        if($parameterNow >= $parameter->parameter_hour){

            $email = 'apeganteng@gmail.com';
            $data = [
                'title' => 'PENTING! Order masuk melewati jam batas',
                'name' => $salesOrder->customer->AcctName,
                'url' => 'https://yamazakimyroti.co.id',
            ];
            Mail::to($email)->send(new SendMailSubmit($data));
        }

        return redirect(route('salesOrders.show', $id))->with('success', 'Order Submitted Sucessfully.');
    }

    public function processOrder($id)
    {

        if (!\Auth::user()->can('process sales order')) {
            abort(403);
        }

        $salesOrder = SalesOrder::find($id);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $salesOrder = SalesOrder::find($id);
        $salesOrder['status'] = 'P';
        $salesOrder['processed_by'] = \Auth::user()->id;
        $salesOrder['processed_at'] = Carbon::now()->toDateTimeString();
        $salesOrder->save();

        return redirect(route('salesOrders.show', $id))->with('success', 'Order Submitted Sucessfully.');
    }

    public function cancelOrder($id)
    {

        if (!\Auth::user()->can('cancel sales order')) {
            abort(403);
        }

        $salesOrder = SalesOrder::find($id);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $salesOrder = SalesOrder::find($id);
        $salesOrder['status'] = 'C';
        $salesOrder['canceled_by'] = \Auth::user()->id;
        $salesOrder['canceled_at'] = Carbon::now()->toDateTimeString();
        $salesOrder->save();

        return redirect(route('salesOrders.index'))->with('success', 'Order Canceled Sucessfully.');
    }

    public function rejectOrder(Request $request)
    {

        if (!\Auth::user()->can('reject sales order')) {
            abort(403);
        }

        $input = $request->all();

        $salesOrder = SalesOrder::find($input['id_order']);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $salesOrder = SalesOrder::find($input['id_order']);
        $salesOrder['status'] = 'B';
        $salesOrder['rejected_reason'] = $input['reason'];
        $salesOrder['rejected_by'] = \Auth::user()->id;
        $salesOrder['rejected_at'] = Carbon::now()->toDateTimeString();
        $salesOrder->save();

        return redirect(route('salesOrders.index'))->with('success', 'Order Rejected Sucessfully.');
    }

    public function resetOrder()
    {
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->delete();

        return redirect(route('createOrder'));
    }

    public function printPdf($id)
    {

        $salesOrder = SalesOrder::find($id);
        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id)->get();
        // dd($salesOrder);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $pdf = PDF::loadview('sales_orders.print',['salesOrder'=>$salesOrder, 'salesOrderDetails'=>$salesOrderDetails]);
    	return $pdf->download("Order - $salesOrder->order_nbr.pdf");

        // return view('sales_orders.print', compact('salesOrder', 'salesOrderDetails'));
    }

    public function reOrder($id)
    {

        $salesOrder = SalesOrder::find($id);
        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id)->get();
        // dd($salesOrderDetails);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        // Delete all cart from this customer
        Cart::where('customer_id', $salesOrder->customer_id)->delete();

        // define data header
        $data = [];
        $data['order_type'] = $salesOrder->order_type;
        $data['description'] = $salesOrder->description;

        foreach($salesOrderDetails as $detail){
            // Get data code product and customer
            $code = $detail->inventory_id;
            $customer = $salesOrder->customer_id;
            // Get data price
            $dataprice = $this->getPrice($code, $customer);
            $dataprice['unit_price'] = str_replace('.','',$dataprice['unit_price']);
            $dataprice['unit_price'] = str_replace(',','.',$dataprice['unit_price']);
            // Resum amount
            $amount = $dataprice['unit_price'] * $detail->qty;
            // Store to carts
            Cart::create([
                'inventory_id' => $detail->inventory_id,
                'inventory_name' => $dataprice['inventory_name'],
                'qty' => $detail->qty,
                'uom' => $detail->uom,
                'unit_price' => $dataprice['unit_price'],
                'amount' => $amount,
                'customer_id' => $salesOrder->customer_id,
                'created_by' => \Auth::user()->id,
            ]);  
        }

        return redirect()->route('createOrder')->with('success', 'Silahkan sesuaikan tanggal kirim dan kuantitas item!')->with('data', $data);
    }
}
