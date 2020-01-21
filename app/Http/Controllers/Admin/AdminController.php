<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Admin\Admin;
use App\Cbt\Navbar;
use App\Cbt\NavGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\CustomClasses\DataTableRes;

class AdminController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('admins.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Admin::class);
        $data = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $data['password'] =  Hash::make($request->password);

        Admin::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        $this->authorize('view', $admin);
        return $admin;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin $admin)
    {
        $this->authorize('update', $admin);
        $data = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if($data['password'] === $admin->password) {
            $admin->update(['username' => $data['username']]);
        } else {
            $data['password'] =  Hash::make($request->password);
            $admin->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        $this->authorize('delete', $admin);
        $admin->delete();
        $admin->navbar()->Detach();
    }

    public function get_admins(Request $request, DataTableRes $DataTable, Admin $admin)
    {
        $this->authorize('view', $admin);
        return $DataTable->get_collections($request, $admin);
    }

    public function navbargroup(Navbar $navbar) {
        return NavGroup::all();
    }

    public function navbars()
    {
        return Admin::find($this::admin('id'))->navbar->all();
        // return Admin::find($this::admin('id'))->with('navbar')->get();
    }

    public function permited_navbars(Admin $admin)
    {
        return $admin->navbar->all();
    }

    public function add_permission(Request $request, Admin $admin) 
    {
        $this->authorize('delete', $admin);
        $data = $this->validate($request, [
            'admin_id' => 'required',
            'navbar_id' => 'required'
        ]);

        $admin->navbar()->syncWithoutDetaching($data['navbar_id']);
        return $admin->navbar->all();
    }

    public function delete_permission (Request $request, Admin $admin)
    {
        $this->authorize('delete', $admin);
        $data = $this->validate($request, [
            'admin_id' => 'required',
            'navbar_id' => 'required'
        ]);
        $admin->navbar()->Detach($data['navbar_id']);
        return $admin->navbar->all();
    }

    private function admin($name)
    {
        return Auth::guard('admin')->user()->$name;
    }
}
