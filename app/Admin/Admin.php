<?php

namespace App\Admin;

use App\Cbt\Navbar;
use App\Cbt\NavGroup;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Admin extends Authenticatable
{
    use Notifiable;
    use LaravelVueDatatableTrait;
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'username' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = [
        'username', 'password',
    ];

    public function navbar()
    {
        return $this->belongsToMany(Navbar::class)->withTimestamps();
    //    return $this->belongsToMany(Navbar::class)::performJoin(Navbar::find(1)->id);
    // return $this->belongsToMany(Navbar::class);
    }

    // public function navgroup()
    // {
    //     return $this->navbar()->hasOne(NavGroup::class);
    //     // return $this->navbar()->navgroup();
    // }
}
