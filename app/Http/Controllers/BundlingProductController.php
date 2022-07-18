<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBundlingProductRequest;
use App\Http\Requests\UpdateBundlingProductRequest;
use App\Repositories\BundlingProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
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
        return view('bundling_products.create');
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

        $bundlingProduct = $this->bundlingProductRepository->create($input);

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
        $bundlingProduct = $this->bundlingProductRepository->find($id);

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        return view('bundling_products.edit')->with('bundlingProduct', $bundlingProduct);
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

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        $bundlingProduct = $this->bundlingProductRepository->update($request->all(), $id);

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
        $bundlingProduct = $this->bundlingProductRepository->find($id);

        if (empty($bundlingProduct)) {
            Flash::error('Bundling Product not found');

            return redirect(route('bundlingProducts.index'));
        }

        $this->bundlingProductRepository->delete($id);

        Flash::success('Bundling Product deleted successfully.');

        return redirect(route('bundlingProducts.index'));
    }
}
