<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Repositories\CartRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Cart;
use App\Models\ParameterVAT;
use App\Models\PacketDiscount;
use App\Models\Location;
use App\Models\Product;
use App\Models\SalesPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Flash;
use Response;
use Auth;
use DataTables;
use DB;

class CartController extends AppBaseController
{
    /** @var  CartRepository */
    private $cartRepository;

    public function __construct(CartRepository $cartRepo)
    {
        $this->cartRepository = $cartRepo;
    }

    /**
     * Display a listing of the Cart.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->get()->frist();
        dd($carts);
        // dd($carts);
      
        return view('carts.index',compact('carts'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $datas = Cart::where('customer_id', \Auth::user()->customer_id)->orderBy('inventory_id', 'ASC')->get();
            return DataTables::of($datas)
                ->editColumn('qty', function (Cart $cart) 
                {
                    return number_format($cart->qty, 0, ',', '.');
                })
                ->editColumn('unit_price', function (Cart $cart) 
                {
                    return number_format($cart->unit_price, 2, ',', '.');
                })
                ->editColumn('discount', function (Cart $cart) 
                {
                    return number_format($cart->discount, 2, ',', '.');
                })
                ->editColumn('amount', function (Cart $cart) 
                {
                    return number_format($cart->amount, 2, ',', '.');
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    if ($row->packet_code == null) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    } else {
                        $btn = '';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook2" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                    }
                    

                    return $btn;
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new Cart.
     *
     * @return Response
     */
    // public function create()
    // {
    //     return view('carts.create');
    // }

    /**
     * Store a newly created Cart in storage.
     *
     * @param CreateCartRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $cekCart = Cart::where('inventory_id', $data['inventory_id'])->where('customer_id', $data['customer_id'])->get()->first();
           
        if($cekCart !== null){

            return response()->json(['error'=>'Product already listed on carts.'], 403);

        } else {

            $data['qty'] = str_replace('.','',$data['qty']);
            $data['unit_price'] = str_replace('.','',$data['unit_price']);
            $data['unit_price'] = str_replace(',','.',$data['unit_price']);
            $data['amount'] = str_replace('.','',$data['amount']);
            $data['amount'] = str_replace(',','.',$data['amount']);

            Cart::create([
                        'inventory_id' => $request->inventory_id,
                        'inventory_name' => $request->inventory_name,
                        'qty' => $request->qty,
                        'uom' => $request->uom,
                        'unit_price' => $data['unit_price'],
                        'amount' => $data['amount'],
                        'customer_id' => $request->customer_id,
                        'created_by' => \Auth::user()->id,
                    ]);    
       
            return response()->json(['success'=>'Cart added successfully.']);

        }


    }

    public function storePromo(Request $request)
    {
        $data = $request->all();

        // return response()->json(['success'=>$data]);
        
        $cekCart = Cart::where('packet_code', $data['packet_code'])->where('customer_id', $data['customer_id'])->get()->first();
        //    return response()->json(['success' => $cekCart]);
        if($cekCart == null){

            $packetDiscount = PacketDiscount::where('packet_code', $data['packet_code'])->get()->first();


            foreach($packetDiscount->detail as $detail){
                Cart::create([
                    'packet_code' => $packetDiscount->packet_code,
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

            
       
            return response()->json(['success'=>'Cart added successfully.']);

        } else {

            $packetDiscount = PacketDiscount::where('packet_code', $data['packet_code'])->get()->first();
            
            foreach($packetDiscount->detail as $detail){
                $cart = Cart::where('packet_code', $data['packet_code'])->where('customer_id', $data['customer_id'])->where('inventory_id', $detail->inventory_code)->get()->first();
                $cart['qty'] = $cart->qty + ($detail->qty * $data['qty']);
                $cart['discount'] = $cart->discount + ($detail->discount_amount * $data['qty']);
                $cart['amount'] = $cart->amount + ($detail->amount * $data['qty']);
                $cart->save();
            }

            return response()->json(['success'=>'Cart added successfully.']);

        }


    }

    /**
     * Display the specified Cart.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cart = $this->cartRepository->find($id);

        if (empty($cart)) {
            Flash::error('Cart not found');

            return redirect(route('carts.index'));
        }

        return view('carts.show')->with('cart', $cart);
    }

    /**
     * Show the form for editing the specified Cart.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cart = Cart::find($id);
        $response = $cart->all();
        $response['id'] = $cart->id;
        $response['inventory_name'] = $cart->inventory_name;
        $response['inventory_id']= $cart->inventory_id;
        $response['qty'] = $cart->qty;
        $response['unit_price'] = number_format($cart->unit_price,2,',','.');
        $response['amount'] = number_format($cart->amount,2,',','.');

        return response()->json($response);
    }

    /**
     * Update the specified Cart in storage.
     *
     * @param int $id
     * @param UpdateCartRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['amount'] = str_replace('.','',$data['amount']);
        $data['amount'] = str_replace(',','.',$data['amount']);

        $cart = $this->cartRepository->update($data, $id);

        return response()->json(['success'=>'Cart updated successfully.']);
    }

    /**
     * Remove the specified Cart from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        Cart::find($id)->delete();
     
        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function destroyPromo($id)
    {

        $cart = Cart::find($id);

        Cart::where('packet_code', $cart->packet_code)->where('created_by', \Auth::user()->id)->delete();
     
        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function getAllCounter($customerCode, $date){

        $getCounter = Cart::where('customer_id', $customerCode)->get();
        $parameterVAT = ParameterVAT::whereRaw("start_date <= '$date' AND (end_date is null OR end_date >= '$date') ")->get()->first();
        // dd($parameterVAT);
        $data['order_qty'] = $getCounter->sum('qty');
        $data['order_amount'] = $getCounter->sum('amount');
        $data['discount'] = $getCounter->sum('discount');
        $tax = ($parameterVAT->value/100) * ($data['order_amount'] - $data['discount']);
        $total = $data['order_amount'] - $data['discount'] + $tax;
        // dd($tax);
        $data['order_qty'] = number_format($data['order_qty'],0,',','.');
        $data['order_amount'] = number_format($data['order_amount'],2,',','.');
        $data['discount'] = number_format($data['discount'],2,',','.');
        $data['tax'] = number_format($tax,2,',','.');
        $data['order_total'] = number_format($total,2,',','.');

        return $data;
    }

    public function reCountDetailProduct($date)
    {
        // dd('test');
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->get();
        $priceClass = $this->getCPriceClass(\Auth::user()->customer_id);

        if($carts->count('id') > 0){
            foreach($carts as $cart){
                $inventory = $this->getInventoryID($cart->inventory_id);
                $inventoryID = $inventory->InventoryID;
                $inventoryName = $inventory->Descr;
                $salesPrice = SalesPrice::whereRaw("CustPriceClassID = '$priceClass' AND InventoryID = '$inventoryID' AND EffectiveDate <= '$date' AND (ExpirationDate IS NULL OR ExpirationDate >= '$date')")->get()->first();
                
                $updateCart = Cart::find($cart->id);
                $updateCart['unit_price'] = $salesPrice->SalesPrice;
                $updateCart['amount'] = $salesPrice->SalesPrice * $cart->qty;
                $updateCart->save();
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
