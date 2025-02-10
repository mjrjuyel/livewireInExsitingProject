@extends('layouts.superAdmin')
@section('superAdminContent')

@section('css')

@endsection

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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Daily Report</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('superadmin.dailyreport.searchname')}}" method="">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">Search by Name: </label>
                                <select class="form-control" data-toggle="select2" name="id" data-placeholder="Choose ...">
                                    @foreach($name as $name)
                                    <option value="">Select Employee Name</option>
                                    <option value="{{$name->submit_by}}">{{$name->employe->emp_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($alldata->count() != null)
                            <div class="col-4" style="margin-top: 20px;">
                                <button class="btn btn-danger" type="submit"><span class="mdi mdi-magnify" style="font-size:24px;"></span></button>
                            </div>
                            @endif
                            <div class="col-2">
                                <label class="form-label">Search by Year: </label>
                                <select class="form-control" data-toggle="select2" id="yearSearch" data-placeholder="Choose ...">
                                    @foreach($dates as $date)
                                    <option value="">Select Year</option>
                                    <option value="{{$date->submit_date->format('Y')}}">{{$date->submit_date->format('Y')}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="mt-5">
                        <table class="table table-centered text-center" id="productTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Submit By</th>
                                    <th class="text-center">Report Date</th>
                                    <th class="text-center">Submited Date</th>
                                    <th class="text-center">Text</th>
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
                                        {{ $data->submit_date->format('d-M-Y') }}
                                    </td>

                                    <td>
                                        {{ formatDate($data->created_at) }}
                                    </td>


                                    <td>
                                        {!! Str::words($data->detail,15) !!}
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                @can('View Daily-Report')
                                                <li><a class="dropdown-item" href="{{ url('superadmin/dailyreport/view/'.$data->slug) }}"><i class="mdi mdi-eye-circle-outline">
                                                        </i>View</a></li>
                                                </li>
                                                @endcan
                                                @can('Soft Delete Daily-Report')
                                                <li>
                                                    <a href="#" id="softDel" class="dropdown-item waves-effect waves-light text-danger" data-id="{{$data->id}}" data-bs-toggle="modal" data-bs-target="#softDelete"><i class="mdi mdi-delete-alert">
                                                        </i>Delete</a>
                                                </li>
                                                @endcan
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

{{-- delete modal --}}
{{-- soft delete MOdal  --}}
<div id="softDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete A Report </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('superadmin.dailyreport.softdelete')}}" method="post">
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
    $(document).ready(function() {
        $('#datatable').DataTable({
            ordering: false // Disables ordering for all columns
        });

        $('#yearSearch').on('change', function() {
            let year = $(this).val();
            if (year) {
                window.location.href = "{{url('/superadmin/dailyreport/searchYear/')}}?name=" + year;
            }
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
