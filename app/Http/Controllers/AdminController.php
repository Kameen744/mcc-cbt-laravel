<?php

namespace App\Http\Controllers;

use Auth;
use App\admin;
use App\Navbar;
use App\NavGroup;
use Illuminate\Http\Request;

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
        // $aut = authadm::admin()
        // $admin = [
        //     'name' => Auth::guard('admin')->user()->username, 
        //     'id' => Auth::guard('admin')->user()->id,
        //     'createdAt' => Auth::guard('admin')->user()->created_at,
        //     'updatedAt' => Auth::guard('admin')->user()->updated_at,
        // ];
        
        return view('admins.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(admin $admin)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }

//  return json data for vue js

    public function navbargroup(Navbar $navbar) {
        return NavGroup::all();
    }

    public function navbars()
    {
        return Admin::find($this::admin('id'))->navbar->all();
    }

    private function admin($name)
    {
        return Auth::guard('admin')->user()->$name;
    }
}
