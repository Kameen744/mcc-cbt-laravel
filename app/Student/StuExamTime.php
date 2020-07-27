<?php

namespace App\Student;

use App\Student\Student;
use Illuminate\Database\Eloquent\Model;

class StuExamTime extends Model
{
    protected $guarded = [];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
