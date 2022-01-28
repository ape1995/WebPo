<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAddRequest;
use App\Http\Requests\UpdateAddRequest;
use App\Repositories\AddRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AddController extends AppBaseController
{
    /** @var  AddRepository */
    private $addRepository;

    public function __construct(AddRepository $addRepo)
    {
        $this->addRepository = $addRepo;
    }

    /**
     * Display a listing of the Add.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $adds = $this->addRepository->all();

        return view('adds.index')
            ->with('adds', $adds);
    }

    /**
     * Show the form for creating a new Add.
     *
     * @return Response
     */
    public function create()
    {
        return view('adds.create');
    }

    /**
     * Store a newly created Add in storage.
     *
     * @param CreateAddRequest $request
     *
     * @return Response
     */
    public function store(CreateAddRequest $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $input = $request->all();

        $file = $request->file('image');
        
        $file_name = time()."_adds.".$file->getClientOriginalExtension();

        $tujuan_upload = 'uploads/adds';

        // upload file
        $file->move($tujuan_upload, $file_name);
        $input['image'] = $file_name;

        $add = $this->addRepository->create($input);

        return redirect(route('adds.index'))->with('success', 'Add saved successfully.');
    }

    /**
     * Display the specified Add.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            Flash::error('Add not found');

            return redirect(route('adds.index'));
        }

        return view('adds.show')->with('add', $add);
    }

    /**
     * Show the form for editing the specified Add.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            Flash::error('Add not found');

            return redirect(route('adds.index'));
        }

        return view('adds.edit')->with('add', $add);
    }

    /**
     * Update the specified Add in storage.
     *
     * @param int $id
     * @param UpdateAddRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAddRequest $request)
    {
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            Flash::error('Add not found');

            return redirect(route('adds.index'));
        }

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $input = $request->all();

        if(empty($request->image)){

            $input['image'] = $add->image;

        } else {
            $input = $request->all();
    
            $file = $request->file('image');
            
            $file_name = time()."_adds.".$file->getClientOriginalExtension();
    
            $tujuan_upload = 'uploads/adds';
    
            // upload file
            $file->move($tujuan_upload, $file_name);
            $input['image'] = $file_name;
        }

        $add = $this->addRepository->update($input, $id);

        Flash::success('Add updated successfully.');

        return redirect(route('adds.index'));
    }

    /**
     * Remove the specified Add from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            Flash::error('Add not found');

            return redirect(route('adds.index'));
        }

        $this->addRepository->delete($id);

        Flash::success('Add deleted successfully.');

        return redirect(route('adds.index'));
    }
}
