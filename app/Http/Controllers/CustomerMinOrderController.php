<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerMinOrderRequest;
use App\Http\Requests\UpdateCustomerMinOrderRequest;
use App\Repositories\CustomerMinOrderRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Customer;
use App\Models\User;
use App\Models\CustomerMinOrder;
use App\Models\CustomerMinOrderHist;
use Illuminate\Http\Request;
use Flash;
use Response;

class CustomerMinOrderController extends AppBaseController
{
    /** @var  CustomerMinOrderRepository */
    private $customerMinOrderRepository;

    public function __construct(CustomerMinOrderRepository $customerMinOrderRepo)
    {
        $this->customerMinOrderRepository = $customerMinOrderRepo;
    }

    /**
     * Display a listing of the CustomerMinOrder.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerMinOrders = $this->customerMinOrderRepository->all();

        return view('customer_min_orders.index')
            ->with('customerMinOrders', $customerMinOrders);
    }

    /**
     * Show the form for creating a new CustomerMinOrder.
     *
     * @return Response
     */
    public function create()
    {
        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('customer_min_orders.create', compact('customers'));
    }

    /**
     * Store a newly created CustomerMinOrder in storage.
     *
     * @param CreateCustomerMinOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerMinOrderRequest $request)
    {
        $input = $request->all();

        $input['minimum_order'] = str_replace('.','',$input['minimum_order']);

        // cek existing data
        $cekData = CustomerMinOrder::where('customer_code', $input['customer_code'])->get()->first();

        if($cekData == null || empty($cekData)){
            $customerMinOrder = $this->customerMinOrderRepository->create($input);
        } else {
            // Create History
            CustomerMinOrderHist::create([
                'customer_code' => $cekData->customer_code,
                'old_price' => $cekData->minimum_order,
                'new_price' => $input['minimum_order']
            ]);

            // Delete Min Order
            $minOrder = CustomerMinOrder::find($cekData->id);
            $minOrder->delete();

            // Store New Min Order
            $customerMinOrder = $this->customerMinOrderRepository->create($input);
        }


        Flash::success('Customer Min Order saved successfully.');

        return redirect(route('customerMinOrders.index'));
    }

    /**
     * Display the specified CustomerMinOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerMinOrder = $this->customerMinOrderRepository->find($id);

        if (empty($customerMinOrder)) {
            Flash::error('Customer Min Order not found');

            return redirect(route('customerMinOrders.index'));
        }

        $customerMinOrderHists = CustomerMinOrderHist::where('customer_code', $customerMinOrder->customer_code)->orderBy('id', 'desc')->get();

        return view('customer_min_orders.show', compact('customerMinOrder', 'customerMinOrderHists'));
    }

    /**
     * Show the form for editing the specified CustomerMinOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerMinOrder = $this->customerMinOrderRepository->find($id);

        if (empty($customerMinOrder)) {
            Flash::error('Customer Min Order not found');

            return redirect(route('customerMinOrders.index'));
        }

        return view('customer_min_orders.edit')->with('customerMinOrder', $customerMinOrder);
    }

    /**
     * Update the specified CustomerMinOrder in storage.
     *
     * @param int $id
     * @param UpdateCustomerMinOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerMinOrderRequest $request)
    {
        $customerMinOrder = $this->customerMinOrderRepository->find($id);

        if (empty($customerMinOrder)) {
            Flash::error('Customer Min Order not found');

            return redirect(route('customerMinOrders.index'));
        }

        $customerMinOrder = $this->customerMinOrderRepository->update($request->all(), $id);

        Flash::success('Customer Min Order updated successfully.');

        return redirect(route('customerMinOrders.index'));
    }

    /**
     * Remove the specified CustomerMinOrder from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerMinOrder = $this->customerMinOrderRepository->find($id);

        if (empty($customerMinOrder)) {
            Flash::error('Customer Min Order not found');

            return redirect(route('customerMinOrders.index'));
        }

        $this->customerMinOrderRepository->delete($id);

        Flash::success('Customer Min Order deleted successfully.');

        return redirect(route('customerMinOrders.index'));
    }
}
