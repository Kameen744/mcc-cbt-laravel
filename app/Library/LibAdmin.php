<?php

namespace App\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LibAdmin extends Model
{
    protected $fillable = [
        'username', 'password',
    ];
}
