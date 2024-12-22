<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Dashboard | SuperAdmin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="SupreoX" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('uploads/basic/'.$basic->favlogo)}}">
    <!-- Vendor css -->
    @include('layouts.partials.css.dashboardcss')
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- Sidenav Menu Start -->
        <div class="sidenav-menu">
            <!-- Brand Logo -->
            <a href="{{route('superadmin')}}" class="logo">
                <span class="logo-light">
                    <span class="logo-lg">
                    <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}" class=" img-fluid" style="width:60%; height:auto" alt="logo"></span>
                    <span class="logo-sm"> <img src="{{asset('uploads/basic/'.$basic->favlogo)}}" class=" img-fluid" style="width:100%; height:auto" alt="logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"> <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}"class=" img-fluid" style="width:60%; height:auto" alt="logo"></span>
                    <span class="logo-sm"> <img src="{{asset('uploads/basic/'.$basic->favlogo)}}"class="img-fluid" style="width:100%; height:auto;" alt="logo"></span>
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <button class="button-sm-hover">
                <i class="ti ti-circle align-middle"></i>
            </button>
            <!-- Full Sidebar Menu Close Button -->
            <button class="button-close-fullsidebar">
                <i class="ti ti-x align-middle"></i>
            </button>

            <div data-simplebar>
                <!--- Sidenav Menu -->
                <ul class="side-nav">
                    <li class="side-nav-title">Super Admin Navigation</li>

                    <li class="side-nav-item">
                        <a href="{{route('superadmin')}}" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarAdmin" aria-expanded="false" aria-controls="sidebarAdmin" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-account-star"></i></span>
                            <span class="menu-text"> Employees</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAdmin">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.employe.add')}}" class="side-nav-link">
                                        <span class="menu-text">Add Employee</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.employe')}}" class="side-nav-link">
                                        <span class="menu-text">All Employee</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarRole" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-account-check"></i></span>
                            <span class="menu-text">Role</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRole">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.role')}}" class="side-nav-link">
                                        <span class="menu-text">All Role</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.role.add')}}" class="side-nav-link">
                                        <span class="menu-text">Add Role</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDesignation" aria-expanded="false" aria-controls="sidebarDesignation" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-material-design"></i></span>
                            <span class="menu-text">Designation</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarDesignation">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.designation')}}" class="side-nav-link">
                                        <span class="menu-text">All Desigantion</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.designation.add')}}" class="side-nav-link">
                                        <span class="menu-text">Add Desigantion</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLeaveType" aria-expanded="false" aria-controls="sidebarLeaveType" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-emoticon-sick-outline"></i></span>
                            <span class="menu-text">Leave Type</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLeaveType">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.leavetype')}}" class="side-nav-link">
                                        <span class="menu-text">All Type</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.leavetype.add')}}" class="side-nav-link">
                                        <span class="menu-text">Add Type</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{route('superadmin.leave')}}" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                            <span class="menu-text"> Leave Application </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{route('superadmin.dailyreport')}}" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-notebook-edit"></i></span>
                            <span class="menu-text"> Daily Report </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarBasicSetting" aria-expanded="false" aria-controls="sidebarBasicSetting" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-octagram-edit-outline"></i></span>
                            <span class="menu-text">Settings</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarBasicSetting">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.basic')}}" class="side-nav-link">
                                        <span class="menu-text">Website</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.leavesetting')}}" class="side-nav-link">
                                        <span class="menu-text">Leave</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('superadmin.timezone')}}" class="side-nav-link">
                                        <span class="menu-text">Time Zone</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false" aria-controls="sidebarMultiLevel" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-card-multiple-outline"></i></span>
                            <span class="menu-text"> Multi Level </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarMultiLevel">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarSecondLevel" aria-expanded="false" aria-controls="sidebarSecondLevel" class="side-nav-link">
                                        <span class="menu-text"> Second Level </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarSecondLevel">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="javascript: void(0);" class="side-nav-link">
                                                    <span class="menu-text">Item 1</span>
                                                </a>
                                            </li>
                                            <li class="side-nav-item">
                                                <a href="javascript: void(0);" class="side-nav-link">
                                                    <span class="menu-text">Item 2</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarThirdLevel" aria-expanded="false" aria-controls="sidebarThirdLevel" class="side-nav-link">
                                        <span class="menu-text"> Third Level </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarThirdLevel">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="javascript: void(0);" class="side-nav-link">Item 1</a>
                                            </li>
                                            <li class="side-nav-item">
                                                <a data-bs-toggle="collapse" href="#sidebarFourthLevel" aria-expanded="false" aria-controls="sidebarFourthLevel" class="side-nav-link">
                                                    <span class="menu-text"> Item 2 </span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <div class="collapse" id="sidebarFourthLevel">
                                                    <ul class="sub-menu">
                                                        <li class="side-nav-item">
                                                            <a href="javascript: void(0);" class="side-nav-link">
                                                                <span class="menu-text">Item 2.1</span>
                                                            </a>
                                                        </li>
                                                        <li class="side-nav-item">
                                                            <a href="javascript: void(0);" class="side-nav-link">
                                                                <span class="menu-text">Item 2.2</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="side-nav-title">Logout</li>

                    <li class="side-nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="
                            side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-logout-variant"></i></span>
                            <span class="menu-text"> Logout </span>
                        </a>
                    </li>
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Sidenav Menu End -->

        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Brand Logo -->
                    <a href="{{route('dashboard')}}" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="{{asset('contents/admin')}}/assets/images/logo-light.png" class="img-fluid" alt="" style=" object-fit:cover;" alt="logo"></span>
                            <span class="logo-sm"><img src="{{asset('contents/admin')}}/assets/images/logo-sm-light.png" class="img-fluid" alt="" style="object-fit:cover;" alt="small logo"></span>
                        </span>

                        <span class="logo-dark">
                            <span class="logo-lg"><img src="{{asset('contents/admin')}}/assets/images/logo-dark.png" class="img-fluid" alt="" style="object-fit:cover;" alt="dark logo"></span>
                            <span class="logo-sm"><img src="{{asset('contents/admin')}}/assets/images/logo-sm.png" alt="small logo"></span>
                        </span>
                    </a>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="sidenav-toggle-button px-2">
                        <i class="mdi mdi-menu font-24"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="mdi mdi-menu font-22"></i>
                    </button>

                    <div class="d-none d-md-flex">
                        <form class="app-search">
                            <div class="app-search-box">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn btn-icon" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <!-- Light/Dark Toggle Button  -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" id="light-dark-mode" type="button">
                            <i class="ti ti-moon font-22"></i>
                        </button>
                    </div>
                    <!-- Email Dropdown -->
                    <div class="topbar-item">
                        <div class="dropdown position-relative">
                            <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-email-outline font-22"></i>
                                <span class="noti-icon-badge"></span>
                            </button>

                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
                                <div class="p-3 border-bottom bg-primary rounded-top-2">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 font-16 fw-medium text-white"> Notifications</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative z-2" style="max-height: 300px;" data-simplebar>
                                    <!-- item-->
                                
                                    
                                    <!-- item-->
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                                        <span class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0 me-3">
                                                <span class="avatar-title bg-success-subtle text-success rounded-circle font-22">
                                                    <iconify-icon icon="solar:wallet-money-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <span class="flex-grow-1 text-muted">
                                                You withdraw a <span class="fw-medium text-body"></span> by <span class="fw-medium text-body">New York ATM</span>
                                                <br />
                                                <span class="font-12">2h ago</span>
                                            </span>
                                            <span class="notification-item-close">
                                                <button type="button" class="btn btn-ghost-danger rounded-circle btn-sm btn-icon" data-dismissible="#notification-3">
                                                    <i class="mdi mdi-close font-16"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </div>
                                    
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item notification-item position-fixed z-2 bottom-0 text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                                @if(Auth::user()->image != '')
                                <img src="{{ asset('uploads/adminprofile/'.Auth::user()->image) }}" class="rounded-circle me-lg-2 d-flex img-fluid" style="width:35px; height:35px; object-fit:cover;"  alt="user-image">
                                @else
                                <img src="{{ asset('uploads/adminprofile/img.jpg')}}" class="rounded-circle me-lg-2 d-flex img-fluid" style="width:35px; height:35px; object-fit:cover;" alt="user-image">
                                @endif
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h6 class="my-0">{{ Auth::user()->name }}</h6>
                                </span>
                                <i class="mdi mdi-chevron-down d-none d-lg-block align-middle ms-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <div class="dropdown-header bg-primary mt-n3 rounded-top-2">
                                    <h6 class="text-overflow text-white m-0">Welcome ! </h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('superadmin.view.profile',Crypt::encrypt(Auth::user()->id) ) }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-cog"></i>
                                    <span>Profile</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout-variant"></i>
                                    <span>Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="page-content">
            @yield('superAdminContent')
            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {{strip_tags($basic->copyright)}}</span>
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
    </div>
    <!-- Vendor js -->
    @include('layouts.partials.js.dashboardjs')
</body>
</html>
