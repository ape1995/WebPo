<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderRequest;
use App\Http\Requests\UpdateSalesOrderRequest;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesOrderDetailRepository;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Models\MailSetting;
use App\Mail\SendMailSubmit;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerProduct;
use App\Models\CategoryMinOrder;
use App\Models\CustomerMinOrder;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SalesPrice;
use App\Models\Location;
use App\Models\SalesOrder;
use App\Models\Parameter;
use App\Models\ParameterVAT;
use App\Models\SalesOrderDetail;
use App\Models\Attachment;
use App\Models\SOOrder;
use App\Models\DsRule;
use App\Models\DsPercentage;
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

        return view('sales_orders.index');
    }

    public function filter(Request $request, $status)
    {
        if (!\Auth::user()->can('list sales order')) {
            abort(403);
        }

        // dd($status);

        return view('sales_orders.filter', compact('status'));
    }

    public function filterDataTable($status, Request $request)
    {
        if ($request->ajax()) {

            if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
                $datas = SalesOrder::with('customer')->where('status', $status)->where('customer_id', \Auth::user()->customer_id)->orderBy('id', 'desc');
            } else {
                $datas = SalesOrder::with('customer')->where('status', $status)->latest();
            }

            return DataTables::of($datas)
                ->addColumn('customer', function (SalesOrder $salesOrder) {
                    return $salesOrder->customer->AcctName;
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
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
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

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {

            if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
                $datas = SalesOrder::where('customer_id', \Auth::user()->customer_id)->orderBy('id', 'desc');
            } else {
                $datas = SalesOrder::with('customer')->whereNotIn('status', ['S', 'C'])->latest();
            }

            return DataTables::of($datas)
                ->addColumn('customer', function (SalesOrder $salesOrder) {
                    return $salesOrder->customer->AcctName;
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
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
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

    public function dataTableFilter(Request $request)
    {
        if ($request->ajax()) {

            if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
                $datas = SalesOrder::where('customer_id', \Auth::user()->customer_id)->orderBy('id', 'desc');
            } else {
                $datas = SalesOrder::whereNotIn('status', ['S', 'C'])->orderBy('id', 'desc');
            }

            return DataTables::of($datas)
                ->addColumn('customer', function (SalesOrder $salesOrder) {
                    return $salesOrder->customer->AcctName;
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
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
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

        $customerProducts = CustomerProduct::select('inventory_code')->where('customer_code',  \Auth::user()->customer->AcctCD)->get()->pluck('inventory_code');
        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->whereIn('InventoryCD', $customerProducts)->orderBy('InventoryCD', 'ASC')->get();

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

        // Removing Mask
        $orderTotal = $input['order_total'];
        $orderTotal = str_replace('.','',$orderTotal);
        $orderTotal = (int)str_replace(',','.',$orderTotal);
        
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
        $input['order_nbr_merge'] = $orderNbr;
        $input['created_by'] = \Auth::user()->id;
        $input['status'] = 'S';
        $deliveryDate = $input['delivery_date'];

        $carts = Cart::where('customer_id', $input['customer_id'])->get();

        if($carts == null){
            return redirect(route('SalesOrders.create'))->with('error', 'Keranjang anda kosong');
        }
        // dd($carts);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$deliveryDate' AND (end_date is null OR end_date >= '$deliveryDate') ")->get()->first();

        $input['order_qty'] = $carts->sum('qty');
        $input['order_amount'] = $carts->sum('amount');
        $input['tax'] = ($parameterVAT->value/100) *$input['order_amount'];
        $input['order_total'] = $input['order_amount'] + $input['tax'];


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

        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id )->orderBy('inventory_id', 'ASC')->get();
        $customers = Customer::where('BAccountID', $salesOrder->customer_id)->get();

        $parameter = Parameter::where('name','Maximum Time Order')->get()->first();
        $parameterNow = Carbon::now()->toTimeString();

        $attachments = Attachment::where('sales_order_id', $id)->get();

        // dd($parameter->parameter_hour, $parameterNow);

        if (empty($salesOrder)) {

            return redirect(route('salesOrders.index'))->with('error', 'Order not found');
        }

        return view('sales_orders.show', compact('salesOrder', 'salesOrderDetails', 'customers', 'parameter', 'parameterNow', 'attachments'));
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

        if ($salesOrder->status == 'R' || $salesOrder->status == 'P') {
            // Flash::error('Cannot edit this order');

            return redirect(route('salesOrders.index'))->with('error', 'Cannot edit this order');
        }

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

        $customerProducts = CustomerProduct::select('inventory_code')->where('customer_code',  \Auth::user()->customer->AcctCD)->get()->pluck('inventory_code');
        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->whereIn('InventoryCD', $customerProducts)->orderBy('InventoryCD', 'ASC')->get();


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

        // Removing Mask
        $orderTotal = $input['order_total'];
        $orderTotal = str_replace('.','',$orderTotal);
        $orderTotal = (int)str_replace(',','.',$orderTotal);

        // dd($customerMinOrder);

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

        
        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $id)->get();
        $deliveryDate = $input['delivery_date'];

        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$deliveryDate' AND (end_date is null OR end_date >= '$deliveryDate') ")->get()->first();


        $dataEdit = [];
        $dataEdit['order_nbr'] = $input['order_nbr'];
        $dataEdit['order_nbr_merge'] = $input['order_nbr'];
        $dataEdit['order_type'] = $input['order_type'];
        $dataEdit['delivery_date'] = $input['delivery_date'];
        $dataEdit['description'] = $input['description'];
        $dataEdit['order_qty'] = $salesOrderDetail->sum('qty');
        $dataEdit['order_amount'] = $salesOrderDetail->sum('amount');
        $dataEdit['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
        $dataEdit['updated_by'] = \Auth::user()->id;
        $dataEdit['updated_at'] = Carbon::now()->toDateTimeString();


        if (empty($salesOrder)) {
            Flash::error('Sales Order not found');

            return redirect(route('salesOrders.index'));
        }

        $salesOrder = $this->salesOrderRepository->update($dataEdit, $id);

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

    public function getPrice($code, $customer, $date){
        // dd($code, $customer);

        $priceClass = $this->getCPriceClass($customer);
        $inventory = $this->getInventoryID($code);
        $inventoryID = $inventory->InventoryID;
        $inventoryName = $inventory->Descr;
        $salesPrice = SalesPrice::whereRaw("CustPriceClassID = '$priceClass' AND InventoryID = '$inventoryID' AND EffectiveDate <= '$date' AND (ExpirationDate IS NULL OR ExpirationDate >= '$date')")->get()->first();
        // dd($salesPrice);
        $data['unit_price'] = number_format($salesPrice->SalesPrice,2,',','.');
        $data['uom'] = $salesPrice->UOM;
        $data['inventory_name'] = $inventoryName;

        return $data;
    }

    public function submitOrder($id)
    {
        // Cek Hak akses
        if (!\Auth::user()->can('submit sales order')) {
            abort(403);
        }

        // Find data sales order
        $salesOrder = SalesOrder::find($id);

        // Jika tidak ada return notfound
        if (empty($salesOrder)) {
            return redirect(route('salesOrders.index'))->with('error', 'Order Not Found');
        }

        // Get Status Direct Selling Rule
        $dsRule = DsRule::get()->first();


        // Cek Jika Direct Selling
        if($salesOrder->order_type == 'D'){
            // Cek Status Rule, IF Active, cek data prosentase PO reguler
            if ($dsRule->status == true) {
                $cekCountOrder = SalesOrder::whereIn('status', ['R', 'P'])->where('delivery_date', $salesOrder->delivery_date)->where('customer_id', $salesOrder->customer_id)->get()->first();
                // dd($cekCountOrder);
                if($cekCountOrder == null){
                    return redirect(route('salesOrders.show', $id))->with("error", "Untuk PO jenis Direct Selling, Anda harus melakukan submit PO Reguler terlebih dahulu");
                } else {
                    $customerCode = $salesOrder->customer->AcctCD;
                    $dsPercentage = DsPercentage::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') AND customer_code = '$customerCode' ")->get()->first();
                    if ($dsPercentage == null) {
                        return $this->nextSubmit($id);
                    } else {
                        $percentage = $dsPercentage->percentage;
                        $orderRegulerSubmitted = SalesOrder::whereIn('status', ['R', 'P'])->where('order_type', 'R')->where('delivery_date', $salesOrder->delivery_date)->where('customer_id', $salesOrder->customer_id)->get();
                        $totalOrderRegulerSubmitted = $orderRegulerSubmitted->sum('order_total');
                        $orderTotalSubmitted = SalesOrder::whereIn('status', ['R', 'P'])->where('delivery_date', $salesOrder->delivery_date)->where('customer_id', $salesOrder->customer_id)->get();
                        $totalOrderAllSubmitted = $orderTotalSubmitted->sum('order_total');
                        $totalOrderCounted = $totalOrderAllSubmitted + $salesOrder->order_total;
                        
                        // Perhitungan prosentase
                        $prosentaseReguler = ($totalOrderRegulerSubmitted / $totalOrderCounted) * 100;

                        if($prosentaseReguler < $percentage){
                            $minusPercentage = round($percentage - $prosentaseReguler,0);
                            return redirect(route('salesOrders.show', $id))->with("error", "PO Reguler anda belum memenuhi persyaratan. Kurang ".$minusPercentage." %" );
                        } else {
                            return $this->nextSubmit($id);
                        }
                    }
                }
            } else {
                return $this->nextSubmit($id);
            }

        } else {
            return $this->nextSubmit($id);
        }

        

        
    }

    public function nextSubmit($id)
    {
        $salesOrder = SalesOrder::find($id);

        // Get data minimum order for this customer
        $customerMinOrder = CustomerMinOrder::whereRaw("customer_code = '".$salesOrder->customer->AcctCD."' AND start_date <= '$salesOrder->delivery_date' AND (end_date IS NULL OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
        
        if($customerMinOrder == null){
            $minimumOrder = 0;
        } else {
            $minimumOrder = $customerMinOrder->minimum_order;
        }

        // Get all order by delivery date
        $orders = SalesOrder::selectRaw('sum(order_total) as total')
                ->where('customer_id', $salesOrder->customer_id)
                ->where('delivery_date', $salesOrder->delivery_date)
                ->whereIn('status', ['R','P'])
                ->whereNotIn('order_nbr', [$salesOrder->order_nbr])
                ->get();
        
        
        $totalOrderToday = $salesOrder->order_total + $orders[0]->total;

        // Jika ada datanya Validasi data order dengan minimum order per customer
        if($customerMinOrder != null){

            if($totalOrderToday >= $customerMinOrder->minimum_order ){
                return $this->processSubmit($id);
            } else {
                $minusOrder = $customerMinOrder->minimum_order - $salesOrder->order_total;
                return redirect(route('salesOrders.show', $id))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");
            }

        } else {
            // Get Minimum Order Category 
            $thisCustomer = Customer::where('BAccountID', $salesOrder->customer_id)->get()->first();
            // dd($thisCustomer->category);
            if($thisCustomer->category == null) {

                return redirect(route('salesOrders.show', $id))->with("error", "Category customer belum diatur, Tolong hubungi admin Yamazaki");

            } else {

                $customerCategory = $thisCustomer->category->Value;
                // Minimum order category customer
                $categoryMinOrder = CategoryMinOrder::whereRaw("category = '$customerCategory' AND start_date <= '$salesOrder->delivery_date' AND (end_date IS NULL OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
                
                if($categoryMinOrder == null){
                    return redirect(route('salesOrders.show', $id))->with("error", "Category order belum di atur, Tolong hubungi admin Yamazaki");
                } else {
                    // Validasi minimum order by category
                    if($totalOrderToday >= $categoryMinOrder->minimum_order ){
                        // dd('test');
                        return $this->processSubmit($id);
                    } else {
                        $minusOrder = $categoryMinOrder->minimum_order - $salesOrder->order_total;
                        return redirect(route('salesOrders.show', $id))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");
                    }
                }
            }

        }

    }

    public function processSubmit($id)
    {
        // Ambil Jam Submit
        $parameter = Parameter::where('name','Maximum Time Order')->get()->first();
        $parameterNow = Carbon::now()->toTimeString();

        // Cek Ulang Data Detail
        $salesOrder = SalesOrder::find($id);
        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $salesOrder->id)->get();

        if($salesOrder->order_amount == $salesOrderDetail->sum('qty')){
            $salesOrder = SalesOrder::find($id);
            $salesOrder['status'] = 'R';
            $salesOrder['submitted_by'] = \Auth::user()->id;
            $salesOrder['submitted_at'] = Carbon::now()->toDateTimeString();
            $salesOrder->save();
        } else {
            $salesOrder = SalesOrder::find($id);
            $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
            $salesOrder['status'] = 'R';
            $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
            $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
            $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
            $salesOrder['submitted_by'] = \Auth::user()->id;
            $salesOrder['submitted_at'] = Carbon::now()->toDateTimeString();
            $salesOrder->save();
        }


        if($parameterNow >= $parameter->parameter_hour){

            $mailTo = MailSetting::where('name', 'Overtime Order')->where('type', 'Receiver')->where('sub_type', 'To')->where('status', 1)->pluck('email');
            $mailCC = MailSetting::where('name', 'Overtime Order')->where('type', 'Receiver')->where('sub_type', 'CC')->where('status', 1)->pluck('email');
            $mailBCC = MailSetting::where('name', 'Overtime Order')->where('type', 'Receiver')->where('sub_type', 'BCC')->where('status', 1)->pluck('email');
            
            $email = $mailTo;
            $cc = $mailCC;
            $bcc = $mailBCC;
            $url = url("/salesOrders/$id");

            $data = [
                'title' => 'PENTING! Order masuk melewati jam batas',
                'name' => $salesOrder->customer->AcctName,
                'url' => $url,
            ];

            // if($email != null){

                Mail::to($email)->cc($cc)->bcc($bcc)->send(new SendMailSubmit($data));

            // }

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

        $id = $salesOrder->id;

        $cekSOAcumatica = SOOrder::where('OrderNbr', $salesOrder->order_nbr)->get();
        // dd($cekSOAcumatica);
        if ($cekSOAcumatica->count() >= 1) {
            return redirect(route('salesOrders.show', $id))->with('error', 'Before you reject this order. Please delete this SO Data in Acumatica');
        }

        $salesOrder = SalesOrder::find($input['id_order']);
        $salesOrder['status'] = 'B';
        $salesOrder['rejected_reason'] = $input['reason'];
        $salesOrder['rejected_by'] = \Auth::user()->id;
        $salesOrder['rejected_at'] = Carbon::now()->toDateTimeString();
        $salesOrder->save();

        return redirect(route('salesOrders.show', $id))->with('success', 'Order Rejected Sucessfully.');
    }

    public function resetOrder()
    {
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->delete();

        return redirect(route('createOrder'));
    }

    public function printPdf($id)
    {

        $salesOrder = SalesOrder::find($id);
        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id)->orderBy('inventory_id', 'ASC')->get();
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
            $dataprice = $this->getPrice($code, $customer, $salesOrder->delivery_date);
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
    
    public function uploadAttachment(Request $request){

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $x=20;
        $file = time().'-1.'.$request->file->extension();
        
        $img=\Image::make($request->file('file'))->orientate();
        
        $img->save(public_path('uploads/attachments/convert_'.$file),$x);

        $input['sales_order_id'] = $request->id_order;
        $input['type'] = $request->type;
        $input['image'] = 'convert_'.$file;

        Attachment::create($input);

        return redirect(route('salesOrders.show', $request->id_order));
    }

    public function importProduct(Request $request){

        // dd($request->all());
        $file = $request->file('file');
        $namaFile =  $file->getClientOriginalName();
        $file->move('uploads/product', $namaFile);

        $import = Excel::import(new ProductImport($request->date_file), public_path('uploads/product/'.$namaFile));
        
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->get()->first();

        if($carts == null){
            return response()->json([
                'error' => 'You have not accesiable for some products',
            ], 404);
        } else {
            return response()->json([
                'success' => 'Data Imported Successfully',
            ]);
        }
        

    }


    public function bulkSubmitIndex()
    {
        $date = Carbon::now();
        $date->addDays(3);

        $minDeliveryDate = $date->toDateString();

        return view('sales_orders.bulk_submit', compact('minDeliveryDate'));
    }

    
    public function bulkSubmitProcess(Request $request)
    {   
        $input = $request->all();
        if(!isset($input['id'])){
            // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Pilih Minimal 1 Order yang akan di submit!");
            $returnData = array(
                'message' => 'Pilih Minimal 1 Order yang akan di submit!',
            );
    
            return response()->json($returnData, 403);
        }
        $idOrders = $input['id'];
        $deliveryDate = $input['date'];

        $submitOrders = SalesOrder::whereIn('id', $idOrders)->get();
        $submitOrderD = SalesOrder::whereIn('id', $idOrders)->where('order_type', 'D')->get();
        $submitOrderR = SalesOrder::whereIn('id', $idOrders)->where('order_type', 'R')->get();
        $processedOrders = SalesOrder::where('delivery_date', $input['date'])->whereIn('status', ['P', 'R'])->where('customer_id', $submitOrders[0]->customer_id)->get();
        $processedOrderD = SalesOrder::where('order_type', 'D')->where('delivery_date', $input['date'])->whereIn('status', ['P', 'R'])->where('customer_id', $submitOrders[0]->customer_id)->get();
        $processedOrderR = SalesOrder::where('order_type', 'R')->where('delivery_date', $input['date'])->whereIn('status', ['P', 'R'])->where('customer_id', $submitOrders[0]->customer_id)->get();

        // Get Status Direct Selling Rule
        $dsRule = DsRule::get()->first();

        // Jika Order Direct Selling Tidak Ada
        if ($submitOrderD->sum('order_total') == null) {

            $customer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();

            // Cek Minimum Order Customer
            $customerMinOrder = CustomerMinOrder::whereRaw("customer_code = '".$customer->AcctCD."' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
        
            if($customerMinOrder == null){
                $minimumOrder = 0;
            } else {
                $minimumOrder = $customerMinOrder->minimum_order;
            }

            // Jika ada datanya Validasi data order dengan minimum order per customer
            if($customerMinOrder != null){

                $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                if($totalOrderToday >= $customerMinOrder->minimum_order ){
                    foreach($submitOrders as $order) {
                        $this->processSubmitBulk($order->id);
                    }
                    return response()->json(['success'=>'Order Submitted successfully.']);
                } else {
                    $minusOrder = $customerMinOrder->minimum_order - $totalOrderToday;
                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");

                    $returnData = array(
                        "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                    );
            
                    return response()->json($returnData, 403);
                }

            } else {
                // Get Minimum Order Category 
                $thisCustomer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();
                // dd($thisCustomer->category);
                if($thisCustomer->category == null) {

                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category customer belum diatur, Tolong hubungi admin Yamazaki");

                    $returnData = array(
                        "message" => "Category customer belum diatur, Tolong hubungi admin Yamazaki",
                    );
            
                    return response()->json($returnData, 403);

                } else {

                    $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                    $customerCategory = $thisCustomer->category->Value;
                    // Minimum order category customer
                    $categoryMinOrder = CategoryMinOrder::whereRaw("category = '$customerCategory' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
                    
                    if($categoryMinOrder == null){
                    
                        $returnData = array(
                            "message" => "Category order belum di atur, Tolong hubungi admin Yamazaki",
                        );
                
                        return response()->json($returnData, 403);
                    
                    } else {
                        // Validasi minimum order by category
                        if($totalOrderToday >= $categoryMinOrder->minimum_order ){
                            foreach($submitOrders as $order) {
                                $this->processSubmitBulk($order->id);
                            }
                            return response()->json(['success'=>'Order Submitted successfully.']);
                        } else {
                            $minusOrder = $categoryMinOrder->minimum_order - $totalOrderToday;
                            // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");

                            $returnData = array(
                                "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                            );
                    
                            return response()->json($returnData, 403);

                        }
                    }
                }

            }

        } else {

            // Cek Status Rule, IF Active, cek data prosentase PO reguler
            if ($dsRule->status == true) {
                $totalOrderReguler = $submitOrderR->sum('order_total') + $processedOrderR->sum('order_total');
                // dd($cekCountOrder);
                if($totalOrderReguler == 0){
                    
                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Untuk PO jenis Direct Selling, Anda harus melakukan submit PO Reguler terlebih dahulu");
                    
                    $returnData = array(
                        "message" => "Untuk PO jenis Direct Selling, Anda harus melakukan submit PO Reguler terlebih dahulu",
                    );
            
                    return response()->json($returnData, 403);
                
                } else {
                    $customer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();

                    $dsPercentage = DsPercentage::whereRaw("start_date <= '$deliveryDate' AND (end_date is null OR end_date >= '$deliveryDate') AND customer_code = '$customer->AcctCD' ")->get()->first();
                    
                    if ($dsPercentage == null) {
                        // Jika DS Percentage Null, Maka Langsung cek Minimum Order
                        // Cek Minimum Order Customer
                        $customerMinOrder = CustomerMinOrder::whereRaw("customer_code = '".$customer->AcctCD."' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
                    
                        if($customerMinOrder == null){
                            $minimumOrder = 0;
                        } else {
                            $minimumOrder = $customerMinOrder->minimum_order;
                        }

                        // Jika ada datanya Validasi data order dengan minimum order per customer
                        if($customerMinOrder != null){

                            $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                            if($totalOrderToday >= $customerMinOrder->minimum_order ){
                                foreach($submitOrders as $order) {
                                    $this->processSubmitBulk($order->id);
                                }
                                return response()->json(['success'=>'Order Submitted successfully.']);
                            } else {
                                $minusOrder = $customerMinOrder->minimum_order - $totalOrderToday;
                                // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");
                                $returnData = array(
                                    "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                                );
                        
                                return response()->json($returnData, 403);
                            }

                        } else {
                            // Get Minimum Order Category 
                            $thisCustomer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();
                            // dd($thisCustomer->category);
                            if($thisCustomer->category == null) {

                                // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category customer belum diatur, Tolong hubungi admin Yamazaki");

                                $returnData = array(
                                    "message" => "Category customer belum diatur, Tolong hubungi admin Yamazaki",
                                );
                        
                                return response()->json($returnData, 403);

                            } else {

                                $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                                $customerCategory = $thisCustomer->category->Value;
                                // Minimum order category customer
                                $categoryMinOrder = CategoryMinOrder::whereRaw("category = '$customerCategory' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
                                
                                if($categoryMinOrder == null){
                                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category order belum di atur, Tolong hubungi admin Yamazaki");
                                
                                    $returnData = array(
                                        "message" => "Category order belum di atur, Tolong hubungi admin Yamazaki",
                                    );
                            
                                    return response()->json($returnData, 403);

                                } else {
                                    // Validasi minimum order by category
                                    if($totalOrderToday >= $categoryMinOrder->minimum_order ){
                                        foreach($submitOrders as $order) {
                                            $this->processSubmitBulk($order->id);
                                        }
                                        return response()->json(['success'=>'Order Submitted successfully.']);
                                    } else {
                                        $minusOrder = $categoryMinOrder->minimum_order - $totalOrderToday;
                                        // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");
                                    
                                        $returnData = array(
                                            "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                                        );
                                
                                        return response()->json($returnData, 403);
                                    }
                                }
                            }

                        }
                    } else {
                        
                        $percentage = $dsPercentage->percentage;
                        $totalOrderCounted = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');
                        
                        // Perhitungan prosentase
                        $prosentaseReguler = (( $submitOrderR->sum('order_total') + $processedOrderR->sum('order_total')) / $totalOrderCounted) * 100;

                        if($prosentaseReguler < $percentage){
                            $minusPercentage = round($percentage - $prosentaseReguler, 2);
                            // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "PO Reguler anda belum memenuhi persyaratan. Kurang ".$minusPercentage." %" );
                            
                            $returnData = array(
                                "message" => "PO Reguler anda belum memenuhi persyaratan. Kurang ".$minusPercentage." %",
                            );
                    
                            return response()->json($returnData, 403);
                        
                        } else {
                            // Jika Memenuhi Persyaratan Persentase, Langsung cek Minimum Order
                            $customer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();

                            // Cek Minimum Order Customer
                            $customerMinOrder = CustomerMinOrder::whereRaw("customer_code = '".$customer->AcctCD."' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
                        
                            if($customerMinOrder == null){
                                $minimumOrder = 0;
                            } else {
                                $minimumOrder = $customerMinOrder->minimum_order;
                            }

                            // Jika ada datanya Validasi data order dengan minimum order per customer
                            if($customerMinOrder != null){

                                $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                                if($totalOrderToday >= $customerMinOrder->minimum_order ){
                                    foreach($submitOrders as $order) {
                                        $this->processSubmitBulk($order->id);
                                    }
                                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with('success', 'Order Submitted Sucessfully.');
                                
                                    return response()->json(['success'=>'Order Submitted successfully.']);
                                } else {
                                    $minusOrder = $customerMinOrder->minimum_order - $totalOrderToday;
                                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");

                                    $returnData = array(
                                        "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                                    );
                            
                                    return response()->json($returnData, 403);
                                }

                            } else {
                                // Get Minimum Order Category 
                                $thisCustomer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();
                                // dd($thisCustomer->category);
                                if($thisCustomer->category == null) {

                                    // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category customer belum diatur, Tolong hubungi admin Yamazaki");
                                    
                                    $returnData = array(
                                        "message" => "Category customer belum diatur, Tolong hubungi admin Yamazaki",
                                    );
                            
                                    return response()->json($returnData, 403);

                                } else {

                                    $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                                    $customerCategory = $thisCustomer->category->Value;
                                    // Minimum order category customer
                                    $categoryMinOrder = CategoryMinOrder::whereRaw("category = '$customerCategory' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
                                    
                                    if($categoryMinOrder == null){
                                        // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category order belum di atur, Tolong hubungi admin Yamazaki");
                                        
                                        $returnData = array(
                                            "message" => "Category order belum di atur, Tolong hubungi admin Yamazaki",
                                        );
                                
                                        return response()->json($returnData, 403);
                                    } else {
                                        // Validasi minimum order by category
                                        if($totalOrderToday >= $categoryMinOrder->minimum_order ){
                                            foreach($submitOrders as $order) {
                                                $this->processSubmitBulk($order->id);
                                            }
                                            // return redirect(route('salesOrders.bulkSubmitIndex'))->with('success', 'Order Submitted Sucessfully.');
                                            
                                            return response()->json(['success'=>'Order Submitted successfully.']);
                                        } else {
                                            $minusOrder = $categoryMinOrder->minimum_order - $totalOrderToday;
                                            // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");
                                        
                                            $returnData = array(
                                                "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                                            );
                                    
                                            return response()->json($returnData, 403);

                                        }
                                    }
                                }

                            }
                        }
                    }
                }
            } else {
                // Jika DS Rule Tidak Ada, Langsung cek minimum Order
                $customer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();

                // Cek Minimum Order Customer
                $customerMinOrder = CustomerMinOrder::whereRaw("customer_code = '".$customer->AcctCD."' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
            
                if($customerMinOrder == null){
                    $minimumOrder = 0;
                } else {
                    $minimumOrder = $customerMinOrder->minimum_order;
                }

                // Jika ada datanya Validasi data order dengan minimum order per customer
                if($customerMinOrder != null){

                    $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                    if($totalOrderToday >= $customerMinOrder->minimum_order ){
                        foreach($submitOrders as $order) {
                            $this->processSubmitBulk($order->id);
                        }
                        // return redirect(route('salesOrders.bulkSubmitIndex'))->with('success', 'Order Submitted Sucessfully.');
                    
                        return response()->json(['success'=>'Order Submitted successfully.']);
                    } else {
                        $minusOrder = $customerMinOrder->minimum_order - $totalOrderToday;
                        // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");
                        
                        $returnData = array(
                            "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($customerMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                        );
                
                        return response()->json($returnData, 403);
                    }

                } else {
                    // Get Minimum Order Category 
                    $thisCustomer = Customer::where('BAccountID', $submitOrders[0]->customer_id)->get()->first();
                    // dd($thisCustomer->category);
                    if($thisCustomer->category == null) {

                        // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category customer belum diatur, Tolong hubungi admin Yamazaki");

                        $returnData = array(
                            "message" => "Category customer belum diatur, Tolong hubungi admin Yamazaki",
                        );
                
                        return response()->json($returnData, 403);

                    } else {

                        $totalOrderToday = $submitOrders->sum('order_total') + $processedOrders->sum('order_total');

                        $customerCategory = $thisCustomer->category->Value;
                        // Minimum order category customer
                        $categoryMinOrder = CategoryMinOrder::whereRaw("category = '$customerCategory' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate') ")->get()->first();
                        
                        if($categoryMinOrder == null){
                            // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Category order belum di atur, Tolong hubungi admin Yamazaki");
                        
                            $returnData = array(
                                "message" => "Category order belum di atur, Tolong hubungi admin Yamazaki",
                            );
                    
                            return response()->json($returnData, 403);
                        } else {
                            // Validasi minimum order by category
                            if($totalOrderToday >= $categoryMinOrder->minimum_order ){
                                foreach($submitOrders as $order) {
                                    $this->processSubmitBulk($order->id);
                                }
                                
                                // return redirect(route('salesOrders.bulkSubmitIndex'))->with('success', 'Order Submitted Sucessfully.');
                                return response()->json(['success'=>'Order Submitted successfully.']);
                            
                            } else {
                                $minusOrder = $categoryMinOrder->minimum_order - $totalOrderToday;
                                // return redirect(route('salesOrders.bulkSubmitIndex'))->with("error", "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")");

                                $returnData = array(
                                    "message" => "Maaf Order anda belum mencapai minimum order. Minimum order anda adalah Rp. ".number_format($categoryMinOrder->minimum_order)." (kurang Rp. ".number_format($minusOrder).")",
                                );
                        
                                return response()->json($returnData, 403);
                            }
                        }
                    }

                }
            }
            
        }
    }

    public function processSubmitBulk($id)
    {
        // Ambil Jam Submit
        $parameter = Parameter::where('name','Maximum Time Order')->get()->first();
        $parameterNow = Carbon::now()->toTimeString();

        // Cek Ulang Data Detail
        $salesOrder = SalesOrder::find($id);
        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $salesOrder->id)->get();

        if($salesOrder->order_amount == $salesOrderDetail->sum('qty')){
            $salesOrder = SalesOrder::find($id);
            $salesOrder['status'] = 'R';
            $salesOrder['submitted_by'] = \Auth::user()->id;
            $salesOrder['submitted_at'] = Carbon::now()->toDateTimeString();
            $salesOrder->save();
        } else {
            $salesOrder = SalesOrder::find($id);
            $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
            $salesOrder['status'] = 'R';
            $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
            $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
            $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
            $salesOrder['submitted_by'] = \Auth::user()->id;
            $salesOrder['submitted_at'] = Carbon::now()->toDateTimeString();
            $salesOrder->save();
        }


        if($parameterNow >= $parameter->parameter_hour){

            $mailTo = MailSetting::where('name', 'Overtime Order')->where('type', 'Receiver')->where('sub_type', 'To')->where('status', 1)->pluck('email');
            $mailCC = MailSetting::where('name', 'Overtime Order')->where('type', 'Receiver')->where('sub_type', 'CC')->where('status', 1)->pluck('email');
            $mailBCC = MailSetting::where('name', 'Overtime Order')->where('type', 'Receiver')->where('sub_type', 'BCC')->where('status', 1)->pluck('email');
            
            $email = $mailTo;
            $cc = $mailCC;
            $bcc = $mailBCC;
            $url = url("/salesOrders/$id");

            $data = [
                'title' => 'PENTING! Order masuk melewati jam batas',
                'name' => $salesOrder->customer->AcctName,
                'url' => $url,
            ];

            // if($email != null){

                Mail::to($email)->cc($cc)->bcc($bcc)->send(new SendMailSubmit($data));

            // }

        }

    }
    

    public function dataSubmit(Request $request, $date)
    {
        if ($request->ajax()) {

            $datas = SalesOrder::where('delivery_date', $date)->where('status', 'S')->where('customer_id', \Auth::user()->customer_id)->orderBy('id', 'desc');
            

            return DataTables::of($datas)
                ->addColumn('checkbox', function (SalesOrder $salesOrder) {
                    return "<input type='checkbox' class='checkbox1' id='checkbox1' name='id[]' value='".$salesOrder->id."'>";
                })
                ->addColumn('customer', function (SalesOrder $salesOrder) {
                    return $salesOrder->customer->AcctName;
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
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
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
                    return 'Draft';
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('sales_orders.action')->with('salesOrder',$data)->render();
                })
                ->rawColumns(['action', 'checkbox'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    public function dataMerge(Request $request, $date, $customer, $type)
    {
        if ($request->ajax()) {

            $soOrder = SOOrder::select('OrderNbr')->whereYear('RequestDate', date('Y', strtotime($date)))->whereMonth('RequestDate', date('m', strtotime($date)))->pluck('OrderNbr')->toArray();

            $datas = SalesOrder::where('delivery_date', $date)->where('customer_id', $customer)->where('order_type', $type)->whereIn('status', ['R', 'P'])->whereNotIn('order_nbr', $soOrder)->orderBy('id', 'desc');
            

            return DataTables::of($datas)
                ->addColumn('checkbox', function (SalesOrder $salesOrder) {
                    return "<input type='checkbox' class='checkbox1' id='checkbox1' name='id[]' value='".$salesOrder->id."'>";
                })
                ->addColumn('customer', function (SalesOrder $salesOrder) {
                    return $salesOrder->customer->AcctName;
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
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrder $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
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
                    if ($salesOrder->status == 'R') {
                        return 'Submitted';
                    } else {
                        return 'Processed';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('sales_orders.action')->with('salesOrder',$data)->render();
                })
                ->rawColumns(['action', 'checkbox'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    public function mergeIndex()
    {
        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('sales_orders.merge', compact('customers'));
    }

    public function mergeProcess(Request $request)
    {
        $input = $request->all();
        if(!isset($input['id']) || count($input['id']) < 2){
            $returnData = array(
                'message' => 'Pilih Minimal 2 Order yang akan di merge!',
            );
    
            return response()->json($returnData, 403);
        }

        $salesOrders = SalesOrder::whereIn('id', $input['id'])->orderBy('id')->get();
        $noOrder = $salesOrders[0]->order_nbr;
        foreach ($salesOrders as $order) {
            $dataOrder = SalesOrder::find($order->id);
            $dataOrder['order_nbr_merge'] = $noOrder;
            $dataOrder['order_merged_by'] = \Auth::user()->id;
            $dataOrder->save();
        }

        return response()->json(['success' => 'Merge Successfull!']);
                        
    }

}
