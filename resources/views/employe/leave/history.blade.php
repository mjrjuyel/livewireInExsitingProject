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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

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

                    <div class="">
                        <table class="table table-centered text-center" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Leave For</th>
                                    <th class="text-center">Total Day</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leavehistory as $leavehistory)
                                <tr>
                                    <td>
                                        {{ $leavehistory->leavetype->type_title }}
                                    </td>

                                    @if($leavehistory->total_day <= 1) 
                                    <td>
                                        {{ $leavehistory->total_day }}Day
                                    </td>
                                    @else 
                                    <td>
                                        {{ $leavehistory->total_day }}Days
                                    </td>
                                    @endif
                                        <td>
                                            {{ $leavehistory->start_date->format('d-M-Y') }}
                                        </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item" href="{{ url('/dashboard/leave/view/'.$leavehistory->slug) }}"><i class="uil-table"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="uil-edit"></i>Edit</a></li>
                                                    <li>
                                                        <form action="" method="post">
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
