@extends('layouts.employe')
@section('content')
<div class="page-container">

    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">

                <h4 class="font-18 mb-0">Dashboard of {{$view->emp_name}}</h4>
                <div>Date : <span>{{date('d-M-Y | h:i:s A')}}</span></div>
                <div>Time : <span id="time"></span></div>
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
                    @php
                    $datetime1 = date_create($view->emp_join->format('Y-m-d'));
                    $datetime2 = date_create(date('Y-m-d'));

                    // Calculates the difference between DateTime objects
                    $interval = date_diff($datetime1, $datetime2);
                    @endphp
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Joining : <span class="text-info">@if($view->emp_join != ''){{ $view->emp_join->format('d-M-Y')}} @endif</span></h6>
                    <h3 class="my-3" style="font-size:25px;">{{optional($interval)->format('%y y, %m m, %d d');}}</h3>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">

                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">His Life Time Leave<span class="text-danger text-italic"> :@if($view->emp_join != ''){{$view->emp_join->format('d-M-Y')}} to {{date('d-M-Y')}} @endif </span></h6>
                    <h3 class="my-3"><span data-plugin="counterup">{{$whole_approved_leave}}</span> Days</h3>

                </div>
            </div>
        </div>

        @php

            if($EmpEva == null){
                $end_date = new DateTime($view->emp_join->format('Y-m-d'));
                $end_date->modify('+1 year');
                }

            if($EmpEva){
                $start_date = new DateTime($EmpEva->eva_last_date);
                }
            
            $totalEvaLeavePaid  = $Evaleaves->sum('total_paid');
            $totalEvaLeaveUnPaid  = $Evaleaves->sum('total_unpaid');

            $totalEvaLeave = $totalEvaLeavePaid + $totalEvaLeaveUnPaid;
        @endphp
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">

                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Evaluation Time<span class="text-danger text-italic">:
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Last Evalution Date :
                                    @if($EmpEva != ''){{$start_date->format('d-M-Y')}} @else @if($view->emp_join != ''){{$view->emp_join->format('d-M-Y')}} @endif @endif</li>
                                <li class="list-group-item">Next Evaluation Date:
                                    @if($EmpEva != ''){{$EmpEva->eva_next_date}} @else {{$end_date->format('d-M-Y')}} @endif</li>
                            </ul>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Total Leave Taken Between Evaluation Periods :</h6>
                    <h3 class="my-3">
                    @if($totalEvaLeave < 1 ) 
                        <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeave}}</span> Day</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeave}}</span> Days</h3>
                    @endif
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Paid Leave Between Evaluation:</h6>
                    @if($totalEvaLeavePaid != null)
                    @if($totalEvaLeavePaid >= 2)
                    <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeavePaid}}</span> Days</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeavePaid}}</span> Day</h3>
                    @endif
                    @else
                    <h3 class="my-3 text-danger">Not Yet</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total UnPaid Leave Between Evaluation:</h6>
                    @if($totalEvaLeaveUnPaid != null)
                    @if($totalEvaLeaveUnPaid >= 2)
                    <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeaveUnPaid}} </span> Days +</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeaveUnPaid}} </span> Day +</h3>
                    @endif
                    @else
                    <h3 class="my-3 text-danger">Not Yet</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    @php
                    $remainEvaluation = $defaultLeave->year_limit - $totalEvaLeave;
                    @endphp
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Paid Leave Remaining Between Evaluation Periods</span></h6>
                    @if($remainEvaluation >= 1 )
                        @if($remainEvaluation >= 2)
                        <h3 class="my-3"><span data-plugin="counterup">{{$remainEvaluation}}</span> Days</h3>
                        @else
                        <h3 class="my-3"><span data-plugin="counterup">{{$remainEvaluation}}</span> Day</h3>
                        @endif
                    @else
                        <h3 class="my-3 text-danger">Zero</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('dashboard.leave.historyMonth',date('d-m-Y'))}}">
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
                    <a href="{{route('dashboard.leave.historyYear',date('d-m-Y'))}}">
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
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Paid Leave Remaining In <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    @if($paidRemainingMonth != 0 && $paidRemainingMonth != null)
                    @if($paidRemainingMonth == 1)
                    <h3 class="my-3"><span data-plugin="counterup">2</span> Days</h3>
                    @elseif($paidRemainingMonth == 2)
                    <h3 class="my-3"><span data-plugin="counterup">1</span> Day</h3>
                    @elseif($paidRemainingMonth >= 3)
                    <h3 class="my-3"><span class="text-danger">Limit Reached</span></h3>
                    @endif
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">3</span> Days</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    @php
                    $remainYear = $defaultLeave->year_limit - $paidRemainingYear;
                    @endphp
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Paid Leave Remaining In <span class="text-danger text-italic">{{date('Y')}}</span></h6>
                    @if($remainYear >= 1 )
                    @if($remainYear >= 2)
                    <h3 class="my-3"><span data-plugin="counterup">{{$remainYear}}</span> Days</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$remainYear}}</span> Day</h3>
                    @endif
                    @else
                    <h3 class="my-3 text-danger">Out of Paid Leave</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Unpaid Leave Take in <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    @if($unpaidRemainingMonth != null)
                    @if($unpaidRemainingMonth >= 2)
                    <h3 class="my-3"><span data-plugin="counterup">{{$unpaidRemainingMonth}}</span> Days</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$unpaidRemainingMonth}}</span> Day</h3>
                    @endif
                    @else
                    <h3 class="my-3 text-danger">Not Yet</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Unpaid Leave in <span class="text-danger text-italic">{{date('Y')}}</span></h6>
                    @if($unpaidRemainingYear != null)
                    @if($unpaidRemainingYear >= 2)
                    <h3 class="my-3"><span data-plugin="counterup">{{$unpaidRemainingYear}} </span> Days +</h3>
                    @else
                    <h3 class="my-3"><span data-plugin="counterup">{{$unpaidRemainingYear}} </span> Day +</h3>
                    @endif
                    @else
                    <h3 class="my-3 text-danger">Not Yet</h3>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Total Early Leave in <span class="text-danger text-italic">{{date('M')}}</span></h6>
                    <h3 class="my-3">{{convertTime($earlyleave)}}</h3>
                
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

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    @if($totalReportSubmit < 0 )
                    <a href="{{ route('dashboard.dailyreport') }}">
                        <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Total Daily Report Submit <span class="text-danger text-italic"></span></h6>
                        <h3 class="my-3"><span data-plugin="counterup">{{$totalReportSubmit}} </span></h3>
                    </a>
                    @else
                        <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Total Daily Report Submit <span class="text-danger text-italic"></span></h6>
                        <h3 class="my-3 text-danger">Not Yet</h3>
                    @endif
                </div>
            </div>
        </div>
    </div> <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <h4 class="text-info">Special Off Day List</h4>
                <hr>
            </div>
            <div class="row">
                @foreach($filteredMonths as $month => $dates)
                <div class="col-md-3 col-xl-3">
                    @php
                    $convertMonth = new DateTime($month);
                    @endphp
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="mdi mdi-calendar-range float-end m-0 h2 text-muted"></i>
                            <h6 class="text-info text-uppercase">{{$convertMonth->format('F')}}</h6>
                            <span>Dates</span>
                            <ul class="list-group">

                                @foreach($dates as $date)
                                @php
                                $convert = new DateTime($date);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$convert->format('Y-m-d')}}
                                    <span class="badge badge-primary text-info badge-pill">{{$convert->format('D')}}</span>
                                </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> <!-- end row -->
        </div>
    </div>

</div> <!-- container -->


<script>
    const timeDiv = document.getElementById("time");

    const userTimezone = "{{ config('app.timezone') }}";

    function updateTime() {
        const now = new Date();
        const options = {
            timeZone: userTimezone
        };
        const formattedTime = now.toLocaleTimeString('en-US', options);
        timeDiv.textContent = formattedTime;
    }

    setInterval(updateTime, 1000);

</script>
@endsection
