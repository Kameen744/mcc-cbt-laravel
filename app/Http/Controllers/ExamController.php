<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Course;
use App\Department;
use App\ExamSection;
use App\CourseSection;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }

    public function index()
    {
        return Exam::all();
    }

    private function validateData($request)
    {
        $data = $this->validate($request, [
            'department_id' => 'required',
            'exam' => 'required',
            'exam_date' => 'required|date',
            'exam_time' => 'required',
            'exam_hours' => 'required|numeric|max:5',
            'exam_minutes' => 'required|numeric|max:55'
        ]);

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this::validateData($request);

        Exam::create($data);

        return Department::find($request->department_id)->exam;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $data = $this::validateData($request);
        $exam->update($data);
        return Department::find($exam->department_id)->exam;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return Department::find($exam->department_id)->exam;
    }

    public function course(Exam $exam, Course $course)
    {
        $exam->course()->syncWithoutDetaching($course);
        return $exam->course;
    }

    public function sections(Exam $exam)
    {
        $sections = $exam->section;
        $resArray = [];
        $totalQuestions = $sections->sum('no_questions');
        if($sections){
            foreach ($sections as $val) {
                $crs = Course::findOrFail($val['course_id']);
                $sec = CourseSection::findOrFail($val['section_id']);
                
                array_push($resArray, [
                    'id' => $val['id'],
                    'course' => $crs['course'],
                    'section' => $sec['section'],
                    'no_questions' => $val['no_questions'],
                    'ttquestions' => $totalQuestions,
                ]);
            }
        }
        return $resArray;
    }

    public function coursesection(Request $request, ExamSection $section)
    {
        $data = $this->validate($request, [
            'exam_id' => 'required',
            'course_id' => 'required',
            'section_id' => 'required',
            'no_questions' => 'required'
        ]);

        $section->create($data);
        $exam = Exam::findOrFail($data['exam_id']);
        return $this->sections($exam);
    }

    public function deletesection(ExamSection $section)
    {
        $section->delete();
        $exam = Exam::findOrFail($section->exam_id);
        return $this->sections($exam);

    }
}
