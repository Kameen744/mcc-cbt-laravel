<?php

namespace App\Library;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class LibAdmin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'password',
    ];
}
