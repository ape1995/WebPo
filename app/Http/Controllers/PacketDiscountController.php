<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePacketDiscountRequest;
use App\Http\Requests\UpdatePacketDiscountRequest;
use App\Repositories\PacketDiscountRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\PacketDiscount;
use App\Models\PacketDiscountDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Flash;
use Response;
use DataTables;

class PacketDiscountController extends AppBaseController
{
    /** @var  PacketDiscountRepository */
    private $packetDiscountRepository;

    public function __construct(PacketDiscountRepository $packetDiscountRepo)
    {
        $this->packetDiscountRepository = $packetDiscountRepo;
    }

    /**
     * Display a listing of the PacketDiscount.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('browse packet discounts')) {
            abort(403);
        }

        $packetDiscounts = $this->packetDiscountRepository->all();

        return view('packet_discounts.index')
            ->with('packetDiscounts', $packetDiscounts);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {

            $datas = PacketDiscount::latest();

            return DataTables::of($datas)
                ->editColumn('total', function (PacketDiscount $packetDiscount) 
                {
                    return number_format($packetDiscount->total,0,',','.');
                })
                ->editColumn('discount', function (PacketDiscount $packetDiscount) 
                {
                    return number_format($packetDiscount->discount,0,',','.');
                })
                ->editColumn('start_date', function (PacketDiscount $packetDiscount) 
                {
                    return $packetDiscount->start_date->format('Y-m-d');
                })
                ->editColumn('end_date', function (PacketDiscount $packetDiscount) 
                {
                    if ($packetDiscount->end_date == null) {
                        return '';
                    } else {
                        return $packetDiscount->end_date->format('Y-m-d');
                    }
                })
                ->editColumn('released_date', function (PacketDiscount $packetDiscount) 
                {
                    if ($packetDiscount->released_date == null) {
                        return '';
                    } else {
                        return $packetDiscount->released_date->format('Y-m-d');
                    }
                })
                ->editColumn('grand_total', function (PacketDiscount $packetDiscount) 
                {
                    return number_format($packetDiscount->grand_total,0,',','.');
                })
                ->editColumn('status', function (PacketDiscount $packetDiscount) 
                {
                    if($packetDiscount->status == 'Hold')
                    {
                        return "<span class='badge badge-secondary'>Hold</span>";
                    } else {
                        return "<span class='badge badge-success'>Released</span>";
                    } 
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('packet_discounts.action')->with('packetDiscount',$data)->render();
                })
                ->rawColumns(['action', 'status'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new PacketDiscount.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create packet discounts')) {
            abort(403);
        }

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG'")->where('ItemStatus', 'AC')->get();

        return view('packet_discounts.create', compact('products'));
    }

    /**
     * Store a newly created PacketDiscount in storage.
     *
     * @param CreatePacketDiscountRequest $request
     *
     * @return Response
     */
    public function store(CreatePacketDiscountRequest $request)
    {
        $input = $request->all();
        
        $input['status'] = 'Hold';
        $input['total'] = str_replace('.','',$input['total']);
        $input['discount'] = str_replace('.','',$input['discount']);
        $input['grand_total'] = str_replace('.','',$input['grand_total']);

        $discountPercentage = $input['discount'] / $input['grand_total'] * 100;

        // dd($discountPercentage);

        $packetDiscount = $this->packetDiscountRepository->create($input);

        $packetDiscountDetail = PacketDiscountDetail::where('user_id', \Auth::user()->id)->where('packet_discount_id', null)
                                ->update([
                                    'packet_discount_id' => $packetDiscount->id]
                                );

        foreach($packetDiscount->detail as $detail){
            $detailData = PacketDiscountDetail::find($detail->id);
            $detailData['discount_percentage'] = $discountPercentage;
            $detailData['discount_amount'] = $detail->total_amount * $discountPercentage / 100;
            $detailData['amount'] = $detail->total_amount - $detailData['discount_amount'];
            $detailData->save();
        }

        Flash::success('Packet Discount saved successfully.');

        return redirect(route('packetDiscounts.index'));
    }

    /**
     * Display the specified PacketDiscount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (!\Auth::user()->can('view packet discounts')) {
            abort(403);
        }

        $packetDiscount = $this->packetDiscountRepository->find($id);

        if (empty($packetDiscount)) {
            Flash::error('Packet Discount not found');

            return redirect(route('packetDiscounts.index'));
        }

        return view('packet_discounts.show')->with('packetDiscount', $packetDiscount);
    }

    /**
     * Show the form for editing the specified PacketDiscount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::user()->can('edit packet discounts')) {
            abort(403);
        }

        $packetDiscount = $this->packetDiscountRepository->find($id);

        if (empty($packetDiscount)) {
            Flash::error('Packet Discount not found');

            return redirect(route('packetDiscounts.index'));
        }

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG'")->where('ItemStatus', 'AC')->get();


        return view('packet_discounts.edit', compact('packetDiscount', 'products'));
    }

    /**
     * Update the specified PacketDiscount in storage.
     *
     * @param int $id
     * @param UpdatePacketDiscountRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $packetDiscount = $this->packetDiscountRepository->find($id);

        if (empty($packetDiscount)) {
            Flash::error('Packet Discount not found');

            return redirect(route('packetDiscounts.index'));
        }

        $input = $request->all();
        $input['status'] = 'Hold';
        $input['total'] = str_replace('.','',$input['total']);
        $input['discount'] = str_replace('.','',$input['discount']);
        $input['grand_total'] = str_replace('.','',$input['grand_total']);

        $discountPercentage = $input['discount'] / $input['grand_total'] * 100;

        $packetDiscount = $this->packetDiscountRepository->update($input, $id);

        foreach($packetDiscount->detail as $detail){
            $detailData = PacketDiscountDetail::find($detail->id);
            $detailData['discount_percentage'] = $discountPercentage;
            $detailData['discount_amount'] = $detail->total_amount * $discountPercentage / 100;
            $detailData['amount'] = $detail->total_amount - $detailData['discount_amount'];
            $detailData->save();
        }

        Flash::success('Packet Discount updated successfully.');

        return redirect(route('packetDiscounts.index'));
    }

    /**
     * Remove the specified PacketDiscount from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::user()->can('delete packet discounts')) {
            abort(403);
        }

        $packetDiscount = $this->packetDiscountRepository->find($id);

        if (empty($packetDiscount)) {
            Flash::error('Packet Discount not found');

            return redirect(route('packetDiscounts.index'));
        }

        $this->packetDiscountRepository->delete($id);

        $packetDiscountDetail = PacketDiscountDetail::where('packet_discount_id', $packetDiscount->id)->delete();

        Flash::success('Packet Discount deleted successfully.');

        return redirect(route('packetDiscounts.index'));
    }

    public function release($id)
    {
        if (!\Auth::user()->can('release packet discounts')) {
            abort(403);
        }

        $packetDiscount = $this->packetDiscountRepository->find($id);
        $packetDiscount['status'] = 'Released';
        $packetDiscount['released_date'] = \Carbon\Carbon::now()->toDateTimeString();
        $packetDiscount->save();

        Flash::success('Packet Discount released successfully.');

        return redirect(route('packetDiscounts.index'));

    }

    public function getCode($id)
    {

        $packetDiscount = PacketDiscount::where('packet_code' ,$id)->get()->first();

        if ($packetDiscount == null) {
            return response()->json(['success'=>'Code Bisa Digunakan.']);
        } else {
            $returnData = array(
                "message" => "Code Sudah Ada",
            );
    
            return response()->json($returnData, 403);
        }

    }
}
