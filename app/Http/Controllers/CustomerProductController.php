<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerProductRequest;
use App\Http\Requests\UpdateCustomerProductRequest;
use App\Repositories\CustomerProductRepository;
use App\Http\Controllers\AppBaseController;
use App\Imports\CustomerProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Models\User;
use App\Models\CustomerProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Flash;
use Response;
use DB;

class CustomerProductController extends AppBaseController
{
    /** @var  CustomerProductRepository */
    private $customerProductRepository;

    public function __construct(CustomerProductRepository $customerProductRepo)
    {
        $this->customerProductRepository = $customerProductRepo;
    }

    /**
     * Display a listing of the CustomerProduct.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customerProducts = $this->customerProductRepository->all();
        
        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        
        return view('customer_products.index', compact('customerProducts', 'customers'));
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $datas = CustomerProduct::query();

            return DataTables::of($datas)
                ->editColumn('customer_code', function (CustomerProduct $customerProduct) {
                    return $customerProduct->customer->AcctCD.' - '.$customerProduct->customer->AcctName;
                })
                ->addColumn('inventory', function (CustomerProduct $customerProduct) {
                    return $customerProduct->product->InventoryCD.' - '.$customerProduct->product->Descr;
                })
                ->addColumn('date_add', function (CustomerProduct $customerProduct) {
                    return $customerProduct->created_at->format('Y-m-d');
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('customer_products.action')->with('customerProduct',$data)->render();
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new CustomerProduct.
     *
     * @return Response
     */
    public function create()
    {
        $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');
        $customers = Customer::whereRaw("LEFT(AcctCD,2) = '60'")->where('Type', 'CU')->where('Status', 'A')->whereIn('BAccountID', $createdCustomer)->get();
        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->orderBy('InventoryCD', 'ASC')->get();

        return view('customer_products.create', compact('customers', 'products'));
    }

    public function createBulk()
    {
        $products = Product::whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->orderBy('InventoryCD', 'ASC')->get();
        // $customerClasses = '';

        return view('customer_products.create_bulk', compact('products'));
    }

    /**
     * Store a newly created CustomerProduct in storage.
     *
     * @param CreateCustomerProductRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerProductRequest $request)
    {
        $input = $request->all();

        foreach ($input['check'] as $key => $value) {
            // Cek data sudah ada
            $cekData = CustomerProduct::where('customer_code', $input['customer_code'])->where('inventory_code', $value)->get()->first();
            $cekCustomerClass = Customer::where('AcctCD', $input['customer_code'])->get()->first();
                
            // dd($cekData);
            if($cekData == null){

                $input['customer_class'] = $cekCustomerClass->customer2->CustomerClassID;
                $input['inventory_code'] = $value;
        
                $customerProduct = $this->customerProductRepository->create($input);
            }

            // Get Customer Class
        }

        Flash::success('Customer Product saved successfully.');

        return redirect(route('customerProducts.index'));
    }

    public function storeBulk(Request $request)
    {

        $input = $request->all();

        // dd($input);

        if(isset($input['delete_item'])){
            // Delete
            $customersByClasses = DB::connection('sqlsrv')->table('Customer')->where('Customer.CustomerClassID', $input['customer_class'])
                                ->join('BAccount', 'Customer.BAccountID', '=', 'BAccount.BAccountID')->get();
            

            foreach($customersByClasses as $customer){
                // dd($customer);
                $product = CustomerProduct::where('customer_code', $customer->AcctCD)->where('inventory_code', $input['inventory_code'])->get()->first();
                if($product != null){
                    $product->delete();
                }
            }

            Flash::success('Customer Product Bulk deleted successfully.');

            return redirect(route('customerProducts.index'));

            
            
        } else {
            // Save
            $createdCustomer = User::select('customer_id')->distinct()->get()->pluck('customer_id');

            // dd($createdCustomer);

            $customersByClasses = DB::connection('sqlsrv')->table('Customer')->where('Customer.CustomerClassID', $input['customer_class'])
                                ->join('BAccount', 'Customer.BAccountID', '=', 'BAccount.BAccountID')
                                ->whereIn('Customer.BAccountID', $createdCustomer)->get();

            foreach($customersByClasses as $customer){
                
                // Cek data sudah ada
                $cekData = CustomerProduct::where('customer_code', $customer->AcctCD)->where('inventory_code', $input['inventory_code'])->get()->first();

                if($cekData == null){
                    // Get Customer Class
                    $cekCustomerClass = Customer::where('AcctCD', $customer->AcctCD)->get()->first();
                    // dd($cekCustomerClass->customer2);
                    $input['customer_code'] = $customer->AcctCD;
                    $input['customer_class'] = $cekCustomerClass->customer2->CustomerClassID;
                    // Store to DB
                    $customerProduct = $this->customerProductRepository->create($input);
                }

            }

            Flash::success('Customer Product Bulk inserted successfully.');

            return redirect(route('customerProducts.index'));
            
        }


    }

    /**
     * Display the specified CustomerProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customerProduct = $this->customerProductRepository->find($id);

        if (empty($customerProduct)) {
            Flash::error('Customer Product not found');

            return redirect(route('customerProducts.index'));
        }

        return view('customer_products.show')->with('customerProduct', $customerProduct);
    }

    /**
     * Show the form for editing the specified CustomerProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customerProduct = $this->customerProductRepository->find($id);

        if (empty($customerProduct)) {
            Flash::error('Customer Product not found');

            return redirect(route('customerProducts.index'));
        }

        return view('customer_products.edit')->with('customerProduct', $customerProduct);
    }

    /**
     * Update the specified CustomerProduct in storage.
     *
     * @param int $id
     * @param UpdateCustomerProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerProductRequest $request)
    {
        $customerProduct = $this->customerProductRepository->find($id);

        if (empty($customerProduct)) {
            Flash::error('Customer Product not found');

            return redirect(route('customerProducts.index'));
        }

        $customerProduct = $this->customerProductRepository->update($request->all(), $id);

        Flash::success('Customer Product updated successfully.');

        return redirect(route('customerProducts.index'));
    }

    /**
     * Remove the specified CustomerProduct from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customerProduct = $this->customerProductRepository->find($id);

        if (empty($customerProduct)) {
            Flash::error('Customer Product not found');

            return redirect(route('customerProducts.index'));
        }

        $this->customerProductRepository->delete($id);

        Flash::success('Customer Product deleted successfully.');

        return redirect(route('customerProducts.index'));
    }

    public function import(Request $request){
        
        $file = $request->file('file');
        $namaFile =  $file->getClientOriginalName();
        $file->move('uploads', $namaFile);

        Excel::import(new CustomerProductImport, public_path('uploads/'.$namaFile));
        
        return redirect()->route('customerProducts.index')->with('success', 'Customer Product Imported Successfully');

    }
}
