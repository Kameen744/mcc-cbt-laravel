<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Navbar;
use App\NavGroup;
use Illuminate\Http\Request;
use Auth;


class AdminApiController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('authadm:admin');
    // }

    public function adminuser(Admin $admin) {
        // $admin = [
        //     'name' => Auth::guard('admin')->user()->username, 
        //     'id' => Auth::guard('admin')->user()->id,
        //     'createdAt' => Auth::guard('admin')->user()->created_at,
        //     'updatedAt' => Auth::guard('admin')->user()->updated_at,
        // ];

        return $admin;
    }

    public function navbargroup(Navbar $navbar) {
        return NavGroup::all();
    }

    public function adminavbars(Admin $admin)
    {
        // $group = [];
       
        // foreach ($admin->navbar->all() as $nav) {
        //     $group_id = $nav->navgroup_id;
        //     $nav['group_name'] = $nav->navgroup()->find($group_id)->name;
        //     array_push($group, $nav);
        // }

        // return $group;
        return $admin->navbar->all();
    }
}
