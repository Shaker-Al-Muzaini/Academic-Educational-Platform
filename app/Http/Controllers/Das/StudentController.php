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

                   $s= Image::create([
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




    public function uploadImages(Request $request): JsonResponse
    {
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            $previousPaths = [];

            foreach ($files as $file) {
                // قم بالحصول على معلومات الطالب المرتبطة بالصورة من خلال اسم الملف
                $studentName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $student = Student::where('name', $studentName)->first();

                if ($student) {
                    $studentDirectory = "attachments/students/{$student->name}";
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs($studentDirectory, $fileName, 'upload_attachments');
                    $path = $file->store('uploads', [
                        'disk' => 'public',
                    ]);
                    $previousPaths[] = $path; // حفظ الأماكن السابقة لحذفها لاحقًا

                    Image::create([
                        'filename' => $fileName,
                        'imageable_id' => $student->id,
                        'imageable_type' => Student::class,
                    ]);
                }
            }

            // حذف الصور السابقة
            foreach ($previousPaths as $previousPath) {
                if ($previousPath) {
                    $previousPath = parse_url($previousPath, PHP_URL_PATH);
                    $previousPath = ltrim($previousPath, '/');
                    Storage::disk('public')->delete($previousPath);
                }
            }
        }

        return response()->json(['message' => 'Profile pictures uploaded successfully!']);
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
        $validatedData = $request->validate(Student::rules());
        $cleanedData = collect($validatedData)->map(function ($value, $key) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        })->toArray();

        $student->update($cleanedData);

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
