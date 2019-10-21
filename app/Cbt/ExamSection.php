<?php

namespace App\Cbt;

use App\Cbt\Exam;
use Illuminate\Database\Eloquent\Model;

class ExamSection extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->hasMany(Exam::class);
    }
}
