<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Repositories\CartRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Flash;
use Response;
use Auth;
use DataTables;

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
            $datas = Cart::where('customer_id', \Auth::user()->customer_id)->get();
            return DataTables::of($datas)
                ->editColumn('unit_price', function (Cart $cart) 
                {
                    return number_format($cart->unit_price, 2, ',', '.');
                })
                ->editColumn('amount', function (Cart $cart) 
                {
                    return number_format($cart->amount, 2, ',', '.');
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
   
                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook"><i class="fas fa-trash-alt"></i></a>';

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
        
        // Check sudah ada dalam cart
        $cekCart = Cart::where('inventory_id', $data['inventory_id'])->where('customer_id', \Auth::user()->customer_id)->get()->first();

        $data['unit_price'] = str_replace('.','',$data['unit_price']);
        $data['unit_price'] = str_replace(',','.',$data['unit_price']);
        $data['amount'] = str_replace('.','',$data['amount']);
        $data['amount'] = str_replace(',','.',$data['amount']);
        
        if($cekCart !== null){

            return response()->json(['error'=>'Product already listed on carts.'], 403);

        } else {

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
        $cart = $this->cartRepository->find($id);

        if (empty($cart)) {
            Flash::error('Cart not found');

            return redirect(route('carts.index'));
        }

        return view('carts.edit')->with('cart', $cart);
    }

    /**
     * Update the specified Cart in storage.
     *
     * @param int $id
     * @param UpdateCartRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCartRequest $request)
    {
        $cart = $this->cartRepository->find($id);

        if (empty($cart)) {
            Flash::error('Cart not found');

            return redirect(route('carts.index'));
        }

        $cart = $this->cartRepository->update($request->all(), $id);

        Flash::success('Cart updated successfully.');

        return redirect(route('carts.index'));
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

    public function getAllCounter($customerCode){

        $getCounter = Cart::where('customer_id', $customerCode)->get();

        // dd($getCounter->sum('qty'));
            
        $data['order_qty'] = $getCounter->sum('qty');
        $data['order_amount'] = $getCounter->sum('amount');
        $tax = (10/100) * $data['order_amount'];
        $total = $data['order_amount'] + $tax;
        $data['order_amount'] = number_format($data['order_amount'],2,',','.');
        $data['tax'] = number_format($tax,2,',','.');
        $data['order_total'] = number_format($total,2,',','.');

        return $data;
    }
}
