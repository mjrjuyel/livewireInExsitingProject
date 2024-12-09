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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

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
                        <table class="table table-centered text-center" id="">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Submit By</th>
                                    <th class="text-center">Leave Type</th>
                                    <th class="text-center">Leave Reason</th>
                                    <th class="text-center">Leave Start date</th>
                                    <th class="text-center">Request For</th>
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
                                        {{ $data->leave_type }}
                                    </td>
                                    <td>
                                        {{ $data->reason }}
                                    </td>
                                    <td>
                                        {{ $data->start_date->format('d-M-Y') }}
                                    </td>
                                    <td>
                                        {{ $data->total_day }} Days
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
                                                            class="uil-table"></i>View</a></li>
                                                    <form action="{{ url('superadmin/leave/delete/'.$data->slug) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item  text-danger" type="sumbit"><i
                                                                class="uil-trash-alt"></i>Delete</button>
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