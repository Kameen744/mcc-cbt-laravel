<?php

namespace App\Http\Controllers\Cbt;

use App\Cbt\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DepartmentController extends Controller
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
    private function getRec($request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        $query = Department::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }

    public function index(Request $request)
    {
        // return Department::all();
        return $this::getRec($request);
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
        $department->delete();
        return $department;
    }

    public function exam(Department $department)
    {
        return $department->exam;
    }
}
