<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderPromoRequest;
use App\Http\Requests\UpdateSalesOrderPromoRequest;
use App\Repositories\SalesOrderPromoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\CartPromo;
use App\Models\Parameter;
use App\Models\ParameterVAT;
use App\Models\PacketDiscount;
use App\Models\SalesOrderPromo;
use App\Models\SalesOrderPromoDetail;
use App\Models\Customer;
use App\Models\AttachmentPromo;
use Carbon\Carbon;
use Flash;
use Response;
use DataTables;
use PDF;


class SalesOrderPromoController extends AppBaseController
{
    /** @var  SalesOrderPromoRepository */
    private $salesOrderPromoRepository;

    public function __construct(SalesOrderPromoRepository $salesOrderPromoRepo)
    {
        $this->salesOrderPromoRepository = $salesOrderPromoRepo;
    }

    /**
     * Display a listing of the SalesOrderPromo.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $salesOrderPromos = $this->salesOrderPromoRepository->all();

        return view('sales_order_promos.index')
            ->with('salesOrderPromos', $salesOrderPromos);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {

            if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
                $datas = SalesOrderPromo::where('customer_id', \Auth::user()->customer_id)->orderBy('id', 'desc');
            } else {
                $datas = SalesOrderPromo::with('customer')->whereNotIn('status', ['S', 'C'])->latest();
            }

            return DataTables::of($datas)
                ->addColumn('customer', function (SalesOrderPromo $salesOrder) {
                    return $salesOrder->customer->AcctName;
                })
                ->addColumn('order_type', function (SalesOrderPromo $salesOrder) {
                    return $salesOrder->order_type == 'P' ? 'Packet Discount' : '';
                })
                ->addColumn('created_name', function (SalesOrderPromo $salesOrder) {
                    return $salesOrder->createdBy->name;
                })
                ->editColumn('order_date', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
                })
                ->editColumn('tax', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->tax, 2, ',', '.');
                })
                ->editColumn('order_total', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_total, 2, ',', '.');
                })
                ->editColumn('status', function (SalesOrderPromo $salesOrder) 
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
                    return view('sales_order_promos.action')->with('salesOrder',$data)->render();
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new SalesOrderPromo.
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
        $rbpClass = \Auth::user()->customer->location->CPriceClassID;

        $minDeliveryDate = $date->toDateString();
        
        return view('sales_order_promos.create', compact('customers', 'minDeliveryDate'));
    }

    /**
     * Store a newly created SalesOrderPromo in storage.
     *
     * @param CreateSalesOrderPromoRequest $request
     *
     * @return Response
     */
    public function store(CreateSalesOrderPromoRequest $request)
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
        
        $cekOrder = SalesOrderPromo::where('customer_id', $input['customer_id'])->where('delivery_date', $input['delivery_date'])->latest()->first();
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
        $input['created_by'] = \Auth::user()->id;
        $input['status'] = 'S';
        $deliveryDate = $input['delivery_date'];

        $carts = CartPromo::where('customer_id', $input['customer_id'])->get();

        if($carts == null){
            return redirect(route('SalesOrderPromos.create'))->with('error', 'Keranjang anda kosong');
        }
        // dd($carts);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$deliveryDate' AND (end_date is null OR end_date >= '$deliveryDate') ")->get()->first();

        $input['order_qty'] = $carts->sum('qty');
        $input['order_amount'] = $carts->sum('total');
        $input['tax'] = ($parameterVAT->value/100) *$input['order_amount'];
        $input['order_total'] = $input['order_amount'] + $input['tax'];


        // Store To Sales Order DB
        $salesOrder = $this->salesOrderPromoRepository->create($input);

        // Get All Carts Item

        // Resave all carts item into sales order detail
        foreach($carts as $data){
            $detailData['sales_order_promo_id'] = $salesOrder->id;
            $detailData['packet_code'] = $data->packet_code;
            $detailData['qty'] = $data->qty;
            $detailData['unit_price'] = $data->unit_price;
            $detailData['total'] = $data->total;

            $salesOrderDetail = SalesOrderPromoDetail::create($detailData);
        }

        // Delete All Carts from customer
        CartPromo::where('customer_id', $request->customer_id)->delete();

