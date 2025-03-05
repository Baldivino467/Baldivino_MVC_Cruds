@extends('layouts.dashboardTemplate')

@section('title', 'View Grades')

@section('content')
<div class="container-fluid">
    <!-- Academic Profile -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Academic Profile</h6>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Student ID -->
                <div class="col-md-3">
                    <div class="p-4 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary text-white mr-3">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div>
                                <div class="small text-gray-500">STUDENT ID</div>
                                <div class="font-weight-bold">{{ $student->student_id ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course -->
                <div class="col-md-3">
                    <div class="p-4 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-success text-white mr-3">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <div class="small text-gray-500">COURSE</div>
                                <div class="font-weight-bold">{{ $student->course ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Year Level -->
                <div class="col-md-3">
                    <div class="p-4 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info text-white mr-3">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div>
                                <div class="small text-gray-500">YEAR LEVEL</div>
                                <div class="font-weight-bold">{{ $student->year_level ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Semester -->
                <div class="col-md-3">
                    <div class="p-4 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-warning text-white mr-3">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div>
                                <div class="small text-gray-500">SEMESTER</div>
                                <div class="font-weight-bold">{{ $enrollment->semester ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Report -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grade Report</h6>
        </div>
        <div class="card-body">
            @if(!$student || $grades->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">No Grades Available</h5>
                    <p class="text-gray-500 mb-0">Your grades will appear here once they are posted.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th class="text-center">Units</th>
                                <th class="text-center">Grade</th>
                                <th class="text-center">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalUnits = 0; $totalGradePoints = 0; @endphp
                            @foreach($grades as $grade)
                                @php 
                                    $totalUnits += $grade->subject->units;
                                    $totalGradePoints += ($grade->grade * $grade->subject->units);
                                @endphp
                                <tr>
                                    <td>{{ $grade->subject->subject_code }}</td>
                                    <td>{{ $grade->subject->name }}</td>
                                    <td class="text-center">{{ $grade->subject->units }}</td>
                                    <td class="text-center">{{ number_format($grade->grade, 2) }}</td>
                                    <td class="text-center">
                                        {{ $grade->grade <= 3.0 ? 'Passed' : 'Failed' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="2" class="font-weight-bold">Total</td>
                                <td class="text-center">{{ $totalUnits }}</td>
                                <td class="text-center" colspan="2">
                                    GWA: {{ $totalUnits > 0 ? number_format($totalGradePoints / $totalUnits, 2) : 'N/A' }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media print {
    .btn-primary {
        display: none;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection