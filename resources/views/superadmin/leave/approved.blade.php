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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                        @if($data->leave_type_id != 0)
                                        {{$data->leavetype->type_title}}
                                        @else
                                        Other Reason
                                        @endif
                                    </td>

                                    <td>
                                        {!!  Str::words($data->reason,20) !!}
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
                                        @else
                                        <button type="button" class="btn btn-warning">
                                            Cancle
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
                                                        href="{{ url('superadmin/leave/view/'.$data->slug) }}"><i
                                                            class="mdi mdi-view-agenda"></i>View</a></li>
                                                 @if(Auth::user()->role_id == 1)
                                                   <li><a href="#" id="softDel" class="dropdown-item waves-effect waves-light text-danger" data-id="{{$data->id}}"      data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="mdi mdi-delete-alert">
                                                        </i>Delete</a>
                                                   </li>
                                                @endif
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
{{-- soft delete MOdal  --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete an Employee Leave Request Data </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('superadmin.leave.delete')}}" method="post">
            @method('delete')
                @csrf
                <div class="modal-body modal_body">
                    <h5 class="font-16">Are You Sure Want to Delete ?</h5>
                    <input type="hidden" name="id" id="modal_id" value="">
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
    $(document).ready(function () {
        $('#datatable').DataTable({
            ordering: false // Disables ordering for all columns
        });
    });
</script>
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