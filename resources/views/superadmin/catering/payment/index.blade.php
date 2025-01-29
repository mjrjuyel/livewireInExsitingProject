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

                    <li class="breadcrumb-item active">Catring Payment History</li>
                </ol>
            </div>
        </div>
    </div>
    @php
    use Carbon\Carbon;
        $parseMonth = new DateTime($search_date->format('d-m-Y'));

        $preYear = new DateTime($search_date->format('d-m-Y'));
        $preYear->modify('-1 year');
        $nextYear = new DateTime($search_date->format('d-m-Y'));
        $nextYear->modify('+1 year');

    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-2">
                            <a href="{{route('superadmin.cateringpayment.add')}}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i> Add </a>

                        </div>
                        <div class="col-8">
                            <div class="row text-center">
                                <div class="row text-center">
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-1-Y'))}}" class="btn btn-primary">Jan</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-2-Y'))}}" class="btn btn-primary">Feb</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-3-Y'))}}" class="btn btn-primary">March</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-4-Y'))}}" class="btn btn-primary">April</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-5-Y'))}}" class="btn btn-primary">May</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-6-Y'))}}" class="btn btn-primary">June</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-7-Y'))}}" class="btn btn-primary">July</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-8-Y'))}}" class="btn btn-primary">Aug</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-9-Y'))}}" class="btn btn-primary">Sept</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-10-Y'))}}" class="btn btn-primary">Oct</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-11-Y'))}}" class="btn btn-primary">Nov</a>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{url('superadmin/cateringpayment/'.$parseMonth->format('d-12-Y'))}}" class="btn btn-primary">Dec</a>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-4">
                                        <a href="{{url('superadmin/cateringpayment/year/'.$preYear->format('d-m-Y'))}}" class="btn btn-danger">{{$preYear->format('Y')}}</a>
                                    </div>
                                    <div class="col-4">
                                        <a href="{{url('superadmin/cateringpayment/year/'.$parseMonth->format('d-m-Y'))}}" class="btn btn-primary">{{$parseMonth->format('Y')}}</a>
                                    </div>
                                    <div class="col-4">
                                        <a href="{{url('superadmin/cateringpayment/year/'.$nextYear->format('d-m-Y'))}}" class="btn btn-danger">{{$nextYear->format('Y')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <table class="table table-centered text-center border" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Day</th>
                                        <th class="text-center">Payment</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allPayment as $allPayment)
                                    <tr>
                                        <td>
                                            {{ $allPayment->payment_date->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ $allPayment->payment_date->format('l') }}
                                        </td>
                                        <td>
                                            {{ $allPayment->payment }}
                                        </td>


                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li><a class="dropdown-item" href="{{ route('superadmin.cateringpayment.view',Crypt::encrypt($allPayment->id)) }}"><i class="mdi mdi-view-agenda"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('superadmin.cateringpayment.edit',Crypt::encrypt($allPayment->id)) }}"><i class="mdi mdi-receipt-text-edit"></i>Edit</a></li>
                                                    <li>
                                                    <a href="#" id="delete" data-id="{{$allPayment->id}}" class="dropdown-item waves-effect waves-light text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="mdi mdi-delete-alert"></i>Delete</a>
                                                   </li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-bold text-dark text-end">Total Payment :</td>
                                        <td class="text-bold text-info">{{number_format($totalPayment,'2','.','')}}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-primary">Current Month : {{$parseMonth->format('F')}}</div>
                            <div class="text-primary">Current Year : {{$parseMonth->format('Y')}}</div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
    </div>

</div> <!-- container -->

{{--delete MOdal  --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-primary">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Parmanent !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('superadmin.cateringpayment.delete')}}" method="post">
                @csrf
                @method('delete')
                <div class="modal-body modal_body">
                    <h5 class="font-16">Are You Sure Want to Delete ?</h5>
                    <input type="hidden" name="id" id="modal_id" value="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

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
