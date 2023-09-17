<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Grades;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sections= Grades::with('sections.My_class')
            ->latest()
            ->paginate(\setting(('pagination_limit')));
        return $sections;
    }

    public function store(Request $request)
    {
        $validated =request()->validate(Section::rules(),[
            'grade_id.required' => 'The grade name field is required.',
            'class_room_id.required' => 'The class_room name field is required.',
        ]);

        return Section::create([
            'class_room_id' => $validated['class_room_id'],
            'grade_id' => $validated['grade_id'],
            'name' => $validated['name'],
            'status' => 1,
        ]);
    }


    public function update(Request $request, Section $section)
    {
        request()->validate([
            'name' => 'required',
            'grade_id' => 'required',
            'class_room_id' => 'required',

        ]);
        $section->update([
            'name' => request('name'),
            'grade_id' => request('grade_id'),
            'class_room_id' => request('class_room_id'),
        ]);
        return $section;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
         $section->delete();

        return response()->json(['success' => true], 200);
    }
}
