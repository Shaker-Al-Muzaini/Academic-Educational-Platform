<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Explanation;
use App\Models\Grades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExplanationController extends Controller
{
    public function index()
    {

        $explanation = Explanation::latest()
            ->paginate(\setting(('pagination_limit')));
        return $explanation;

    }

    public  function store(Request $request)
    {
        DB::beginTransaction();
        try {

        $explanations=  Explanation::create([
                'notes' => $request['notes'],
                'name' => $request['name'],
                'teacher_id' => $request['teacher_id'],
                'grade_id' => $request['grade_id'],
                'class_room_id' => $request['class_room_id'],
            ]);
            DB::commit();
            return  $explanations;


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'حدث خطأ أثناء إنشاء '], 500);
        }
    }
    public function update(Request $request, Explanation $explanations)
    {
        DB::beginTransaction();
        try {
            request()->validate([
                'name' => 'required',
                'grade_id' => 'required',
                'class_room_id' => 'required',
                'teacher_id' => 'required',
                'notes' => 'string',

            ]);
            $explanations->update([
                'name' => request('name'),
                'class_room_id' => request('class_room_id'),
                'teacher_id' => request('teacher_id'),
                'grade_id' => request('grade_id'),
                'notes' => request('notes'),
            ]);


            DB::commit();
            return $explanations;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'حدث خطأ أثناء تحديث الطالب'], 500);
        }
    }

    public function destroy(Explanation $explanation)
    {
        $explanation->delete();

        return response()->json(['success' => true], 200);
    }


}
