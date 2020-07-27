<?php

namespace App\Cbt;

use App\Student\Student;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $guarded = [];

    public function student() 
    {
        return $this->belongsTo(Student::class);
    }
}
