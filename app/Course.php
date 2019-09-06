<?php

namespace App;

use App\Exam;
use App\Question;
use App\CourseSection;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }   

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function exam()
    {
        return $this->belongsToMany(Exam::class, 'exams_courses')->withTimestamps();
    }
}
