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
        @can('All User')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('portal.employe')}}">
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
                    <a href="{{route('portal.role')}}">
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
                    <a href="{{route('portal.leaveMonth',date('d-m-Y'))}}">
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
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Days Approved In <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    <h3 class="my-3">
                    @if($leaveTotalDayApprovedInMonth < 1 ) 
                        <h3 class="my-3"><span data-plugin="counterup">{{$leaveTotalDayApprovedInMonth}}</span> Day</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$leaveTotalDayApprovedInMonth}}</span> Days</h3>
                    @endif
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('portal.leaveYear',date('d-m-Y'))}}">
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
                    <a href="{{route('portal.leave.pending')}}">
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
                    <a href="{{route('portal.leave.approved')}}">
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
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Days Approved In {{date('Y')}} :</h6>
                    <h3 class="my-3">
                    @if($leaveTotalDayApprovedInYear < 1 ) 
                        <h3 class="my-3"><span data-plugin="counterup">{{$leaveTotalDayApprovedInYear}}</span> Day</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$leaveTotalDayApprovedInYear}}</span> Days</h3>
                    @endif
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('portal.leave.cancled')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Request Cancelled in <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInCancled}}</h3>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Early Leave in <span class="text-danger text-italic">{{date('M')}}</span></h6>
                    <h3 class="my-3">{{convertTime($earlyleaveMonth)}}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Early Leave in <span class="text-danger text-italic">{{date('Y')}}</span></h6>
                    <h3 class="my-3">{{convertTime($earlyleaveYear)}}</h3>
                
                </div>
            </div>
        </div>
        @endcan

       @can('Catering')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('portal.cateringfood')}}">
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
                    <a href="{{route('portal.cateringpayment')}}">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Catering Payment in {{date('M')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$curTotalPay}}</h3>
                    </a>
                    
                </div>
            </div>
        </div>
        @endcan

       @can('Employee')
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('dashboard')}}">
                     <span class="mdi mdi-arrow-left-circle float-end m-0 h2 text-muted"></span>
                    <h6 class="text-info text-uppercase mt-0">Click On Me To Go:  My Dashboard</h6>
                    </a>
                </div>
            </div>
        </div>
        @endcan
    </div> <!-- end row -->
       
</div> <!-- container -->

<!-- end Footer -->
@endsection