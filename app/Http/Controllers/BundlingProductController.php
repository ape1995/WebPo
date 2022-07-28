<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBundlingProductRequest;
use App\Http\Requests\UpdateBundlingProductRequest;
use App\Repositories\BundlingProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\BundlingProductFree;
use App\Models\CustomerProduct;
use App\Models\BundlingProduct;
use Flash;
use Response;

class BundlingProductController extends AppBaseController
{
    /** @var  BundlingProductRepository */
    private $bundlingProductRepository;

    public function __construct(BundlingProductRepository $bundlingProductRepo)
    {
        $this->bundlingProductRepository = $bundlingProductRepo;
    }

    /**
     * Display a listing of the BundlingProduct.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('browse bundling products')) {
            abort(403);
        }

        $bundlingProducts = $this->bundlingProductRepository->all();

        return view('bundling_products.index')
            ->with('bundlingProducts', $bundlingProducts);
    }

    /**
     * Show the form for creating a new BundlingProduct.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create bundling products')) {
            abort(403);
        }

        $products = Product::whereRaw("LEFT(InventoryCD,2) = 'FG' and ItemStatus = 'AC'")->get();
        // dd($products);

        return view('bundling_products.create', compact('products'));
    }

    /**
     * Store a newly created BundlingProduct in storage.
     *
     * @param CreateBundlingProductRequest $request
     *
     * @return Response
     */
    public function store(CreateBundlingProductRequest $request)
    {
        $input = $request->all();

        $input['qty'] = $input['qty_total'];
        $product = Product::where('InventoryCD', $input['product_code'])->get()->first();
        $input['product_name'] = $product->Descr;

        $bundlingProduct = $this->bundlingProductRepository->create($input);

        $bundlingProductFree = BundlingProductFree::where('user_id', \Auth::user()->id)->where('bundling_product_id', null)
                                ->update([
                                    'bundling_product_id' => $bundlingProduct->id]
                                );

        Flash::success('Bundling Product saved successfully.');

        return redirect(route('bundlingProducts.index'));
    }

    /**
     * Display the specified BundlingProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (!\Auth::user()->can('view bundling products')) {
            abort(403);
        }

        $bundlingProduct = $this->bundlingProductRepository->find($id);

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        return view('bundling_products.show')->with('bundlingProduct', $bundlingProduct);
    }

    /**
     * Show the form for editing the specified BundlingProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::user()->can('edit bundling products')) {
            abort(403);
        }

        $bundlingProduct = $this->bundlingProductRepository->find($id);

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        $products = Product::whereRaw("LEFT(InventoryCD,2) = 'FG' and ItemStatus = 'AC'")->get();

        return view('bundling_products.edit', compact('bundlingProduct', 'products'));
    }

    /**
     * Update the specified BundlingProduct in storage.
     *
     * @param int $id
     * @param UpdateBundlingProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBundlingProductRequest $request)
    {
        $bundlingProduct = $this->bundlingProductRepository->find($id);

        $input = $request->all();

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        $input['qty'] = $input['qty_total'];
        $product = Product::where('InventoryCD', $input['product_code'])->get()->first();
        $input['product_name'] = $product->Descr;

        $bundlingProduct = $this->bundlingProductRepository->update($input, $id);

        Flash::success('Bundling Product updated successfully.');

        return redirect(route('bundlingProducts.index'));
    }

    /**
     * Remove the specified BundlingProduct from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::user()->can('delete bundling products')) {
            abort(403);
        }

        $bundlingProduct = $this->bundlingProductRepository->find($id);

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        $this->bundlingProductRepository->delete($id);

        Flash::success('Bundling Product deleted successfully.');

        return redirect(route('bundlingProducts.index'));
    }

    public function release($id)
    {
        $bundlingProduct = BundlingProduct::find($id);
        $bundlingProduct['status'] = 'Released';
        $bundlingProduct->save();

        Flash::success('Bundling Product released successfully.');

        return redirect(route('bundlingProducts.index'));
    }

    public function getProductActive($date, $user, $type)
    {
        $user = User::find($user);

        // dd($packetDiscounts);
        if($type == 'P')
        {
            $bundlingProducts = BundlingProduct::whereRaw("start_date <= '$date' AND (end_date is null OR end_date >= '$date') ")->where('status', 'Released')->get();
            $output = [];
            $output[] = "<option value=''>- Choose -</option>";
            foreach ($bundlingProducts as $item) {
                $output[] = "<option value='$item->product_code'> ".$item->product->Descr." ( $item->product_code )</option>";
            }

            return $output;
        } else {
            $customerProducts = CustomerProduct::select('inventory_code')->where('customer_code',  $user->customer->AcctCD)->get()->pluck('inventory_code');
        
            $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->whereIn('InventoryCD', $customerProducts)->orderBy('InventoryCD', 'ASC')->get();
        
            $output = [];
            $output[] = "<option value=''>- Choose -</option>";
            foreach ($products as $item) {
                $output[] = "<option value='$item->InventoryCD'> ".$item->Descr."</option>";
            }

            return $output;
        }

        
    }
}
