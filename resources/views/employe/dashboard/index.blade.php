@extends('layouts.employe')
@section('content')
<div class="page-container">

    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0">Dashboard of {{$view->emp_name}}</h4><div>Date : <span>{{date('d-M-Y')}}</span></div><div>Time : <span id="time"></span></div>
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
                    <h6 class="text-muted text-uppercase mt-0">Joining : <span class="text-info">{{$view->emp_join->format('Y-M-d')}}</span></h6>
                    <h3 class="my-3" style="font-size:25px;">{{$interval->format('%y Y %m M %d D %R');}}</h3>
                   
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="{{route('superadmin.employe')}}">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">His Life Time Leave<span class="text-danger text-italic"> : {{$view->emp_join->format('Y-m-d')}} to {{date('Y-m-d')}}</span></h6>
                    <h3 class="my-3"><span data-plugin="counterup">{{$whole_approved_leave}}</span>Days</h3>
                    
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
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Paid Remaining In <span class="text-danger text-italic">{{date('F')}}</span></h6>
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
                    <h6 class="text-muted text-uppercase mt-0">Paid Remaining In <span class="text-danger text-italic">{{date('Y')}}</span></h6>
                    @if($remainYear >= 1 )
                      @if($remainYear  >= 2)
                      <h3 class="my-3" ><span data-plugin="counterup">{{$remainYear}}</span>Days</h3>
                      @else
                       <h3 class="my-3"><span data-plugin="counterup">{{$remainYear}}</span>Day</h3>
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
                    <h6 class="text-muted text-uppercase mt-0">Total Unpaid Days in <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    @if($unpaidRemainingMonth != null)
                      @if($unpaidRemainingMonth  >= 2)
                      <h3 class="my-3" ><span data-plugin="counterup">{{$unpaidRemainingMonth}}</span>Days</h3>
                      @else
                       <h3 class="my-3"><span data-plugin="counterup">{{$unpaidRemainingMonth}}</span>Day</h3>
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
                    <h6 class="text-muted text-uppercase mt-0">Total Unpaid Days in <span class="text-danger text-italic">{{date('Y')}}</span></h6>
                    @if($unpaidRemainingYear != null)
                      @if($unpaidRemainingYear  >= 2)
                      <h3 class="my-3" ><span data-plugin="counterup">{{$unpaidRemainingYear}} </span>Days +</h3>
                      @else
                       <h3 class="my-3"><span data-plugin="counterup">{{$unpaidRemainingYear}} </span>Day +</h3>
                      @endif
                    @else
                      <h3 class="my-3 text-danger">Not Yet</h3>
                    @endif
                </div>
            </div>
        </div>

        

    </div> <!-- end row -->

</div> <!-- container -->


<script>
      const timeDiv = document.getElementById("time");

      function updateTime() {
        const now = new Date();
        const formattedTime = now.toLocaleTimeString();
        timeDiv.textContent = formattedTime;
      }

      setInterval(updateTime, 1000);
    </script>
@endsection