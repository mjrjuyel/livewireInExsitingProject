@extends('layouts.superAdmin')
@section('superAdminContent')
@if(Session::has('success'))
<script type="text/javascript">
swal({
    title: "Success!",
    text: "{{ Session::get('success') }}",
    icon: "success",
    button: "OK",
    timer: 5000,
});
</script>
@endif
@if(Session::has('error'))
<script type="text/javascript">
swal({
    title: "Opps!",
    text: "{{ Session::get('error') }}",
    icon: "error",
    button: "OK",
    timer: 5000,
});
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Leave</li>
                </ol>
            </div>
        </div>
    </div>
    @php
    use Carbon\Carbon;
        $preYear = new DateTime($parseDate);
        $preYear->modify(' -1 year');

        $nextYear = new DateTime($parseDate);
        $nextYear->modify(' +1 year');
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-3">
                      <a href="{{route('superadmin.leaveYear',$preYear->format('d-m-Y'))}}" class="btn btn-dark">Previous Year {{$preYear->format('Y')}}</a>
                     </div>

                     <div class="col-2 offset-2">
                      <strong>Total Leave Request in <span class="text-info"> {{$parseDate->format('Y')}}</span></strong>
                     </div>
                     
                     <div class="col-5 text-end">
                      <a href="{{route('superadmin.leaveYear',$nextYear->format('d-m-Y'))}}" class="btn btn-dark">Next Year {{$nextYear->format('Y')}}</a>
                     </div>
                    </div>
                    <div class="">
                        <table class="table table-centered text-center" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Submit By</th>
                                    <th class="text-center">Leave Type</th>
                                    <th class="text-center">Leave Reason</th>
                                    <th class="text-center">Total Leave Request</th>
                                    <th class="text-center">Total Paid</th>
                                    <th class="text-center">Total UnPaid</th>
                                    <th class="text-center">Start To End</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alldata as $data)
                                <tr>

                                   <td>
                                        {{ $data->employe->emp_name }}
                                    </td>

                                    <td>
                                        {{ $data->leavetype->type_title }}
                                    </td>

                                    <td>
                                        {{ $data->reason }}
                                    </td>

                                    @if($data->total_unpaid + $data->total_paid <= 1) 
                                    <td class="text-danger">
                                        {{ $data->total_unpaid + $data->total_paid }}Day
                                    </td>
                                    @else 
                                    <td class="text-danger">
                                        {{ $data->total_unpaid + $data->total_paid }}Days
                                    </td>
                                    @endif

                                   @if($data->total_paid <= 1) 
                                    <td>
                                        {{ $data->total_paid }}Day
                                    </td>
                                    @else 
                                    <td>
                                        {{ $data->total_paid }}Days
                                    </td>
                                    @endif

                                    @if($data->total_unpaid <= 1) 
                                    <td class="text-danger">
                                        @if($data->total_unpaid == 1)
                                        {{ $data->total_unpaid }}Day
                                        @else
                                        0 Day
                                        @endif
                                    </td>
                                    @else 
                                    <td class="text-danger">
                                        {{ $data->total_unpaid }}Days
                                    </td>
                                    @endif

                                        <td>
                                            {{ $data->start_date->format('d-M-Y') }} To {{ $data->end_date->format('d-M-Y') }}
                                        </td>
                                    
                                    <td>
                                        @if($data->status == 1)
                                        <button type="button" class="btn btn-warning ">
                                            Pending
                                        </button>
                                        @elseif($data->status == 2)
                                        <button type="button" class="btn btn-primary " >
                                            Approved
                                        </button>
                                        @elseif($data->status == 3)
                                        <button type="button" class="btn btn-primary " >
                                            Cancled
                                        </button>
                                        @elseif($data->status == 4)
                                        <button type="button" class="btn btn-primary " >
                                           Feedback
                                        </button>
                                        @endif
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
                                                        href="{{ url('superadmin/leave/view/'.Crypt::encrypt($data->id)) }}"><i
                                                            class="mdi mdi-view-agenda"></i>View</a></li>
                                                    <form action="{{ url('superadmin/leave/delete/'.$data->slug) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item  text-danger" type="sumbit"><i
                                                                class="mdi mdi-receipt-text-edit"></i>Delete</button>
                                                    </form>
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
<script src="{{ asset('contents/admin') }}/assets/libs/datatables.net/js/dataTables.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js">
</script>
<script src="{{ asset('contents/admin') }}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
</script>
<script src="{{ asset('contents/admin') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js">
</script>

<!-- Datatables init -->
<script src="{{ asset('contents/admin') }}/assets/js/pages/table-datatable.js"></script>

<script src="{{ asset('contents/admin') }}/assets/libs/@adactive/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/mohithg-switchery/switchery.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/jquery.quicksearch/jquery.quicksearch.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

    <script src="{{ asset('contents/admin') }}/assets/js/pages/form-advanced.js"></script>
@endsection