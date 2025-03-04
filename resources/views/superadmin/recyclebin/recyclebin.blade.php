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

                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Recycle Bin</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    @if($activeEmploye <= 0)
                        <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                        <h6 class="text-muted text-uppercase mt-0">Total Deleted Employe</h6>
                        <h3 class="my-3" data-plugin="counterup">0</h3>
                    @else
                    <a href="{{route('portal.recycle.employe')}}">
                        <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                        <h6 class="text-muted text-uppercase mt-0">Total Deleted Employe</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$activeEmploye}}</h3>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    @if($dailyReport <= 0)
                        <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                        <h6 class="text-muted text-uppercase mt-0">Total Deleted Report</h6>
                        <h3 class="my-3" data-plugin="counterup">0</h3>
                    @else
                    <a href="{{route('portal.recycle.dailyreport')}}">
                        <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                        <h6 class="text-muted text-uppercase mt-0">Total Deleted Reports</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$dailyReport}}</h3>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('portal.leaveMonth',date('d-m-Y'))}}">
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
                    <a href="{{route('portal.leaveYear',date('d-m-Y'))}}">
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
                    <a href="{{route('portal.leave.pending')}}">
                        <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                        <h6 class="text-muted text-uppercase mt-0">Leave Request In Pending <span class="text-danger text-italic">{{date('Y')}}</h6>
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
                        <h6 class="text-muted text-uppercase mt-0">Leave Request Approved in <span class="text-danger text-italic">{{date('Y')}}</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInApproved}}</h3>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('portal.leave.cancled')}}">
                        <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                        <h6 class="text-muted text-uppercase mt-0">Leave Request Cancled in <span class="text-danger text-italic">{{date('Y')}}</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInCancled}}</h3>
                    </a>
                </div>
            </div>
        </div>

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
        </div> --}}
    </div> <!-- end row -->

</div> <!-- container -->

<!-- end Footer -->
@endsection
