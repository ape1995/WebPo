<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBundlingProductFreeRequest;
use App\Http\Requests\UpdateBundlingProductFreeRequest;
use App\Repositories\BundlingProductFreeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BundlingProduct;
use App\Models\BundlingProductFree;
use Flash;
use Response;
use DataTables;

class BundlingProductFreeController extends AppBaseController
{
    /** @var  BundlingProductFreeRepository */
    private $bundlingProductFreeRepository;

    public function __construct(BundlingProductFreeRepository $bundlingProductFreeRepo)
    {
        $this->bundlingProductFreeRepository = $bundlingProductFreeRepo;
    }

    /**
     * Display a listing of the BundlingProductFree.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $bundlingProductFrees = $this->bundlingProductFreeRepository->all();

        return view('bundling_product_frees.index')
            ->with('bundlingProductFrees', $bundlingProductFrees);
    }

    /**
     * Show the form for creating a new BundlingProductFree.
     *
     * @return Response
     */
    public function create()
    {
        return view('bundling_product_frees.create');
    }

    /**
     * Store a newly created BundlingProductFree in storage.
     *
     * @param CreateBundlingProductFreeRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        
        $product = Product::where('InventoryCD', $input['product_code'])->get()->first();
        $input['product_name'] = $product->Descr;
        
        $packetDiscountDetail = BundlingProductFree::create($input);

        return response()->json(['success'=>'Data saved successfully.']);
    }

    /**
     * Display the specified BundlingProductFree.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bundlingProductFree = $this->bundlingProductFreeRepository->find($id);

        if (empty($bundlingProductFree)) {
            Flash::error('Bundling Product Free not found');

            return redirect(route('bundlingProductFrees.index'));
        }

        return view('bundling_product_frees.show')->with('bundlingProductFree', $bundlingProductFree);
    }

    /**
     * Show the form for editing the specified BundlingProductFree.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bundlingProductFree = $this->bundlingProductFreeRepository->find($id);

        if (empty($bundlingProductFree)) {
            Flash::error('Bundling Product Free not found');

            return redirect(route('bundlingProductFrees.index'));
        }

        $data = [];
        $data['id'] = $bundlingProductFree->id;
        $data['product_code'] = $bundlingProductFree->product_code;
        $data['product_name'] = $bundlingProductFree->product->Descr;
        $data['qty'] = $bundlingProductFree->qty;

        return $data;

        // return view('bundling_product_frees.edit')->with('bundlingProductFree', $bundlingProductFree);
    }

    /**
     * Update the specified BundlingProductFree in storage.
     *
     * @param int $id
     * @param UpdateBundlingProductFreeRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $bundlingProductFree = $this->bundlingProductFreeRepository->find($id);

        $bundlingProductFree = $this->bundlingProductFreeRepository->update($request->all(), $id);

        return response()->json(['success'=>'Data saved successfully.']);
    }

    /**
     * Remove the specified BundlingProductFree from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bundlingProductFree = $this->bundlingProductFreeRepository->find($id);

        if (empty($bundlingProductFree)) {
            Flash::error('Bundling Product Free not found');

            return redirect(route('bundlingProductFrees.index'));
        }

        $this->bundlingProductFreeRepository->delete($id);

        return response()->json(['success'=>'Data saved successfully.']);
    }

    public function carts(Request $request, $user_id)
    {
        if ($request->ajax()) {

            $datas = BundlingProductFree::where('user_id', $user_id)->where('bundling_product_id', null);

            return DataTables::of($datas)
                ->editColumn('product', function (BundlingProductFree $product) 
                {
                    return $product->product->InventoryCD.' - '.$product->product->Descr;
                })
                ->addIndexColumn()
                ->addColumn('action',function ($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';

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

            $datas = BundlingProductFree::where('bundling_product_id', $id);

            return DataTables::of($datas)
                ->editColumn('product', function (BundlingProductFree $packetDiscount) 
                {
                    return $packetDiscount->product_code.' - '.$packetDiscount->product->Descr;
                })
                ->addIndexColumn()
                ->addColumn('action',function ($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fas fa-trash-alt"></i></a>';

                    return $btn;

                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    public function reset($user_id)
    {
        $packetDiscountDetail = BundlingProductFree::where('user_id', $user_id)->where('packet_discount_id', null)->delete();

        return response()->json(['success'=>'Data deleted successfully.']);
    }

    public function resetDetail($code)
    {
        $packetDiscountDetail = BundlingProductFree::where('packet_discount_id', $code)->delete();

        return response()->json(['success'=>'Data deleted successfully.']);
    }
}
