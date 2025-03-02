@extends('layouts.dashboardTemplate')

@section('title', 'Add Student')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Student</h6>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Student</label>
                        <select class="form-control select2" id="name" name="name" required>
                            <option></option>
                            @foreach($users as $user)
                                <option value="{{ $user->name }}" 
                                        data-email="{{ $user->email }}"
                                        {{ old('name') == $user->name ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="course">Course</label>
                        <select class="form-control" id="course" name="course" required>
                            <option value="">Select Course</option>
                            <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                            <option value="BSCS" {{ old('course') == 'BSCS' ? 'selected' : '' }}>Bachelor of Science in Computer Science</option>
                            <option value="BSIS" {{ old('course') == 'BSIS' ? 'selected' : '' }}>Bachelor of Science in Information Systems</option>
                            <option value="BSEMC" {{ old('course') == 'BSEMC' ? 'selected' : '' }}>Bachelor of Science in Entertainment and Multimedia Computing</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year_level">Year Level</label>
                        <select class="form-control" id="year_level" name="year_level" required>
                            <option value="">Select Year Level</option>
                            <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                            <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">Add Student</button>
                        <a href="{{ route('admin.students') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select Student",
            allowClear: true,
            width: '100%'
        });

        // Handle student selection
        $('#name').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var email = selectedOption.data('email');
            $('#email').val(email || '');
        });

        // Trigger change event if there's a pre-selected value
        if ($('#name').val()) {
            $('#name').trigger('change');
        }
    });
    </script>

    <style>
    .select2-container--default .select2-selection--single {
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        border: 1px solid #d1d3e2;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
    }

    .select2-container--default .select2-results__option {
        padding: 8px 12px;
    }

    .student-info {
        margin-left: 10px;
    }

    .student-email {
        color: #666;
        font-size: 0.85em;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #4e73df;
    }
    </style>
    @endpush
@endsection