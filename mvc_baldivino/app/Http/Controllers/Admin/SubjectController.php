<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use DataTables;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subjects = Subject::query();
            return DataTables::of($subjects)
                ->addColumn('actions', function($subject) {
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return '
                        <button onclick="editSubject('.$subject->id.')" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-subject" data-id="'.$subject->id.'" data-name="'.$subject->name.'">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-'.$subject->id.'" action="'.route('admin.subjects.destroy', $subject).'" method="POST" class="d-none">
                            '.$csrf.'
                            '.$method.'
                        </form>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.subjects.index');
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subjects,name',
            'subject_code' => 'required|unique:subjects',
            'units' => 'required|numeric'
        ]);

        try {
            Subject::create($request->all());

            if($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('admin.subjects')
                            ->with('success', 'Subject added successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error adding subject: ' . $e->getMessage());
        }
    }

    public function edit(Subject $subject)
    {
        if(request()->ajax()) {
            return response()->json($subject);
        }
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required',
            'subject_code' => 'required|unique:subjects,subject_code,' . $subject->id,
            'units' => 'required|numeric'
        ]);

        try {
            $subject->update($request->all());
            
            if($request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.subjects')
                            ->with('success', 'Subject updated successfully.');
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error updating subject: ' . $e->getMessage());
        }
    }

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            
            if(request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('admin.subjects')
                ->with('success', 'Subject deleted successfully.');
        } catch (\Exception $e) {
            if(request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error deleting subject: ' . $e->getMessage());
        }
    }
}
