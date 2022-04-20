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
        $customers = Customer::whereIn('BAccountID', $createdCustomer)->whereNotIn('AcctCD', ['MAIN'])->get();
        
        return view('customer_min_orders.create', compact('customers'));
    }

    /**
     * Store a newly created CustomerMinOrder in storage.
     *
     * @param CreateCustomerMinOrderRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if($input['end_date'] != null || $input['end_date'] != ''){
            if($input['start_date'] > $input['end_date']){
                return redirect(route('customerMinOrders.create'))->withInput()->with('error', 'start date must be older than end date.');
            }
        }

        $input['minimum_order'] = str_replace('.','',$input['minimum_order']);

        // cek existing data
        $cekData = CustomerMinOrder::where('customer_code', $input['customer_code'])->latest()->first();
        // dd($cekData);
        if($cekData != null){

            if($cekData->end_date == null){
    
                Flash::error('Please fill end date before input new value.');
    
                return redirect(route('customerMinOrders.index'));
    
            } else if($cekData->end_date >= $input['start_date']) {
    
                return redirect(route('customerMinOrders.create'))->withInput()->with('error', 'Start date must be newest from the last end date.');
    
            } else {
    
                $this->customerMinOrderRepository->create($input);
    
                Flash::success('Customer Min Order saved successfully.');
    
                return redirect(route('customerMinOrders.index'));
            }

        } else {

            $this->customerMinOrderRepository->create($input);
    
            Flash::success('Customer Min Order saved successfully.');

            return redirect(route('customerMinOrders.index'));
            
        }
        
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

        $cekCustomerActive = CustomerMinOrder::where('customer_code',$customerMinOrder->customer_code)->whereNull('end_date')->whereNotIn('id', [$customerMinOrder->id])->get()->first();
        
        if($cekCustomerActive !== null){
            
            Flash::error('Delete the newest data first');

            return redirect(route('customerMinOrders.index'));

        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereIn('BAccountID', $createdCustomer)->whereNotIn('AcctCD', ['MAIN'])->get();
        

        return view('customer_min_orders.edit', compact('customerMinOrder', 'customers'));
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

        $input = $request->all();

        if($input['end_date'] != null || $input['end_date'] != ''){
            if($input['start_date'] > $input['end_date']){
                return redirect(route('customerMinOrders.edit', $id))->with('error', 'start date must be older than end date.');
            }
        }

        if (empty($customerMinOrder)) {
            Flash::error('Customer Min Order not found');

            return redirect(route('customerMinOrders.index'));
        }

         // cek existing data
        $cekData = CustomerMinOrder::where('customer_code', $input['customer_code'])->whereNotIn('id', [$customerMinOrder->id])->latest()->first();
        // dd($cekData);
        if($cekData != null){
            if($input['start_date'] <= $cekData->end_date){

                return redirect(route('customerMinOrders.edit', $id))->with('error', 'Start date must be newest from end date last data, please setting last data first');
            
            } else {
                $customerMinOrder = $this->customerMinOrderRepository->update($input, $id);
    
                Flash::success('Customer Min Order updated successfully.');
        
                return redirect(route('customerMinOrders.index'));
            }
        } else {
            $customerMinOrder = $this->customerMinOrderRepository->update($input, $id);
    
            Flash::success('Customer Min Order updated successfully.');
    
            return redirect(route('customerMinOrders.index'));
        }

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
