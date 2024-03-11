<?php

namespace App\Http\Controllers\Das;
use App\Http\Controllers\Controller;
use App\Models\Explanation;
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
    public function update(Request $request,Explanation $explanation)
    {
//        DB::beginTransaction();
//        try {
            $validatedData = $request->validate(Explanation::rules());
            dd($validatedData);
            $cleanedData = collect($validatedData)->map(function ($value, $key) {
                return is_string($value) ? trim(strip_tags($value)):$value;
            })->toArray();

            $explanation->update($cleanedData);
//            $request->validate(Explanation::rules());
//        $explanation->update([
//            'name' => $request['name'],
//            'notes' => $request['notes'],
//            'grade_id' => $request['grade_id'],
//            'class_room_id' => $request['class_room_id'],
//            'teacher_id' => $request['teacher_id'],
//
//        ]);
        return $explanation;
//            DB::commit();
//            return $explanation;
//        } catch (\Exception $e) {
//            DB::rollback();
//            return response()->json(['message' => 'حدث خطأ أثناء تحديث '], 500);
//        }
    }

    public function destroy(Explanation $explanation)
    {
        $explanation->delete();

        return response()->json(['success' => true], 200);
    }


}
