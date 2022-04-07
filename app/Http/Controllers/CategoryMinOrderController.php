<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryMinOrderRequest;
use App\Http\Requests\UpdateCategoryMinOrderRequest;
use App\Repositories\CategoryMinOrderRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\CategoryMinOrder;
use Illuminate\Http\Request;
use Flash;
use Response;

class CategoryMinOrderController extends AppBaseController
{
    /** @var  CategoryMinOrderRepository */
    private $categoryMinOrderRepository;

    public function __construct(CategoryMinOrderRepository $categoryMinOrderRepo)
    {
        $this->categoryMinOrderRepository = $categoryMinOrderRepo;
    }

    /**
     * Display a listing of the CategoryMinOrder.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $categoryMinOrders = $this->categoryMinOrderRepository->all();

        return view('category_min_orders.index')
            ->with('categoryMinOrders', $categoryMinOrders);
    }

    /**
     * Show the form for creating a new CategoryMinOrder.
     *
     * @return Response
     */
    public function create()
    {
        return view('category_min_orders.create');
    }

    /**
     * Store a newly created CategoryMinOrder in storage.
     *
     * @param CreateCategoryMinOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryMinOrderRequest $request)
    {
        $input = $request->all();

        if($input['end_date'] != null || $input['end_date'] != ''){
            if($input['start_date'] > $input['end_date']){
                return redirect(route('categoryMinOrders.index'))->withInput()->with('error', 'start date must be older than end date.');
            }
        }

        $input['minimum_order'] = str_replace('.','',$input['minimum_order']);

        $cekData = CategoryMinOrder::where('category', $input['category'])->latest()->first();
        
        if($cekData != null){

            if($cekData->end_date == null){

                Flash::error('Please fill end date before input new value.');
    
                return redirect(route('categoryMinOrders.index'));
    
            } else if($cekData->end_date >= $input['start_date']) {
    
                return redirect(route('categoryMinOrders.create'))->withInput()->with('error', 'Start date must be newest from the last end date.');
    
            } else {
    
                $categoryMinOrder = $this->categoryMinOrderRepository->create($input);
        
                Flash::success('Category Min Order saved successfully.');
        
                return redirect(route('categoryMinOrders.index'));
            }

        } else {

            $categoryMinOrder = $this->categoryMinOrderRepository->create($input);
        
            Flash::success('Category Min Order saved successfully.');
    
            return redirect(route('categoryMinOrders.index'));

        }
        
    }

    /**
     * Display the specified CategoryMinOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryMinOrder = $this->categoryMinOrderRepository->find($id);

        if (empty($categoryMinOrder)) {
            Flash::error('Category Min Order not found');

            return redirect(route('categoryMinOrders.index'));
        }

        return view('category_min_orders.show')->with('categoryMinOrder', $categoryMinOrder);
    }

    /**
     * Show the form for editing the specified CategoryMinOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryMinOrder = $this->categoryMinOrderRepository->find($id);

        if (empty($categoryMinOrder)) {
            Flash::error('Category Min Order not found');

            return redirect(route('categoryMinOrders.index'));
        }

        return view('category_min_orders.edit')->with('categoryMinOrder', $categoryMinOrder);
    }

    /**
     * Update the specified CategoryMinOrder in storage.
     *
     * @param int $id
     * @param UpdateCategoryMinOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryMinOrderRequest $request)
    {
        $categoryMinOrder = $this->categoryMinOrderRepository->find($id);

        if (empty($categoryMinOrder)) {
            Flash::error('Category Min Order not found');

            return redirect(route('categoryMinOrders.index'));
        }

        $input = $request->all();

        if($input['end_date'] != null || $input['end_date'] != ''){
            if($input['start_date'] > $input['end_date']){
                return redirect(route('categoryMinOrders.edit', $id))->with('error', 'start date must be older than end date.');
            }
        }
        
        $input['minimum_order'] = str_replace('.','',$input['minimum_order']);

         // cek existing data
        $cekData = CategoryMinOrder::where('category', $input['category'])->whereNotIn('id', [$categoryMinOrder->id])->latest()->first();
         // dd($cekData);
        if($cekData != null){
            if($input['start_date'] <= $cekData->end_date){

                return redirect(route('categoryMinOrders.edit', $id))->with('error', 'Start date must be newest from end date last data, please setting last data first');
            
            } else {
                $categoryMinOrder = $this->categoryMinOrderRepository->update($input, $id);

                Flash::success('Category Min Order updated successfully.');
        
                return redirect(route('categoryMinOrders.index'));
            }
        } else {
            $categoryMinOrder = $this->categoryMinOrderRepository->update($input, $id);

            Flash::success('Category Min Order updated successfully.');
    
            return redirect(route('categoryMinOrders.index'));
         }

    }

    /**
     * Remove the specified CategoryMinOrder from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $categoryMinOrder = $this->categoryMinOrderRepository->find($id);

        if (empty($categoryMinOrder)) {
            Flash::error('Category Min Order not found');

            return redirect(route('categoryMinOrders.index'));
        }

        $this->categoryMinOrderRepository->delete($id);

        Flash::success('Category Min Order deleted successfully.');

        return redirect(route('categoryMinOrders.index'));
    }
}
