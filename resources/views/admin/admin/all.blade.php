@extends('layouts.admin')
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

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

                    <div class="">
                        <table class="table table-centered text-center" id="">
                            <thead class="table-light">
                                <tr>
                                    <th class="all">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Admin Pic</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Role</th>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                    <th class="text-center">Dashboard login</th>
                                    @endif

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admin as $admin)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck2">
                                            <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $admin->name }}
                                    </td>

                                    <td>
                                        @if($admin->image != '')
                                        <img src="{{ asset('uploads/admin/profile/'.$admin->image) }}" class="img-fluid" alt="" style="width:50px; height:100px; object-fit:cover;">
                                        @endif
                                    </td>
                                    <td>{{optional($admin->designation)->title}}</td>
                                    <td>
                                        {{$admin->email}}
                                    </td>

                                    <td>
                                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                        <a href="{{route('dashboard.superAdmin')}}" class="btn btn-primary">
                                            {{optional($admin->role)->role_name}}
                                        </a>
                                        @else
                                        <button class="btn btn-primary disable">
                                            {{optional($admin->role)->role_name}}
                                        </button>
                                        @endif
                                    </td>

                                    @if(Auth::user()->role_id == 1|| Auth::user()->role_id == 2)
                                    <td>
                                        @if($admin->role_id == 1 || $admin->role_id == 2)
                                            @if(Auth::user()->role_id == $admin->role_id)
                                            <a href="{{route('dashboard.superAdmin')}}" class="btn btn-primary">
                                                Log In
                                            </a>
                                            @else
                                            <button class="btn btn-warning disabled">
                                                Sorry!
                                            </button>
                                            @endif
                                        @else
                                        <button class="btn btn-warning disable">
                                            Sorry! He HasNo Access!
                                        </button>
                                        @endif
                                    </td>
                                    @endif

                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item" href="{{ url('/dashboard/admin/view/'.$admin->slug) }}"><i class="uil-table"></i>View</a></li>
                                                <li><a class="dropdown-item" href="{{ url('dashboard/admin/edit/'.$admin->slug) }}"><i class="uil-edit"></i>Edit</a></li>
                                                <li>
                                                    <form action="{{ url('/dashboard/admin/delete/'.$admin->slug) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item  text-danger" type="sumbit"><i class="uil-trash-alt"></i>Delete</button>
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

<!-- Footer Start -->
<footer class="footer">
    <div class="page-container">
        <div class="row">
            <div class="col-md-12 text-center">
                <script>
                    document.write(new Date().getFullYear())

                </script> © Uplon - By <span class="fw-semibold text-decoration-underline text-primary">Coderthemes</span>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div>
<!-- end Footer -->
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
