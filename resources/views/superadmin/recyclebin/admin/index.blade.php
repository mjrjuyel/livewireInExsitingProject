@extends('layouts.superAdmin')
@section('superAdminContent')
@if (Session::has('success'))
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
@if (Session::has('error'))
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

                    <li class="breadcrumb-item active">Admin</li>
                </ol>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="{{route('portal.employe.add')}}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i> Add
                                New Employe</a>
                        </div>
                    </div>
                    <div class="">
                        <table class="table table-centered text-center" id="datatable">
                            <thead class="table-light">
                                <tr>

                                    <th class="text-center">Name</th>
                                    <th class="text-center">Admin Pic</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Reporting Manager</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employe as $employe)
                                <tr>
                                    <td>
                                        {{ $employe->name }}
                                    </td>

                                    <td>
                                        @if ($employe->image != '')
                                        <img src="{{ asset('uploads/employe/profile/' . $employe->image) }}" class="img-fluid" alt="" style="width:50px; height:100px; object-fit:cover;">
                                        @endif
                                    </td>
                                    <td>{{ optional($employe->emp_desig)->title }}</td>
                                    <td>
                                        {{ $employe->email }}
                                    </td>

                                    <td>
                                        {{ optional($employe->reporting)->name }}
                                    </td>
                                    <td>
                                        @if($employe->status == 1)
                                        <button type="button" class="btn btn-primary ">
                                            Active
                                        </button>
                                        @elseif($employe->status == 2)
                                        <button type="button" class="btn btn-warning ">
                                            Suspend
                                        </button>
                                        @elseif($employe->status == 0)
                                        <button type="button" class="btn btn-danger">
                                            Recycle Bin
                                        </button>
                                        @endif
                                    </td>


                                    <td>

                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a href="#" id="restore" data-id="{{$employe->id}}" class="dropdown-item waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#restoreModal"><i class="mdi mdi mdi-file-restore">
                                                        </i>Restore</a></li>
                                                </li>
                                                <li><a href="#" id="delete" data-id="{{$employe->id}}" class="dropdown-item waves-effect waves-light text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="mdi mdi-delete-alert">
                                                        </i>Delete</a></li>
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

{{-- delete modal --}}
{{--delete MOdal  --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Parment Delete A Employee !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('admin.delete')}}" method="post">
                @csrf
                @method('delete')
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

{{-- Restore MOdal  --}}
<div id="restoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-primary">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Restore Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('portal.restore')}}" method="post">
                @csrf

                <div class="modal-body modal_body">
                    <h5 class="font-16">Are You Sure Want To Restore ?</h5>
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
    

</script>

@endsection


@section('js')

<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net/js/dataTables.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-responsive/js/dataTables.responsive.min.js">
</script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
</script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js">
</script>

<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-buttons/js/buttons.print.min.js"></script>

<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-keytable/js/dataTables.keyTable.min.js">
</script>
<script src="{{ asset('contents/admin') }}/assets//libs/datatables.net-select/js/dataTables.select.min.js"></script>

<!-- Datatables init -->
<script src="{{ asset('contents/admin') }}/assets//js/pages/table-datatable.js"></script>
@endsection
