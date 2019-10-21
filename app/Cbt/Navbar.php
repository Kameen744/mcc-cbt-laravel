<?php

namespace App\Cbt;

use App\Cbt\Admin;
use App\Cbt\NavGroup;
use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsToMany(Admin::class)->withTimestamps();
    }

    public function navgroup()
    {
        return $this->belongsTo(NavGroup::class);
    }

    public function create_default()
    {
        
    }
}
