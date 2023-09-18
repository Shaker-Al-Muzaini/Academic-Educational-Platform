<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\Grades;
use App\Models\ParentStudent;
use Illuminate\Http\Request;

class ParentStudentController extends Controller
{

    public function index()
    {
        //
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
        // validate
        $validated =request()->validate(ParentStudent::rules());


        return Grades::create([
            'name' => $validated['name'],
            'notes' => $validated['notes'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentStudent $parentStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentStudent $parentStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentStudent $parentStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentStudent $parentStudent)
    {
        //
    }
}
