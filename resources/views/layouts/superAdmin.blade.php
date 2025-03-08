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
            <a href="{{route('portal')}}" class="logo">
                <span class="logo-light">
                    <span class="logo-lg">
                        <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}" class=" img-fluid" style="width:60%; height:auto" alt="logo"></span>
                    <span class="logo-sm"> <img src="{{asset('uploads/basic/'.$basic->favlogo)}}" class=" img-fluid" style="width:100%; height:auto" alt="logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"> <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}" class=" img-fluid" style="width:60%; height:auto" alt="logo"></span>
                    <span class="logo-sm"> <img src="{{asset('uploads/basic/'.$basic->favlogo)}}" class="img-fluid" style="width:100%; height:auto;" alt="logo"></span>
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
                
                    <li class="side-nav-title">Navigation Bar</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#employeActivity" aria-expanded="false" aria-controls="employeActivity" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-account-hard-hat"></i></span>
                            <span class="menu-text">My Dashboard</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="employeActivity">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('dashboard') }}" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                                        <span class="menu-text"> Dashboard </span>
                                    </a>
                                </li>

                                <li class="side-nav-title">My Daily Duty</li>

                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarDailyReportemployee" aria-expanded="false" aria-controls="sidebarDailyReportemployee" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-chart-arc"></i></span>
                                        <span class="menu-text">Daily Report</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarDailyReportemployee">
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
                                    <a data-bs-toggle="collapse" href="#sidebarLeaveEmployee" aria-expanded="false" aria-controls="sidebarLeaveEmployee" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                                        <span class="menu-text"> Leave Application</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarLeaveEmployee">
                                        <ul class="sub-menu">
                                            @php
                                            $check = App\Models\Leave::where('emp_id',Auth::user()->id)->where('status','!=','1')->latest('id')->first();
                                            @endphp

                                            <li class="side-nav-item">
                                                <a href="{{ route('dashboard.leave.add') }}" class="side-nav-link">
                                                    <span class="menu-text">Application Form</span>
                                                </a>
                                            </li>
                                            <li class="side-nav-item">
                                                <a href="{{ url('/dashboard/leave/history/'.Crypt::encrypt(Auth::user()->id)) }}" class="side-nav-link">
                                                    <span class="menu-text">History</span>
                                                </a>
                                            </li>

                                            <li class="side-nav-item">
                                                <a href="{{ route('dashboard.earlyleave.add') }}" class="side-nav-link">
                                                    <span class="menu-text">Early Leave Form</span>
                                                </a>
                                            </li>

                                            <li class="side-nav-item">
                                                <a href="{{ route('dashboard.earlyleave') }}" class="side-nav-link">
                                                    <span class="menu-text">Early Leave History</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                     <hr>

                    @can('Admin Overview')
                    <li class="side-nav-item">
                        <a href="{{route('portal')}}" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-view-dashboard"></i></span>
                            <span class="menu-text">Admin Overview</span>
                        </a>
                    </li>
                    @endcan

                    @can('User Management')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarAdmin" aria-expanded="false" aria-controls="sidebarAdmin" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-shield-crown"></i></span>
                            <span class="menu-text">User Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAdmin">
                            <ul class="sub-menu">
                                @can('All User')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarAdminAdd" aria-expanded="false" aria-controls="sidebarAdminAdd" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-shield-crown"></i></span>
                                        <span class="menu-text"> Users</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarAdminAdd">
                                        <ul class="sub-menu">

                                            <li class="side-nav-item">
                                                <a href="{{route('portal.employe')}}" class="side-nav-link">
                                                    <span class="menu-text">All User</span>
                                                </a>
                                            </li>

                                            @can('Add User')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.employe.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add User</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan

                                @can('All Role')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarRole" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-account-check"></i></span>
                                        <span class="menu-text">Role</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarRole">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.role')}}" class="side-nav-link">
                                                    <span class="menu-text">All Role</span>
                                                </a>
                                            </li>

                                            @can('Add Role')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.role.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add Role</span>
                                                </a>
                                            </li>
                                            @endcan
                                            
                                            @can('All Permission')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.permission')}}" class="side-nav-link">
                                                    <span class="menu-text">All Permission</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan

                                {{-- @can('All Permission')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarPermission" aria-expanded="false" aria-controls="sidebarPermission" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-security"></i></span>
                                        <span class="menu-text">Permission</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarPermission">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.permission')}}" class="side-nav-link">
                                                    <span class="menu-text">All Permission</span>
                                                </a>
                                            </li>

                                            @can('Add')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.permission.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add New Permission</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan --}}
                            </ul>
                        </div>
                    </li>
                    @endcan
                    {{-- --}}
                    @can('Leave')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLeave" aria-expanded="false" aria-controls="sidebarLeave" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-airplane-takeoff"></i></span>
                            <span class="menu-text"> Leave </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLeave">
                            <ul class="sub-menu">
                                @can('Leave Application List')
                                <li class="side-nav-item">
                                    <a href="{{route('portal.leave')}}" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-airplane-takeoff"></i></span>
                                        <span class="menu-text">All Leave Application </span>
                                    </a>
                                </li>
                                @endcan

                                @can('All Early Leave')
                                    <li class="side-nav-item">
                                    <a href="{{route('admin.earlyleave')}}" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-battery-off-outline"></i></span>
                                        <span class="menu-text">Early Leave Application </span>
                                    </a>
                                </li>
                                @endcan
                                

                                @can('Add Manual Leave')
                                <li class="side-nav-item">
                                    <a href="{{route('portal.leave.add')}}" class="side-nav-link">
                                        <span class="menu-icon"><i class="mdi mdi-battery-off-outline"></i></span>
                                        <span class="menu-text">Add Leave Manually</span>
                                    </a>
                                </li>
                                @endcan

                                @can('Leave Type')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarLeaveType" aria-expanded="false" aria-controls="sidebarLeaveType" class="side-nav-link">
                                        <span class="menu-text">Leave Type</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarLeaveType">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.leavetype')}}" class="side-nav-link">
                                                    <span class="menu-text">All</span>
                                                </a>
                                            </li>

                                            @can('Leave Type Add')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.leavetype.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add New</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcan

                    @can('Daily-Report')
                    <li class="side-nav-item">
                        <a href="{{route('portal.dailyreport')}}" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-notebook-edit"></i></span>
                            <span class="menu-text"> Daily Report </span>
                        </a>
                    </li>
                    @endcan

                    @can('Department & Designation')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDepartment" aria-expanded="false" aria-controls="sidebarDepartment" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-slash-forward-box"></i></span>
                            <span class="menu-text"> Department </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarDepartment">
                            <ul class="sub-menu">

                                @can('Departments')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarDepartmentList" aria-expanded="false" aria-controls="sidebarDepartmentList" class="side-nav-link">
                                        <span class="menu-text">Department</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarDepartmentList">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.department')}}" class="side-nav-link">
                                                    <span class="menu-text">All Department</span>
                                                </a>
                                            </li>

                                            @can('Add Department')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.department.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add Department</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan

                                @can('Designation')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarDesignation" aria-expanded="false" aria-controls="sidebarDesignation" class="side-nav-link">
                                        {{-- <span class="menu-icon"><i class="mdi mdi-material-design"></i></span> --}}
                                        <span class="menu-text">Designation</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarDesignation">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.designation')}}" class="side-nav-link">
                                                    <span class="menu-text">All Desigantion</span>
                                                </a>
                                            </li>

                                            @can('Add Designation')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.designation.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add Desigantion</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcan

                    @can('Office Branch')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarBranchName" aria-expanded="false" aria-controls="sidebarBranchName" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-office-building-plus"></i></span>
                            <span class="menu-text">Office Branch</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarBranchName">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('portal.office_branch')}}" class="side-nav-link">
                                        <span class="menu-text">All Branch</span>
                                    </a>
                                </li>
                                @can('Add Bank Branch')
                                <li class="side-nav-item">
                                    <a href="{{route('portal.office_branch.add')}}" class="side-nav-link">
                                        <span class="menu-text">Add Branch</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcan

                    @can('Bank & Branch')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarBank" aria-expanded="false" aria-controls="sidebarBank" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-bank"></i></span>
                            <span class="menu-text"> Bank Detail </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarBank">
                            <ul class="sub-menu">
                                @can('Bank Detail')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarBankName" aria-expanded="false" aria-controls="sidebarBankName" class="side-nav-link">
                                        <span class="menu-text">Bank</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarBankName">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.bank_name')}}" class="side-nav-link">
                                                    <span class="menu-text">All Bank</span>
                                                </a>
                                            </li>

                                            @can('Add Bank Detail')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.bank_name.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add Bank</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('Bank Branch')
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarBankBranch" aria-expanded="false" aria-controls="sidebarBankBranch" class="side-nav-link">
                                        <span class="menu-text">Bank Branches</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarBankBranch">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.bank_branch')}}" class="side-nav-link">
                                                    <span class="menu-text">All Branch</span>
                                                </a>
                                            </li>
                                            @can('Add Bank Branch')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.bank_branch.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add Branch</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcan

                    @can('Catering')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCatering" aria-expanded="false" aria-controls="sidebarCatering" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-noodles"></i></span>
                            <span class="menu-text"> Catering </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCatering">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarFood" aria-expanded="false" aria-controls="sidebarFood" class="side-nav-link">
                                        <span class="menu-text">Food Order</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarFood">
                                        <ul class="sub-menu">
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.cateringfood')}}" class="side-nav-link">
                                                    <span class="menu-text">Order in {{date('F')}}</span>
                                                </a>
                                            </li>
                                            @can('Add Meal')
                                            <li class="side-nav-item">
                                                <a href="{{route('portal.cateringfood.add')}}" class="side-nav-link">
                                                    <span class="menu-text">Add Meal</span>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>

                                @can('Check Balance')
                                <li class="side-nav-item">
                                    <a href="{{route('portal.cateringpayment.checkbill')}}" class="side-nav-link">
                                        <span class="menu-icon">{{currencyChange()}}</span>
                                        <span class="menu-text"> Check Balance </span>
                                    </a>
                                </li>
                                @endcan
                                <li class="side-nav-item">

                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcan

                    @can('Setting')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarBasicSetting" aria-expanded="false" aria-controls="sidebarBasicSetting" class="side-nav-link">
                            <span class="menu-icon"><i class="mdi mdi-octagram-edit-outline"></i></span>
                            <span class="menu-text">Settings</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="collapse" id="sidebarBasicSetting">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{route('portal.basic')}}" class="side-nav-link">
                                        <span class="menu-text">Global Settings</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{route('portal.leavesetting')}}" class="side-nav-link">
                                        <span class="menu-text">Leave</span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{route('portal.email')}}" class="side-nav-link">
                                        <span class="menu-text">Email</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcan

                    @can('Recycle Bin')
                    <li class="side-nav-item">
                        <a href="{{route('portal.recycle')}}" class="side-nav-link">
                            <span class="menu-icon text-warning"><i class="mdi mdi-trash-can"></i></span>
                            <span class="menu-text text-warning"> Recyclebin </span>
                        </a>
                    </li>
                    @endcan

                    <hr>

                    <li class="side-nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="
                            side-nav-link">
                            <span class="menu-icon text-danger"><i class="mdi mdi-logout-variant"></i></span>
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
                    @php
                    $notification = auth()->user()->unreadNotifications;
                    @endphp
                    <!-- Email Dropdown -->
                 
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


                                    <!-- item-->
                                    @if($notificAdmin >=1)
                                    @foreach ($notification as $item)
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                                        <span class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0 me-3">
                                                <span class="avatar-title bg-success-subtle text-success rounded-circle font-22">
                                                    <iconify-icon icon="solar:wallet-money-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <a href="{{url('portal/leave/view/'.Crypt::encrypt($item->data['leave_id']))}}">
                                                <span class="flex-grow-1 text-muted">
                                                    You have a notification <span class="fw-medium text-body"></span> From <span class="fw-medium text-body"></span>
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
                                @if(Auth::user()->image != '')
                                <img src="{{ asset('uploads/employe/profile/'.Auth::user()->image) }}" class="rounded-circle me-lg-2 d-flex img-fluid" style="width:35px; height:35px; object-fit:cover;" alt="user-image">
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
                                <a href="{{ route('portal.employe.profile',Crypt::encrypt(Auth::user()->id) ) }}" class="dropdown-item notify-item">
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
