<button type="button" class="btn btn-warning btn-sm edit-student" data-id="{{ $student->id }}">
    <i class="fas fa-edit"></i>
</button>
<button type="button" class="btn btn-danger btn-sm delete-student" data-id="{{ $student->id }}" data-name="{{ $student->name }}">
    <i class="fas fa-trash"></i>
</button>

<form id="delete-form-{{ $student->id }}" action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form> 