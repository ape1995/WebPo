<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDsPercentageRequest;
use App\Http\Requests\UpdateDsPercentageRequest;
use App\Repositories\DsPercentageRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\DsPercentage;
use Illuminate\Http\Request;
use Flash;
use Response;
use DataTables;

class DsPercentageController extends AppBaseController
{
    /** @var  DsPercentageRepository */
    private $dsPercentageRepository;

    public function __construct(DsPercentageRepository $dsPercentageRepo)
    {
        $this->dsPercentageRepository = $dsPercentageRepo;
    }

    /**
     * Display a listing of the DsPercentage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dsPercentages = $this->dsPercentageRepository->all();

        return view('ds_percentages.index')
            ->with('dsPercentages', $dsPercentages);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $datas = DsPercentage::query()->with(['customer']);
            return DataTables::of($datas)
                ->editColumn('start_date', function (DsPercentage $data) 
                {
                    return $data->start_date->format('Y-m-d');
                })
                ->addColumn('customer', function (DsPercentage $data) 
                {
                    return $data->customer->AcctCD.'-'.$data->customer->AcctName;
                })
                ->editColumn('end_date', function (DsPercentage $data) 
                {
                    if($data->end_date == null){
                        return '';
                    } else {
                        return $data->end_date->format('Y-m-d');
                    }
                })
                ->editColumn('percentage', function (DsPercentage $data) 
                {
                    return $data->percentage.' %';
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    
                    $maxID = DsPercentage::latest()->first();

                    if($row->id == $maxID->id) {

                        // $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editBook" title="Edit"><i class="fa fa-edit"></i></a>';
                        $btn = '';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook" title="Delete"><i class="fa fa-trash"></i></a>';
    
                        return $btn;
                    }

                    // }
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new DsPercentage.
     *
     * @return Response
     */
    public function create()
    {
        return view('ds_percentages.create');
    }

    /**
     * Store a newly created DsPercentage in storage.
     *
     * @param CreateDsPercentageRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $cekLatestData = DSPercentage::where('customer_code', $input['customer_code'])->latest()->first();

        if($input['start_date'] > $input['end_date'] && $input['end_date'] != null) {

            $returnData = array(
                'message' => 'End Date harus lebih dari Start Date!',
            );
    
            return response()->json($returnData, 403);
        
        } else if($cekLatestData == null){

            $dsPercentage = $this->dsPercentageRepository->create($input);

            return response()->json(['success'=>'Condition added successfully.']);

        } else if($cekLatestData->end_date == null) {
            
            $returnData = array(
                'message' => 'Silahkan isi terlebih dahulu tanggal akhir condition sebelumnya!',
            );
    
            return response()->json($returnData, 403);

        } else if($cekLatestData->end_date >= $input['start_date']) {

            $returnData = array(
                'message' => 'Start Date harus lebih dari End date Kondisi sebelumnya!',
            );
    
            return response()->json($returnData, 403);

        } else {

            $dsPercentage = $this->dsPercentageRepository->create($input);

            return response()->json(['success'=>'Condition added successfully.']);

        }
       

        
    }

    /**
     * Display the specified DsPercentage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dsPercentage = $this->dsPercentageRepository->find($id);

        if (empty($dsPercentage)) {
            Flash::error('Ds Percentage not found');

            return redirect(route('dsPercentages.index'));
        }

        return view('ds_percentages.show')->with('dsPercentage', $dsPercentage);
    }

    /**
     * Show the form for editing the specified DsPercentage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $dsPercentage = $this->dsPercentageRepository->find($id);

        $data = [];
        $data['id'] = $dsPercentage->id;
        $data['start_date'] = date('Y-m-d',strtotime($dsPercentage->start_date));
        $data['end_date'] = $dsPercentage->end_date == null ? '' : date('Y-m-d',strtotime($dsPercentage->end_date))    ;
        $data['percentage'] = $dsPercentage->percentage;

        return $data;
    }

    /**
     * Update the specified DsPercentage in storage.
     *
     * @param int $id
     * @param UpdateDsPercentageRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        
        $dsPercentage = $this->dsPercentageRepository->find($id);

        if (empty($dsPercentage)) {
            Flash::error('Ds Percentage not found');

            return redirect(route('dsPercentages.index'));
        }

        $input = $request->all();

        $cekLatestData = DSPercentage::whereNotIn('id', [$id])->latest()->first();

        if($input['start_date'] > $input['end_date'] && $input['end_date'] != null) {

            $returnData = array(
                'message' => 'End Date harus lebih dari Start Date!',
            );
    
            return response()->json($returnData, 403);
        
        } else if($cekLatestData->end_date >= $input['start_date']) {

            $returnData = array(
                'message' => 'Start Date harus lebih dari End date Kondisi sebelumnya!',
            );
    
            return response()->json($returnData, 403);

        } else {

            $dsPercentage = $this->dsPercentageRepository->update($input, $id);

            return response()->json(['success'=>'Condition updated successfully.']);

        }
        
    }

    /**
     * Remove the specified DsPercentage from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dsPercentage = $this->dsPercentageRepository->find($id);

        if (empty($dsPercentage)) {
            Flash::error('Ds Percentage not found');

            return redirect(route('dsPercentages.index'));
        }

        $this->dsPercentageRepository->delete($id);

        return response()->json(['success'=>'Condition deleted successfully.']);
    }
}
