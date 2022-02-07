<?php

namespace App\Http\Controllers;
use App\Models\Estimasi;
use App\Models\Customer;
use App\Models\SOOutlet;
use Illuminate\Http\Request;
use DataTables;

class EstimasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('browse estimasi')) {
            abort(403);
        }

        $customers =  Customer::where('Type', 'CU')->where('Status', 'A')->get();
        
        // $outlets =  SOOutlet::select('OutletID', 'OutletName')->groupBy('OutletID', 'OutletName')->get();

        return view('estimasi.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            User::find($request->pk)
                ->update([
                    $request->name => $request->value
                ]);
  
            return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOutletData($id)
    {
        // $kwh = $this->sitesRepository->findBy('site_id', $id);
        $kwh = SOOutlet::select('OutletID', 'OutletName')->where('CustomerID', $id)->groupBy('OutletID', 'OutletName')->get();

        $output = [];
        $output[] = '<option value="">- Choose Outlet - </option>';
        foreach($kwh as $row){
            $output[] = '<option value="'.$row->OutletID.'">'.$row->OutletName.' - '.$row->OutletID.'</option>';
        }
        return $output;
    }

    public function dataTable(Request $request)
    {

        $request->date;
        
        if ($request->ajax()) {

            $datas = Estimasi::where('CustomerID', $request->customer)->where('OutletID', $request->outlet)->where('ShippedDate', '=', $request->date);
            $number = 0;
            
            return DataTables::of($datas)
                ->editColumn('OrderQty', function (Estimasi $estimasi) 
                {
                    //change over here
                    return number_format($estimasi->OrderQty, 0);
                })
                ->editColumn('InventoryID', function (Estimasi $estimasi) 
                {
                    //change over here
                    return $estimasi->product->Descr;
                })
                ->editColumn('ShippedDate', function (Estimasi $estimasi) 
                {
                    //change over here
                    return date('d M Y', strtotime($estimasi->ShippedDate) );
                })
                ->addIndexColumn()
                ->addColumn('Adjustment',function (Estimasi $estimasi){
                    // $number++;

                    return view('estimasi.adjustment')->with('estimasi', $estimasi)->render();
                })
                ->rawColumns(['Adjustment'])
                ->escapeColumns()
                ->toJson();

        } 
    }

}
