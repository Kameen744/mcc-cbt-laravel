<?php

namespace App\Library;

use App\Cbt\Department;
use App\Library\LibResourceType;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class LibResource extends Model
{
    use LaravelVueDatatableTrait;

    protected $guarded = [];
    protected $with = ['res_type', 'res_department'];
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'res_title' => [
            'searchable' => true,
        ],
        'res_subject' => [
            'searchable' => true,
        ],
        'res_author' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];

    public function res_type()
    {
        return $this->belongsTo(LibResourceType::class, 'res_type_id');
    }

    public function res_department()
    {
        return $this->belongsTo(Department::class, 'res_department_id');
    }
}
