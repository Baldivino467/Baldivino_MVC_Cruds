<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @push('styles')
    <style>
    /* Sidebar Base */
    .sidebar {
        min-height: 100vh;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        width: 250px !important;
    }

    /* Nav Items */
    .nav-item {
        margin: 5px 15px;
    }

    .nav-link {
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.8) !important;
        display: flex;
        align-items: center;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .nav-link i {
        font-size: 1.2rem;
        margin-right: 15px;
        width: 20px;
        text-align: center;
    }

    .nav-link span {
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Hover & Active States */
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff !important;
        transform: translateX(5px);
    }

    .nav-item.active .nav-link {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff !important;
    }

    /* Sidebar Brand */
    .sidebar-brand {
        padding: 20px 15px;
        margin-bottom: 10px;
    }

    .sidebar-brand-icon {
        display: flex;
        align-items: center;
    }

    .sidebar-brand-text {
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* Collapse Animation */
    .sidebar.toggled {
        width: 6.5rem !important;
        animation: collapseAnimation 0.3s ease forwards;
    }

    .sidebar.toggled .nav-link {
        justify-content: center;
        padding: 15px;
    }

    .sidebar.toggled .nav-link span {
        display: none;
    }

    .sidebar.toggled .nav-link i {
        margin: 0;
        font-size: 1.4rem;
    }

    .sidebar.toggled .sidebar-brand-text {
        display: none;
    }

    @keyframes collapseAnimation {
        from { width: 250px; }
        to { width: 6.5rem; }
    }

    /* Toggle Button */
    #sidebarToggle {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px auto;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #sidebarToggle:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    /* Updated styles for student sidebar */
    .nav-link {
        padding: 12px 20px;
        margin: 4px 15px;
        color: rgba(255, 255, 255, 0.8) !important;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .nav-link i {
        font-size: 1.1rem;
        margin-right: 12px;
        width: 20px;
        text-align: center;
    }

    .nav-link span {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .nav-link:hover {
        color: #ffffff !important;
        transform: translateX(5px);
    }

    .nav-item.active .nav-link {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.1);
    }

    /* Sidebar Brand Adjustments */
    .sidebar-brand {
        padding: 1.5rem 1rem;
    }

    .sidebar-brand-icon i {
        font-size: 1.5rem;
    }

    .sidebar-brand-text span {
        font-size: 1.1rem;
        font-weight: 600;
    }

    /* Toggle Button */
    #sidebarToggle {
        background: rgba(255, 255, 255, 0.1);
        width: 35px;
        height: 35px;
        margin: 15px auto;
    }

    #sidebarToggle:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Divider */
    .sidebar-divider {
        margin: 1rem 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    </style>
    @endpush
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" 
            style="background: #6C5DD3; border-radius: 0 25px 25px 0;">

            @if(Auth::user()->role == 'admin')
                <!-- Admin Brand -->
                <div class="sidebar-brand d-flex align-items-center mb-4">
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-user-shield text-white"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">
                        <span class="text-white">ADMIN</span>
                    </div>
                </div>

                <!-- Admin Navigation Items -->
                <li class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs('admin.students')) active @endif">
                    <a class="nav-link" href="{{ route('admin.students') }}">
                        <i class="fas fa-users"></i>
                        <span>Students</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs('admin.subjects')) active @endif">
                    <a class="nav-link" href="{{ route('admin.subjects') }}">
                        <i class="far fa-file-alt"></i>
                        <span>Subjects</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs('admin.enrollments')) active @endif">
                    <a class="nav-link" href="{{ route('admin.enrollments') }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Enrollments</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs('admin.grades')) active @endif">
                    <a class="nav-link" href="{{ route('admin.grades') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Grades</span>
                    </a>
                </li>

            @else
                <!-- Student Brand -->
                <div class="sidebar-brand d-flex align-items-center mb-4">
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">
                        <span class="text-white">STUDENT</span>
                    </div>
                </div>

                <!-- Student Navigation Items -->
                <li class="nav-item @if(request()->routeIs('student.dashboard')) active @endif">
                    <a class="nav-link" href="{{ route('student.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Student Dashboard</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs('profile.edit')) active @endif">
                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs('student.view-grades')) active @endif">
                    <a class="nav-link" href="{{ route('student.view-grades') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>View Grades</span>
                    </a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Single Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Title in Navbar -->
                    <h1 class="h3 mb-0 text-gray-800 ml-3">@yield('title')</h1>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->email }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Baldivino MVC</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>