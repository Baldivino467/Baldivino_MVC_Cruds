<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        // Get the authenticated user's email
        $userEmail = Auth::user()->email;
        
        // Find the student record
        $student = Student::where('email', $userEmail)->first();
        
        if ($student) {
            // Get enrollments with subject relationship eager loaded
            $enrolledCourses = Enrollment::with(['subject', 'student'])
                ->where('student_id', $student->id)
                ->get();

            // For debugging
            \Log::info('Enrolled Courses:', ['count' => $enrolledCourses->count()]);
            \Log::info('First Course Subject:', ['subject' => $enrolledCourses->first()->subject ?? 'No subject']);
        } else {
            $enrolledCourses = collect();
        }

        return view('student.dashboard', compact('enrolledCourses', 'student'));
    }
} 