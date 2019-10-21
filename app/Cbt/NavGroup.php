<?php

namespace App\Cbt;

use App\Cbt\Navbar;
use Illuminate\Database\Eloquent\Model;

class NavGroup extends Model
{
    protected $guarded = [];


    public function navbar()
    {
        return $this->hasMany(Navbar::class);
    }
}
