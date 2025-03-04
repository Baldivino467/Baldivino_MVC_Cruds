@extends('layouts.dashboardTemplate')

@section('title', 'Grades')

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
            <h6 class="m-0 font-weight-bold text-primary">Grade List</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addGradeModal">
                <i class="fas fa-plus"></i> Add Grade
            </button>
        </div>
        <div class="card-body px-2">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="gradeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Sem</th>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Units</th>
                            <th>Remark</th>
                            <th>Curr. Eval</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Grade Modal -->
<div class="modal fade" id="addGradeModal" tabindex="-1" role="dialog" aria-labelledby="addGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addGradeModalLabel">Add New Grade</h5>
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

                <form id="addGradeForm" action="{{ route('admin.grades.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="student_id">Student</label>
                        <select class="form-control select2" id="student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject_id">Subject</label>
                        <select class="form-control select2" id="subject_id" name="subject_id" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                @php
                                    $isGraded = $grades->where('student_id', old('student_id'))->pluck('subject_id')->toArray();
                                @endphp
                                <option value="{{ $subject->id }}" @if(in_array($subject->id, $isGraded)) disabled @endif>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <select class="form-control" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            @php
                                for($i = 1.0; $i <= 5.0; $i += 0.25) {
                                    $formatted = number_format($i, 2);
                                    echo "<option value='{$formatted}'>{$formatted}</option>";
                                }
                            @endphp
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="addGradeForm" class="btn btn-primary">Add Grade</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editGradeModalLabel">Edit Grade</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editGradeForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="edit_student_id">Student</label>
                        <select class="form-control select2" id="edit_student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
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

                    <div class="form-group">
                        <label for="edit_grade">Grade</label>
                        <select class="form-control" id="edit_grade" name="grade" required>
                            <option value="">Select Grade</option>
                            @php
                                for($i = 1.0; $i <= 5.0; $i += 0.25) {
                                    $formatted = number_format($i, 2);
                                    echo "<option value='{$formatted}'>{$formatted}</option>";
                                }
                            @endphp
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editGradeForm" class="btn btn-warning">Update Grade</button>
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
    var table = $('#gradeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.grades') }}",
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
                data: 'grade',
                name: 'grade',
                render: function(data) {
                    return `<span class="badge badge-warning">${data}</span>`;
                }
            },
            { 
                data: 'units',
                name: 'units',
                render: function(data) {
                    return `<span class="badge badge-secondary">${data}</span>`;
                }
            },
            { 
                data: 'remark',
                name: 'remark',
                render: function(data) {
                    return `<span class="badge badge-${data === 'Passed' ? 'success' : 'danger'}">${data}</span>`;
                }
            },
            { 
                data: 'curriculum_evaluation',
                name: 'curriculum_evaluation',
                render: function(data) {
                    return `<span class="badge badge-${data === 'Passed' ? 'success' : 'danger'}">${data}</span>`;
                }
            },
            { 
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button onclick="editGrade(${row.id})" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-grade" 
                                data-id="${row.id}" 
                                data-student="${row.student_name}" 
                                data-subject="${row.subject_name}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-${row.id}" action="/admin/grades/${row.id}" method="POST" class="d-none">
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
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addGradeModal')
    });

    // Form submission handling for adding grade
    $('#addGradeForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#addGradeModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Added!',
                    text: 'Grade added successfully.',
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
                $('.select2').val('').trigger('change');
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
    $('#addGradeModal').on('hidden.bs.modal', function () {
        $('#addGradeForm')[0].reset();
        $('.select2').val('').trigger('change');
    });

    // Edit grade function
    window.editGrade = function(id) {
        $.get(`/admin/grades/${id}/edit`, function(grade) {
            $('#editGradeForm').attr('action', `/admin/grades/${id}`);
            $('#edit_student_id').val(grade.student_id).trigger('change');
            $('#edit_subject_id').val(grade.subject_id).trigger('change');
            $('#edit_grade').val(parseFloat(grade.grade).toFixed(2));
            $('#editGradeModal').modal('show');
        });
    }

    // Initialize Select2 for edit modal
    $('#edit_student_id, #edit_subject_id').select2({
        dropdownParent: $('#editGradeModal'),
        width: '100%',
        placeholder: 'Select an option'
    });

    // Handle edit form submission
    $('#editGradeForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#editGradeModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Updated!',
                    text: 'Grade updated successfully.',
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
    $(document).on('click', '.delete-grade', function() {
        var gradeId = $(this).data('id');
        var studentName = $(this).data('student');
        var subjectName = $(this).data('subject');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete grade for ${studentName} in ${subjectName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(`#delete-form-${gradeId}`);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Grade deleted successfully.',
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
                            'There was an error deleting the grade.',
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
    .table td { 
        vertical-align: middle;
        font-size: 0.8rem;
        padding: 0.5rem;
    }
    .table th {
        font-size: 0.8rem;
        padding: 0.5rem;
    }
    .badge { 
        font-size: 0.75rem;
        padding: 0.3rem 0.5rem;
    }
    .btn-sm { 
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
    .avatar-circle {
        width: 25px;
        height: 25px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .text-truncate {
        display: inline-block;
    }
    .alert { border-left: 4px solid #1cc88a; }
    .card { transition: transform 0.2s ease; }
    .card:hover { transform: translateY(-5px); }
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
</style>
@endpush
@endsection