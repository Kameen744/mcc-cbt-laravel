<?php

namespace App;

use App\Course;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];
    
    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public function exam()
    {
        return $this->hasMany(Exam::class, 'department_id');
    }
}
