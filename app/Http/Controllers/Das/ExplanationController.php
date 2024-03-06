<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Explanation;
use App\Models\Grades;
use Illuminate\Support\Facades\DB;

class ExplanationController extends Controller
{
    public function index()
    {

        $explanation = Explanation::latest()
            ->paginate(\setting(('pagination_limit')));
        return $explanation;

    }

    public  function store()
    {
        DB::beginTransaction();
        try {
            $validated = request()->validate(Explanation::rules());

            return Explanation::create([
                'notes' => $validated['notes'],
            ]);

            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'حدث خطأ أثناء إنشاء '], 500);
        }
    }



}
