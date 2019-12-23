<?php

namespace App\Cbt;

use App\Cbt\Exam;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class ExamSection extends Model
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

    public function exam()
    {
        return $this->belongsToMany(Exam::class);
    }
}
