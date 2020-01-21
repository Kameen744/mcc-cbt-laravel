<?php

namespace App\CustomClasses;

class Permited {
    public static function check($navbar) 
    {
        if(auth()->user()->navbar()->where('name', $navbar)->first()) {
            return true;
        } else {
            return false;
        }
    }
}
