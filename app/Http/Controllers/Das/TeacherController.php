<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\gender;
use App\Models\specialization;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('genders:id,Name','specializations:id,Name')
            ->latest()
            ->paginate(\setting(('pagination_limit')));
        return $teachers;
    }
    public function index2()
    {
        return gender::latest()->get();
    }
    public function index3()
    {
        return specialization::latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
