@extends('layouts.dashboardTemplate')

@section('title', 'Add Enrollment')

@section('content')
    <div class="container">
        <h1 class="my-4">Add Enrollment</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.enrollments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="student_id">Student</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" data-course="{{ $student->course }}">
                            {{ $student->name }} - {{ $student->course }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" class="form-control" id="course" name="course" readonly>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <select class="form-control" id="semester" name="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1st">1st Semester</option>
                    <option value="2nd">2nd Semester</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subject_id">Subject</label>
                <select class="form-control" id="subject_id" name="subject_id" required>
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                        @php
                            $isEnrolled = $enrollments->where('subject_id', $subject->id)->pluck('student_id')->toArray();
                        @endphp
                        <option value="{{ $subject->id }}" @if(in_array(old('student_id'), $isEnrolled)) disabled @endif>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Enrollment</button>
        </form>
    </div>

    <script>
        document.getElementById('student_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var course = selectedOption.getAttribute('data-course');
            document.getElementById('course').value = course;
        });
    </script>
@endsection