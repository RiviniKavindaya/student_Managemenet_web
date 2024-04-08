<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return Inertia::render('Students/Index',[
            'students'=>Student::all()->map(function($student){
                return[
                    'id'=>$student->id,
                    'name'=>$student->name,
                    'age'=>$student->age,
                    'status'=>$student->status,
                    'image'=>asset('images/'.$student->image)
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Students/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'age' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $student = new Student([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'status' => $request->input('status'),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $student->image = $imageName;
        }

        $student->save();

        return Redirect::route('students.index')->with('success', 'Student created successfully.');
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
        return Inertia::render('Students/Edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $student->update([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'status' => $request->input('status'),
        ]);

        return Redirect::route('students.index')->with('success', 'Student updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Storage::delete('images/'.$student->image);
        $student->delete();
        return Redirect::route('students.index')->with('success', 'Student deleted successfully.');
    }
}
