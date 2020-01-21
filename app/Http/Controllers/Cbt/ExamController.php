<?php

namespace App\Http\Controllers\Cbt;

use App\Cbt\Exam;
use App\Cbt\Course;
use App\Cbt\ExamScore;
use App\Cbt\Department;
use App\Cbt\ExamSection;
use App\Student\Student;
use App\Cbt\CourseSection;
use Illuminate\Http\Request;
use App\CustomClasses\Permited;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }

    public function abort_if_not_permited() 
    {
        abort_unless(Permited::check('Create Exam'), 403);
    }

    public function index(Request $request, DataTableRes $DataTable, Exam $exam)
    {
        $this->abort_if_not_permited();
        return $DataTable->get_collections($request, $exam);
    }

    private function validateData($request)
    {
        $data = $this->validate($request, [
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
        $this->abort_if_not_permited();
        $data = $this::validateData($request);

        Exam::create($data);

        // return Department::find($request->department_id)->exam;
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
        $this->abort_if_not_permited();
        $data = $this::validateData($request);
        $exam->update($data);
        return $exam;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $this->abort_if_not_permited();
        $exam->delete();
        return Department::find($exam->department_id)->exam;
    }

    public function course(Exam $exam, Course $course)
    {
        $this->abort_if_not_permited();
        $exam->course()->syncWithoutDetaching($course);
        return $exam->course;
    }

    public function sections(Exam $exam)
    {
        $this->abort_if_not_permited();
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

    public function departments(Exam $exam)
    {
        return $exam->department;
    }

    public function course_section(Request $request, ExamSection $section)
    {
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'exam_id'       => 'required',
            'course_id'     => 'required',
            'section_id'    => 'required',
            'no_questions'  => 'required'
        ]);

        $section->create($data);
        $exam = Exam::findOrFail($data['exam_id']);
        $exam->course()->syncWithoutDetaching($data['course_id']);
        return $this->sections($exam);
    }

    public function exam_department(Exam $exam, Department $department)
    {
        $this->abort_if_not_permited();
        $exam->department()->syncWithoutDetaching($department);
        return $exam->department;
    }

    public function del_exam_section(ExamSection $section)
    {
        $this->abort_if_not_permited();
        $section->delete();
        $exam = Exam::findOrFail($section->exam_id);
        $exam->course()->detach($section->course_id);
        return $this->sections($exam);
    }

    public function del_exam_department(Exam $exam, Department $department) 
    {
        $this->abort_if_not_permited();
        $exam->department()->detach($department);
        return $exam->department;
    }

    public function department_exams(Department $department)
    {
        $this->abort_if_not_permited();
        return $department->exam;
    }

    public function exam_scores(Department $department, Exam $exam)
    {
        abort_unless(Permited::check('Exam Result'), 403);
        $examScores = $exam->load('scores.course');
        // collect and map throught all department students
        $students = collect($department->student)
        ->map(function($student) use($examScores) {
            // collect and map through students socres
            $student->scores = collect($examScores->scores)->where('student_id', $student->id);  
            $student->total = $student->scores->sum('marks');    
            return $student;
        });
       
        return [
            'exam' => $examScores->exam, 
            'exam_date' => $examScores->exam_date, 
            'students' => $students
        ];
    }
        
        // $courses = [];

        // for($i = 0; $i < count($students); ++$i) {
            
        //     for($ii = 0; $ii < count($courses_and_scores->course); ++$ii) {
                
        //         $mark = collect($courses_and_scores->scores)
        //         ->where('student_id', $students[$i]->id)
        //         ->where('course_id', $courses_and_scores->course[$ii]->id)
        //         ->first();

        //         $mark ? $course_marks = $mark->marks : $course_marks = 0;

        //         $courses[$ii] = $courses_and_scores->course[$ii];
        //         $courses[$ii]['marks'] = $course_marks; 
        //         // $courses_and_scores->course[$ii]['marks'] = $course_marks;
                
        //         // $courses[] =  $courses_and_scores->course[$ii];
        //     }

        //     $students[$i]['courses'] = $courses;
            
        

        // }
        // foreach($stu as $key => $student) {
        //     $courses = [];
        //     foreach($exam->course as $course) {
        //         $score = ExamScore::where([
        //             'student_id' => $student->id,
        //             'exam_id' => $exam->id,
        //             'course_id' => $course->id
        //         ])->first();
                
        //         $course['marks'] = $score; 
        //         array_push($courses, $course);
        //     }
        //     $student['courses'] = $courses;
        //     array_push($students, $student);
        //     if($key === 4) {
        //         return $students;
        //     }
        // }
       
        // return $students;

    // }

    // public function exam_scores($department_id, Exam $exam)
    // {
    //     // get all students of the department 
    //     $students = Student::where('department_id', $department_id)->get();
       
    //     // get the courses and attepts of the exam
    //     $coursesAndAttempts = $exam->load('course', 'attempts');
    //      // marked students exam
    //      $markedExam = [
    //         'exam' => $exam->exam, 
    //         'exam_data' => $exam->exam_date,
    //         'students' => []
    //     ];
    //     // loop throught the students 
    //     foreach($students as $key => $student) {
    //         // array to store student courses
    //         $studentCourses = [];
    //         // student total score
    //         $studentTotal = 0;
    //         // loop throught exam courses
    //         foreach($coursesAndAttempts->course as $key => $course) {
    //             // collect course scored attempts 
    //             $scored = collect($coursesAndAttempts->attempts)
    //             ->where('student_id', $student->id)
    //             ->where('course_id', $course->id)
    //             ->where('stu_mark', 1)
    //             ->count();
               
    //             // add scored to the course array
    //             $course['scored'] = $scored;
    //             // push course to student courses
    //             array_push($studentCourses, $course);
    //             // add to the student total score;
    //             $studentTotal += $scored;
    //         }

            
    //         $student['courses'] = $studentCourses;
    //         $student['total'] = $studentTotal;
    //         return $student;
        
    //         // push to marked student exam
    //         array_push($markedExam['students'], $student);
    //     }

    //     return $markedExam;
    // }
}
