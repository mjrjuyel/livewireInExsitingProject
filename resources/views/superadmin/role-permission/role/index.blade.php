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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Role</li>
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
                            <a href="{{route('superadmin.role.add')}}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i> Add
                                Role
                            </a>      
                        </div>
                    </div>

                    <div class="">
                        <table class="table table-centered text-center" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Role Name</th>
                                    <th class="text-center text-danger">Role As A SuperAdmin Dashboard</th>
                                    <th class="text-center text-danger">Permissions</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        {{ $role->name }}
                                    </td>

                                    
                                    <td class="text-danger">
                                        @foreach($role->users as $user)
                                        <span class="badge bg-secondary">{{$user->name}}</span>
                                        @endforeach
                                    </td>

                                    <td class="text-danger">
                                        @foreach($role->permissions as $permission)
                                        <span class="badge bg-secondary">{{$permission->name}}</span>
                                        @endforeach
                                    </td>


                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item" href="{{ route('superadmin.role.view',Crypt::encrypt($role->id)) }}"><i class="mdi mdi-view-agenda"></i>View</a></li>
                                                 <li><a class="dropdown-item" href="{{ route('superadmin.role.edit',Crypt::encrypt($role->id)) }}"><i class="mdi mdi-receipt-text-edit"></i>Edit</a></li>

                                                @if(Auth::user()->role_id == 1)
                                                   <li><a href="#" id="softDel" class="dropdown-item waves-effect waves-light text-danger" data-id="{{$role->id}}"      data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="mdi mdi-delete-alert">
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

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete a Role </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('superadmin.role.delete')}}" method="post">
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
