<?php

namespace App\Http\Controllers\Cbt;

use App\Cbt\Navbar;
use App\Admin\Admin;
use App\Cbt\Department;
use Illuminate\Http\Request;
use App\CustomClasses\Permited;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }
    public function abort_if_not_permited() 
    {
        abort_unless(Permited::check('Departments'), 403);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, DataTableRes $DataTable, Department $Dept)
    {
        $this->abort_if_not_permited();
        return $DataTable->get_collections($request, $Dept);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'department' => 'required',
            'department_code' => 'required',
        ]);

        return Department::create($data);
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'department' => 'required',
            'department_code' => 'required',
        ]);

        $department->update($data);
        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $this->abort_if_not_permited();
        $department->delete();
        return $department;
    }

    public function exam(Department $department)
    {
        return $department->exam;
    }
}
