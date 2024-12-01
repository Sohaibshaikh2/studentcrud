<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{


    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
        ]);

      
        try {
           
            $student = new Student();
            $student->name = $validated['name'];
            $student->email = $validated['email'];
            $student->save();

           
            return response()->json(['message' => 'Student added successfully!'], 201);
        } catch (\Exception $e) {
          
            return response()->json(['error' => 'An error occurred while saving the student.'], 500);
        }
    }

    public function create()
    {
      
        $students = DB::table('students')
            ->leftJoin('course_student', 'students.id', '=', 'course_student.student_id')
            ->leftJoin('courses', 'course_student.course_id', '=', 'courses.id')
            ->select(
                'students.id as student_id',
                'students.name as student_name',
                'students.email as student_email',
                DB::raw('GROUP_CONCAT(courses.name) as course_names') 
            )
            ->groupBy('students.id', 'students.name', 'students.email') 
            ->get();

        return response()->json($students);
    }

    public function insert(Request $req)
    {
        $student = new Student();

        $student->name = $req->name;
        $student->email = $req->email;
        $student->save();
        return response()->json($student);
    }

    public function edit($id)
    {
        $student = Student::with('courses')->find($id);
    
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
    
        $assignedCourses = DB::table('course_student')
            ->join('courses', 'course_student.course_id', '=', 'courses.id')
            ->where('course_student.student_id', $id)
            ->select('courses.id', 'courses.name')
            ->get();
    
        return response()->json([
            'student' => $student,
            'courses' => $assignedCourses, // Assigned courses
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'courses' => 'array',
            'courses.*' => 'exists:courses,id',
        ]);
    
        $student = Student::find($id);
    
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
    
   
        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->save();
    
      
        $student->courses()->sync($validated['courses'] ?? []);
    
        return response()->json(['success' => 'Student updated successfully.']);
    }
    

    public function destroy($studentId)
    {
        DB::beginTransaction(); 
    
        try {
           
            DB::table('course_student')->where('student_id', $studentId)->delete();
    
            DB::table('students')->where('id', $studentId)->delete();
    
            DB::commit();
            return response()->json(['message' => 'Student and associated courses deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete student or associated courses.'], 500);
        }
    }
    


    public function enroll(Request $request)
    {
      
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|array|max:5',
            'course_id.*' => 'exists:courses,id',
        ]);
    
        $student = Student::find($request->student_id);
    
       
        if ($student->courses()->count() >= 5) {
            return response()->json(['error' => 'Student cannot enroll in more than 5 courses.'], 400);
        }
    
   
        foreach ($request->course_id as $course_id) {
            if ($student->courses()->where('course_id', $course_id)->exists()) {
                return response()->json(['error' => 'Student is already enrolled in course ID ' . $course_id], 400);
            }
        }
   
        foreach ($request->course_id as $course_id) {
            $student->courses()->attach($course_id);
        }
    
        return response()->json(['success' => 'Student enrolled successfully!']);
    }



 
}
