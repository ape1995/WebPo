<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerFirstOrderRequest;
use App\Http\Requests\UpdateCustomerFirstOrderRequest;
use App\Repositories\CustomerFirstOrderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\User;
use App\Models\CustomerFirstOrder;
use App\Models\PromoHoldDuration;
use Flash;
use Response;
use DateTime;

class CustomerFirstOrderController extends AppBaseController
{
    /** @var  CustomerFirstOrderRepository */
    private $customerFirstOrderRepository;

    public function __construct(CustomerFirstOrderRepository $customerFirstOrderRepo)
    {
        $this->customerFirstOrderRepository = $customerFirstOrderRepo;
    }

    /**
     * Display a listing of the CustomerFirstOrder.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerFirstOrders = $this->customerFirstOrderRepository->all();

        return view('customer_first_orders.index')
            ->with('customerFirstOrders', $customerFirstOrders);
    }

    /**
     * Show the form for creating a new CustomerFirstOrder.
     *
     * @return Response
     */
    public function create()
    {
        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereIn('BAccountID', $createdCustomer)->whereNotIn('AcctCD', ['MAIN'])->get();

        return view('customer_first_orders.create', compact('customers'));
    }

    /**
     * Store a newly created CustomerFirstOrder in storage.
     *
     * @param CreateCustomerFirstOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerFirstOrderRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = \Auth::user()->id;

        $customerFirstOrder = $this->customerFirstOrderRepository->create($input);

        Flash::success('Customer First Order saved successfully.');

        return redirect(route('customerFirstOrders.index'));
    }

    /**
     * Display the specified CustomerFirstOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerFirstOrder = $this->customerFirstOrderRepository->find($id);

        if (empty($customerFirstOrder)) {
            Flash::error('Customer First Order not found');

            return redirect(route('customerFirstOrders.index'));
        }

        return view('customer_first_orders.show')->with('customerFirstOrder', $customerFirstOrder);
    }

    /**
     * Show the form for editing the specified CustomerFirstOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerFirstOrder = $this->customerFirstOrderRepository->find($id);

        if (empty($customerFirstOrder)) {
            Flash::error('Customer First Order not found');

            return redirect(route('customerFirstOrders.index'));
        }

        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereIn('BAccountID', $createdCustomer)->whereNotIn('AcctCD', ['MAIN'])->get();

        return view('customer_first_orders.edit', compact('customerFirstOrder',  'customers'));
    }

    /**
     * Update the specified CustomerFirstOrder in storage.
     *
     * @param int $id
     * @param UpdateCustomerFirstOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerFirstOrderRequest $request)
    {
        $customerFirstOrder = $this->customerFirstOrderRepository->find($id);

        if (empty($customerFirstOrder)) {
            Flash::error('Customer First Order not found');

            return redirect(route('customerFirstOrders.index'));
        }

        $customerFirstOrder = $this->customerFirstOrderRepository->update($request->all(), $id);

        Flash::success('Customer First Order updated successfully.');

        return redirect(route('customerFirstOrders.index'));
    }

    /**
     * Remove the specified CustomerFirstOrder from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerFirstOrder = $this->customerFirstOrderRepository->find($id);

        if (empty($customerFirstOrder)) {
            Flash::error('Customer First Order not found');

            return redirect(route('customerFirstOrders.index'));
        }

        $this->customerFirstOrderRepository->delete($id);

        Flash::success('Customer First Order deleted successfully.');

        return redirect(route('customerFirstOrders.index'));
    }

    public function getFirstOrder($customerCode)
    {
        $customer = Customer::where('AcctCD', $customerCode)->get()->first();
        $salesOrder = SalesOrder::where('status', 'P')->where('customer_id', $customer->BAccountID)->get()->first();

        $data = [];
        $data['first_order_number'] = $salesOrder->order_nbr;
        $data['first_order_date'] = $salesOrder->delivery_date->format('Y-m-d');
        
        return $data;
    }

    public function loadData()
    {
        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereIn('BAccountID', $createdCustomer)->whereNotIn('AcctCD', ['MAIN'])->get();

        foreach($customers as $customer){
            // Get Last Order Data for customer
            $salesOrder = SalesOrder::where('status', 'P')->where('customer_id', $customer->BAccountID)->orderBy('delivery_date', 'ASC')->orderBy('processed_at', 'ASC')->get()->first();

            // Cek Null
            if ($salesOrder != null) {

                // Cek Existing data, if exist just ignore, if not exist create new one
                $custFirstOrder = CustomerFirstOrder::where('customer_code', $customer->AcctCD)->get()->first();
                
                if ($custFirstOrder == null) {
                    CustomerFirstOrder::create([
                        'customer_code' => $customer->AcctCD,
                        'first_order_number' => $salesOrder->order_nbr,
                        'first_order_date' => $salesOrder->delivery_date,
                        'created_by' => \Auth::user()->id
                    ]);
                }
            }
        }

        Flash::success('Customer First Order loaded successfully.');

        return redirect(route('customerFirstOrders.index'));
        
    }

    public function validateOrderType($code, $userid, $deliveryDate)
    {
        if ($code == 'G') {
            $value = 'BUNDLING GIMMICK';
        } else if ($code == 'P') {
            $value = 'BUNDLING PRODUCT';
        } else if ($code == 'C') {
            $value = 'BUNDLING DISCOUNT';
        } else {
            $value = 'REGULAR';
        }

        $user = User::find($userid);
        $custFirstOrder = CustomerFirstOrder::where('customer_code', $user->customer->AcctCD)->get()->first();
        $promoDuration = PromoHoldDuration::whereRaw("packet_type = '$value' AND start_date <= '$deliveryDate' AND (end_date IS NULL OR end_date >= '$deliveryDate')")->get()->first();

        // if firts order not found, reject the order
        if ($custFirstOrder == null) {
            return 0;
        }

        // if duration promo not found allow the order
        if ($promoDuration == null) {
            return 1;
        }
        
        $date1 = new DateTime($custFirstOrder->first_order_date);
        $date2 = new DateTime($deliveryDate);

        $interval = $date1->diff($date2);
        $days = $interval->format('%a');

        if($days >= $promoDuration->duration_in_day){
            return 1;
        } else {
            return 0;
        }

        /*
            1 = Allow
            2 = Reject
        */

    }
}
