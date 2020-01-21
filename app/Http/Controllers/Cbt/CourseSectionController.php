<?php

namespace App\Http\Controllers\Cbt;

use App\Cbt\Course;
use App\Cbt\CourseSection;
use Illuminate\Http\Request;
use App\CustomClasses\Permited;
use App\Http\Controllers\Controller;

class CourseSectionController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }

    public function abort_if_not_permited() 
    {
        abort_unless(Permited::check('Section Questions'), 403);
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
            'course_id' => 'required',
            'section' => 'required',
            'question' => 'required'
        ]);

        CourseSection::create($data);

        return Course::find($data['course_id'])->sections;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseSection  $courseSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseSection $section)
    {
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'course_id' => 'required',
            'section' => 'required',
            'question' => 'required'
        ]);

        $section->update($data);
        return Course::find($data['course_id'])->sections;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseSection  $courseSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseSection $section)
    {
        $this->abort_if_not_permited();
        $section->delete();

        return Course::find($section->course_id)->sections;
    }

    public function questions(CourseSection $section)
    {
        $this->abort_if_not_permited();
        return $section->questions;
    }
}
