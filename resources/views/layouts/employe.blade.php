<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Dashboard | Employe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="SupreoX" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('uploads/basic/'.$basic->favlogo)}}">

    {{-- partial Css --}}
    @include('layouts.partials.css.dashboardcss')
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- Sidenav Menu Start -->
        <div class="sidenav-menu">

            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"> <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}" class=" img-fluid" style="width:60%; height:auto" alt="logo"></span>
                    <span class="logo-sm"> <img src="{{asset('uploads/basic/'.$basic->favlogo)}}" class=" img-fluid" style="width:100%; height:auto;" alt="logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"> <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}" class=" img-fluid" style="width:60%; height:auto" alt="logo"></span>
                    <span class="logo-sm"> <img src="{{asset('uploads/basic/'.$basic->favlogo)}}" class=" img-fluid" style="width:100%; height:auto;" alt="logo"></span>
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
                    <li class="side-nav-title">General Navigation Bar</li>

                    <li class="side-nav-item">
                        <a href="{{ route('dashboard',Crypt::encrypt(Auth::guard('employee')->user()->id)) }}" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-title">Extra Pages</li>

                    {{-- <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarAdmin" aria-expanded="false" aria-controls="sidebarAdmin" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-account-star"></i></span>
                            <span class="menu-text"> Employees</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAdmin">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="#" class="side-nav-link">
                                        <span class="menu-text">All Employee</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}

                    {{-- <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarRole" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-puzzle-outline"></i></span>
                            <span class="menu-text"> Admin Role</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarRole">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="#" class="side-nav-link">
                                        <span class="menu-text">All Role</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="#" class="side-nav-link">
                                        <span class="menu-text">Add Role</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDailyReport" aria-expanded="false" aria-controls="sidebarDailyReport" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-chart-arc"></i></span>
                            <span class="menu-text">Daily Report</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarDailyReport">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('dashboard.dailyreport') }}" class="side-nav-link">
                                        <span class="menu-text">Reports</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('dashboard.dailyreport.add') }}" class="side-nav-link">
                                        <span class="menu-text">Submit Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLeave" aria-expanded="false" aria-controls="sidebarLeave" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                            <span class="menu-text"> Leave Application</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLeave">
                            <ul class="sub-menu">
                                @php
                                $check = App\Models\Leave::where('emp_id',Auth::guard('employee')->user()->id)->where('status','!=','1')->latest('id')->first();
                                @endphp

                                <li class="side-nav-item">
                                    <a href="{{ route('dashboard.leave.add') }}" class="side-nav-link">
                                        <span class="menu-text">Request Form</span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ url('/dashboard/leave/history/'.Crypt::encrypt(Auth::guard('employee')->user()->id)) }}" class="side-nav-link">
                                        <span class="menu-text">My History</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <hr>
                    @php
                    $user = App\Models\User::where('email',Auth::guard('employee')->user()->email)->first();
                    @endphp
                    @if($user)
                    <li class="side-nav-item">
                        <form action="{{ url('/dashboard/asAdmin/'.Crypt::encrypt($user->id)) }}" method="post">
                            @csrf
                            @method('post')
                            <button class="btn side-nav-link menu-text text-primary" type="sumbit"><i class=" menu-icon text-primary mdi mdi-account-switch-outline"></i>Switch As @foreach($user->roles as $role) {{$role->name}} @endforeach</button>
                        </form>
                    </li>
                    @endif

                    <hr>
                    <li class="side-nav-title">Logout</li>

                    <li class="side-nav-item">
                        <a href="{{ route('employe.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-logout-variant"></i></span>
                            <span class="menu-text text-danger"> Logout </span>
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
                    <a href="{{ route('dashboard') }}" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="{{ asset('contents/admin') }}/assets/images/logo-light.png" alt="logo"></span>
                            <span class="logo-sm"><img src="{{ asset('contents/admin') }}/assets/images/logo-sm-light.png" alt="small logo"></span>
                        </span>

                        <span class="logo-dark">
                            <span class="logo-lg"><img src="{{ asset('contents/admin') }}/assets/images/logo-dark.png" alt="dark logo"></span>
                            <span class="logo-sm"><img src="{{ asset('contents/admin') }}/assets/images/logo-sm.png" alt="small logo"></span>
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

                    @php
                        $notification = auth('employee')->user()->unreadNotifications;
                    @endphp

                    <div class="topbar-item">
                        <div class="dropdown position-relative">
                            <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-email-outline font-22"></i>
                                @if($notification->count('id') >= 1)
                                <span class="noti-icon-badge"></span>
                                @endif
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
                                    @if($notification->count('id') >=1)
                                    @foreach ($notification as $item)

                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                                        <span class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0 me-3">
                                                <span class="avatar-title bg-success-subtle text-success rounded-circle font-22">
                                                    <iconify-icon icon="solar:wallet-money-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <a href="{{url('dashboard/leave/view/'.Crypt::encrypt($item->data['leave_id']))}}">
                                                <span class="flex-grow-1 text-muted">
                                                    You have a notification <span class="fw-medium text-body"></span><span class="fw-medium text-body">From Admin</span>
                                                    <br />
                                                    <span class="font-12"></span>
                                                </span>
                                            </a>
                                            <span class="notification-item-close">
                                                <form action="{{url('/notificationAdmin/remove/'.$item->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-ghost-danger rounded-circle btn-sm btn-icon" data-dismissible="#notification-3" type="sumbit"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </span>

                                        </span>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                                        <span class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0 me-3">
                                                <span class="avatar-title bg-success-subtle text-success rounded-circle font-22">
                                                    <span class="mdi mdi-flask-empty"></span>
                                                </span>
                                            </div>
                                            <span class="flex-grow-1 text-muted">
                                                Empty Notification <span class="fw-medium text-body"></span><span class="fw-medium text-body"></span>
                                                <br />
                                                <span class="font-12"></span>
                                            </span>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                                @if(Auth::guard('employee')->user()->emp_image != '')
                                <img src="{{ asset('uploads/employe/profile/'.Auth::guard('employee')->user()->emp_image) }}" class="rounded-circle me-lg-2 d-flex img-fluid" style="width:35px; height:35px; object-fit:cover;" alt="user-image">
                                @else
                                <img src="{{ asset('uploads/adminprofile/img.jpg')}}" class="rounded-circle me-lg-2 d-flex img-fluid" style="width:35px; height:35px; object-fit:cover;" alt="user-image">
                                @endif
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h6 class="my-0">{{ Auth::guard('employee')->user()->emp_name }}</h6>
                                </span>
                                <i class="mdi mdi-chevron-down d-none d-lg-block align-middle ms-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <div class="dropdown-header bg-primary mt-n3 rounded-top-2">
                                    <h6 class="text-overflow text-white m-0">Welcome ! {{Auth::guard('employee')->user()->emp_name}}</h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('dashboard.employe.view',Auth::guard('employee')->user()->emp_slug ) }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-cog"></i>
                                    <span>Profile</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="{{ route('employe.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout-variant"></i>
                                    <span>Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('employe.logout') }}" method="POST" style="display: none;">
                                    @csrf
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


            @yield('content')

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
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
        <!-- Footer Start -->
    </div>
    <!-- Vendor js -->

    <script src="{{ asset('contents/admin') }}/assets/js/vendor.min.js"></script>
    <!-- App js -->
    @yield('js')
    <script src="{{ asset('contents/admin') }}/assets/js/app.js"></script>
    <!--Morris Chart-->
    <script src="{{ asset('contents/admin') }}/assets/libs/morris.js/morris.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/raphael/raphael.min.js"></script>
    <!-- Projects Analytics Dashboard App js -->
    <script src="{{ asset('contents/admin') }}/assets/js/pages/dashboard-sales.js"></script>

</body>


<!-- Mirrored from coderthemes.com/uplon/layouts/{{ route('dashboard') }} by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2024 09:35:15 GMT -->

</html>
