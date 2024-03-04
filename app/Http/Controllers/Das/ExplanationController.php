<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Explanation;

class ExplanationController extends Controller
{
    public function index()
    {
        return Explanation::latest()->get('name');

    }
}
