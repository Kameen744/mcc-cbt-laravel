<?php

namespace App;

use App\Exam;
use Illuminate\Database\Eloquent\Model;

class ExamSection extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->hasMany(Exam::class);
    }
}
