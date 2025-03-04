@extends('layouts.dashboardTemplate')

@section('title', 'My Courses')

@section('content')
<div class="container-fluid">
    <!-- Student Overview Cards -->
    <div class="row">
        <!-- Enrolled Subjects Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Enrolled Subjects</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $enrolledCourses->count() }}</div>
                        </div>
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-book-open text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Units Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-left-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Total Units</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalUnits = $enrolledCourses->reduce(function ($total, $enrollment) {
                                        return $total + ($enrollment->subject->units ?? 0);
                                    }, 0);
                                @endphp
                                {{ $totalUnits }}
                            </div>
                        </div>
                        <div class="icon-circle bg-success">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Semester Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card dashboard-card border-left-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs text-uppercase mb-1 card-label">Current Semester</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">2nd</div>
                        </div>
                        <div class="icon-circle bg-info">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Student Information Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=150&background=random" 
                                 class="rounded-circle profile-image" alt="Profile Picture">
                            <div class="online-status"></div>
                        </div>
                        <h5 class="font-weight-bold text-gray-800 mt-3">{{ auth()->user()->name }}</h5>
                        <span class="badge badge-primary rounded-pill">Student</span>
                    </div>
                    
                    @php
                        $student = App\Models\Student::where('email', auth()->user()->email)->first();
                    @endphp

                    <div class="info-list">
                        <div class="info-item mb-3">
                            <label class="text-gray-500">Student ID</label>
                            <p class="font-weight-bold text-gray-800 mb-0">{{ $student->student_id ?? 'N/A' }}</p>
                        </div>
                        <div class="info-item mb-3">
                            <label class="text-gray-500">Email</label>
                            <p class="font-weight-bold text-gray-800 mb-0">{{ $student->email ?? 'N/A' }}</p>
                        </div>
                        <div class="info-item mb-3">
                            <label class="text-gray-500">Course</label>
                            <p class="font-weight-bold text-gray-800 mb-0">{{ $student->course ?? 'N/A' }}</p>
                        </div>
                        <div class="info-item">
                            <label class="text-gray-500">Year Level</label>
                            <p class="font-weight-bold text-gray-800 mb-0">{{ $student->year_level ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Courses Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">My Courses</h6>
                </div>
                <div class="card-body">
                    @if($enrolledCourses->count() > 0)
                        @foreach($enrolledCourses as $enrollment)
                            @if($enrollment->subject)
                                <div class="course-item mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="course-info">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge badge-info mr-2">COURSE #{{ $enrollment->subject->subject_code ?? 'N/A' }}</span>
                                                <h5 class="mb-0 font-weight-bold text-gray-800">{{ $enrollment->subject->name ?? 'N/A' }}</h5>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-light mr-2">{{ $enrollment->semester ?? 'N/A' }}</span>
                                                <span class="badge badge-success">{{ $enrollment->subject->units ?? 0 }} Units</span>
                                            </div>
                                        </div>
                                        <!-- <a href="#" class="btn btn-primary btn-sm rounded-pill px-3">
                                            <i class="fas fa-eye mr-1"></i> View Details
                                        </a> -->
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-book-open fa-4x text-gray-300 mb-3"></i>
                                <h4 class="text-gray-800 font-weight-bold mb-2">No Enrolled Subjects</h4>
                                <p class="text-gray-600 mb-0">Please contact your administrator for enrollment.</p>
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
.dashboard-card {
    border-radius: 15px;
    border: none;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Icon Circle */
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-circle i {
    font-size: 1.5rem;
}

/* Profile Image */
.profile-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.online-status {
    width: 16px;
    height: 16px;
    background: #1cc88a;
    border: 3px solid #fff;
    border-radius: 50%;
    position: absolute;
    bottom: 5px;
    right: 5px;
}

/* Course Items */
.course-item {
    padding: 1.25rem;
    border-radius: 15px;
    background: #fff;
    border: 1px solid #e3e6f0;
    transition: all 0.3s ease;
}

.course-item:hover {
    transform: translateX(5px);
    border-color: #4e73df;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Info Items */
.info-item label {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #858796;
    margin-bottom: 0.25rem;
}

/* Badges */
.badge {
    padding: 0.5em 1em;
    font-weight: 500;
}

.badge-info { background-color: #36b9cc; }
.badge-success { background-color: #1cc88a; }
.badge-light {
    background-color: #f8f9fc;
    color: #5a5c69;
}

/* Empty State */
.empty-state {
    padding: 2rem;
}

/* Border Colors */
.border-left-primary { border-left: 4px solid #4e73df; }
.border-left-success { border-left: 4px solid #1cc88a; }
.border-left-info { border-left: 4px solid #36b9cc; }
.border-left-warning { border-left: 4px solid #f6c23e; }

/* Card Labels */
.card-label {
    color: #858796;
    font-weight: 600;
    letter-spacing: 0.05em;
}

/* Buttons */
.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2e59d9;
}

.rounded-pill {
    border-radius: 50rem !important;
}
</style>
@endpush
@endsection