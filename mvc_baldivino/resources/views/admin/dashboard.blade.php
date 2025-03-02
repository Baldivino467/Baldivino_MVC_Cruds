@extends('layouts.dashboardTemplate')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Students</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $studentCount }}</div>
                        </div>
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.students') }}" class="text-primary d-flex align-items-center">
                            View Details
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card border-left-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Subjects</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $subjectCount }}</div>
                        </div>
                        <div class="icon-circle bg-success">
                            <i class="fas fa-book text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.subjects') }}" class="text-success d-flex align-items-center">
                            View Details
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollments Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card border-left-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Enrollments</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $enrollmentCount }}</div>
                        </div>
                        <div class="icon-circle bg-info">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.enrollments') }}" class="text-info d-flex align-items-center">
                            View Details
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grades Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card border-left-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Grades</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $gradeCount }}</div>
                        </div>
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.grades') }}" class="text-warning d-flex align-items-center">
                            View Details
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Enrollments Table -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Enrollments</h6>
                    <a href="{{ route('admin.enrollments') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEnrollments as $enrollment)
                                <tr>
                                    <td class="font-weight-bold">{{ $enrollment->student->name }}</td>
                                    <td>{{ $enrollment->subject->name }}</td>
                                    <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Grades Table -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Grades</h6>
                    <a href="{{ route('admin.grades') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentGrades as $grade)
                                <tr>
                                    <td class="font-weight-bold">{{ $grade->student->name }}</td>
                                    <td>{{ $grade->subject->name }}</td>
                                    <td>
                                        <span class="badge badge-success rounded-pill px-2">
                                            {{ number_format($grade->grade, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Dashboard Cards */
.dashboard-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-label {
    color: #858796;
    font-weight: 600;
    letter-spacing: 0.05em;
}

.icon-circle {
    height: 3rem;
    width: 3rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-circle i {
    font-size: 1.5rem;
}

/* Table Styles */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-top: none;
    border-bottom: 2px solid #e3e6f0;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #858796;
    padding: 1rem;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #e3e6f0;
    color: #6e707e;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
}

/* Card Headers */
.card-header {
    background-color: transparent;
    border-bottom: 1px solid #e3e6f0;
}

/* Badges */
.badge {
    padding: 0.5em 1em;
    font-weight: 600;
}

.badge-success {
    background-color: #1cc88a;
}

/* Buttons */
.btn-sm {
    font-size: 0.8rem;
    font-weight: 600;
}

.rounded-pill {
    border-radius: 50rem !important;
}

/* Links */
a {
    text-decoration: none !important;
    font-size: 0.875rem;
    font-weight: 600;
}

/* Border Colors */
.border-left-primary { border-left-color: #4e73df !important; }
.border-left-success { border-left-color: #1cc88a !important; }
.border-left-info { border-left-color: #36b9cc !important; }
.border-left-warning { border-left-color: #f6c23e !important; }

/* Background Colors */
.bg-primary { background-color: #4e73df !important; }
.bg-success { background-color: #1cc88a !important; }
.bg-info { background-color: #36b9cc !important; }
.bg-warning { background-color: #f6c23e !important; }
</style>
@endpush