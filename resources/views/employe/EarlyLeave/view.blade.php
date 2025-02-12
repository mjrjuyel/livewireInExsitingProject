@extends('layouts.employe')
@section('content')
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
                <h4 class="font-18 mb-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">Early Leave</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>!{{$view->employe->emp_name}}!
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <table class="table border view_table">
                                <tr>
                                    <td>Early Leave Status</td>
                                    <td>:</td>
                                    <td>
                                        @if($view->status == 1)
                                        <button type="button" class="btn btn-warning">
                                            Pending
                                        </button>
                                        @elseif($view->status == 2)
                                        <button type="button" class="btn btn-primary">
                                            Approve
                                        </button>
                                        @elseif($view->status == 3)
                                        <button type="button" class="btn btn-danger">
                                            Reject
                                        </button>
                                        @elseif($view->status == 4)
                                        <button type="button" class="btn btn-primary">
                                            FeedBack
                                        </button>
                                        @if($leave->status == 4 || $leave->status == 1)
                                        <a class="btn btn-primary" href="{{ url('dashboard/earlyleave/edit/'.Crypt::encrypt($view->id)) }}"><i class="mdi mdi-view-agenda"></i>Edit</a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>

                                @if($view->comments != '')
                                <tr>
                                    <td>Reply From Admin</td>
                                    <td>:</td>
                                    <td>
                                        <span class=" btn-warning ">
                                            {{$view->comments}}
                                        </span>
                                        
                                    </td>
                                </tr>
                                @endif

                                <tr>
                                    <td>Submit By</td>
                                    <td>:</td>
                                    <td>
                                        {{$view->employe->emp_name}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Type</td>
                                    <td>:</td>
                                    <td class="text-danger">
                                        @if($view->leave_type != 0)
                                        {{$view->leavetype->type_title}}
                                        @else
                                        Other Reason
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Short Detail</td>
                                    <td>:</td>
                                    <td>
                                        {!! $view->detail !!}
                                    </td>
                               </tr>
                                <tr>
                                    <td> Early Leave Date</td>
                                    <td>:</td>

                                    <td>{{$view->leave_date->format('d-M-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Start Time to End Time</td>
                                    <td>:</td>
                                    <td>{{displayTime($view->start)}} To {{displayTime($view->end)}}</td>
                                </tr>

                                <tr>
                                    <td>Total Time (in hour)</td>
                                    <td>:</td>
                                    <td>{{convertTime($view->total_hour)}} Hours</td>
                                </tr>

                                @if($view->total_unpaid != '')
                                <tr>
                                    <td>Total Un-Paid</td>
                                    <td>:</td>
                                    @if($view->total_unpaid <= 1) <td class="text-danger">
                                        @if($view->total_unpaid !== null)
                                        {{ $view->total_unpaid}}Day
                                        @else
                                        0 Day
                                        @endif
                                        </td>
                                        @else
                                        <td class="text-danger">
                                            {{ $view->total_unpaid }}Days
                                        </td>
                                        @endif
                                </tr>
                                @endif

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
                                        @endif
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
</div>

</div> <!-- container -->
@endsection
