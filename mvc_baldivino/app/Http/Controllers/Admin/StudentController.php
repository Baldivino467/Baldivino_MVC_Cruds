<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->wantsJson()) {
                $students = Student::query();
                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('name_with_initial', function($student) {
                        return view('admin.students.name-column', compact('student'))->render();
                    })
                    ->addColumn('course_badge', function($student) {
                        return '<span class="badge badge-info">' . $student->course . '</span>';
                    })
                    ->addColumn('year_level_badge', function($student) {
                        return '<span class="badge badge-success">' . $student->year_level . '</span>';
                    })
                    ->addColumn('actions', function($student) {
                        return view('admin.students.actions', compact('student'))->render();
                    })
                    ->rawColumns(['name_with_initial', 'course_badge', 'year_level_badge', 'actions'])
                    ->make(true);
            }
        }

        // Get available students for Select2
        $users = User::where('role', 'student')
                     ->whereNotIn('email', Student::pluck('email'))
                     ->select('id', 'name', 'email')
                     ->orderBy('name')
                     ->get();

        return view('admin.students.index', compact('users'));
    }

    public function create()
    {
        $users = User::where('role', 'student')
                     ->whereNotIn('email', Student::pluck('email'))
                     ->select('id', 'name', 'email')
                     ->orderBy('name')
                     ->get();
        return view('admin.students.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'course' => 'required',
            'year_level' => 'required'
        ]);

        try {
            Student::create([
                'student_id' => $request->student_id,
                'name' => $request->name,
                'email' => $request->email,
                'course' => $request->course,
                'year_level' => $request->year_level
            ]);

            if($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.students')
                            ->with('success', 'Student added successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error adding student: ' . $e->getMessage());
        }
    }

    public function edit(Student $student)
    {
        if(request()->ajax()) {
            return response()->json($student);
        }
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'course' => 'required',
            'year_level' => 'required'
        ]);

        try {
            $student->update($request->all());
            
            if($request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.students')
                            ->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error updating student: ' . $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        $student->delete();
        
        if(request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.students')
            ->with('success', 'Student deleted successfully.');
    }
}

