<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestImportRequest;
use App\Http\Requests\UpdateTestImportRequest;
use App\Repositories\TestImportRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TestImportController extends AppBaseController
{
    /** @var  TestImportRepository */
    private $testImportRepository;

    public function __construct(TestImportRepository $testImportRepo)
    {
        $this->testImportRepository = $testImportRepo;
    }

    /**
     * Display a listing of the TestImport.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $testImports = $this->testImportRepository->all();

        return view('test_imports.index')
            ->with('testImports', $testImports);
    }

    /**
     * Show the form for creating a new TestImport.
     *
     * @return Response
     */
    public function create()
    {
        return view('test_imports.create');
    }

    /**
     * Store a newly created TestImport in storage.
     *
     * @param CreateTestImportRequest $request
     *
     * @return Response
     */
    public function store(CreateTestImportRequest $request)
    {
        $input = $request->all();

        $testImport = $this->testImportRepository->create($input);

        Flash::success('Test Import saved successfully.');

        return redirect(route('testImports.index'));
    }

    /**
     * Display the specified TestImport.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $testImport = $this->testImportRepository->find($id);

        if (empty($testImport)) {
            Flash::error('Test Import not found');

            return redirect(route('testImports.index'));
        }

        return view('test_imports.show')->with('testImport', $testImport);
    }

    /**
     * Show the form for editing the specified TestImport.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $testImport = $this->testImportRepository->find($id);

        if (empty($testImport)) {
            Flash::error('Test Import not found');

            return redirect(route('testImports.index'));
        }

        return view('test_imports.edit')->with('testImport', $testImport);
    }

    /**
     * Update the specified TestImport in storage.
     *
     * @param int $id
     * @param UpdateTestImportRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTestImportRequest $request)
    {
        $testImport = $this->testImportRepository->find($id);

        if (empty($testImport)) {
            Flash::error('Test Import not found');

            return redirect(route('testImports.index'));
        }

        $testImport = $this->testImportRepository->update($request->all(), $id);

        Flash::success('Test Import updated successfully.');

        return redirect(route('testImports.index'));
    }

    /**
     * Remove the specified TestImport from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $testImport = $this->testImportRepository->find($id);

        if (empty($testImport)) {
            Flash::error('Test Import not found');

            return redirect(route('testImports.index'));
        }

        $this->testImportRepository->delete($id);

        Flash::success('Test Import deleted successfully.');

        return redirect(route('testImports.index'));
    }
}
