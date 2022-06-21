<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderPromoDetailRequest;
use App\Http\Requests\UpdateSalesOrderPromoDetailRequest;
use App\Repositories\SalesOrderPromoDetailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\SalesOrderPromo;
use App\Models\SalesOrderPromoDetail;
use App\Models\ParameterVAT;
use Flash;
use Response;
use DataTables;

class SalesOrderPromoDetailController extends AppBaseController
{
    /** @var  SalesOrderPromoDetailRepository */
    private $salesOrderPromoDetailRepository;

    public function __construct(SalesOrderPromoDetailRepository $salesOrderPromoDetailRepo)
    {
        $this->salesOrderPromoDetailRepository = $salesOrderPromoDetailRepo;
    }

    /**
     * Display a listing of the SalesOrderPromoDetail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $salesOrderPromoDetails = $this->salesOrderPromoDetailRepository->all();

        return view('sales_order_promo_details.index')
            ->with('salesOrderPromoDetails', $salesOrderPromoDetails);
    }

    public function getData(Request $request, $code)
    {
        
        if ($request->ajax()) {
            $datas = SalesOrderPromoDetail::where('sales_order_promo_id', $code)->orderBy('packet_code', 'ASC')->get();
            return DataTables::of($datas)
                ->editColumn('qty', function (SalesOrderPromoDetail $data) 
                {
                    return number_format($data->qty, 0, ',', '.');
                })
                ->editColumn('unit_price', function (SalesOrderPromoDetail $data) 
                {
                    return number_format($data->unit_price, 2, ',', '.');
                })
                ->editColumn('total', function (SalesOrderPromoDetail $data) 
                {
                    return number_format($data->total, 2, ',', '.');
                })
                ->addColumn('uom', function (SalesOrderPromoDetail $data) 
                {
                    return 'Packet(s)';
                })
                ->addColumn('packet_name', function (SalesOrderPromoDetail $data) 
                {
                    return $data->packet->packet_name;
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

    /**
     * Show the form for creating a new SalesOrderPromoDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales_order_promo_details.create');
    }

    /**
     * Store a newly created SalesOrderPromoDetail in storage.
     *
     * @param CreateSalesOrderPromoDetailRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        // Check sudah ada dalam cart
        $cekProduct = SalesOrderPromoDetail::where('packet_code', $data['packet_code'])->where('sales_order_promo_id', $data['sales_order_promo_id'])->get()->first();
        
        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['total'] = str_replace('.','',$data['total']);
        $data['total'] = str_replace(',','.',$data['total']);
        
        if($cekProduct !== null){

            return response()->json(['error'=>'Product already listed on carts.'], 403);

        } else {

            SalesOrderPromoDetail::create([
                'sales_order_promo_id' => $request->sales_order_promo_id,
                'packet_code' => $request->packet_code,
                'qty' => $request->qty,
                'unit_price' => $data['unit_price'],
                'total' => $data['total']
            ]); 
             
            $salesOrderDetail = SalesOrderPromoDetail::where('sales_order_promo_id', $request->sales_order_promo_id)->get();
        
            $salesOrder = SalesOrderPromo::find($request->sales_order_promo_id);
            $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
            $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
            $salesOrder['order_amount'] = $salesOrderDetail->sum('total');
            $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
            $salesOrder['order_total'] = $salesOrder['order_amount'] + $salesOrder['tax'];
            $salesOrder->save();
       
            return response()->json(['success'=>'Products added successfully.']);

        }
    }

    /**
     * Display the specified SalesOrderPromoDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->find($id);

        if (empty($salesOrderPromoDetail)) {
            Flash::error('Sales Order Promo Detail not found');

            return redirect(route('salesOrderPromoDetails.index'));
        }

        return view('sales_order_promo_details.show')->with('salesOrderPromoDetail', $salesOrderPromoDetail);
    }

    /**
     * Show the form for editing the specified SalesOrderPromoDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salesOrderDetail = $this->salesOrderPromoDetailRepository->find($id);

        $response['id'] = $salesOrderDetail->id;
        $response['packet_name'] = $salesOrderDetail->packet->packet_name;
        $response['packet_code']= $salesOrderDetail->packet_code;
        $response['qty'] = $salesOrderDetail->qty;
        $response['unit_price'] = number_format($salesOrderDetail->unit_price,2,',','.');
        $response['total'] = number_format($salesOrderDetail->total,2,',','.');

        return response()->json($response);
    }

    /**
     * Update the specified SalesOrderPromoDetail in storage.
     *
     * @param int $id
     * @param UpdateSalesOrderPromoDetailRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $data['qty'] = str_replace('.','',$data['qty']);
        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['total'] = str_replace('.','',$data['total']);
        $data['total'] = str_replace(',','.',$data['total']);

        $salesOrderDetail = $this->salesOrderPromoDetailRepository->update($data, $id);

        $salesOrderDetailData = SalesOrderPromoDetail::find($id);

        $salesOrderID = $salesOrderDetailData->sales_order_promo_id;

        $salesOrderDetails = SalesOrderPromoDetail::where('sales_order_promo_id', $salesOrderID)->get();
        
        $salesOrder = SalesOrderPromo::find($salesOrderID);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
        $salesOrder['order_qty'] = $salesOrderDetails->sum('qty');
        $salesOrder['order_amount'] = $salesOrderDetails->sum('total');
        $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
        $salesOrder['order_total'] = $salesOrder['order_amount'] + $salesOrder['tax'];
        $salesOrder->save();


        return response()->json(['success'=>'Data updated successfully.']);
    }

    /**
     * Remove the specified SalesOrderPromoDetail from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->find($id);

        if (empty($salesOrderPromoDetail)) {
            Flash::error('Sales Order Promo Detail not found');

            return redirect(route('salesOrderPromoDetails.index'));
        }

        $this->salesOrderPromoDetailRepository->delete($id);

        $salesOrderDetail = SalesOrderPromoDetail::where('sales_order_promo_id', $salesOrderPromoDetail->sales_order_promo_id)->get();
        
        $salesOrder = SalesOrderPromo::find($salesOrderPromoDetail->sales_order_promo_id);
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$salesOrder->delivery_date' AND (end_date is null OR end_date >= '$salesOrder->delivery_date') ")->get()->first();
        $salesOrder['order_qty'] = $salesOrderDetail->sum('qty');
        $salesOrder['order_amount'] = $salesOrderDetail->sum('total');
        $salesOrder['tax'] = ($parameterVAT->value/100) * $salesOrder['order_amount'];
        $salesOrder['order_total'] = $salesOrder['order_amount'] + $salesOrder['tax'];
        $salesOrder->save();

        return response()->json(['success'=>'Row updated successfully.']);
    }

    public function countOrderDetail($code, $date){

        $salesOrderDetail = SalesOrderPromoDetail::where('sales_order_promo_id', $code)->get();
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$date' AND (end_date is null OR end_date >= '$date') ")->get()->first();
        
            
        $data['order_qty'] = $salesOrderDetail->sum('qty');
        $data['order_amount'] = $salesOrderDetail->sum('total');
        $tax = ($parameterVAT->value/100) * $data['order_amount'];
        $total = $data['order_amount'] + $tax;
        $data['order_qty'] = number_format($data['order_qty'],0,',','.');
        $data['order_amount'] = number_format($data['order_amount'],2,',','.');
        $data['tax'] = number_format($tax,2,',','.');
        $data['order_total'] = number_format($total,2,',','.');

        return $data;

    }
}
