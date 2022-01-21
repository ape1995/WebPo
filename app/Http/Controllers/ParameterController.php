<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParameterRequest;
use App\Http\Requests\UpdateParameterRequest;
use App\Repositories\ParameterRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ParameterController extends AppBaseController
{
    /** @var  ParameterRepository */
    private $parameterRepository;

    public function __construct(ParameterRepository $parameterRepo)
    {
        $this->parameterRepository = $parameterRepo;
    }

    /**
     * Display a listing of the Parameter.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $parameters = $this->parameterRepository->all();

        return view('parameters.index')
            ->with('parameters', $parameters);
    }

    /**
     * Show the form for creating a new Parameter.
     *
     * @return Response
     */
    public function create()
    {
        return view('parameters.create');
    }

    /**
     * Store a newly created Parameter in storage.
     *
     * @param CreateParameterRequest $request
     *
     * @return Response
     */
    public function store(CreateParameterRequest $request)
    {
        $input = $request->all();

        $parameter = $this->parameterRepository->create($input);

        Flash::success('Parameter saved successfully.');

        return redirect(route('parameters.index'));
    }

    /**
     * Display the specified Parameter.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            Flash::error('Parameter not found');

            return redirect(route('parameters.index'));
        }

        return view('parameters.show')->with('parameter', $parameter);
    }

    /**
     * Show the form for editing the specified Parameter.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            Flash::error('Parameter not found');

            return redirect(route('parameters.index'));
        }

        return view('parameters.edit')->with('parameter', $parameter);
    }

    /**
     * Update the specified Parameter in storage.
     *
     * @param int $id
     * @param UpdateParameterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParameterRequest $request)
    {
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            Flash::error('Parameter not found');

            return redirect(route('parameters.index'));
        }

        $parameter = $this->parameterRepository->update($request->all(), $id);

        Flash::success('Parameter updated successfully.');

        return redirect(route('parameters.index'));
    }

    /**
     * Remove the specified Parameter from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            Flash::error('Parameter not found');

            return redirect(route('parameters.index'));
        }

        $this->parameterRepository->delete($id);

        Flash::success('Parameter deleted successfully.');

        return redirect(route('parameters.index'));
    }
}
