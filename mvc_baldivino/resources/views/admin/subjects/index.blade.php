@extends('layouts.dashboardTemplate')

@section('title', 'Subjects')

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
            <h6 class="m-0 font-weight-bold text-primary">Subject List</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSubjectModal">
                <i class="fas fa-plus"></i> Add Subject
            </button>
        </div>
        <div class="card-body px-2">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="subjectTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Units</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addSubjectModalLabel">Add New Subject</h5>
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

                <form id="addSubjectForm" action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Subject Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_code">Subject Code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code" value="{{ old('subject_code') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="units">Units</label>
                        <input type="number" class="form-control" id="units" name="units" value="{{ old('units') }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="addSubjectForm" class="btn btn-primary">Add Subject</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="editSubjectModalLabel">Edit Subject</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSubjectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="edit_name">Subject Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_subject_code">Subject Code</label>
                        <input type="text" class="form-control" id="edit_subject_code" name="subject_code" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_units">Units</label>
                        <input type="number" class="form-control" id="edit_units" name="units" min="1" max="6" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="editSubjectForm" class="btn btn-warning">Update Subject</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#subjectTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.subjects') }}",
        columns: [
            { 
                data: 'subject_code',
                name: 'subject_code',
                render: function(data) {
                    return `<span class="badge badge-info">${data}</span>`;
                }
            },
            { 
                data: 'name',
                name: 'name',
                render: function(data) {
                    return `<span class="badge badge-success">${data}</span>`;
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
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button onclick="editSubject(${row.id})" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-subject" data-id="${row.id}" data-name="${row.name}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-${row.id}" action="/admin/subjects/${row.id}" method="POST" class="d-none">
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

    // Form submission handling
    $('#addSubjectForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#addSubjectModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Added!',
                    text: 'Subject added successfully.',
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
    $('#addSubjectModal').on('hidden.bs.modal', function () {
        $('#addSubjectForm')[0].reset();
    });

    window.editSubject = function(id) {
        $.get(`/admin/subjects/${id}/edit`, function(subject) {
            $('#editSubjectForm').attr('action', `/admin/subjects/${id}`);
            $('#edit_name').val(subject.name);
            $('#edit_subject_code').val(subject.subject_code);
            $('#edit_units').val(subject.units);
            $('#editSubjectModal').modal('show');
        });
    }

    // Handle edit form submission
    $('#editSubjectForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                $('#editSubjectModal').modal('hide');
                table.ajax.reload();
                
                // Show success message with checkmark
                Swal.fire({
                    title: 'Updated!',
                    text: 'Subject updated successfully.',
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
    $(document).on('click', '.delete-subject', function() {
        var subjectId = $(this).data('id');
        var subjectName = $(this).data('name');
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete ${subjectName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(`#delete-form-${subjectId}`);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Subject deleted successfully.',
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
                            'There was an error deleting the subject.',
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