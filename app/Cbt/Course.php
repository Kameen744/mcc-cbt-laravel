<?php

namespace App\Cbt;

use App\Cbt\Exam;
use App\Cbt\Question;
use App\Cbt\CourseSection;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Course extends Model
{
    use LaravelVueDatatableTrait;

    protected $guarded = [];
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'course' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];

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
