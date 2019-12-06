<?php

namespace App\Cbt;

use App\Cbt\Course;
use App\Cbt\Department;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Exam extends Model
{
    use LaravelVueDatatableTrait;

    protected $guarded = [];
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'department' => [
            'searchable' => true,
        ],
        'department_code' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];

    public function department()
    {
        return $this->belongsToMany(Department::class, 'exam_department')->withTimestamps();
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
