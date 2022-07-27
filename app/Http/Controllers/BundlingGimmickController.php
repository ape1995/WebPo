<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBundlingGimmickRequest;
use App\Http\Requests\UpdateBundlingGimmickRequest;
use App\Repositories\BundlingGimmickRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\BundlingGimmick;
use Flash;
use Response;

class BundlingGimmickController extends AppBaseController
{
    /** @var  BundlingGimmickRepository */
    private $bundlingGimmickRepository;

    public function __construct(BundlingGimmickRepository $bundlingGimmickRepo)
    {
        $this->bundlingGimmickRepository = $bundlingGimmickRepo;
    }

    /**
     * Display a listing of the BundlingGimmick.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('browse bundling gimmicks')) {
            abort(403);
        }

        $bundlingGimmicks = BundlingGimmick::orderBy('id', 'DESC')->get();
        $maxId = BundlingGimmick::max('id');

        return view('bundling_gimmicks.index', compact('bundlingGimmicks', 'maxId'));

    }

    /**
     * Show the form for creating a new BundlingGimmick.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create bundling gimmicks')) {
            abort(403);
        }

        return view('bundling_gimmicks.create');
    }

    /**
     * Store a newly created BundlingGimmick in storage.
     *
     * @param CreateBundlingGimmickRequest $request
     *
     * @return Response
     */
    public function store(CreateBundlingGimmickRequest $request)
    {
        $input = $request->all();

        // dd($input);

        $input['nominal'] = str_replace(',','',$input['nominal']);
        $input['nominal'] = str_replace('.','',$input['nominal']);

        $cekData = BundlingGimmick::latest()->first();

        if ($input['end_date'] != null) {
            if ($input['end_date'] < $input['start_date']) {
                return redirect(route('bundlingGimmicks.create'))->with('error', 'End date must be newest from Start date!');
            }
        }

        if($cekData == null){

            $bundlingGimmick = $this->bundlingGimmickRepository->create($input);
            Flash::success('Data Saved Successfull');
            return redirect(route('bundlingGimmicks.index'));

        } else if ($cekData->end_date == null) {

            Flash::error('Let fill the end date of the latest data before you create new one!');
            return redirect(route('bundlingGimmicks.index'));

        } else if ($input['start_date'] <= $cekData->end_date) {
            
            return redirect(route('bundlingGimmicks.create'))->with('error', 'Start date cannot be less than end date from latest data!');

        } else {

            $bundlingGimmick = $this->bundlingGimmickRepository->create($input);
            Flash::success('Data Saved Successfull');
            return redirect(route('bundlingGimmicks.index'));

        }


    }

    /**
     * Display the specified BundlingGimmick.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (!\Auth::user()->can('view bundling gimmicks')) {
            abort(403);
        }

        $bundlingGimmick = $this->bundlingGimmickRepository->find($id);

        if (empty($bundlingGimmick)) {
            Flash::error('Bundling Gimmick not found');

            return redirect(route('bundlingGimmicks.index'));
        }

        return view('bundling_gimmicks.show')->with('bundlingGimmick', $bundlingGimmick);
    }

    /**
     * Show the form for editing the specified BundlingGimmick.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::user()->can('edit bundling gimmicks')) {
            abort(403);
        }

        $bundlingGimmick = $this->bundlingGimmickRepository->find($id);

        if (empty($bundlingGimmick)) {
            Flash::error('Bundling Gimmick not found');

            return redirect(route('bundlingGimmicks.index'));
        }

        return view('bundling_gimmicks.edit')->with('bundlingGimmick', $bundlingGimmick);
    }

    /**
     * Update the specified BundlingGimmick in storage.
     *
     * @param int $id
     * @param UpdateBundlingGimmickRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBundlingGimmickRequest $request)
    {
        $bundlingGimmick = $this->bundlingGimmickRepository->find($id);

        $input = $request->all();

        
        if (empty($bundlingGimmick)) {
            Flash::error('Bundling Gimmick not found');
            
            return redirect(route('bundlingGimmicks.index'));
        }
        $input['nominal'] = str_replace(',','',$input['nominal']);
        $input['nominal'] = str_replace('.','',$input['nominal']);

        $cekData = BundlingGimmick::whereNotIn('id', [$id])->latest()->first();
        // dd($cekData);
        if ($input['end_date'] != null) {
            if ($input['end_date'] < $input['start_date']) {
                return redirect(route('bundlingGimmicks.edit', $id))->with('error', 'End date must be newest from Start date!');
            }
        }

        if($cekData == null){

            $bundlingGimmick = $this->bundlingGimmickRepository->update($input, $id);
            Flash::success('Data Updated Successfull');
            return redirect(route('bundlingGimmicks.index'));

        } else if ($cekData->end_date == null) {

            Flash::error('Let fill the end date of the latest data before you create new one!');
            return redirect(route('bundlingGimmicks.index'));

        } else if ($input['start_date'] <= $cekData->end_date) {
            
            return redirect(route('bundlingGimmicks.edit', $id))->with('error', 'Start date cannot be less than end date from latest data!');

        } else {

            $bundlingGimmick = $this->bundlingGimmickRepository->update($input, $id);
            Flash::success('Data Updated Successfull');
            return redirect(route('bundlingGimmicks.index'));

        }

        Flash::success('Bundling Gimmick updated successfully.');

        return redirect(route('bundlingGimmicks.index'));
    }

    /**
     * Remove the specified BundlingGimmick from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::user()->can('delete bundling gimmicks')) {
            abort(403);
        }

        $bundlingGimmick = $this->bundlingGimmickRepository->find($id);

        if (empty($bundlingGimmick)) {
            Flash::error('Bundling Gimmick not found');

            return redirect(route('bundlingGimmicks.index'));
        }

        $this->bundlingGimmickRepository->delete($id);

        Flash::success('Bundling Gimmick deleted successfully.');

        return redirect(route('bundlingGimmicks.index'));
    }

    public function release($id)
    {
        $bundlingGimmick = BundlingGimmick::find($id);
        $bundlingGimmick['status'] = 'Released';
        $bundlingGimmick->save();

        Flash::success('Bundling Gimmick released successfully.');

        return redirect(route('bundlingGimmicks.index'));
    }
}
