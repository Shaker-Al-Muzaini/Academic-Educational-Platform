<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Grades;
use App\Models\User;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grades::latest()
            ->paginate(\setting(('pagination_limit')));
        return $grades;
    }

    public function index2()
    {
        return Grades::latest()->get();
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
        $validated =request()->validate(Grades::rules());


        return Grades::create([
            'name' => $validated['name'],
            'notes' => $validated['notes'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grades $grades)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grades $grades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Grades $grade)
    {
        request()->validate([
            'name' => 'required',
            'notes' => 'required',

        ]);

        $grade->update([
            'name' => request('name'),
            'notes' => request('notes'),
        ]);
        return $grade;
    }


    public function destroy(Grades $grade)
    {
        $grade->delete();

        return response()->json(['success' => true], 200);
    }
}
