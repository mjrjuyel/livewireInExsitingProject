@extends('layouts.superAdmin')
@section('superAdminContent')
<div class="page-container">

    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0">Admin Dashboard </h4>
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
        @can('Employee')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.employe')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Active Employees</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$activeEmploye}}</h3>
                    </a>
                </div>
            </div>
        </div>
        @endcan

        @can('All Role')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.role')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Role</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$role}}</h3>
                    
                    </a>
                </div>
            </div>
        </div>
        @endcan

        @can('Leave')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.leaveMonth',date('d-m-Y'))}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Request In <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInMonth}}</h3>
                    
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.leaveYear',date('d-m-Y'))}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Request In <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInYear}}</h3>
                    
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.leave.pending')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Request Pending In  <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInPending}}</h3>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.leave.approved')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Request Approved in <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInApproved}}</h3>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.leave.cancled')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Request Cancelled in <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInCancled}}</h3>
                    </a>
                </div>
            </div>
        </div>
        @endcan

       @can('Catering')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.cateringfood')}}">
                     <i class="icon-chart float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Catering Cost of {{date('M')}}</h6>
                    <h3 class="my-3"><span data-plugin="counterup">{{number_format($curFoodCost,'2','.','')}}</span></h3>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.cateringpayment')}}">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Catering Payment in {{date('M')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$curTotalPay}}</h3>
                    </a>
                    
                </div>
            </div>
        </div>
        @endcan
    </div> <!-- end row -->
       
</div> <!-- container -->

<!-- end Footer -->
@endsection