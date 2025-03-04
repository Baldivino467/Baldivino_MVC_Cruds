<div class="d-flex align-items-center">
    <div class="rounded-circle bg-primary text-white p-2 mr-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
        {{ strtoupper(substr($student->name, 0, 1)) }}
    </div>
    {{ $student->name }}
</div> 