@extends('layouts.superAdmin')
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
                <h4 class="font-18 mb-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Employe</a></li>

                    <li class="breadcrumb-item ">Leave</li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   <span class="text-info">{{$parseDate->format('M-Y') }} Month History</span>
                    <div class="">
                        <table class="table table-centered text-center" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Leave For</th>
                                    <th class="text-center">Total Leave Request</th>
                                    <th class="text-center">Total Paid</th>
                                    
                                    <th class="text-center">Total Un-Paid</th>
                                    <th class="text-center">Leave Status</th>
                                    <th class="text-center">Start to End Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leavehistory as $leavehistory)
                                <tr>
                                    <td>
                                        @if($leavehistory->leave_type_id != 0)
                                        {{$leavehistory->leavetype->type_title}}
                                        @else
                                        Other Reason
                                        @endif
                                    </td>

                                    @if($leavehistory->total_unpaid + $leavehistory->total_paid <= 1) 
                                    <td class="text-danger">
                                        {{ $leavehistory->total_unpaid + $leavehistory->total_paid }} Day
                                    </td>
                                    @else 
                                    <td class="text-danger">
                                        {{ $leavehistory->total_unpaid + $leavehistory->total_paid }} Days
                                    </td>
                                    @endif

                                        @if($leavehistory->total_paid <= 1) 
                                        <td>
                                            @if($leavehistory->total_paid !== null)
                                            {{ $leavehistory->total_paid}} Day
                                            @else
                                            0 Day
                                            @endif
                                        </td>
                                        @else 
                                        <td>
                                            {{ $leavehistory->total_paid }} Days
                                        </td>
                                        @endif
                                    
                                    @if($leavehistory->total_unpaid <= 1) 
                                    <td class="text-danger">
                                       @if($leavehistory->total_unpaid !== null)
                                        {{ $leavehistory->total_unpaid}} Day
                                        @else
                                        0 Day
                                        @endif
                                    </td>
                                    @else 
                                    <td class="text-danger">
                                        {{ $leavehistory->total_unpaid }} Days
                                    </td>
                                    @endif

                                     <td>
                                        @if($leavehistory->status == 1)
                                            <button type="button" class="btn btn-warning ">
                                                Pending
                                            </button>
                                            @elseif($leavehistory->status == 2)
                                            <button type="button" class="btn btn-primary " >
                                                Approve
                                            </button>
                                            @elseif($leavehistory->status == 3)
                                            <button type="button" class="btn btn-primary " >
                                                Reject
                                            </button>
                                            @elseif($leavehistory->status == 4)
                                            <button type="button" class="btn btn-primary " >
                                               Feedback
                                            </button>
                                        @endif
                                    </td>

                                        <td>
                                            {{ $leavehistory->start_date->format('d-M-Y') }} To {{ $leavehistory->end_date->format('d-M-Y') }}
                                        </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button"
                                                class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item"
                                                        href="{{ url('dashboard/leave/view/'.Crypt::encrypt($leavehistory->id)) }}"><i
                                                            class="mdi mdi-view-agenda"></i>View</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>

</div> <!-- container -->
@endsection

@section('js')
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net/js/dataTables.min.js"></script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js">
</script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-responsive/js/dataTables.responsive.min.js">
</script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
</script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-buttons/js/dataTables.buttons.min.js">
</script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js">
</script>

<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-buttons/js/buttons.print.min.js"></script>

<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-keytable/js/dataTables.keyTable.min.js">
</script>
<script src="{{asset('contents/admin')}}/assets//libs/datatables.net-select/js/dataTables.select.min.js">
</script>

<!-- Datatables init -->
<script src="{{asset('contents/admin')}}/assets//js/pages/table-datatable.js"></script>
@endsection
