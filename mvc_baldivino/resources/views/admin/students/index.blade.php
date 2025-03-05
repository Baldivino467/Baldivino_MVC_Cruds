@extends('layouts.dashboardTemplate')

@section('title', 'Students')

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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Student List</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
                <i class="fas fa-plus"></i> Add Student
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="studentTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addStudentModalLabel">Add New Student</h5>
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

                <form id="addStudentForm" action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Student</label>
                        <select class="form-control select2" id="name" name="name" required>
                            <option value="">Select Student</option>
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
                            <option value="BSIT">Bachelor of Science in Information Technology</option>
                            <option value="BSCS">Bachelor of Science in Computer Science</option>
                            <option value="BSIS">Bachelor of Science in Information Systems</option>
                            <option value="BSEMC">Bachelor of Science in Entertainment and Multimedia Computing</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year_level">Year Level</label>
                        <select class="form-control" id="year_level" name="year_level" required>
                            <option value="">Select Year Level</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="addStudentForm" class="btn btn-primary">Add Student</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="edit_student_id">Student ID</label>
                        <input type="text" class="form-control" id="edit_student_id" name="student_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_course">Course</label>
                        <select class="form-control" id="edit_course" name="course" required>
                            <option value="">Select Course</option>
                            <option value="BSIT">Bachelor of Science in Information Technology</option>
                            <option value="BSCS">Bachelor of Science in Computer Science</option>
                            <option value="BSIS">Bachelor of Science in Information Systems</option>
                            <option value="BSEMC">Bachelor of Science in Entertainment and Multimedia Computing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_year_level">Year Level</label>
                        <select class="form-control" id="edit_year_level" name="year_level" required>
                            <option value="">Select Year Level</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="5th Year">5th Year</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editStudentForm" class="btn btn-warning">Update Student</button>
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
    var table = $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.students') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_id', name: 'student_id' },
            { data: 'name_with_initial', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'course_badge', name: 'course' },
            { data: 'year_level_badge', name: 'year_level' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });

    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select Student",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#addStudentModal')
    });

    // Handle student selection
    $('#name').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var email = selectedOption.data('email');
        $('#email').val(email || '');
    });

    // Reset form when modal is closed
    $('#addStudentModal').on('hidden.bs.modal', function () {
        $('#addStudentForm')[0].reset();
        $('.select2').val('').trigger('change');
    });

    // Form submission handling
    $('#addStudentForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#addStudentModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Added!',
                    text: 'Student added successfully.',
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

    // Edit student function
    function editStudent(id) {
        $.get(`/admin/students/${id}/edit`, function(student) {
            $('#editStudentForm').attr('action', `/admin/students/${id}`);
            $('#edit_student_id').val(student.student_id);
            $('#edit_name').val(student.name);
            $('#edit_email').val(student.email);
            $('#edit_course').val(student.course);
            $('#edit_year_level').val(student.year_level);
            $('#editStudentModal').modal('show');
        });
    }

    // Handle edit form submission
    $('#editStudentForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#editStudentModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Updated!',
                    text: 'Student updated successfully.',
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

    // Make edit button clickable
    $(document).on('click', '.edit-student', function() {
        var id = $(this).data('id');
        editStudent(id);
    });

    // Delete confirmation
    $(document).on('click', '.delete-student', function() {
        var studentId = $(this).data('id');
        var studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${studentName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(`#delete-form-${studentId}`);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Refresh the table
                        table.ajax.reload();
                        
                        // Refresh the Select2 dropdown options
                        $.ajax({
                            url: '{{ route("admin.students") }}',
                            method: 'GET',
                            success: function(response) {
                                var select = $('#name');
                                select.empty();
                                select.append('<option value="">Select Student</option>');
                                
                                response.data.forEach(function(student) {
                                    select.append(
                                        `<option value="${student.name}" data-email="${student.email}">
                                            ${student.name}
                                        </option>`
                                    );
                                });
                                
                                // Reset Select2
                                select.val('').trigger('change');
                            }
                        });

                        // Show success message
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Student deleted successfully.',
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
                            'A Student cannot be deleted if they are currently enrolled in any subjects.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Add this to your existing JavaScript
    function deleteStudent(studentId) {
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                url: `/admin/students/${studentId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Refresh the DataTable
                        $('#studentTable').DataTable().ajax.reload();
                        // Show success message
                        toastr.success('Student deleted successfully');
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    if (xhr.status === 422) {
                        // Show validation error message
                        toastr.error(xhr.responseJSON.error);
                    } else {
                        // Show generic error message
                        toastr.error('An error occurred while deleting the student');
                    }
                }
            });
        }
    }
});
</script>

<style>
.modal-lg {
    max-width: 800px;
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

.select2-container--default .select2-results__option {
    padding: 8px 12px;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #4e73df;
}

.modal-content {
    border-radius: 0.35rem;
    border: none;
}

.modal-header {
    border-top-left-radius: 0.35rem;
    border-top-right-radius: 0.35rem;
}

.table td { vertical-align: middle; }
.badge { padding: 8px 12px; font-size: 0.85rem; }
.btn-sm { padding: 0.4rem 0.6rem; }
.alert { border-left: 4px solid #1cc88a; }
.card { transition: transform 0.2s ease; }
.card:hover { transform: translateY(-5px); }
</style>
@endpush
@endsection