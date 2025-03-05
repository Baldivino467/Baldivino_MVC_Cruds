<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use DataTables;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $enrollments = Enrollment::with(['student', 'subject']);
            return DataTables::of($enrollments)
                ->addColumn('student_name', function($enrollment) {
                    return $enrollment->student->name;
                })
                ->addColumn('course', function($enrollment) {
                    return $enrollment->student->course;
                })
                ->addColumn('subject_name', function($enrollment) {
                    return $enrollment->subject->name;
                })
                ->addColumn('actions', function($enrollment) {
                    return '<a href="'.route('admin.enrollments.edit', $enrollment).'" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="'.route('admin.enrollments.destroy', $enrollment).'" method="POST" class="d-inline">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $students = Student::all();
        $subjects = Subject::all();
        $enrollments = Enrollment::all();

        return view('admin.enrollments.index', compact('students', 'subjects', 'enrollments'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        $enrollments = Enrollment::all();

        return view('admin.enrollments.create', compact('students', 'subjects', 'enrollments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if student is already enrolled in this subject
                    $exists = Enrollment::where('student_id', $request->student_id)
                        ->where('subject_id', $value)
                        ->exists();
                    
                    if ($exists) {
                        $fail('Student is already enrolled in this subject.');
                    }
                },
            ],
            'semester' => 'required'
        ]);

        try {
            Enrollment::create($request->all());

            if($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.enrollments')
                            ->with('success', 'Enrollment added successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json([
                    'errors' => [
                        'general' => ['Error adding enrollment. Student may already be enrolled in this subject.']
                    ]
                ], 422);
            }
            return back()->with('error', 'Error adding enrollment: ' . $e->getMessage());
        }
    }

    public function edit(Enrollment $enrollment)
    {
        if(request()->ajax()) {
            // Load the student relationship to get the course
            $enrollment->load('student');
            return response()->json($enrollment);
        }
        return view('admin.enrollments.edit', compact('enrollment'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
            'semester' => 'required'
        ]);

        try {
            $enrollment->update($request->all());
            
            if($request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.enrollments')
                            ->with('success', 'Enrollment updated successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error updating enrollment: ' . $e->getMessage());
        }
    }

    public function destroy(Enrollment $enrollment)
    {
        try {
            // Check if there's a grade for this enrollment
            $hasGrade = \App\Models\Grade::where('student_id', $enrollment->student_id)
                ->where('subject_id', $enrollment->subject_id)
                ->exists();

            if ($hasGrade) {
                if(request()->ajax()) {
                    return response()->json([
                        'error' => 'Cannot delete enrollment. This student already has a grade for this subject.'
                    ], 422);
                }
                return back()->with('error', 'Cannot delete enrollment. This student already has a grade for this subject.');
            }

            $enrollment->delete();
            
            if(request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.enrollments')
                ->with('success', 'Enrollment deleted successfully.');
        } catch (\Exception $e) {
            if(request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error deleting enrollment: ' . $e->getMessage());
        }
    }
}
