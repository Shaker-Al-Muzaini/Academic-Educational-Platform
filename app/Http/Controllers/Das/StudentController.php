<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\Grades;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        $students= Student::latest()
            ->paginate(\setting(('pagination_limit')));
        return$students ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated =request()->validate(Student::rules());

        return Student::create([
            'email' => $validated['email'],
            'Gender_id' => $validated['Gender_id'],
            'name' => $validated['name'],
            'password' => $validated['password'],
            'address' => $validated['address'],
            'parent_student_id' => $validated['parent_student_id'],
            'class_room_id' => $validated['class_room_id'],
            'grade_id' => $validated['grade_id'],
            'section_id' => $validated['section_id'],

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student->update([
            'email' => $request['email'],
            'Gender_id' => $request['Gender_id'],
            'name' => $request['name'],
            'password' => $request['password'],
            'address' => $request['address'],
            'parent_student_id' => $request['parent_student_id'],
            'class_room_id' => $request['class_room_id'],
            'grade_id' => $request['grade_id'],
            'section_id' => $request['section_id'],
        ]);
        return $student;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(['success' => true], 200);
    }
}
