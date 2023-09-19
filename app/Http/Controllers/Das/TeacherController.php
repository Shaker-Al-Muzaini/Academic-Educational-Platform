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
        return specialization::latest()->get();
    }
    public function index3()
    {
        return gender::latest()->get();
    }
    public function index4()
    {
        return Teacher::latest()->get();
    }


    public function store(Request $request)
    {
        $validated =request()->validate(Teacher::rules());

        return Teacher::create([
            'email' => $validated['email'],
            'Gender_id' => $validated['Gender_id'],
            'specialization_id' => $validated['specialization_id'],
            'name' => $validated['name'],
            'password' => $validated['password'],
            'address' => $validated['address'],
            'joining_Date' => $validated['joining_Date'],
        ]);
    }


    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update([
            'email' => $request['email'],
            'Gender_id' => $request['Gender_id'],
            'specialization_id' => $request['specialization_id'],
            'name' => $request['name'],
            'password' => $request['password'],
            'address' => $request['address'],
            'joining_Date' => $request['joining_Date'],
        ]);
        return $teacher;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json(['success' => true], 200);
    }

    public  function bulkDelete(){
        Teacher::whereIn('id', request('ids'))->delete();
        return response()->json(['message' => 'Teacher deleted successfully!']);

    }
}
