<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSignsRequest;
use App\Http\Requests\UpdateSignsRequest;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Flash;
use Response;
use Artisan;

class RoleController extends Controller
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
        if (!\Auth::user()->can('browse group permissions')) {
            abort(403);
        }

        $roles = Role::all();

        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new Signs.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create group permissions')) {
            abort(403);
        }

        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
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
        
        // dd($request);
        $role = Role::create(['name' => $request->name]);

        $permissions = $request->permission;
        // dd($permissions);

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return redirect(route('roles.index'))->with('success', 'Roles saved successfully.');
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

        $role = Role::find($id);

        $permissions = Role::findByName($role->name)->permissions;

        // dd($permissions);

        if (empty($role)) {
            return redirect(route('roles.index'))->with('error', 'Role not found.');
        }

        return view('roles.show')->with('role', $role)->with('permissions', $permissions);
    }

    /**
     * Show the form for editing the specified Signs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::user()->can('edit group permissions')) {
            abort(403);
        }

        $role = Role::find($id);
        $permissions = Permission::all();
        // $permission = Role::findByName($role->name)->permissions;
        // dd($permissions);

        foreach ($permissions as $key => $value) {
            // dd($value->name);
            if($role->hasPermissionTo($value->name)){
                $permissions[$key]['checked'] = 'checked';
            } else {
                $permissions[$key]['checked'] = '';
            }
        }

        if (empty($role)) {
            return redirect(route('roles.index'))->with('error', 'Role not found.');
        }

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified Signs in storage.
     *
     * @param int $id
     * @param UpdateSignsRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = Role::find($id);
        $role = Role::findByName($data->name)->permissions;

        // dd($role);

        foreach ($role as $value) {
            $data->revokePermissionTo($value->name);
        }

        $permissions = $request->permission;

        foreach ($permissions as $permission) {
            // dd($value);
            $data->givePermissionTo($permission);
        }

        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');

        return redirect(route('roles.index'))->with('success', 'Roles updated successfully.');
    }

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
        if (!\Auth::user()->can('delete group permissions')) {
            abort(403);
        }

        $role = Role::findOrFail($id); 
        $role->delete();

        return redirect(route('roles.index'))->with('success', 'Role deleted successfully.');
    }

}
