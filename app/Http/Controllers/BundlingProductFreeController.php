<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBundlingProductFreeRequest;
use App\Http\Requests\UpdateBundlingProductFreeRequest;
use App\Repositories\BundlingProductFreeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

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
    public function store(CreateBundlingProductFreeRequest $request)
    {
        $input = $request->all();

        $bundlingProductFree = $this->bundlingProductFreeRepository->create($input);

        Flash::success('Bundling Product Free saved successfully.');

        return redirect(route('bundlingProductFrees.index'));
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

        return view('bundling_product_frees.edit')->with('bundlingProductFree', $bundlingProductFree);
    }

    /**
     * Update the specified BundlingProductFree in storage.
     *
     * @param int $id
     * @param UpdateBundlingProductFreeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBundlingProductFreeRequest $request)
    {
        $bundlingProductFree = $this->bundlingProductFreeRepository->find($id);

        if (empty($bundlingProductFree)) {
            Flash::error('Bundling Product Free not found');

            return redirect(route('bundlingProductFrees.index'));
        }

        $bundlingProductFree = $this->bundlingProductFreeRepository->update($request->all(), $id);

        Flash::success('Bundling Product Free updated successfully.');

        return redirect(route('bundlingProductFrees.index'));
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

        Flash::success('Bundling Product Free deleted successfully.');

        return redirect(route('bundlingProductFrees.index'));
    }
}
