<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Cbt\Question;
use App\Cbt\ExamScore;
use App\Cbt\ExamAtempt;
use Illuminate\Support\Facades\DB;
use App\Events\studentAttemptsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class updateOrCreateAttemptListener
{
    public function updateExamScore($attempt)
    {

        $marks = ExamAtempt::where([
            'student_id' => $attempt['student_id'],
            'exam_id'   => $attempt['exam_id'],
            'course_id' => $attempt['course_id'],
            'stu_mark' => 1
        ])->sum('stu_mark');

        $examScore = ExamScore::where([
            'student_id' => $attempt['student_id'],
            'exam_id'   => $attempt['exam_id'],
            'course_id' => $attempt['course_id'],
        ]);

        if(count($examScore->get()) > 0) {
            $examScore->update([
                'student_id' => $attempt['student_id'],
                'exam_id'   => $attempt['exam_id'],
                'course_id' => $attempt['course_id'],
                'marks' => $marks
            ]);
        } else {
            ExamScore::create([
                'student_id' => $attempt['student_id'],
                'exam_id'   => $attempt['exam_id'],
                'course_id' => $attempt['course_id'],
                'marks' => $marks
            ]);
        }
    }
    
    public function alreadyAttempted($attempt) {
        $findMatch = ExamAtempt::where([
            'student_id' => $attempt['student_id'],
            'exam_id'   => $attempt['exam_id'],
            'course_id' => $attempt['course_id'],
            'question_id' => $attempt['question_id']
        ]);
        
        if(count($findMatch->get()) > 0) {
            $attempt['updated_at'] = Carbon::now();
            $findMatch->update($attempt);
            return true;
        } else {
            return false;
        }
    }

    public function markAttempt($question_id, $stu_attempt) {
        if(Question::find($question_id)->answer === $stu_attempt) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Handle the event.
     *
     * @param  studentAttemptsEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $data = [];
        
        foreach($event->attempts as $attempt) {

            $attempt['stu_mark'] = $this->markAttempt($attempt['question_id'], $attempt['stu_attempt']);
        
            // if question attempted update it else create new attempt
            if($this->alreadyAttempted($attempt) === false) {
                $attempt['created_at'] = Carbon::now();
                $attempt['updated_at'] = Carbon::now();
                array_push($data, $attempt);
            }

           $this->updateExamScore($attempt);
        }

        DB::table('exam_atempts')->insert($data);
    }
}
