<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'studentCount' => Student::count(),
            'subjectCount' => Subject::count(),
            'enrollmentCount' => Enrollment::count(),
            'gradeCount' => Grade::count(),
            'recentEnrollments' => Enrollment::with(['student', 'subject'])
                                    ->latest()
                                    ->take(5)
                                    ->get(),
            'recentGrades' => Grade::with(['student', 'subject'])
                                ->latest()
                                ->take(5)
                                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}