<?php

namespace App\Http\Controllers\Cbt;


use App\Cbt\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
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
        return Course::all();
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
        $course->delete();
        return Course::all();
    }
}
