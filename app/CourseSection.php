<?php

namespace App;

use App\Course;
use App\Question;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'section_id');
    }
}
