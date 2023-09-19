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
        return ParentStudent::create([
            'email_mother' => $validated['email_mother'],
            'password_mother' => $validated['password_mother'],
            'password_Father' => $validated['password_Father'],
            'email_Father' => $validated['email_Father'],
            'Name_Father' => $validated['Name_Father'],
            'National_ID_Father' => $validated['National_ID_Father'],
            'Phone_Father' => $validated['Phone_Father'],
            'Job_Father' => $validated['Job_Father'],
            'Nationality_Father_id' => $validated['Nationality_Father_id'],
            'Address_Father' => $validated['Address_Father'],
            'Name_Mother' => $validated['Name_Mother'],
            'National_ID_Mother' => $validated['National_ID_Mother'],
            'Phone_Mother' => $validated['Phone_Mother'],
            'Job_Mother' => $validated['Job_Mother'],
            'Nationality_Mother_id' => $validated['Nationality_Mother_id'],
            'Address_Mother' => $validated['Address_Mother'],
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
