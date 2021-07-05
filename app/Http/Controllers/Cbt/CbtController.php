<?php

namespace App\Http\Controllers\Cbt;

use App\Cbt\Exam;
use App\Cbt\Course;
use App\Cbt\Question;
use App\Cbt\ExamScore;
use App\Cbt\Department;
use App\Cbt\ExamAtempt;
use App\Student\Student;
use App\Student\StuExamTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\studentAttemptsEvent;
use App\Http\Controllers\Controller;

class CbtController extends Controller
{
    public function __construct()
    {
        $this->middleware('authcbt:cbt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cbt.dashboard');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_exams(Department $department)
    {
        $carbonDate = Carbon::now();
        $date = $carbonDate->toDateString();
        $time = $carbonDate->toTimeString();
        $hour = substr($time, 0,2);

        $hourOne = $hour -1 .'%';
        $hourTwo = $hour -2 .'%';
        $hourThree = $hour -3 .'%';

        $exam = $department->exam()
        ->where('exam_date', $date)
        ->where('started', 1)
        // ->orWhere('exam_time', 'like', $hourOne)
        // ->orWhere('exam_time', 'like', $hourTwo)
        // ->orWhere('exam_time', 'like', $hourThree)
        ->with('course', 'section')
        ->first();

        // $exam->push(now());
        return $exam;
        // return $exam->load('course');
    }

    private static function cal_finish_time($time, $hours, $minutes) {
        $finishTime = Carbon::parse($time);
        $finishTime->addHours($hours);
        $finishTime->addMinutes($minutes);
        return $finishTime;
    }

    public function get_exam_start_time($student_id, Exam $exam, $status) {

        $finishTime = $this::cal_finish_time(now(), $exam->exam_hours, $exam->exam_minutes);

        if($status === 'start') {
            $examStartTime = StuExamTime::where('student_id', $student_id)
            ->where('exam_id', $exam->id)->first();
            if($examStartTime) {
                $finishTime = $this::cal_finish_time($examStartTime->start_time, $exam->exam_hours, $exam->exam_minutes);

                if($examStartTime->elapse_time) {
                    return [
                        'startTime' => $examStartTime->elapse_time,
                        'finishTime' => $finishTime
                    ];
                } else {
                    return [
                        'startTime' => $examStartTime->start_time,
                        'finishTime' => $finishTime
                    ];
                }
            } else {
                $examTime = StuExamTime::create([
                    'student_id'    =>  $student_id,
                    'exam_id'       =>  $exam->id,
                    'start_time'    =>  now(),
                    'finish_time'   =>  $finishTime,
                ]);
                return [
                    'startTime' => $examTime->start_time,
                    'finishTime' => $examTime->finish_time,
                ];
            }
        } else {
            return [
                'startTime' => now(),
                'finishTime' => $finishTime,
            ];
        }
    }

    public function set_elapse_time($student_id, $exam_id, $time)
    {
        $examStartTime = StuExamTime::where('student_id', $student_id)
        ->where('exam_id', $exam_id)->first();
        $examStartTime->update(['elapse_time' => Carbon::createFromTimestampMs($time)]);
    }

    public function set_exam_finish_time($student_id, $exam_id)
    {
        $examFinishTime = StuExamTime::where('student_id', $student_id)
        ->where('exam_id', $exam_id)->first();
        $examFinishTime->update(['finish_time' => now()]);
    }

    public function get_course_questions(Student $student, Exam $exam, Course $course)
    {
        // empty array to store random questions
        $randomise_questions = [];
        // get all course sections and questions
        $data = $course->load('sections', 'questions');
        // collect sections of the current course
        $exam_sections = collect($exam->section)->where('course_id', $course->id);
        // check if student has attempted questions before on this exam
        $stu_attempt = $student->attempts()->where([
            'exam_id' => $exam->id,
            'course_id' => $course->id
        ])->get();

            // loop through current exam sections
            foreach($exam_sections as $exam_section) {
                // pick current exam section questions only
                $section_questions = collect($data->questions)->where('section_id', $exam_section->section_id);
                // get already attempted questions first
                $stu_attempted = collect($stu_attempt)->where('section_id', $exam_section->section_id);
                    // if there's attempted questions
                    if(count($stu_attempted) > 0 ) {
                        $from_stu_attempted = [];
                        foreach($stu_attempted as $attempt) {
                            // $match = $section_questions->where('id', $q_attempt->question_id);
                            foreach($section_questions as $key => $question) {
                                if($question->id === $attempt->question_id) {
                                    array_push($from_stu_attempted, $question);
                                    unset($section_questions[$key]);
                                }
                            }
                        //
                        }
                        // return $from_stu_attempted;
                        // $col_stu_att = collect($from_stu_attempted)->collapse();

                        $remain = $exam_section->no_questions - count($from_stu_attempted);

                        // if attemped questios are less than number of required section questions
                        if($remain > 0) {

                            $random = collect([
                                $from_stu_attempted,
                                $section_questions->random($remain)
                            ])->collapse();

                        } else {
                            $random = $from_stu_attempted;
                        }
                    } else {
                        $random = $section_questions->random($exam_section->no_questions);
                    }

                // push it to the $randomise_questions variable
                array_push($randomise_questions, $random);
            }

        // return course sections and exam randomised questions
        return [
            'sections' => $data->sections,
            'questions' => collect($randomise_questions)->collapse()
        ];

    }

    public function get_attempted(Request $request)
    {
        // return $request->input('courses');
        $attempted = [];
        foreach($request->courses as $course) {
            $attempts = ExamAtempt::where([
                'student_id' => $request->student,
                'exam_id' => $request->exam_id,
                'course_id' => $course['id'],
            ])->get(['question_id', 'stu_attempt']);
            array_push($attempted, $attempts);
        }

        return collect($attempted)->collapse();
    }

    public function attempt(Request $request)
    {
        event(new studentAttemptsEvent($request->input('attempts')));
    }
}
