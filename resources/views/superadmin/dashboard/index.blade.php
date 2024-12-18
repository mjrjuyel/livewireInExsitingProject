@extends('layouts.superAdmin')
@section('superAdminContent')
<div class="page-container">

    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0">Dashboard SuperAdmin</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>

                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.employe')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Active Employe</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$activeEmploye}}</h3>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.employe')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Role</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$role}}</h3>
                    
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.employe')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Leave Request In <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInMonth}}</h3>
                    
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.employe')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Leave Request In <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInYear}}</h3>
                    
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-chart float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Average Price</h6>
                    <h3 class="my-3">$<span data-plugin="counterup">15.9</span></h3>
                    <span class="badge bg-danger me-1"> 0% </span> <span class="text-muted">From previous
                        period</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Product Sold</h6>
                    <h3 class="my-3" data-plugin="counterup">1,890</h3>
                    <span class="badge bg-warning me-1"> +89% </span> <span class="text-muted">Last
                        year</span>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

</div> <!-- container -->

<!-- end Footer -->
@endsection