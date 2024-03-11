<?php

namespace App\Http\Controllers\Das;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function setting;

class StudentController extends Controller
{

    public function index()
    {
        return Student::latest()
            ->paginate(setting(('pagination_limit')));

    }




    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate(Student::rules());
            $cleanedData = collect($validatedData)->map(function ($value, $key) {
                return is_string($value) ? trim(strip_tags($value)) : $value;
            })->toArray();
            $student = Student::create($cleanedData);
            if ($request->hasFile('photos')) {
                $studentDirectory = "attachments/students/{$student->name}";
                if (!Storage::exists($studentDirectory)) {
                    Storage::makeDirectory($studentDirectory);
                }

                foreach ($request->file('photos') as $photo) {
                    $fileName = time() . '_' . $photo->getClientOriginalName();
                    $photo->storeAs($studentDirectory, $fileName, 'upload_attachments');

                     Image::create([
                        'filename' => $fileName,
                        'imageable_id' => $student->id,
                        'imageable_type' => Student::class,
                    ]);
                }
            }
            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'حدث خطأ أثناء إنشاء الطالب'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function show($id)
    {
       return $id;

    }


    public function update(Request $request, Student $student)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate(Student::rules());
            $cleanedData = collect($validatedData)->map(function ($value, $key) {
                return is_string($value) ? trim(strip_tags($value)) : $value;
            })->toArray();

            $student->update($cleanedData);

            // معالجة الصور مماثلة لعملية الإنشاء
            if ($request->hasFile('photos')) {
                $studentDirectory = "attachments/students/{$student->name}";
                if (!Storage::exists($studentDirectory)) {
                    Storage::makeDirectory($studentDirectory);
                }

                foreach ($request->file('photos') as $photo) {
                    $fileName = time() . '_' . $photo->getClientOriginalName();
                    $photo->storeAs($studentDirectory, $fileName, 'upload_attachments');

                    Image::create([
                        'filename' => $fileName,
                        'imageable_id' => $student->id,
                        'imageable_type' => Student::class,
                    ]);
                }
            }

            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'حدث خطأ أثناء تحديث الطالب'], 500);
        }
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(['success' => true], 200);
    }
}
