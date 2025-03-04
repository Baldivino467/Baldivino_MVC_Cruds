<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Find the student record for this user
        $student = Student::where('email', $user->email)->first();
        
        if (!$student) {
            return view('student.dashboard', [
                'enrolledCourses' => collect(),
                'upcomingAssignments' => collect(),
                'error' => 'Student record not found'
            ]);
        }

        // Get enrolled courses through enrollments using student ID
        $enrolledCourses = Enrollment::where('student_id', $student->id)
                            ->with('subject')
                            ->get()
                            ->map(function($enrollment) {
                                return (object)[
                                    'id' => $enrollment->subject->id,
                                    'name' => $enrollment->subject->name
                                ];
                            });

        // For debugging
        \Log::info('User ID: ' . $user->id);
        \Log::info('Student ID: ' . $student->id);
        \Log::info('Enrollments count: ' . $enrolledCourses->count());

        // Get upcoming assignments (placeholder for now)
        $upcomingAssignments = collect([]);

        return view('student.dashboard', compact('enrolledCourses', 'upcomingAssignments'));
    }
} 