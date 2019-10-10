<?php

namespace App\Http\Controllers;

use Auth;
use App\Admin;
use App\Navbar;
use App\NavGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $data = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $data['password'] =  Hash::make($request->password);

        Admin::create($data);
        return $this->get_admins();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
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
        $data = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $data['password'] =  Hash::make($request->password);
        
        $admin->update($data);
        return $this->get_admins();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        $admin->delete();
        return $this->get_admins();
    }

    public function get_admins()
    {
        return Admin::all();
    }

    public function navbargroup(Navbar $navbar) {
        return NavGroup::all();
    }

    public function navbars()
    {
        return Admin::find($this::admin('id'))->navbar->all();
    }

    public function permited_navbars(Admin $admin)
    {
        return $admin->navbar->all();
    }

    public function add_permission(Request $request, Admin $admin) 
    {
        $data = $this->validate($request, [
            'admin_id' => 'required',
            'navbar_id' => 'required'
        ]);

        $admin->navbar()->syncWithoutDetaching($data['navbar_id']);
        return $admin->navbar->all();
    }

    public function delete_permission (Request $request, Admin $admin)
    {
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
