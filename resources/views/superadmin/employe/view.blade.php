@extends('layouts.superAdmin')

@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet">
<link href="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endsection

@section('superAdminContent')
@if(Session::has('success'))
<script type="text/javascript">
    swal({
        title: "Success!"
        , text: "{{ Session::get('success') }}"
        , icon: "success"
        , button: "OK"
        , timer: 5000
    , });

</script>
@endif
@if(Session::has('error'))
<script type="text/javascript">
    swal({
        title: "Opps!"
        , text: "{{ Session::get('error') }}"
        , icon: "error"
        , button: "OK"
        , timer: 5000
    , });

</script>
@endif

<div class="page-container">
    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0"> Dashboard Of: <span class="text-primary">{{$view->name}}</span></h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>

                    <li class="breadcrumb-item active">Employe</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    @php
                    $datetime1 = date_create($view->join_date->format('Y-m-d'));
                    $datetime2 = date_create(date('Y-m-d'));

                    // Calculates the difference between DateTime objects
                    $interval = date_diff($datetime1, $datetime2);
                    @endphp
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Joining : <span class="text-info">{{$view->join_date->format('Y-M-d')}}</span></h6>
                    <h3 class="my-3" style="font-size:25px;">{{$interval->format('%y y, %m m, %d d');}}</h3>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">His Life Time Leave<span class="text-danger text-italic"> :@if($view->join != ''){{$view->join_date->format('d-M-Y')}} to {{date('d-M-Y')}} @endif </span></h6>
                    <h3 class="my-3"><span data-plugin="counterup">{{$whole_approved_leave}}</span> Days</h3>
                </div>
            </div>
        </div>
        @php

        if($EmpEva == null){
        $end_date = new DateTime($view->join_date->format('Y-m-d'));
        $end_date->modify('+1 year');
        }

        if($EmpEva){
        $start_date = new DateTime($EmpEva->eva_last_date);
        }
        $totalEvaLeavePaid = $Evaleaves->sum('total_paid');
        $totalEvaLeaveUnPaid = $Evaleaves->sum('total_unpaid');

        $totalEvaLeave = $totalEvaLeavePaid + $totalEvaLeaveUnPaid;
        @endphp
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">

                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Evaluation Time<span class="text-danger text-italic">:
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Last Evalution Date :
                                    @if($EmpEva != ''){{$start_date->format('d-M-Y')}} @else @if($view->join_date != ''){{$view->join_date->format('d-M-Y')}} @endif @endif</li>
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
                        @if($totalEvaLeave < 1 ) <h3 class="my-3"><span data-plugin="counterup">{{$totalEvaLeave}}</span> Day</h3>
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
                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Leave Request In <span class="text-danger text-italic">{{date('F')}}</span></h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInMonth}}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">

                    <img src="{{asset('recruitment.svg')}}" class="float-end m-0 h2 text-muted" style="width:60px;">
                    <h6 class="text-muted text-uppercase mt-0">Leave Request In <span class="text-danger text-italic">{{date('Y')}}</h6>
                    <h3 class="my-3" data-plugin="counterup">{{$leaveRequestInYear}}</h3>

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
                    <h6 class="text-muted text-uppercase mt-0">Total Unpaid Days in <span class="text-danger text-italic">{{date('F')}}</span></h6>
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
                    <h6 class="text-muted text-uppercase mt-0">Total Unpaid Days in <span class="text-danger text-italic">{{date('Y')}}</span></h6>
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



    </div> <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">

                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>{{$view->name}}
                                        </h3>
                                    </div>

                                    <div class="col-md-2 text-end"><a href="{{route('portal.employe')}}" class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i>All Employe</a>
                                    </div>
                                    @can('All Employee Evaluation')
                                    <div class="col-md-2 text-center"><a href="{{route('admin.evaluation',Crypt::encrypt($view->id))}}" class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i>Evaluation History</a>
                                    </div>
                                    @endcan
                                    @can('All Employee Promotion')
                                    <div class="col-md-2 text-center"><a href="{{route('admin.promotion',Crypt::encrypt($view->id))}}" class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i> Promotion History</a>
                                    </div>
                                    @endcan
                                    @can('Edit User')
                                    <div class="col-md-2 text-center"><a href="{{route('portal.employe.edit',Crypt::encrypt($view->id))}}" class="btn btn-bg btn-primary btn_header"><i class="fa-solid fa-pen-to-square
                                            btn_icon"></i>Edit</a>
                                    </div>
                                    @endcan
                                </div>
                            </div>

                            <table class="table border view_table">
                                <tr>
                                    <td>Employe Name</td>
                                    <td>:</td>
                                    <td>{{ $view->name }}</td>
                                </tr>

                                <tr>
                                    <td>Employe Status</td>
                                    <td>:</td>
                                    <td>@if($view->status == 1)
                                        <button type="button" class="btn btn-warning ">
                                            Active
                                        </button>
                                        @elseif($view->status == 2)
                                        <button type="button" class="btn btn-primary ">
                                            Suspend
                                        </button>
                                        @elseif($view->status == 0)
                                        <button type="button" class="btn btn-warning">
                                            Recycle Bin
                                        </button>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Profile Picture</td>
                                    <td>:</td>
                                    <td>@if($view->image != '')
                                        <img src="{{ asset('uploads/employe/profile/'.$view->image) }}" class="img-fluid" alt="" style="width:200px; object-fit:cover;">
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employe Email</td>
                                    <td>:</td>
                                    <td>{{ $view->email }}</td>
                                </tr>

                                <tr>
                                    <td>Employe Addresss</td>
                                    <td>:</td>
                                    <td>{{ $view->address }}</td>
                                </tr>

                                <tr>
                                    <td>Designation</td>
                                    <td>:</td>
                                    <td>
                                        <span class="text-info"> {{ $activeDesig != '' ? $activeDesig->emp_desig->title : optional($view->emp_desig)->title}}</span>
                                        @can('Add Employee Promotion')
                                        <button class="btn btn-primary">
                                            <a href="#" class=" dropdown-item waves-effect waves-light text-white" data-bs-toggle="modal" data-bs-target="#promotion"><i class="mdi mdi-stairs-up"></i>Promotion</a></button>
                                        @endcan
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employe Joining Date</td>
                                    <td>:</td>
                                    <td>{{$view->join_date->format('d-M-Y')}}</td>
                                </tr>

                                <tr>
                                    <td>Employe Creator</td>
                                    <td>:</td>
                                    <td>{{optional($view->creator)->name}}</td>
                                </tr>


                                <tr>
                                    <td>Created At</td>
                                    <td>:</td>
                                    <td>{{formatDate($view->created_at)}}</td>
                                </tr>
                                <tr>
                                    <td>Edited At</td>
                                    <td>:</td>
                                    <td>@if($view->updated_at)
                                        {{formatDate($view->updated_at)}}
                                        @endif</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Employee Details</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-danger">Reporting Manager : {{optional($view->reporting)->name}}</li>
                                    <li class="list-group-item">Department : {{$activeDesig != '' ? $activeDesig->department->depart_name : optional($view->department)->depart_name}}</li>
                                    <li class="list-group-item">Designation : {{$activeDesig != '' ? $activeDesig->emp_desig->title : optional($view->emp_desig)->title}}</li>
                                    <li class="list-group-item">Employee Job Type : {{$activeDesig != '' ? $activeDesig->emp_type : $view->emp_type}}</li>
                                    <li class="list-group-item">Employee Salary : {{$activeDesig != '' ? $activeDesig->salary : 'Not Yet'}}</li>
                                    <li class="list-group-item text-info">Promotion Status : {{$activeDesig != '' ? $activeDesig->pro_status : '----'}}</li>
                                    <li class="list-group-item text-info">Employee Promotion Date : {{$activeDesig != '' ? $activeDesig->pro_date->format('d-M-Y') : $view->join_date->format('Y-M-d')}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Joining Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Joinig Date : {{ $view->join != null && $view->join != ' ' ? $view->join_date->format('d-M-Y') : 'yes'}}</li>
                                    <li class="list-group-item">Office Located In : {{optional($view->officeBranch)->branch_name}}</li>
                                    <li class="list-group-item">Office Id Card Number : {{$view->office_id_number}}</li>
                                    <li class="list-group-item">Work Schedule : {{$view->office_work_schedule}}</li>
                                    @if($view->resign)
                                    <li class="list-group-item">Work Schedule : {{$view->resign->format('d-M-Y')}}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h5 class="card-title">Evaluation</h5>
                                        </div>
                                        <div class="col-md-5 text-end">
                                            @can('Add Employee Evaluation')
                                            <button class="btn btn-primary"><a href="#" class=" dropdown-item waves-effect waves-light text-white" data-bs-toggle="modal" data-bs-target="#evaluation"><i class="mdi mdi-receipt-text-edit"></i> Renew</a>
                                            </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                @php
                                if($EmpEva == null){
                                $end_date = new DateTime($view->join_date->format('Y-m-d'));
                                $end_date->modify('+1 year');
                                }
                                @endphp
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Last Evaluation Date : @if($EmpEva != ''){{$EmpEva->eva_last_date}} @else {{$view->join_date->format('d-M-Y')}} @endif</li>
                                    <li class="list-group-item">Next Evaluation Date: @if($EmpEva != ''){{$EmpEva->eva_next_date}} @else {{$end_date->format('d-M-Y')}} @endif</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Contact Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Gender : {{$view->gender}}</li>
                                    <li class="list-group-item">Date Of Birth : @if($view->dob != ''){{ $view->dob->format('d-M-Y')}} @endif</li>
                                    <li class="list-group-item">Marriage Status : {{$view->marriage}}</li>
                                    <li class="list-group-item">Personal Number : <a href="tel:{{$view->phone}}">{{$view->phone}}</a></li>
                                    @if($view->phone2 != '')
                                    <li class="list-group-item">Personal Number : <a href="tel:{{$view->phone2}}">{{$view->phone2}}</a></li>
                                    @endif
                                    <li class="list-group-item">Email : <a href="mailto:{{$view->email}}">{{$view->email}}</a></li>
                                    @if($view->email2 != '')
                                    <li class="list-group-item">AlterNate Email : <a href="mailto:{{$view->email2}}">{{$view->email2}}</a></li>
                                    @endif

                                    <li class="list-group-item">Parmanent Address : {{$view->address}}</li>
                                    <li class="list-group-item">Present Address : {{$view->present}}</li>

                                    <h5 class="card-title text-info" style="padding:10px 0px 10px 15px;">Emergency Contact Information :-</h5>

                                    <li class="list-group-item">Emergency Contact Number : <a href="tel:{{$view->emer_contact}}">{{$view->emer_contact}}</a></li>

                                    @if($view->emer_name != '')
                                    <li class="list-group-item">Emergency Contact's Name : {{$view->emer_name}}</li>
                                    @endif
                                    @if($view->emer_relation != '')
                                    <li class="list-group-item">Emergency Relationship : {{$view->emer_relation}}</li>
                                    @endif

                                    @if($view->id_type == 'national_id')
                                    <li class="list-group-item">Identity Type : National Id</li>
                                    <li class="list-group-item">Id Number : {{$view->id_number}}</li>
                                    @elseif($view->id_type == 'ssn')
                                    <li class="list-group-item">Identity Type : Social Security Number</li>
                                    <li class="list-group-item">Id Number : {{$view->id_number}}</li>
                                    @elseif($view->id_type == 'driver_license')
                                    <li class="list-group-item">Identity Type : Driver License</li>
                                    <li class="list-group-item">Id Number : {{$view->id_number}}</li>
                                    @endif

                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Bank Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-info">Bank Name : {{optional($view->bankName)->bank_name}}</li>
                                    <li class="list-group-item">Branch Name : {{optional($view->bankBranch)->bank_branch_name}}</li>
                                    <li class="list-group-item">Account Name : {{$view->bank_account_name}}</li>
                                    <li class="list-group-item">Account Number : {{$view->bank_account_number}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Education and Skills</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Last Academic Degree : {{$view->rec_degree}}</li>
                                    <li class="list-group-item">Passing Year: {{$view->rec_year}}</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
</div>

</div> <!-- container -->

{{-- Evaluation  --}}
<div id="evaluation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Evaluate of {{$view->name}} Job Duration?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('admin.evaluation.insert')}}" method="post">
                @csrf
                <div class="modal-body modal_body">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group clearfix">
                                <label>Name<span class="text-danger">*</span> :</label>
                                <select type="text" class="form-control" name="employe">
                                    <option value="{{ $view->id }}">{{ $view->name }}</option>
                                </select>
                                @error('employe')
                                <small class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group clearfix">
                                <label>Last Evaluation Date<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" id="humanfd-datepicke" name="eva_last_date" value="" placeholder="select Start date">
                                @error('eva_last_date')
                                <small class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group clearfix">
                                <label>Next Evaluation Date<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" id="humanfd-datepicker" name="eva_next_date" value="" placeholder="Select End Date">
                                @error('eva_next_date')
                                <small class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

{{-- Promotion  --}}
<div id="promotion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upgrade {{$view->name}} Designation ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('admin.promotion.insert')}}" method="post">
                @csrf
                <div class="modal-body modal_body">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group clearfix">
                                <label>Name<span class="text-danger">*</span> :</label>
                                <select type="text" class="form-control" name="employe">
                                    <option value="{{ $view->id }}">{{ $view->name }}</option>
                                </select>
                                @error('employe')
                                <small class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <select type="text" class="form-control" id="department" name="department">
                                    <option value="">Select One</option>
                                    @foreach($departs as $depart)
                                    <option value="{{ $depart->id }}" {{$view->depart_id == $depart->id || old('department') == $depart->id ? 'Selected' : '' }}>{{ $depart->depart_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department')
                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="mb-3">
                                <label class="form-label">Designation <span class="text-danger">*</span> :</label>
                                <select type="text" class="form-control" name="desig">
                                    @foreach($designs as $designation)
                                    <option value="{{$designation->id}}" {{ $view->desig_id == $designation->id || old('desig') == $designation->id ? 'Selected' : ''}}>{{$designation->title}}</option>
                                    @endforeach
                                </select>
                                @error('desig')
                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="mb-3">
                                <label class="form-label">Employement Type<span class="text-danger">*</span> :</label>
                                <select type="text" class="form-control" name="empType">
                                    <option value="">Select One</option>

                                    <option value="Full Time" @if($activeDesig !='' && $activeDesig->emp_type == 'Full Time') Selected @elseif($activeDesig == '' && $view->emp_type == 'Full Time') Selected @elseif(old('empType') == 'Full Time') Selected @endif>Full Time </option>

                                    <option value="Part Time" @if($activeDesig !='' && $activeDesig->emp_type == 'Part Time') Selected @elseif($activeDesig == '' && $view->emp_type == 'Part Time') Selected @elseif(old('empType') == 'Part Time') Selected @endif>Part Time</option>

                                    <option value="Freelance" @if($activeDesig !='' && $activeDesig->emp_type == 'Freelance') Selected @elseif($activeDesig == '' && $view->emp_type == 'Freelance') Selected @elseif(old('empType') == 'Freelance') Selected @endif>Frelance</option>

                                    <option value="Contract" @if($activeDesig !='' && $activeDesig->emp_type == 'Contract') Selected @elseif($activeDesig == '' && $view->emp_type == 'Contract') Selected @elseif(old('empType') == 'Contract') Selected @endif>Contract</option>

                                    <option value="Internship" @if($activeDesig !='' && $activeDesig->emp_type == 'Internship') Selected @elseif($activeDesig == '' && $view->emp_type == 'Internship') Selected @elseif(old('empType') == 'Internship') Selected @endif>Internship</option>

                                    <option value="Remote" @if($activeDesig !='' && $activeDesig->emp_type == 'Remote') Selected @elseif($activeDesig == '' && $view->emp_type == 'Remote') Selected @elseif(old('empType') == 'Remote') Selected @endif>Remote</option>

                                    <option value="Hybrid" @if($activeDesig !='' && $activeDesig->emp_type == 'Hybrid') Selected @elseif($activeDesig == '' && $view->emp_type == 'Hybrid') Selected @elseif(old('empType') == 'Hybrid') Selected @endif>Hybrid</option>

                                </select>
                                @error('empType')
                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group clearfix">
                                <label for="salary">Salary<span class="text-danger">*</span> :</label>
                                <input class="required form-control" id="salary" value="{{$activeDesig != '' ? $activeDesig->salary : old('salary')}}" name="salary" type="number">
                                @error('salary')
                                <small class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group clearfix">
                                <label for="salary">Created At<span class="text-danger">*</span> :</label>
                                <input class="required form-control" id="humanfd-datepic" value="{{$activeDesig != '' ? $activeDesig->pro_date->format('Y-m-d') : old('created_at')}}" name="created_at" type="date">
                                @error('created_at')
                                <small class="form-text text-warning">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <fieldset class="row">
                                <legend class="col-sm-6 pt-0">Status*:</legend>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="gender1" {{ old('status') == 'Promoted' ? 'checked' : '' }} value="Promoted">
                                        <label class="form-check-label" for="gender1">
                                            Promoted
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="gender2" value="Demoted" {{ old('status') == 'Demoted' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender2">
                                            Demoted
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="gender3" value="Unchanged" Checked>
                                        <label class="form-check-label" for="gender3">
                                            Unchanged
                                        </label>
                                    </div>
                                    @error('status')
                                    <small class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>
                    </div><!-- end row -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $('body').ready(function() {
        $('#department').on('change', function() {
            var id = $(this).val();

            $.ajax({
                url: "{{url('/get_designation/')}}/" + id
                , type: "get"
                , success: function(data) {
                    $('select[name="desig"]').empty();
                    $.each(data, function(key, data) {
                        $('select[name="desig"]').append('<option value="' + data.id + '">' + data.title + '</option>');
                    })
                }
            })
        });
    });

</script>
@endsection

@section('js')
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/js/custom.js"></script>

@endsection
