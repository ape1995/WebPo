<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderDetailRequest;
use App\Http\Requests\UpdateSalesOrderDetailRequest;
use App\Repositories\SalesOrderDetailRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\Location;
use App\Models\SalesPrice;
use App\Models\SalesOrderDetail;
use App\Models\PacketDiscount;
use App\Models\ParameterVAT;
use Illuminate\Http\Request;
use Flash;
use Response;
use DataTables;

class SalesOrderDetailController extends AppBaseController
{
    /** @var  SalesOrderDetailRepository */
    private $salesOrderDetailRepository;

    public function __construct(SalesOrderDetailRepository $salesOrderDetailRepo)
    {
        $this->salesOrderDetailRepository = $salesOrderDetailRepo;
    }

    /**
     * Display a listing of the SalesOrderDetail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $salesOrderDetails = $this->salesOrderDetailRepository->all();

        return view('sales_order_details.index')
            ->with('salesOrderDetails', $salesOrderDetails);
    }

    /**
     * Show the form for creating a new SalesOrderDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales_order_details.create');
    }

    /**
     * Store a newly created SalesOrderDetail in storage.
     *
     * @param CreateSalesOrderDetailRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        // Check sudah ada dalam cart
        $cekProduct = SalesOrderDetail::where('inventory_id', $data['inventory_id'])->where('sales_order_id', $data['sales_order_id'])->get()->first();
        
        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['amount'] = str_replace('.','',$data['amount']);
        $data['amount'] = str_replace(',','.',$data['amount']);
        
        if($cekProduct !== null){

            return response()->json(['error'=>'Product already listed on carts.'], 403);

        } else {

            SalesOrderDetail::create([
                        'sales_order_id' => $request->sales_order_id,
                        'inventory_id' => $request->inventory_id,
                        'inventory_name' => $request->inventory_name,
                        'qty' => $request->qty,
                        'uom' => $request->uom,
                        'unit_price' => $data['unit_price'],
                        'amount' => $data['amount'],
                        'created_by' => \Auth::user()->id,
                    ]); 
             
            $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $request->sales_order_id)->get();
        
            $salesOrder = SalesOrder::find($request->sales_order_id);
            $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
            $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
            $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
            $salesOrder['discount'] = $salesOrderDetail->sum('discount');
            $salesOrder['tax'] = ($parameterVAT->value/100) * ( $salesOrder['order_amount'] - $salesOrder['discount'] );
            $salesOrder['order_total'] = $salesOrder['order_amount'] - $salesOrder['discount'] + $salesOrder['tax'];
            $salesOrder->save();
       
            return response()->json(['success'=>'Products added successfully.']);

        }
    }

    public function storePromo(Request $request)
    {
        $data = $request->all();

        // return response()->json(['success'=>$data]);
        
        $cekCart = SalesOrderDetail::where('packet_code', $data['packet_code'])->where('sales_order_id', $data['sales_order_id'])->get()->first();
        //    return response()->json(['success' => $cekCart]);
        if($cekCart == null){

            $packetDiscount = PacketDiscount::where('packet_code', $data['packet_code'])->get()->first();


            foreach($packetDiscount->detail as $detail){
                SalesOrderDetail::create([
                    'packet_code' => $packetDiscount->packet_code,
                    'sales_order_id' => $request->sales_order_id,
                    'inventory_id' => $detail->inventory_code,
                    'inventory_name' => $detail->inventory_name,
                    'qty' => $detail->qty * $data['qty'],
                    'uom' => 'PIECE',
                    'unit_price' => $detail->unit_price,
                    'discount' => $detail->discount_amount * $data['qty'],
                    'amount' => $detail->amount * $data['qty'],
                    'customer_id' => $data['customer_id'],
                    'created_by' => \Auth::user()->id,
                ]);    
            }

            $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $request->sales_order_id)->get();
        
            $salesOrder = SalesOrder::find($request->sales_order_id);
            $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
            $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
            $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
            $salesOrder['discount'] = $salesOrderDetail->sum('discount');
            $salesOrder['tax'] = ($parameterVAT->value/100) * ( $salesOrder['order_amount'] - $salesOrder['discount'] );
            $salesOrder['order_total'] = $salesOrder['order_amount'] - $salesOrder['discount'] + $salesOrder['tax'];
            $salesOrder->save();

            
       
            return response()->json(['success'=>'Cart added successfully.']);

        } else {

            $packetDiscount = PacketDiscount::where('packet_code', $data['packet_code'])->get()->first();
            
            foreach($packetDiscount->detail as $detail){
                $cart = SalesOrderDetail::where('packet_code', $data['packet_code'])->where('sales_order_id', $data['sales_order_id'])->where('inventory_id', $detail->inventory_code)->get()->first();
                $cart['qty'] = $cart->qty + ($detail->qty * $data['qty']);
                $cart['discount'] = $cart->discount + ($detail->discount_amount * $data['qty']);
                $cart['amount'] = $cart->amount + ($detail->amount * $data['qty']);
                $cart->save();
            }

            $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $request->sales_order_id)->get();
        
            $salesOrder = SalesOrder::find($request->sales_order_id);
            $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
            $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
            $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
            $salesOrder['discount'] = $salesOrderDetail->sum('discount');
            $salesOrder['tax'] = ($parameterVAT->value/100) * ( $salesOrder['order_amount'] - $salesOrder['discount'] );
            $salesOrder['order_total'] = $salesOrder['order_amount'] - $salesOrder['discount'] + $salesOrder['tax'];
            $salesOrder->save();

            return response()->json(['success'=>'Cart added successfully.']);

        }


    }

    /**
     * Display the specified SalesOrderDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salesOrderDetail = $this->salesOrderDetailRepository->find($id);

        if (empty($salesOrderDetail)) {
            Flash::error('Sales Order Detail not found');

            return redirect(route('salesOrderDetails.index'));
        }

        return view('sales_order_details.show')->with('salesOrderDetail', $salesOrderDetail);
    }

    /**
     * Show the form for editing the specified SalesOrderDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salesOrderDetail = SalesOrderDetail::find($id);
        
        $response['id'] = $salesOrderDetail->id;
        $response['inventory_name'] = $salesOrderDetail->inventory_name;
        $response['inventory_id']= $salesOrderDetail->inventory_id;
        $response['qty'] = $salesOrderDetail->qty;
        $response['unit_price'] = number_format($salesOrderDetail->unit_price,2,',','.');
        $response['amount'] = number_format($salesOrderDetail->amount,2,',','.');

        return response()->json($response);
    }

    /**
     * Update the specified SalesOrderDetail in storage.
     *
     * @param int $id
     * @param UpdateSalesOrderDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalesOrderDetailRequest $request)
    {
        $data = $request->all();
        $data['qty'] = str_replace('.','',$data['qty']);
        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['amount'] = str_replace('.','',$data['amount']);
        $data['amount'] = str_replace(',','.',$data['amount']);

        $salesOrderDetail = $this->salesOrderDetailRepository->update($data, $id);

        $salesOrderDetailData = SalesOrderDetail::find($id);

        $salesOrderID = $salesOrderDetailData->sales_order_id;

        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $salesOrderID)->get();
        
        $salesOrder = SalesOrder::find($salesOrderID);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
        $salesOrder['order_qty'] = $salesOrderDetails->sum('qty');
        $salesOrder['order_amount'] = $salesOrderDetails->sum('amount');
        $salesOrder['discount'] = $salesOrderDetails->sum('discount');
        $salesOrder['tax'] = ($parameterVAT->value/100) * ($salesOrder['order_amount'] - $salesOrder['discount']);
        $salesOrder['order_total'] = $salesOrder['order_amount'] - $salesOrder['discount'] + $salesOrder['tax'];
        $salesOrder->save();


        return response()->json(['success'=>'Data updated successfully.']);
    }

    /**
     * Remove the specified SalesOrderDetail from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesOrderDelete = SalesOrderDetail::find($id);
        $salesOrderID = $salesOrderDelete->sales_order_id;
        $salesOrderDelete->delete();
        
        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $salesOrderID)->get();
        
        $salesOrder = SalesOrder::find($salesOrderID);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
        $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
        $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
        $salesOrder['discount'] = $salesOrderDetail->sum('discount');
        $salesOrder['tax'] = ($parameterVAT->value/100) * ($salesOrder['order_amount'] - $salesOrder['discount']);
        $salesOrder['order_total'] = $salesOrder['order_amount'] - $salesOrder['discount'] + $salesOrder['tax'];
        $salesOrder->save();

     
        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function destroyPromo($id)
    {

        $salesOrderDetail = SalesOrderDetail::find($id);
        $salesOrderID = $salesOrderDetail->sales_order_id;
        SalesOrderDetail::where('packet_code', $salesOrderDetail->packet_code)->where('sales_order_id', $salesOrderDetail->sales_order_id)->delete();
     
        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $salesOrderID)->get();
        
        $salesOrder = SalesOrder::find($salesOrderID);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
        $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
        $salesOrder['order_amount'] = $salesOrderDetail->sum('amount');
        $salesOrder['discount'] = $salesOrderDetail->sum('discount');
        $salesOrder['tax'] = ($parameterVAT->value/100) * ($salesOrder['order_amount'] - $salesOrder['discount']);
        $salesOrder['order_total'] = $salesOrder['order_amount'] - $salesOrder['discount'] + $salesOrder['tax'];
        $salesOrder->save();


        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function getData(Request $request, $code)
    {
        
        if ($request->ajax()) {
            $datas = SalesOrderDetail::where('sales_order_id', $code)->orderBy('inventory_id', 'ASC')->get();
            return DataTables::of($datas)
                ->editColumn('inventory_name', function (SalesOrderDetail $data) 
                {
                    if ($data->packet_code == null) {
                        return $data->inventory_name;
                    } else {
                        return $data->inventory_name.' ( ' .$data->packet_code. ' )';
                    }
                    
                })
                ->editColumn('qty', function (SalesOrderDetail $data) 
                {
                    return number_format($data->qty, 0, ',', '.');
                })
                ->editColumn('unit_price', function (SalesOrderDetail $data) 
                {
                    return number_format($data->unit_price, 2, ',', '.');
                })
                ->editColumn('discount', function (SalesOrderDetail $data) 
                {
                    return number_format($data->discount, 2, ',', '.');
                })
                ->editColumn('amount', function (SalesOrderDetail $data) 
                {
                    return number_format($data->amount, 2, ',', '.');
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if ($row->header->order_type == 'C') {
                        $btn = '';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook2" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    } else {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editProduct" title="Edit"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    }

                        return $btn;
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    public function countOrderDetail($code, $date){

        $salesOrderDetail = SalesOrderDetail::where('sales_order_id', $code)->get();
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$date' AND (end_date is null OR end_date >= '$date') ")->get()->first();
        
            
        $data['order_qty'] = $salesOrderDetail->sum('qty');
        $data['order_amount'] = $salesOrderDetail->sum('amount');
        $data['discount'] = $salesOrderDetail->sum('discount');
        $tax = ($parameterVAT->value/100) * ($data['order_amount'] - $data['discount']);
        $total = $data['order_amount'] - $data['discount'] + $tax;
        $data['discount'] = number_format($data['discount'],2,',','.');
        $data['order_qty'] = number_format($data['order_qty'],0,',','.');
        $data['order_amount'] = number_format($data['order_amount'],2,',','.');
        $data['tax'] = number_format($tax,2,',','.');
        $data['order_total'] = number_format($total,2,',','.');

        return $data;

    }

    public function reCountDetailProduct($id, $date)
    {
        // dd('test');
        $salesOrderDetails = SalesOrderDetail::where('sales_order_id', $id)->get();
        $priceClass = $this->getCPriceClass(\Auth::user()->customer_id);

        if($salesOrderDetails->count('id') > 0){
            foreach($salesOrderDetails as $detail){
                $inventory = $this->getInventoryID($detail->inventory_id);
                $salesPrice = SalesPrice::whereRaw("CustPriceClassID = '$priceClass' AND InventoryID = '$inventory->InventoryID' AND EffectiveDate <= '$date' AND (ExpirationDate IS NULL OR ExpirationDate >= '$date')")->get()->first();
                
                $updateDetail = SalesOrderDetail::find($detail->id);
                $updateDetail['unit_price'] = $salesPrice->SalesPrice;
                $updateDetail['amount'] = $salesPrice->SalesPrice * $detail->qty;
                $updateDetail->save();
            }
        }
            
        return response()->json(['success'=>'Product deleted successfully.']);
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
}
