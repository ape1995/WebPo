<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderDetailRequest;
use App\Http\Requests\UpdateSalesOrderDetailRequest;
use App\Repositories\SalesOrderDetailRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
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
            $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
            $salesOrder['order_total'] = $salesOrder['order_amount'] + $salesOrder['tax'];
            $salesOrder->save();
       
            return response()->json(['success'=>'Products added successfully.']);

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
        $response = $salesOrderDetail->all();
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
        $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
        $salesOrder['order_total'] = $salesOrder['order_amount'] + $salesOrder['tax'];
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
        $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
        $salesOrder['order_total'] = $salesOrder['order_amount'] + $salesOrder['tax'];
        $salesOrder->save();

     
        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function getData(Request $request, $code)
    {
        
        if ($request->ajax()) {
            $datas = SalesOrderDetail::where('sales_order_id', $code)->get();
            return DataTables::of($datas)
                ->editColumn('qty', function (SalesOrderDetail $data) 
                {
                    return number_format($data->qty, 0, ',', '.');
                })
                ->editColumn('unit_price', function (SalesOrderDetail $data) 
                {
                    return number_format($data->unit_price, 2, ',', '.');
                })
                ->editColumn('amount', function (SalesOrderDetail $data) 
                {
                    return number_format($data->amount, 2, ',', '.');
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editProduct" title="Edit"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';

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
        $tax = ($parameterVAT->value/100) * $data['order_amount'];
        $total = $data['order_amount'] + $tax;
        $data['order_qty'] = number_format($data['order_qty'],0,',','.');
        $data['order_amount'] = number_format($data['order_amount'],2,',','.');
        $data['tax'] = number_format($tax,2,',','.');
        $data['order_total'] = number_format($total,2,',','.');

        return $data;

    }
}
