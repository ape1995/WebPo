<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePacketDiscountRequest;
use App\Http\Requests\UpdatePacketDiscountRequest;
use App\Repositories\PacketDiscountRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\PacketDiscount;
use App\Models\PacketDiscountDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
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
        if (!\Auth::user()->can('browse bundling discounts')) {
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
                ->editColumn('created_at', function (PacketDiscount $packetDiscount) 
                {
                    return $packetDiscount->created_at->format('Y-m-d');
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
        if (!\Auth::user()->can('create bundling discounts')) {
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
        $input['created_by'] = \Auth::user()->id;


        $packetDiscount = $this->packetDiscountRepository->create($input);

        $packetDiscountDetail = PacketDiscountDetail::where('user_id', \Auth::user()->id)->where('packet_discount_id', null)
                                ->update([
                                    'packet_discount_id' => $packetDiscount->id]
                                );

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
        if (!\Auth::user()->can('view bundling discounts')) {
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
        if (!\Auth::user()->can('edit bundling discounts')) {
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
        $input['updated_by'] = \Auth::user()->id;

        $discountPercentage = $input['discount'] / $input['grand_total'] * 100;

        $packetDiscount = $this->packetDiscountRepository->update($input, $id);

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
        if (!\Auth::user()->can('delete bundling discounts')) {
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
        if (!\Auth::user()->can('release bundling discounts')) {
            abort(403);
        }

        $packetDiscount = $this->packetDiscountRepository->find($id);
        $packetDiscount['status'] = 'Released';
        $packetDiscount['released_date'] = \Carbon\Carbon::now()->toDateTimeString();
        $packetDiscount['released_by'] = \Auth::user()->id;
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

    public function getActivePakcets($date, $user_id)
    {

        $user = User::find($user_id);

        $packetDiscounts = PacketDiscount::whereRaw("start_date <= '$date' AND (end_date is null OR end_date >= '$date') ")->where('status', 'Released')->where('rbp_class', $user->customer->location->CPriceClassID)->get();

        $output = [];
        $output[] = '<option value="">- Please Choose - </option>';
        foreach($packetDiscounts as $row){
            $output[] = '<option value="'.$row->packet_code.'">'.$row->packet_code.'</option>';
        }
        return $output;

    }

    public function getPacketData($code)
    {
        $packetDiscount = PacketDiscount::where('packet_code', $code)->get()->first();

        $output = [];
        $output['packet_name'] = $packetDiscount->packet_name;
        $output['unit_price'] = number_format($packetDiscount->grand_total, 2, ',', '.');

        return $output;
    }

    public function getPromoActive($date, $user)
    {
        $user = User::find($user);

        $cekCustomerClass = Customer::where('BAccountID', $user->customer_id)->get()->first();
        $rbpClass = $cekCustomerClass->location->CPriceClassID;
        // dd($rbpClass);

        $packetDiscounts = PacketDiscount::whereRaw("(start_date <= '$date' AND (end_date is null OR end_date >= '$date') ) AND rbp_class = '$rbpClass'")->where('status', 'Released')->get();
        // dd($packetDiscounts);

        $output = [];
        $output[] = "<option value=''>- Choose -</option>";
        foreach ($packetDiscounts as $item) {
            $output[] = "<option value='$item->packet_code'>$item->packet_name ( $item->packet_code )</option>";
        }

        return $output;
    }

    public function getPromoData($code)
    {
        $packetDiscount = PacketDiscount::where('packet_code', $code)->get()->first();

        return $packetDiscount;
    }
}
