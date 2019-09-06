<?php

namespace App\Http\Controllers;

use App\department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Department::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'department' => 'required',
            'department_code' => 'required',
        ]);

        Department::create(request(['department', 'department_code']));

        return Department::all();
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, department $department)
    {
        $this->validate($request, [
            'department' => 'required',
            'department_code' => 'required',
        ]);

        $department->update(request(['department', 'department_code']));
        return Department::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(department $department)
    {
        $department->delete();
        return Department::all();
    }

    public function exam(department $department)
    {
        return $department->exam;
    }
}
