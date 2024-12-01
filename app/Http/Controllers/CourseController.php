<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function create(){
        $course=Course::all();

        return response()->json($course);
    }

    public function insert(Request $req)
    {

        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        try {
            $course = new Course();
            $course->name = $req->name;
            $course->description = $req->description;
            $course->save();
    
            return response()->json($course);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong while saving the course!',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    public function edit($id){
        $course=Course::find($id);
        
        return response()->json($course);
    }

    public function Update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        try {
            $course = Course::find($id);
    
            if (!$course) {
                return response()->json(['error' => 'Course not found'], 404);
            }
    
            $course->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
    
            return response()->json(['message' => 'Course updated successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong while updating the course!',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function delete($id){
        $course=Course::find($id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }
     
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
