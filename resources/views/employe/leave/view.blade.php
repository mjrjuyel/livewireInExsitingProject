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
                    <li class="breadcrumb-item">Employe</li>
                    <li class="breadcrumb-item active">Leave</li>
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
                                    <td>Leave Status</td>
                                    <td>:</td>
                                    <td>
                                        @if($view->status == 1)
                                        <button type="button" class="btn btn-warning ">
                                            Pending
                                        </button>
                                        @elseif($view->status == 2)
                                        <button type="button" class="btn btn-primary " >
                                            Approved
                                        </button>
                                        @elseif($view->status == 3)
                                        <button type="button" class="btn btn-primary " >
                                            Cancled
                                        </button>
                                        @elseif($view->status == 4)
                                        <button type="button" class="btn btn-primary " >
                                            FeedBack Mes
                                        </button>
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
                                        {{$view->leavetype->type_title}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Reason</td>
                                    <td>:</td>
                                    <td>
                                        {{$view->reason}}
                                    </td>
                                </tr>
                                <tr>
                                    <td> Leave Start to End</td>
                                    <td>:</td>

                                    <td>{{$view->start_date->format('d-M-Y')}} To {{$view->end_date->format('d-M-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Total leave</td>
                                    <td>:</td>

                                    @php
                                        $total_leave = $view->total_paid + $view->total_unpaid;
                                    @endphp

                                     @if($total_leave <= 1) 
                                    <td class="text-danger">
                                        {{ $total_leave }}Day
                                    </td>
                                    @else 
                                    <td class="text-danger">
                                        {{ $total_leave }}Days
                                    </td>
                                    @endif
                                </tr>

                                  

                                 @if($view->total_paid != '')
                                 <tr>
                                    <td>Total Paid</td>
                                    <td>:</td>
                                    @if($view->total_paid <= 1) 
                                    <td class="">
                                        @if($view->total_paid !== null)
                                        {{ $view->total_paid}}Day
                                        @else
                                        0 Day
                                        @endif
                                    </td>
                                    @else 
                                    <td class="">
                                        {{ $view->total_paid }}Days
                                    </td>
                                    @endif
                                 </tr>
                                 @endif

                                 @if($view->total_unpaid != '')
                                 <tr>
                                    <td>Total Unpaid</td>
                                    <td>:</td>
                                    @if($view->total_unpaid <= 1) 
                                    <td class="text-danger">
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
                                    <td>{{$view->created_at->format('d/M/y')}}</td>
                                </tr>
                                <tr>
                                    <td>Edited At</td>
                                    <td>:</td>
                                    <td>{{optional($view->updated_at)->format('d-m-Y | h:i:s A')}}</td>
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
