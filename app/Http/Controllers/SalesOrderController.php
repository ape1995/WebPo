<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderRequest;
use App\Http\Requests\UpdateSalesOrderRequest;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesOrderDetailRepository;
use App\Models\User;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SalesPrice;
use App\Models\Location;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Flash;
use Response;
use Auth;
use DataTables;

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
        // $salesOrders = $this->salesOrderRepository->all();

        if(\Auth::user()->role == 'Customers'){
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
        
        if(\Auth::user()->role == 'Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
        } else {
            $customers = Customer::all();
        }

        // dd($customers[1]->location);

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->get();

        return view('sales_orders.create', compact('customers', 'products'));
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

        $input['order_nbr'] = STR::random(10);
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

        if(\Auth::user()->role == 'Customers'){
            if($salesOrder->customer_id != \Auth::user()->customer_id){
                abort(403);
            }
        }

        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id )->get();
        $customers = Customer::where('BAccountID', $salesOrder->customer_id)->get();

        // dd($salesOrderDetail);

        if (empty($salesOrder)) {

            return redirect(route('salesOrders.index'))->with('error', 'Order not found');
        }

        return view('sales_orders.show', compact('salesOrder', 'salesOrderDetails', 'customers'));
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
        $salesOrder = $this->salesOrderRepository->find($id);

        if (empty($salesOrder)) {
            Flash::error('Order not found');

            return redirect(route('salesOrders.index'));
        }

        if(\Auth::user()->role == 'Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
        } else {
            $customers = Customer::all();
        }

        // dd($customers[1]->location);

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->get();

        return view('sales_orders.edit', compact('salesOrder', 'customers', 'products'));
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

        $salesOrder = SalesOrder::find($id);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $salesOrder = SalesOrder::find($id);
        $salesOrder['status'] = 'R';
        $salesOrder->save();

        return redirect(route('salesOrders.show', $id))->with('success', 'Order Submitted Sucessfully.');
    }

    public function processOrder($id)
    {

        $salesOrder = SalesOrder::find($id);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $salesOrder = SalesOrder::find($id);
        $salesOrder['status'] = 'P';
        $salesOrder->save();

        return redirect(route('salesOrders.show', $id))->with('success', 'Order Submitted Sucessfully.');
    }

    public function cancelOrder($id)
    {

        $salesOrder = SalesOrder::find($id);

        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        $salesOrder = SalesOrder::find($id)->delete();
        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $id)->delete();

        return redirect(route('salesOrders.index'))->with('success', 'Order Canceled Sucessfully.');
    }

    public function resetOrder()
    {
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->delete();

        return redirect(route('createOrder'));
    }
}
