@extends('layouts.dashboardTemplate')

@section('title', 'Enrollments')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Enrollment List</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addEnrollmentModal">
                <i class="fas fa-plus"></i> Add Enrollment
            </button>
        </div>
        <div class="card-body px-2">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="enrollmentTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>Subject</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Enrollment Modal -->
<div class="modal fade" id="addEnrollmentModal" tabindex="-1" role="dialog" aria-labelledby="addEnrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addEnrollmentModalLabel">Add New Enrollment</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="addEnrollmentForm" action="{{ route('admin.enrollments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="student_id">Student</label>
                        <select class="form-control select2" id="student_id" name="student_id" required>
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
                        <select class="form-control select2" id="subject_id" name="subject_id" required>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="addEnrollmentForm" class="btn btn-primary">Add Enrollment</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Enrollment Modal -->
<div class="modal fade" id="editEnrollmentModal" tabindex="-1" role="dialog" aria-labelledby="editEnrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editEnrollmentModalLabel">Edit Enrollment</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEnrollmentForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="edit_student_id">Student</label>
                        <select class="form-control select2" id="edit_student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-course="{{ $student->course }}">
                                    {{ $student->name }} - {{ $student->course }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_course">Course</label>
                        <input type="text" class="form-control" id="edit_course" name="course" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_semester">Semester</label>
                        <select class="form-control" id="edit_semester" name="semester" required>
                            <option value="">Select Semester</option>
                            <option value="1st">1st Semester</option>
                            <option value="2nd">2nd Semester</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_subject_id">Subject</label>
                        <select class="form-control select2" id="edit_subject_id" name="subject_id" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editEnrollmentForm" class="btn btn-warning">Update Enrollment</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Include Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#enrollmentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.enrollments') }}",
        columns: [
            { data: 'student_name', name: 'student_name' },
            { 
                data: 'course',
                name: 'course',
                render: function(data) {
                    return `<span class="badge badge-info">${data}</span>`;
                }
            },
            { 
                data: 'semester',
                name: 'semester',
                render: function(data) {
                    return `<span class="badge badge-primary">${data}</span>`;
                }
            },
            { 
                data: 'subject_name',
                name: 'subject_name',
                render: function(data) {
                    return `<span class="badge badge-success">${data}</span>`;
                }
            },
            { 
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button onclick="editEnrollment(${row.id})" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-enrollment" 
                                data-id="${row.id}" 
                                data-student="${row.student_name}" 
                                data-subject="${row.subject_name}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-${row.id}" action="/admin/enrollments/${row.id}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    `;
                }
            }
        ],
        order: [[0, 'asc']],
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });

    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addEnrollmentModal')
    });

    // Handle student selection
    $('#student_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var course = selectedOption.data('course');
        $('#course').val(course || '');
    });

    // Form submission handling for adding enrollment
    $('#addEnrollmentForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#addEnrollmentModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Added!',
                    text: 'Enrollment added successfully.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'animated fadeInDown faster'
                    },
                    showClass: {
                        popup: 'animated fadeInDown faster'
                    },
                    hideClass: {
                        popup: 'animated fadeOutUp faster'
                    }
                });
                
                form[0].reset();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    // Reset form when modal is closed
    $('#addEnrollmentModal').on('hidden.bs.modal', function () {
        $('#addEnrollmentForm')[0].reset();
        $('.select2').val('').trigger('change');
    });

    // Edit enrollment function
    window.editEnrollment = function(id) {
        $.get(`/admin/enrollments/${id}/edit`, function(enrollment) {
            $('#editEnrollmentForm').attr('action', `/admin/enrollments/${id}`);
            
            // First set the student and trigger change to update course
            var studentOption = $(`#edit_student_id option[value='${enrollment.student_id}']`);
            $('#edit_student_id').val(enrollment.student_id).trigger('change');
            
            // Get the course from the student's data attribute
            var course = studentOption.data('course');
            $('#edit_course').val(course);
            
            // Set other fields
            $('#edit_semester').val(enrollment.semester);
            $('#edit_subject_id').val(enrollment.subject_id).trigger('change');
            
            $('#editEnrollmentModal').modal('show');
        });
    }

    // Update the student selection handler
    $('#edit_student_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var course = selectedOption.data('course');
        $('#edit_course').val(course || '');
    });

    // Initialize Select2 with proper configuration
    $('#edit_student_id, #edit_subject_id').select2({
        dropdownParent: $('#editEnrollmentModal'),
        width: '100%',
        placeholder: 'Select an option'
    });

    // Handle edit form submission
    $('#editEnrollmentForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#editEnrollmentModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Updated!',
                    text: 'Enrollment updated successfully.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'animated fadeInDown faster'
                    },
                    showClass: {
                        popup: 'animated fadeInDown faster'
                    },
                    hideClass: {
                        popup: 'animated fadeOutUp faster'
                    }
                });
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    // Delete confirmation
    $(document).on('click', '.delete-enrollment', function() {
        var enrollmentId = $(this).data('id');
        var studentName = $(this).data('student');
        var subjectName = $(this).data('subject');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete enrollment for ${studentName} in ${subjectName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(`#delete-form-${enrollmentId}`);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Enrollment deleted successfully.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'animated fadeInDown faster'
                            },
                            showClass: {
                                popup: 'animated fadeInDown faster'
                            },
                            hideClass: {
                                popup: 'animated fadeOutUp faster'
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.error || 'There was an error deleting the enrollment.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

<style>
.modal-content {
    border-radius: 0.35rem;
    border: none;
}

.modal-header {
    border-top-left-radius: 0.35rem;
    border-top-right-radius: 0.35rem;
}

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

.table td { 
    vertical-align: middle;
    font-size: 0.95rem;
    padding: 0.75rem;
}

.badge { 
    font-size: 0.9rem;
    padding: 0.4rem 0.6rem;
}

.btn-sm { 
    padding: 0.3rem 0.5rem;
    font-size: 0.9rem;
}

.alert { border-left: 4px solid #1cc88a; }
.card { transition: transform 0.2s ease; }
.card:hover { transform: translateY(-5px); }
</style>
@endpush
@endsection