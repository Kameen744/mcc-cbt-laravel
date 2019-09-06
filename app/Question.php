<?php

namespace App;

use App\Course;
use App\CourseSection;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $guarded = [];
    
    public function course() 
    {
        return $this->belongsTo(Course::class)->with(CourseSection::class);
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class);
    }

}
