<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use Yajra\DataTables\DataTables;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $grades = Grade::with(['student', 'subject', 'enrollment']);
            return DataTables::of($grades)
                ->addColumn('student_name', function($grade) {
                    return $grade->student->name;
                })
                ->addColumn('course', function($grade) {
                    return $grade->student->course;
                })
                ->addColumn('semester', function($grade) {
                    // Get semester from enrollment
                    $enrollment = Enrollment::where('student_id', $grade->student_id)
                        ->where('subject_id', $grade->subject_id)
                        ->first();
                    return $enrollment ? $enrollment->semester : '-';
                })
                ->addColumn('subject_name', function($grade) {
                    return $grade->subject->name;
                })
                ->addColumn('units', function($grade) {
                    // Get units from subject
                    return $grade->subject->units;
                })
                ->addColumn('remark', function($grade) {
                    return $grade->grade <= 3.0 ? 'Passed' : 'Failed';
                })
                ->addColumn('curriculum_evaluation', function($grade) {
                    return $grade->grade <= 3.0 ? 'Passed' : 'Failed';
                })
                ->addColumn('actions', function($grade) {
                    return '
                        <button onclick="editGrade('.$grade->id.')" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="'.route('admin.grades.destroy', $grade).'" method="POST" class="d-inline">
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
        $grades = Grade::all();

        return view('admin.grades.index', compact('students', 'subjects', 'grades'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        $grades = Grade::all();

        return view('admin.grades.create', compact('students', 'subjects', 'grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|between:1.0,5.0'
        ]);

        try {
            // Check if the student is enrolled in the selected subject
            $enrollment = Enrollment::where('student_id', $request->student_id)
                                  ->where('subject_id', $request->subject_id)
                                  ->first();

            if (!$enrollment) {
                return response()->json([
                    'errors' => ['subject_id' => ['The student is not enrolled in the selected subject.']]
                ], 422);
            }

            // Check if the student already has a grade for the selected subject
            $existingGrade = Grade::where('student_id', $request->student_id)
                                ->where('subject_id', $request->subject_id)
                                ->first();

            if ($existingGrade) {
                return response()->json([
                    'errors' => ['subject_id' => ['This student already has a grade for the selected subject.']]
                ], 422);
            }

            // Format and prepare the data
            $student = Student::find($request->student_id);
            $subject = Subject::find($request->subject_id);
            
            $data = [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'grade' => number_format($request->grade, 2),
                'student_name' => $student->name,
                'subject_name' => $subject->name,
                'remark' => $request->grade <= 3.0 ? 'Passed' : 'Failed',
                'curriculum_evaluation' => $request->grade <= 3.0 ? 'Passed' : 'Failed'
            ];

            Grade::create($data);

            if($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.grades')
                            ->with('success', 'Grade added successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error adding grade: ' . $e->getMessage());
        }
    }

    public function edit(Grade $grade)
    {
        if(request()->ajax()) {
            $grade->load(['student', 'subject']);
            return response()->json($grade);
        }
        return view('admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
            'grade' => 'required|numeric|min:0|max:100'
        ]);

        try {
            $grade->update($request->all());
            
            if($request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.grades')
                            ->with('success', 'Grade updated successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error updating grade: ' . $e->getMessage());
        }
    }

    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            
            if(request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.grades')
                ->with('success', 'Grade deleted successfully.');
        } catch (\Exception $e) {
            if(request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error deleting grade: ' . $e->getMessage());
        }
    }

    public function viewGrades()
    {
        // Get the authenticated student
        $student = Student::where('email', auth()->user()->email)->first();
        
        // Initialize grades as empty collection
        $grades = collect([]);
        
        // Only fetch grades if student exists
        if ($student) {
            $grades = Grade::where('student_id', $student->id)
                          ->with(['subject', 'student'])
                          ->get();
        }

        // Get current enrollment for semester info
        $enrollment = $student ? Enrollment::where('student_id', $student->id)
                                ->latest()
                                ->first() 
                                : null;

        return view('student.view-grades', compact('student', 'grades', 'enrollment'));
    }

    private function getRemark($grade)
    {
        if ($grade >= 1.0 && $grade <= 3.0) {
            return 'Passed';
        } else {
            return 'Failed';
        }
    }
}
