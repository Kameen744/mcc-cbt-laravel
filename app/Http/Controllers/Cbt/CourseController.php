<?php

namespace App\Http\Controllers\Cbt;


use App\Cbt\Course;
use Illuminate\Http\Request;
use App\CustomClasses\Permited;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }

    public function abort_if_not_permited() 
    {
        abort_unless(Permited::check('Courses'), 403);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTableRes $DataTable, Course $course)
    {
        $this->abort_if_not_permited();
        return $DataTable->get_collections($request, $course);
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
        $this->validate($request, [
            'course' => 'required|min:3'
        ]);

        Course::create(request(['course']));

        return Course::all();
    }

    public function show(Request $request, course $course)
    {
        return $course->sections;
    }

    public function getcourse(course $course)
    {
        return $course;
    }

    public function questions(course $course)
    {
        return $course->questions; 
    }    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, course $course)
    {
        $this->abort_if_not_permited();
        $this->validate($request, ['course' => 'required|min:3']);

        $course->update(request(['course']));
        return Course::all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(course $course)
    {
        $this->abort_if_not_permited();
        $course->delete();
        return Course::all();
    }
}
