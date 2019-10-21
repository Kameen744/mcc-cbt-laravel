<?php

namespace App\Library;

use App\Cbt\Department;
use App\Library\LibResourceType;
use Illuminate\Database\Eloquent\Model;

class LibResource extends Model
{
    public function res_type()
    {
        return $this->belongsTo(LibResourceType::class, 'type_id');
    }

    public function res_department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
