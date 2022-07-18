<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBundlingGimmickRequest;
use App\Http\Requests\UpdateBundlingGimmickRequest;
use App\Repositories\BundlingGimmickRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
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
        $bundlingGimmicks = $this->bundlingGimmickRepository->all();

        return view('bundling_gimmicks.index')
            ->with('bundlingGimmicks', $bundlingGimmicks);
    }

    /**
     * Show the form for creating a new BundlingGimmick.
     *
     * @return Response
     */
    public function create()
    {
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

        $input['nominal'] = str_replace(',','',$input['nominal']);
        $input['nominal'] = str_replace('.','',$input['nominal']);

        $bundlingGimmick = $this->bundlingGimmickRepository->create($input);

        Flash::success('Bundling Gimmick saved successfully.');

        return redirect(route('bundlingGimmicks.index'));
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

        $input['nominal'] = str_replace(',','',$input['nominal']);
        $input['nominal'] = str_replace('.','',$input['nominal']);

        if (empty($bundlingGimmick)) {
            Flash::error('Bundling Gimmick not found');

            return redirect(route('bundlingGimmicks.index'));
        }

        $bundlingGimmick = $this->bundlingGimmickRepository->update($input, $id);

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
        $bundlingGimmick = $this->bundlingGimmickRepository->find($id);

        if (empty($bundlingGimmick)) {
            Flash::error('Bundling Gimmick not found');

            return redirect(route('bundlingGimmicks.index'));
        }

        $this->bundlingGimmickRepository->delete($id);

        Flash::success('Bundling Gimmick deleted successfully.');

        return redirect(route('bundlingGimmicks.index'));
    }
}
