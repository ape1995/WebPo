<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesOrderPromoRequest;
use App\Http\Requests\UpdateSalesOrderPromoRequest;
use App\Repositories\SalesOrderPromoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\SalesOrderPromo;
// use App\Models\CartPromo;
use Flash;
use Response;
use DataTables;

class SalesOrderPromoController extends AppBaseController
{
    /** @var  SalesOrderPromoRepository */
    private $salesOrderPromoRepository;

    public function __construct(SalesOrderPromoRepository $salesOrderPromoRepo)
    {
        $this->salesOrderPromoRepository = $salesOrderPromoRepo;
    }

    /**
     * Display a listing of the SalesOrderPromo.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $salesOrderPromos = $this->salesOrderPromoRepository->all();

        return view('sales_order_promos.index')
            ->with('salesOrderPromos', $salesOrderPromos);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {

            if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
                $datas = SalesOrderPromo::where('customer_id', \Auth::user()->customer_id)->orderBy('id', 'desc');
            } else {
                $datas = SalesOrderPromo::with('customer')->whereNotIn('status', ['S', 'C'])->latest();
            }

            return DataTables::of($datas)
                ->addColumn('customer', function (SalesOrderPromo $salesOrder) {
                    return $salesOrder->customer->AcctName;
                })
                ->addColumn('order_type', function (SalesOrderPromo $salesOrder) {
                    return $salesOrder->order_type == 'P' ? 'Packet Discount' : '';
                })
                ->addColumn('created_name', function (SalesOrderPromo $salesOrder) {
                    return $salesOrder->createdBy->name;
                })
                ->editColumn('order_date', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->order_date) );
                })
                ->editColumn('delivery_date', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return date('d M Y', strtotime($salesOrder->delivery_date) );
                })
                ->editColumn('order_amount', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_amount, 2, ',', '.');
                })
                ->editColumn('order_qty', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_qty, 0, ',', '.');
                })
                ->editColumn('tax', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->tax, 2, ',', '.');
                })
                ->editColumn('order_total', function (SalesOrderPromo $salesOrder) 
                {
                    //change over here
                    return number_format($salesOrder->order_total, 2, ',', '.');
                })
                ->editColumn('status', function (SalesOrder $salesOrder) 
                {
                    if($salesOrder->status == "S"){
                        $status = 'Draft';
                    } else if ($salesOrder->status == "R"){
                        $status = 'Submitted';
                    } else if ($salesOrder->status == "C"){
                        $status = 'Canceled';
                    } else if ($salesOrder->status == "B"){
                        $status = 'Rejected';
                    } else {
                        $status = 'Processed';
                    }

                    return $status;
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('sales_order_promos.action')->with('salesOrder',$data)->render();
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new SalesOrderPromo.
     *
     * @return Response
     */
    public function create()
    {
        return view('sales_order_promos.create');
    }

    /**
     * Store a newly created SalesOrderPromo in storage.
     *
     * @param CreateSalesOrderPromoRequest $request
     *
     * @return Response
     */
    public function store(CreateSalesOrderPromoRequest $request)
    {
        $input = $request->all();

        $salesOrderPromo = $this->salesOrderPromoRepository->create($input);

        Flash::success('Sales Order Promo saved successfully.');

        return redirect(route('salesOrderPromos.index'));
    }

    /**
     * Display the specified SalesOrderPromo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        return view('sales_order_promos.show')->with('salesOrderPromo', $salesOrderPromo);
    }

    /**
     * Show the form for editing the specified SalesOrderPromo.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        return view('sales_order_promos.edit')->with('salesOrderPromo', $salesOrderPromo);
    }

    /**
     * Update the specified SalesOrderPromo in storage.
     *
     * @param int $id
     * @param UpdateSalesOrderPromoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalesOrderPromoRequest $request)
    {
        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        $salesOrderPromo = $this->salesOrderPromoRepository->update($request->all(), $id);

        Flash::success('Sales Order Promo updated successfully.');

        return redirect(route('salesOrderPromos.index'));
    }

    /**
     * Remove the specified SalesOrderPromo from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salesOrderPromo = $this->salesOrderPromoRepository->find($id);

        if (empty($salesOrderPromo)) {
            Flash::error('Sales Order Promo not found');

            return redirect(route('salesOrderPromos.index'));
        }

        $this->salesOrderPromoRepository->delete($id);

        Flash::success('Sales Order Promo deleted successfully.');

        return redirect(route('salesOrderPromos.index'));
    }
}
