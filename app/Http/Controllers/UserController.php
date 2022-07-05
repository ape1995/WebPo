<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Imports\UsersImport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Flash;
use Auth;
use Hash;
use Artisan;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\Auth::user()->can('browse users')) {
            abort(403);
        }

        return view('users.index');
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            if(\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customers'){
                $datas = User::where('customer_id', \Auth::user()->customer_id)->latest();
            } else {
                $datas = User::with('customer')->latest()->get();
            }
            return DataTables::of($datas)
                ->addColumn('customer', function (User $user) {
                    return $user->customer->AcctName.' - '.$user->customer->AcctCD;
                })
                ->editColumn('status', function (User $user) 
                {
                    //change over here
                    if($user->status == 1){
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->addIndexColumn()
                ->addColumn('action',function ($data){
                    return view('users.action')->with('user',$data)->render();
                })
                ->rawColumns(['action'])
                ->escapeColumns()
                ->toJson();
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Auth::user()->can('create users')) {
            abort(403);
        }

        if(\Auth::user()->role == 'Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
            $roles = Role::where('name', 'Staff Customers')->where('status', true)->get();
        } else {
            $customers =  Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->orWhere('BAccountID', '3')->get();
            // $customers =  Customer::where('Type', 'CU')->get();
            $roles = Role::where('status', true)->get();
        }

        // dd($customers);

        return view('users.create', compact('roles', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validate = $this->validate($request, [
            'email' => 'unique:users,email'
         ],[
            'email.unique' => 'email has already been registered, please enter another one'
         ]);

        $input['password'] = Hash::make($request->password);
        $input['created_by'] = Auth::user()->id;
        
        $User = User::create($input);
        
        $User->assignRole($input['role']);

        return redirect(route('users.index'))->with('success', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!\Auth::user()->can('view users')) {
            abort(403);
        }

        $user = User::find($id);

        if (empty($user)) {
            // Flash::error('User not found');

            return redirect(route('users.index'))->with('error', 'User not found');
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!\Auth::user()->can('edit users')) {
            abort(403);
        }

        $users = User::find($id);
        
        if(\Auth::user()->role == 'Customers'){
            $customers = Customer::where('BAccountID', \Auth::user()->customer_id)->get();
            $roles = Role::where('name', 'Staff Customers')->where('status', true)->get();
        } else {
            $customers =  Customer::whereRaw("(LEFT(AcctCD,2) = '60' OR LEFT(AcctCD,2) = '40')")->where('Type', 'CU')->where('Status', 'A')->orWhere('BAccountID', '3')->get();
            $roles = Role::where('status', true)->get();
        }

        if (empty($users)) {
            return redirect(route('users.index'))->with('error', 'User not found');
        }

        return view('users.edit', compact('users', 'roles', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'))->with('error', 'User not found');
        }

        if(empty($request['password']))
        {
            $request['password'] = $user->password;
        } else {
            $request['password'] = Hash::make($request->password);
        }

        $request['updated_by'] = Auth::user()->id;

        $user->removeRole($user->role);
        
        $user->update($request->all());

        $user->assignRole($request->role);
        $user->syncRoles($request->role);

        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        
        return redirect(route('users.index'))->with('success', 'User Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!\Auth::user()->can('delete users')) {
            abort(403);
        }

        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'))->with('error', 'User not found');
        }

        $user->removeRole($user->role);

        $user->delete($id);

        return redirect(route('users.index'))->with('success', 'User deleted successfully.');
    }

    public function inactive($id)
    {
        if (!\Auth::user()->can('inactive users')) {
            abort(403);
        }

        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'))->with('error', 'User not found');
        }

        // $user->removeRole($user->role);
        $user = User::find($id);
        $user['status'] = 0;
        $user->save();

        return redirect(route('users.index'))->with('success', 'User inactived successfully.');
    }

    public function active($id)
    {
        if (!\Auth::user()->can('active users')) {
            abort(403);
        }

        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'))->with('error', 'User not found');
        }

        // $user->removeRole($user->role);
        $user = User::find($id);
        $user['status'] = 1;
        $user->save();

        return redirect(route('users.index'))->with('success', 'User actived successfully.');
    }

    public function updatePassword(Request $request){

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        $user = \Auth::user();

        // dd($reqOldPassword, $realPassword);

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = \Hash::make($request->new_password);

        $user->save();
  
        return back()->with('success', 'Password successfully changed!');

    }

    public function import(Request $request){

        $file = $request->file('file');
        $namaFile =  $file->getClientOriginalName();
        $file->move('uploads', $namaFile);

        Excel::import(new UsersImport, public_path('uploads/'.$namaFile));
        
        return redirect()->route('users.index');

    }

    public function export(Request $request){

        $users = User::all();

        return Excel::download(new UserExport($users), "All Users.xlsx");

    }
}
