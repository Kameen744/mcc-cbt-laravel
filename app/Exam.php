<?php

namespace App;

use App\Course;
use App\Department;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function course()
    {
        return $this->belongsToMany(Course::class, 'exams_courses')->withTimestamps();
    }

    public function section()
    {
        return $this->hasMany(ExamSection::class)->orderBy('course_id');
    }
}
