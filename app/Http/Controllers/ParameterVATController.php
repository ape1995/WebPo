<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParameterVATRequest;
use App\Http\Requests\UpdateParameterVATRequest;
use App\Repositories\ParameterVATRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ParameterVATController extends AppBaseController
{
    /** @var  ParameterVATRepository */
    private $parameterVATRepository;

    public function __construct(ParameterVATRepository $parameterVATRepo)
    {
        $this->parameterVATRepository = $parameterVATRepo;
    }

    /**
     * Display a listing of the ParameterVAT.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $parameterVATs = $this->parameterVATRepository->all();

        return view('parameter_v_a_ts.index')
            ->with('parameterVATs', $parameterVATs);
    }

    /**
     * Show the form for creating a new ParameterVAT.
     *
     * @return Response
     */
    public function create()
    {
        return view('parameter_v_a_ts.create');
    }

    /**
     * Store a newly created ParameterVAT in storage.
     *
     * @param CreateParameterVATRequest $request
     *
     * @return Response
     */
    public function store(CreateParameterVATRequest $request)
    {
        $input = $request->all();

        $parameterVAT = $this->parameterVATRepository->create($input);

        Flash::success('Parameter V A T saved successfully.');

        return redirect(route('parameterVATs.index'));
    }

    /**
     * Display the specified ParameterVAT.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parameterVAT = $this->parameterVATRepository->find($id);

        if (empty($parameterVAT)) {
            Flash::error('Parameter V A T not found');

            return redirect(route('parameterVATs.index'));
        }

        return view('parameter_v_a_ts.show')->with('parameterVAT', $parameterVAT);
    }

    /**
     * Show the form for editing the specified ParameterVAT.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parameterVAT = $this->parameterVATRepository->find($id);

        if (empty($parameterVAT)) {
            Flash::error('Parameter V A T not found');

            return redirect(route('parameterVATs.index'));
        }

        // dd($parameterVAT);

        return view('parameter_v_a_ts.edit')->with('parameterVAT', $parameterVAT);
    }

    /**
     * Update the specified ParameterVAT in storage.
     *
     * @param int $id
     * @param UpdateParameterVATRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParameterVATRequest $request)
    {
        $parameterVAT = $this->parameterVATRepository->find($id);

        if (empty($parameterVAT)) {
            Flash::error('Parameter V A T not found');

            return redirect(route('parameterVATs.index'));
        }

        $parameterVAT = $this->parameterVATRepository->update($request->all(), $id);

        Flash::success('Parameter V A T updated successfully.');

        return redirect(route('parameterVATs.index'));
    }

    /**
     * Remove the specified ParameterVAT from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parameterVAT = $this->parameterVATRepository->find($id);

        if (empty($parameterVAT)) {
            Flash::error('Parameter V A T not found');

            return redirect(route('parameterVATs.index'));
        }

        $this->parameterVATRepository->delete($id);

        Flash::success('Parameter V A T deleted successfully.');

        return redirect(route('parameterVATs.index'));
    }
}
