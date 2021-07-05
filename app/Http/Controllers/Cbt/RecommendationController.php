<?php

namespace App\Http\Controllers\Cbt;

use App\Cbt\Recommendation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecommendationController extends Controller
{
    public function __construct()
    {
        $this->middleware('authadm:admin');
    }

    public function options()
    {
        return Recommendation::all()->get();
    }
}
