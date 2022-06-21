<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCartPromoRequest;
use App\Http\Requests\UpdateCartPromoRequest;
use App\Repositories\CartPromoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\CartPromo;
use App\Models\ParameterVAT;
use Flash;
use Response;
use DataTables;

class CartPromoController extends AppBaseController
{
    /** @var  CartPromoRepository */
    private $cartPromoRepository;

    public function __construct(CartPromoRepository $cartPromoRepo)
    {
        $this->cartPromoRepository = $cartPromoRepo;
    }

    /**
     * Display a listing of the CartPromo.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cartPromos = $this->cartPromoRepository->all();

        return view('cart_promos.index')
            ->with('cartPromos', $cartPromos);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $datas = CartPromo::where('customer_id', \Auth::user()->customer_id)->orderBy('packet_code', 'ASC')->get();
            return DataTables::of($datas)
                ->editColumn('qty', function (CartPromo $cart) 
                {
                    return number_format($cart->qty, 0, ',', '.');
                })
                ->editColumn('unit_price', function (CartPromo $cart) 
                {
                    return number_format($cart->unit_price, 2, ',', '.');
                })
                ->editColumn('total', function (CartPromo $cart) 
                {
                    return number_format($cart->total, 2, ',', '.');
                })
                ->addColumn('packet_name', function (CartPromo $cart) 
                {
                    return $cart->packet->packet_name;
                })
                ->addColumn('uom', function (CartPromo $cart) 
                {
                    return "Packet(s)";
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new CartPromo.
     *
     * @return Response
     */
    public function create()
    {
        return view('cart_promos.create');
    }

    /**
     * Store a newly created CartPromo in storage.
     *
     * @param CreateCartPromoRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $cekCart = CartPromo::where('packet_code', $input['packet_code'])->where('customer_id', $input['customer_id'])->get()->first();
        
        if($cekCart !== null){

            return response()->json(['error'=>'Product already listed on carts.'], 403);

        } else {

            $input['unit_price'] = str_replace('.','',$input['unit_price']);
            $input['unit_price'] = str_replace(',','.',$input['unit_price']);
            $input['total'] = str_replace('.','',$input['total']);
            $input['total'] = str_replace(',','.',$input['total']);

            $cartPromo = $this->cartPromoRepository->create($input);
            return response()->json(['success'=> 'Cart Added Successfull']);
        }

    }

    /**
     * Display the specified CartPromo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cartPromo = $this->cartPromoRepository->find($id);

        if (empty($cartPromo)) {
            Flash::error('Cart Promo not found');

            return redirect(route('cartPromos.index'));
        }

        return view('cart_promos.show')->with('cartPromo', $cartPromo);
    }

    /**
     * Show the form for editing the specified CartPromo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cart = CartPromo::find($id);
        $response = $cart->all();
        $response['id'] = $cart->id;
        $response['packet_name'] = $cart->packet->packet_name;
        $response['packet_code']= $cart->packet_code;
        $response['qty'] = $cart->qty;
        $response['unit_price'] = number_format($cart->unit_price,2,',','.');
        $response['total'] = number_format($cart->total,2,',','.');

        return response()->json($response);
    }

    /**
     * Update the specified CartPromo in storage.
     *
     * @param int $id
     * @param UpdateCartPromoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCartPromoRequest $request)
    {
        $data = $request->all();
        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['total'] = str_replace('.','',$data['total']);
        $data['total'] = str_replace(',','.',$data['total']);

        $cart = $this->cartPromoRepository->update($data, $id);

        return response()->json(['success'=>'Cart updated successfully.']);
    }

    /**
     * Remove the specified CartPromo from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cartPromo = $this->cartPromoRepository->find($id);

        if (empty($cartPromo)) {
            Flash::error('Cart Promo not found');

            return redirect(route('cartPromos.index'));
        }

        $this->cartPromoRepository->delete($id);

        return response()->json(['success'=>'Row Deleted Successfull']);
    }

    public function getAllCounter($customerCode, $date){

        $getCounter = CartPromo::where('customer_id', $customerCode)->get();
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$date' AND (end_date is null OR end_date >= '$date') ")->get()->first();
        // dd($parameterVAT);
        $data['order_qty'] = $getCounter->sum('qty');
        $data['order_amount'] = $getCounter->sum('total');
        $tax = ($parameterVAT->value/100) * $data['order_amount'];
        $total = $data['order_amount'] + $tax;
        // dd($tax);
        $data['order_qty'] = number_format($data['order_qty'],0,',','.');
        $data['order_amount'] = number_format($data['order_amount'],2,',','.');
        $data['tax'] = number_format($tax,2,',','.');
        $data['order_total'] = number_format($total,2,',','.');

        return $data;
    }

}
