@extends('layouts.dashboardTemplate')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards Row -->
    <div class="row">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-primary-soft rounded-circle">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <div class="stat-label text-uppercase">Students</div>
                    </div>
                    <h3 class="stat-value mb-2">{{ number_format($studentCount) }}</h3>
                    <a href="{{ route('admin.students') }}" class="stat-link text-primary">
                        View Details <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-success-soft rounded-circle">
                            <i class="fas fa-book text-success"></i>
                        </div>
                        <div class="stat-label text-uppercase">Subjects</div>
                    </div>
                    <h3 class="stat-value mb-2">{{ number_format($subjectCount) }}</h3>
                    <a href="{{ route('admin.subjects') }}" class="stat-link text-success">
                        View Details <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Enrollments Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-info-soft rounded-circle">
                            <i class="fas fa-user-plus text-info"></i>
                        </div>
                        <div class="stat-label text-uppercase">Enrollments</div>
                    </div>
                    <h3 class="stat-value mb-2">{{ number_format($enrollmentCount) }}</h3>
                    <a href="{{ route('admin.enrollments') }}" class="stat-link text-info">
                        View Details <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Grades Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-warning-soft rounded-circle">
                            <i class="fas fa-graduation-cap text-warning"></i>
                        </div>
                        <div class="stat-label text-uppercase">Grades</div>
                    </div>
                    <h3 class="stat-value mb-2">{{ number_format($gradeCount) }}</h3>
                    <a href="{{ route('admin.grades') }}" class="stat-link text-warning">
                        View Details <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row">
        <!-- Recent Enrollments -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Enrollments</h6>
                        <a href="{{ route('admin.enrollments') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentEnrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Student</th>
                                        <th class="border-0">Subject</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEnrollments as $enrollment)
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary-soft text-primary mr-3">
                                                    {{ strtoupper(substr($enrollment->student->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $enrollment->student->name }}</div>
                                                    <small class="text-muted">{{ $enrollment->student->student_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <div class="font-weight-bold">{{ $enrollment->subject->subject_code }}</div>
                                            <small class="text-muted">{{ $enrollment->subject->name }}</small>
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state text-muted">
                                <i class="fas fa-user-plus fa-3x mb-3"></i>
                                <p>No recent enrollments</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Grades -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Grades</h6>
                        <a href="{{ route('admin.grades') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentGrades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Student</th>
                                        <th class="border-0">Subject</th>
                                        <th class="border-0">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentGrades as $grade)
                                    <tr>
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-warning-soft text-warning mr-3">
                                                    {{ strtoupper(substr($grade->student->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $grade->student->name }}</div>
                                                    <small class="text-muted">{{ $grade->student->student_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-0">
                                            <div class="font-weight-bold">{{ $grade->subject->subject_code }}</div>
                                            <small class="text-muted">{{ $grade->subject->name }}</small>
                                        </td>
                                        <td class="border-0">
                                            <span class="grade-pill 
                                                @if($grade->grade >= 90) bg-success-soft text-success
                                                @elseif($grade->grade >= 80) bg-info-soft text-info
                                                @elseif($grade->grade >= 75) bg-warning-soft text-warning
                                                @else bg-danger-soft text-danger @endif">
                                                {{ number_format($grade->grade, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state text-muted">
                                <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                <p>No recent grades</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Card Styles */
.stat-card {
    transition: transform 0.2s ease-in-out;
    border-radius: 1rem;
}

.stat-card:hover {
    transform: translateY(-5px);
}

/* Stat Icon */
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i {
    font-size: 1.5rem;
}

/* Stat Label */
.stat-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #858796;
}

/* Stat Value */
.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #4e73df;
    margin: 0;
}

/* Stat Link */
.stat-link {
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.stat-link i {
    transition: transform 0.2s ease-in-out;
}

.stat-link:hover i {
    transform: translateX(5px);
}

/* Avatar Circle */
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Grade Pill */
.grade-pill {
    padding: 0.25rem 0.75rem;
    border-radius: 50rem;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Soft Background Colors */
.bg-primary-soft {
    background-color: rgba(78, 115, 223, 0.1);
}

.bg-success-soft {
    background-color: rgba(28, 200, 138, 0.1);
}

.bg-info-soft {
    background-color: rgba(54, 185, 204, 0.1);
}

.bg-warning-soft {
    background-color: rgba(246, 194, 62, 0.1);
}

.bg-danger-soft {
    background-color: rgba(231, 74, 59, 0.1);
}

/* Empty State */
.empty-state {
    color: #858796;
}

.empty-state i {
    opacity: 0.5;
}

/* Table Hover Effect */
.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

/* Custom Card Header */
.card-header {
    padding: 1.25rem 1.5rem;
}

/* Rounded Pill Button */
.btn-sm.rounded-pill {
    padding-left: 1rem;
    padding-right: 1rem;
}
</style>
@endpush
@endsection