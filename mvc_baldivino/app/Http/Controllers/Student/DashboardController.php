<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user's email
        $userEmail = Auth::user()->email;
        
        // Find the student record
        $student = Student::where('email', $userEmail)->first();
        
        if ($student) {
            // Get all enrollments for this student with their subjects
            $enrollments = Enrollment::with('subject')
                ->where('student_id', $student->id)
                ->get();
        } else {
            $enrollments = collect();
        }

        return view('student.dashboard', compact('enrollments'));
    }
} 