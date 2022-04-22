<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Flash;
use Response;
use Artisan;

class PermissionController extends Controller
{

    /**
     * Display a listing of the Signs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('browse permissions')) {
            abort(403);
        }

        $permissions = Permission::orderBy('id', 'asc')->get();

        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new Signs.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create permissions')) {
            abort(403);
        }

        return view('permissions.create');
    }

    /**
     * Store a newly created Signs in storage.
     *
     * @param CreateSignsRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->name]);

        Flash::success('Permission created successfully.');

        return redirect(route('permissions.index'))->with('success', 'Permission saved successfully.');
    }

    /**
     * Display the specified Signs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (!\Auth::user()->can('view group permissions')) {
            abort(403);
        }

        $permission = Permission::find($id);

        // dd($permissions);

        if (empty($permission)) {
            return redirect(route('permissions.index'))->with('error', 'Permission not found.');
        }

        return view('permissions.show')->with('permission', $permission);
    }

    /**
     * Show the form for editing the specified Signs.
     *
     * @param int $id
     *
     * @return Response
     */

    /**
     * Remove the specified Signs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::user()->can('delete permissions')) {
            abort(403);
        }

        $permission = Permission::findOrFail($id); 
        $permission->delete();

        Flash::success('Permission deleted successfully.');

        return redirect(route('permissions.index'))->with('success', 'Permission deleted successfully.');
    }

}
