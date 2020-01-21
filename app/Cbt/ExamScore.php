<?php

namespace App\Cbt;

use App\Cbt\Exam;
use App\Cbt\Course;
use App\Student\Student;
use Illuminate\Database\Eloquent\Model;

class ExamScore extends Model
{
    protected $guarded = [];
    
    public function students() 
    {
        return $this->hasMany(Student::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function course() 
    {
        return $this->belongsTo(Course::class);
    }

}