        return redirect(route('salesOrderPromos.show', $salesOrder->id))->with('success', 'Order saved successfully.');
    }

    /**
     * Display the specified SalesOrderPromo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);
        
        if(\Auth::user()->role == 'Customers'  || \Auth::user()->role == 'Staff Customers'){
            if($salesOrderPromo->customer_id != \Auth::user()->customer_id){
                abort(403);
            }
        }

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        $salesOrderDetails = SalesOrderPromoDetail::where('sales_order_promo_id', $id )->orderBy('packet_code', 'ASC')->get();
        $customers = Customer::where('BAccountID', $salesOrderPromo->customer_id)->get();

        $parameter = Parameter::where('name','Maximum Time Order')->get()->first();
        $parameterNow = Carbon::now()->toTimeString();

        $attachments = AttachmentPromo::where('sales_order_promo_id', $id)->get();

        return view('sales_order_promos.show', compact('salesOrderDetails', 'customers', 'salesOrderPromo', 'parameter', 'parameterNow', 'attachments'));
    }

    /**
     * Show the form for editing the specified SalesOrderPromo.
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

        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);

        if ($salesOrderPromo->status == 'C' || $salesOrderPromo->status == 'P') {
            // Flash::error('Cannot edit this order');

            return redirect(route('salesOrderPromos.index'))->with('error', 'Cannot edit this order');
        }

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
        } else {
            $customers = Customer::where('Type', 'CU')->where('Status', 'A')->get();
        }

        $date = Carbon::now();
        $date->addDays(3);

        $minDeliveryDate = $date->toDateString();

        $packetDiscounts = PacketDiscount::whereRaw("start_date <= '$salesOrderPromo->delivery_date' AND (end_date is null OR end_date >= '$salesOrderPromo->delivery_date') ")->where('status', 'Released')->where('rbp_class', \Auth::user()->customer->location->CPriceClassID)->get();

        // $customerProducts = CustomerProduct::select('inventory_code')->where('customer_code',  \Auth::user()->customer->AcctCD)->get()->pluck('inventory_code');
        // $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->whereIn('InventoryCD', $customerProducts)->orderBy('InventoryCD', 'ASC')->get();


        return view('sales_order_promos.edit', compact('packetDiscounts', 'salesOrderPromo', 'minDeliveryDate', 'customers'));
    }

    /**
     * Update the specified SalesOrderPromo in storage.
     *
     * @param int $id
     * @param UpdateSalesOrderPromoRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $salesOrder = $this->salesOrderPromoRepository->find($id);

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

            $cekOrder = SalesOrderPromo::where('customer_id', $input['customer_id'])->where('delivery_date', $input['delivery_date'])->latest()->first();
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

        
        $salesOrderDetail = SalesOrderPromoDetail::where('sales_order_promo_id', $id)->get();
        $deliveryDate = $input['delivery_date'];

        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$deliveryDate' AND (end_date is null OR end_date >= '$deliveryDate') ")->get()->first();


        $dataEdit = [];
        $dataEdit['order_nbr'] = $input['order_nbr'];
        $dataEdit['order_type'] = $input['order_type'];
        $dataEdit['delivery_date'] = $input['delivery_date'];
        $dataEdit['description'] = $input['description'];
        $dataEdit['order_qty'] = $salesOrderDetail->sum('qty');
        $dataEdit['order_amount'] = $salesOrderDetail->sum('total');
        $dataEdit['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
        $dataEdit['updated_by'] = \Auth::user()->id;
        $dataEdit['updated_at'] = Carbon::now()->toDateTimeString();


        if (empty($salesOrder)) {
            Flash::error('Sales Order not found');

            return redirect(route('salesOrders.index'));
        }

        $salesOrder = $this->salesOrderPromoRepository->update($dataEdit, $id);

        return redirect(route('salesOrderPromos.show', $id))->with('success', 'Order Updated Sucessfully');
    }

    /**
     * Remove the specified SalesOrderPromo from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        $this->salesOrderPromoRepository->delete($id);

        Flash::success('Sales Order Promo deleted successfully.');

        return redirect(route('salesOrderPromos.index'));
    }

    public function resetOrder()
    {
        $carts = CartPromo::where('customer_id', \Auth::user()->customer_id)->delete();

        return redirect(route('createPromoOrder'));
    }

    public function cancelOrder($id)
    {

        if (!\Auth::user()->can('cancel sales order')) {
            abort(403);
        }

        $salesOrderPromo = SalesOrderPromo::find($id);

        if (empty($salesOrderPromo)) {
            return redirect(route('salesOrderPromos.index'))->with('error', 'Order Not Found');
        }

        $salesOrderPromo = SalesOrderPromo::find($id);
        $salesOrderPromo['status'] = 'C';
        $salesOrderPromo['canceled_by'] = \Auth::user()->id;
        $salesOrderPromo['canceled_at'] = Carbon::now()->toDateTimeString();
        $salesOrderPromo->save();

        return redirect(route('salesOrderPromos.index'))->with('success', 'Order Canceled Sucessfully.');
    }

    public function rejectOrder(Request $request)
    {

        if (!\Auth::user()->can('reject sales order')) {
            abort(403);
        }

        $input = $request->all();

        $salesOrderPromo = SalesOrderPromo::find($input['id_order']);

        if (empty($salesOrderPromo)) {
            return redirect(route('salesOrderPromos.index'))->with('error', 'Order Not Found');
        }

        $id = $salesOrderPromo->id;

        $cekSOAcumatica = SOOrder::where('OrderNbr', $salesOrderPromo->order_nbr)->get();
        // dd($cekSOAcumatica);
        if ($cekSOAcumatica->count() >= 1) {
            return redirect(route('salesOrders.show', $id))->with('error', 'Before you reject this order. Please delete this SO Data in Acumatica');
        }

        $salesOrderPromo = SalesOrderPromo::find($input['id_order']);
        $salesOrderPromo['status'] = 'B';
        $salesOrderPromo['rejected_reason'] = $input['reason'];
        $salesOrderPromo['rejected_by'] = \Auth::user()->id;
        $salesOrderPromo['rejected_at'] = Carbon::now()->toDateTimeString();
        $salesOrderPromo->save();

        return redirect(route('salesOrderPromos.show', $id))->with('success', 'Order Rejected Sucessfully.');
    }

    public function submitOrder ($id)
    {

        if (!\Auth::user()->can('submit sales order')) {
            abort(403);
        }

        $salesOrderPromo = SalesOrderPromo::find($id);

        if (empty($salesOrderPromo)) {
            return redirect(route('salesOrderPromos.index'))->with('error', 'Order Not Found');
        }

        $salesOrderPromo = SalesOrderPromo::find($id);
        $salesOrderPromo['status'] = 'R';
        $salesOrderPromo['submitted_by'] = \Auth::user()->id;
        $salesOrderPromo['submitted_at'] = Carbon::now()->toDateTimeString();
        $salesOrderPromo->save();

        return redirect(route('salesOrderPromos.index'))->with('success', 'Order Submitted Sucessfully.');
    }

    public function processOrder($id)
    {

        if (!\Auth::user()->can('process sales order')) {
            abort(403);
        }

        $salesOrderPromo = SalesOrderPromo::find($id);

        if (empty($salesOrderPromo)) {
            return redirect(route('salesOrderPromos.index'))->with('error', 'Order Not Found');
        }

        $salesOrderPromo = SalesOrderPromo::find($id);
        $salesOrderPromo['status'] = 'P';
        $salesOrderPromo['processed_by'] = \Auth::user()->id;
        $salesOrderPromo['processed_at'] = Carbon::now()->toDateTimeString();
        $salesOrderPromo->save();

        return redirect(route('salesOrderPromos.index'))->with('success', 'Order Processed Sucessfully.');
    }

    public function uploadAttachment(Request $request){

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $x=20;
        $file = time().'-1.'.$request->file->extension();
        
        $img=\Image::make($request->file('file'))->orientate();
        
        $img->save(public_path('uploads/attachments/convert_'.$file),$x);

        $input['sales_order_promo_id'] = $request->id_order;
        $input['type'] = $request->type;
        $input['image'] = 'convert_'.$file;

        AttachmentPromo::create($input);

        return redirect(route('salesOrderPromos.show', $request->id_order));
    }

    public function printPdf($id)
    {

        $salesOrder = SalesOrderPromo::find($id);
        $salesOrderDetails = SalesOrderPromoDetail::where('sales_order_promo_id', $id)->orderBy('packet_code', 'ASC')->get();
        // dd($salesOrder);

        if (empty($salesOrder)) {
            return redirect(route('salesOrderPromos.index'))->with('error', 'Order Not Found');
        }

        $pdf = PDF::loadview('sales_order_promos.print',['salesOrder'=>$salesOrder, 'salesOrderDetails'=>$salesOrderDetails]);
    	return $pdf->download("Order Promo - $salesOrder->order_nbr.pdf");

        // return view('sales_orders.print', compact('salesOrder', 'salesOrderDetails'));
    }


}
