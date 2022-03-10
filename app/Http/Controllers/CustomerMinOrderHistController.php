<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerMinOrderHistRequest;
use App\Http\Requests\UpdateCustomerMinOrderHistRequest;
use App\Repositories\CustomerMinOrderHistRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerMinOrderHistController extends AppBaseController
{
    /** @var  CustomerMinOrderHistRepository */
    private $customerMinOrderHistRepository;

    public function __construct(CustomerMinOrderHistRepository $customerMinOrderHistRepo)
    {
        $this->customerMinOrderHistRepository = $customerMinOrderHistRepo;
    }

    /**
     * Display a listing of the CustomerMinOrderHist.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerMinOrderHists = $this->customerMinOrderHistRepository->all();

        return view('customer_min_order_hists.index')
            ->with('customerMinOrderHists', $customerMinOrderHists);
    }

    /**
     * Show the form for creating a new CustomerMinOrderHist.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer_min_order_hists.create');
    }

    /**
     * Store a newly created CustomerMinOrderHist in storage.
     *
     * @param CreateCustomerMinOrderHistRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerMinOrderHistRequest $request)
    {
        $input = $request->all();

        $customerMinOrderHist = $this->customerMinOrderHistRepository->create($input);

        Flash::success('Customer Min Order Hist saved successfully.');

        return redirect(route('customerMinOrderHists.index'));
    }

    /**
     * Display the specified CustomerMinOrderHist.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerMinOrderHist = $this->customerMinOrderHistRepository->find($id);

        if (empty($customerMinOrderHist)) {
            Flash::error('Customer Min Order Hist not found');

            return redirect(route('customerMinOrderHists.index'));
        }

        return view('customer_min_order_hists.show')->with('customerMinOrderHist', $customerMinOrderHist);
    }

    /**
     * Show the form for editing the specified CustomerMinOrderHist.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerMinOrderHist = $this->customerMinOrderHistRepository->find($id);

        if (empty($customerMinOrderHist)) {
            Flash::error('Customer Min Order Hist not found');

            return redirect(route('customerMinOrderHists.index'));
        }

        return view('customer_min_order_hists.edit')->with('customerMinOrderHist', $customerMinOrderHist);
    }

    /**
     * Update the specified CustomerMinOrderHist in storage.
     *
     * @param int $id
     * @param UpdateCustomerMinOrderHistRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerMinOrderHistRequest $request)
    {
        $customerMinOrderHist = $this->customerMinOrderHistRepository->find($id);

        if (empty($customerMinOrderHist)) {
            Flash::error('Customer Min Order Hist not found');

            return redirect(route('customerMinOrderHists.index'));
        }

        $customerMinOrderHist = $this->customerMinOrderHistRepository->update($request->all(), $id);

        Flash::success('Customer Min Order Hist updated successfully.');

        return redirect(route('customerMinOrderHists.index'));
    }

    /**
     * Remove the specified CustomerMinOrderHist from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerMinOrderHist = $this->customerMinOrderHistRepository->find($id);

        if (empty($customerMinOrderHist)) {
            Flash::error('Customer Min Order Hist not found');

            return redirect(route('customerMinOrderHists.index'));
        }

        $this->customerMinOrderHistRepository->delete($id);

        Flash::success('Customer Min Order Hist deleted successfully.');

        return redirect(route('customerMinOrderHists.index'));
    }
}
