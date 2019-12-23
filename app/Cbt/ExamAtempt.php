<?php

namespace App\Cbt;

use App\Cbt\Exam;
use App\Cbt\Course;
use App\Student\Student;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class ExamAtempt extends Model
{
    use InsertOnDuplicateKey;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam() 
    {
        return $this->belongsTo(Exam::class);
    }

    public function course() 
    {
        return $this->belongsTo(Course::class);
    }

    public function section() 
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    public function quetion()
    {
        return $this->belongsTo(Question::class);
    }
}
