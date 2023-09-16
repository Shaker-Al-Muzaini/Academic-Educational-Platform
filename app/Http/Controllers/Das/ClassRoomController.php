<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClassRoom;
use App\Models\Grades;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classRooms = ClassRoom::with('grade:id,name')
            ->latest()
            ->paginate(\setting(('pagination_limit')));
        return $classRooms;
    }
    public function index2()
    {
        return ClassRoom::latest()->get();
    }

    public function store(Request $request)
    {
        $validated =request()->validate(ClassRoom::rules(),[
            'grade_id.required' => 'The grade name field is required.',
        ]);

        return ClassRoom::create([
            'name_class' => $validated['name_class'],
            'grade_id' => $validated['grade_id'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $classRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassRoom $classRoom)
    {
        request()->validate([
            'name_class' => 'required',
            'grade_id' => 'required',

        ]);
        $classRoom->update([
            'name_class' => request('name_class'),
            'grade_id' => request('grade_id'),
        ]);
        return $classRoom;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classRoom)
    {
        $classRoom->delete();

        return response()->json(['success' => true], 200);
    }

    public function bulkDelete()
    {
        ClassRoom::whereIn('id', request('ids'))->delete();
        return response()->json(['message' => 'ClassRoom deleted successfully!']);
    }
}
