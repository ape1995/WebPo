<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderPromoDetailRequest;
use App\Http\Requests\UpdateSalesOrderPromoDetailRequest;
use App\Repositories\SalesOrderPromoDetailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SalesOrderPromoDetailController extends AppBaseController
{
    /** @var  SalesOrderPromoDetailRepository */
    private $salesOrderPromoDetailRepository;

    public function __construct(SalesOrderPromoDetailRepository $salesOrderPromoDetailRepo)
    {
        $this->salesOrderPromoDetailRepository = $salesOrderPromoDetailRepo;
    }

    /**
     * Display a listing of the SalesOrderPromoDetail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $salesOrderPromoDetails = $this->salesOrderPromoDetailRepository->all();

        return view('sales_order_promo_details.index')
            ->with('salesOrderPromoDetails', $salesOrderPromoDetails);
    }

    /**
     * Show the form for creating a new SalesOrderPromoDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales_order_promo_details.create');
    }

    /**
     * Store a newly created SalesOrderPromoDetail in storage.
     *
     * @param CreateSalesOrderPromoDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateSalesOrderPromoDetailRequest $request)
    {
        $input = $request->all();

        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->create($input);

        Flash::success('Sales Order Promo Detail saved successfully.');

        return redirect(route('salesOrderPromoDetails.index'));
    }

    /**
     * Display the specified SalesOrderPromoDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->find($id);

        if (empty($salesOrderPromoDetail)) {
            Flash::error('Sales Order Promo Detail not found');

            return redirect(route('salesOrderPromoDetails.index'));
        }

        return view('sales_order_promo_details.show')->with('salesOrderPromoDetail', $salesOrderPromoDetail);
    }

    /**
     * Show the form for editing the specified SalesOrderPromoDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->find($id);

        if (empty($salesOrderPromoDetail)) {
            Flash::error('Sales Order Promo Detail not found');

            return redirect(route('salesOrderPromoDetails.index'));
        }

        return view('sales_order_promo_details.edit')->with('salesOrderPromoDetail', $salesOrderPromoDetail);
    }

    /**
     * Update the specified SalesOrderPromoDetail in storage.
     *
     * @param int $id
     * @param UpdateSalesOrderPromoDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalesOrderPromoDetailRequest $request)
    {
        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->find($id);

        if (empty($salesOrderPromoDetail)) {
            Flash::error('Sales Order Promo Detail not found');

            return redirect(route('salesOrderPromoDetails.index'));
        }

        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->update($request->all(), $id);

        Flash::success('Sales Order Promo Detail updated successfully.');

        return redirect(route('salesOrderPromoDetails.index'));
    }

    /**
     * Remove the specified SalesOrderPromoDetail from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesOrderPromoDetail = $this->salesOrderPromoDetailRepository->find($id);

        if (empty($salesOrderPromoDetail)) {
            Flash::error('Sales Order Promo Detail not found');

            return redirect(route('salesOrderPromoDetails.index'));
        }

        $this->salesOrderPromoDetailRepository->delete($id);

        Flash::success('Sales Order Promo Detail deleted successfully.');

        return redirect(route('salesOrderPromoDetails.index'));
    }
}
