<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateproductSchedulerRequest;
use App\Http\Requests\UpdateproductSchedulerRequest;
use App\Repositories\productSchedulerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\productScheduler;
use Flash;
use Response;

class productSchedulerController extends AppBaseController
{
    /** @var  productSchedulerRepository */
    private $productSchedulerRepository;

    public function __construct(productSchedulerRepository $productSchedulerRepo)
    {
        $this->productSchedulerRepository = $productSchedulerRepo;
    }

    /**
     * Display a listing of the productScheduler.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('browse product schedulers')) {
            abort(403);
        }

        $productSchedulers = $this->productSchedulerRepository->all();

        return view('product_schedulers.index')
            ->with('productSchedulers', $productSchedulers);
    }

    /**
     * Show the form for creating a new productScheduler.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create product schedulers')) {
            abort(403);
        }

        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->orderBy('InventoryCD', 'ASC')->get();
        
        return view('product_schedulers.create', compact('products'));
    }

    /**
     * Store a newly created productScheduler in storage.
     *
     * @param CreateproductSchedulerRequest $request
     *
     * @return Response
     */
    public function store(CreateproductSchedulerRequest $request)
    {
        $input = $request->all();

        $productScheduler = $this->productSchedulerRepository->create($input);

        Flash::success('Product Scheduler saved successfully.');

        return redirect(route('productSchedulers.index'));
    }

    /**
     * Display the specified productScheduler.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (!\Auth::user()->can('view product schedulers')) {
            abort(403);
        }

        $productScheduler = $this->productSchedulerRepository->find($id);

        if (empty($productScheduler)) {
            Flash::error('Product Scheduler not found');

            return redirect(route('productSchedulers.index'));
        }

        return view('product_schedulers.show')->with('productScheduler', $productScheduler);
    }

    /**
     * Show the form for editing the specified productScheduler.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::user()->can('edit product schedulers')) {
            abort(403);
        }

        $productScheduler = $this->productSchedulerRepository->find($id);

        if (empty($productScheduler)) {
            Flash::error('Product Scheduler not found');

            return redirect(route('productSchedulers.index'));
        }
        
        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->orderBy('InventoryCD', 'ASC')->get();
        

        return view('product_schedulers.edit', compact('productScheduler', 'products'));
    }

    /**
     * Update the specified productScheduler in storage.
     *
     * @param int $id
     * @param UpdateproductSchedulerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateproductSchedulerRequest $request)
    {
        $productScheduler = $this->productSchedulerRepository->find($id);

        if (empty($productScheduler)) {
            Flash::error('Product Scheduler not found');

            return redirect(route('productSchedulers.index'));
        }

        $productScheduler = $this->productSchedulerRepository->update($request->all(), $id);

        Flash::success('Product Scheduler updated successfully.');

        return redirect(route('productSchedulers.index'));
    }

    /**
     * Remove the specified productScheduler from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::user()->can('delete product schedulers')) {
            abort(403);
        }

        $productScheduler = $this->productSchedulerRepository->find($id);

        if (empty($productScheduler)) {
            Flash::error('Product Scheduler not found');

            return redirect(route('productSchedulers.index'));
        }

        $this->productSchedulerRepository->delete($id);

        Flash::success('Product Scheduler deleted successfully.');

        return redirect(route('productSchedulers.index'));
    }

}
