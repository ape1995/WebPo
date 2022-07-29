<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePacketDiscountDetailRequest;
use App\Http\Requests\UpdatePacketDiscountDetailRequest;
use App\Repositories\PacketDiscountDetailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\SalesPrice;
use App\Models\Product;
use App\Models\PacketDiscountDetail;
use Flash;
use Response;
use DataTables;

class PacketDiscountDetailController extends AppBaseController
{
    /** @var  PacketDiscountDetailRepository */
    private $packetDiscountDetailRepository;

    public function __construct(PacketDiscountDetailRepository $packetDiscountDetailRepo)
    {
        $this->packetDiscountDetailRepository = $packetDiscountDetailRepo;
    }

    /**
     * Display a listing of the PacketDiscountDetail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $packetDiscountDetails = $this->packetDiscountDetailRepository->all();

        return view('packet_discount_details.index')
            ->with('packetDiscountDetails', $packetDiscountDetails);
    }

    /**
     * Show the form for creating a new PacketDiscountDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('packet_discount_details.create');
    }

    /**
     * Store a newly created PacketDiscountDetail in storage.
     *
     * @param CreatePacketDiscountDetailRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $product = Product::where('InventoryCD', $input['inventory_code'])->get()->first();

        $input['unit_price'] = str_replace('.','',$input['unit_price']);
        $input['unit_price'] = str_replace(',','.',$input['unit_price']);
        $input['total_amount'] = str_replace('.','',$input['total_amount']);
        $input['total_amount'] = str_replace(',','.',$input['total_amount']);
        $input['discount_percentage'] = str_replace('.','',$input['discount_percentage']);
        $input['discount_percentage'] = str_replace(',','.',$input['discount_percentage']);
        $input['amount'] = str_replace('.','',$input['amount']);
        $input['amount'] = str_replace(',','.',$input['amount']);
        $input['total_amount'] = $input['unit_price'] * $input['qty'];
        $input['amount'] = $input['total_amount'] - ($input['total_amount'] * $input['discount_percentage'] / 100);
        $input['discount_amount'] = $input['total_amount'] - $input['amount'];
        $input['inventory_name'] = $product->Descr;
        
        $packetDiscountDetail = $this->packetDiscountDetailRepository->create($input);

        return response()->json(['success'=>'Data saved successfully.']);
    }

    /**
     * Display the specified PacketDiscountDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $packetDiscountDetail = $this->packetDiscountDetailRepository->find($id);

        if (empty($packetDiscountDetail)) {
            Flash::error('Packet Discount Detail not found');

            return redirect(route('packetDiscountDetails.index'));
        }

        return view('packet_discount_details.show')->with('packetDiscountDetail', $packetDiscountDetail);
    }

    /**
     * Show the form for editing the specified PacketDiscountDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $packetDiscount = PacketDiscountDetail::find($id);
        $response['id'] = $packetDiscount->id;
        $response['inventory_code']= $packetDiscount->inventory_code;
        $response['inventory_name'] = $packetDiscount->inventory_name;
        $response['qty'] = $packetDiscount->qty;
        $response['unit_price'] = number_format($packetDiscount->unit_price,2,',','.');
        $response['discount_percentage'] = number_format($packetDiscount->discount_percentage,0);
        $response['amount'] = number_format($packetDiscount->amount,2,',','.');
        $response['total_amount'] = number_format($packetDiscount->total_amount,2,',','.');

        return response()->json($response);
    }

    /**
     * Update the specified PacketDiscountDetail in storage.
     *
     * @param int $id
     * @param UpdatePacketDiscountDetailRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        
        $input = $request->all();
        // $returnData = array(
        //     $input
        // );

        // return response()->json($returnData, 403);
        $input['unit_price'] = str_replace('.','',$input['unit_price']);
        $input['unit_price'] = str_replace(',','.',$input['unit_price']);
        $input['total_amount'] = str_replace('.','',$input['total_amount']);
        $input['total_amount'] = str_replace(',','.',$input['total_amount']);
        $input['discount_percentage'] = str_replace('.','',$input['discount_percentage']);
        $input['discount_percentage'] = str_replace(',','.',$input['discount_percentage']);
        $input['amount'] = str_replace('.','',$input['amount']);
        $input['amount'] = str_replace(',','.',$input['amount']);
        $input['total_amount'] = $input['unit_price'] * $input['qty'];
        $input['amount'] = $input['total_amount'] - ($input['total_amount'] * $input['discount_percentage'] / 100);
        $input['discount_amount'] = $input['total_amount'] - $input['amount'];

        $packetDiscountDetail = $this->packetDiscountDetailRepository->find($id);

        $packetDiscountDetail = $this->packetDiscountDetailRepository->update($input, $id);

        return response()->json(['success'=>'Data updated successfully.']);
    }

    /**
     * Remove the specified PacketDiscountDetail from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $packetDiscountDetail = $this->packetDiscountDetailRepository->find($id);

        $this->packetDiscountDetailRepository->delete($id);

        return response()->json(['success'=>'Data deleted successfully.']);
    }

    public function getInventoryID($id){
        $product = Product::where('InventoryCD', $id)->get()->first();

        return $product;
    }

    public function getPrice($code, $rbp, $date){
        // dd($code, $customer);

        $inventory = $this->getInventoryID($code);
        $inventoryID = $inventory->InventoryID;
        $inventoryName = $inventory->Descr;
        $salesPrice = SalesPrice::whereRaw("CustPriceClassID = '$rbp' AND InventoryID = '$inventoryID' AND EffectiveDate <= '$date' AND (ExpirationDate IS NULL OR ExpirationDate >= '$date')")->get()->first();
        // dd($salesPrice);
        $data['unit_price'] = number_format($salesPrice->SalesPrice,2,',','.');
        $data['uom'] = $salesPrice->UOM;
        $data['inventory_name'] = $inventoryName;

        return $data;
    }

    public function getAllCounter($user_id){

        $getCounter = PacketDiscountDetail::where('user_id', $user_id)->where('packet_discount_id', null)->get();
        
        $data['total_amount'] = $getCounter->sum('total_amount');
        $data['discount'] = $getCounter->sum('total_amount') - $getCounter->sum('amount');
        $data['grand_total'] = $getCounter->sum('amount');

        $data['total_amount'] = number_format($data['total_amount'],0,',','.');
        $data['discount'] = number_format($data['discount'],0,',','.');
        $data['grand_total'] = number_format($data['grand_total'],0,',','.');

        return $data;
    }

    public function getAllCounterDetail($id){

        $getCounter = PacketDiscountDetail::where('packet_discount_id', $id)->get();
        
        $data['total_amount'] = $getCounter->sum('total_amount');
        $data['discount'] = $getCounter->sum('total_amount') - $getCounter->sum('amount');
        $data['grand_total'] = $getCounter->sum('amount');

        $data['total_amount'] = number_format($data['total_amount'],0,',','.');
        $data['discount'] = number_format($data['discount'],0,',','.');
        $data['grand_total'] = number_format($data['grand_total'],0,',','.');

        return $data;
    }

    public function carts(Request $request, $user_id)
    {
        if ($request->ajax()) {

            $datas = PacketDiscountDetail::where('user_id', $user_id)->where('packet_discount_id', null);

            return DataTables::of($datas)
                ->editColumn('unit_price', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->unit_price,0,',','.');
                })
                ->editColumn('total_amount', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->total_amount,0,',','.');
                })
                ->editColumn('discount_percentage', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->discount_amount,0).' ('.number_format($packetDiscount->discount_percentage,0).' %)';
                })
                ->editColumn('amount', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->amount,0,',','.');
                })
                ->addIndexColumn()
                ->addColumn('action',function ($row){
                    
                    $btn = "";
                    // if (!\Auth::user()->can('edit bundling products')) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fas fa-edit"></i></a>';
                    // }
                    // if (!\Auth::user()->can('delete bundling products')) {
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    // }
                    
                    return $btn;

                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    public function detailData(Request $request, $id)
    {
        if ($request->ajax()) {

            $datas = PacketDiscountDetail::where('packet_discount_id', $id);

            return DataTables::of($datas)
                ->editColumn('unit_price', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->unit_price,0,',','.');
                })
                ->editColumn('total_amount', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->total_amount,0,',','.');
                })
                ->editColumn('discount_percentage', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->discount_amount,0).' ('.number_format($packetDiscount->discount_percentage,0).' %)';
                })
                ->editColumn('amount', function (PacketDiscountDetail $packetDiscount) 
                {
                    return number_format($packetDiscount->amount,0,',','.');
                })
                ->addIndexColumn()
                ->addColumn('action',function ($row){
                    $btn = "";
                    // if (!\Auth::user()->can('edit bundling products')) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fas fa-edit"></i></a>';
                    // }
                    // if (!\Auth::user()->can('delete bundling products')) {
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    // }
                    return $btn;

                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    public function reset($user_id)
    {
        $packetDiscountDetail = PacketDiscountDetail::where('user_id', $user_id)->where('packet_discount_id', null)->delete();

        return response()->json(['success'=>'Data deleted successfully.']);
    }

    public function resetDetail($code)
    {
        $packetDiscountDetail = PacketDiscountDetail::where('packet_discount_id', $code)->delete();

        return response()->json(['success'=>'Data deleted successfully.']);
    }


}
