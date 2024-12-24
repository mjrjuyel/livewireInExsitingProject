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

                    <li class="breadcrumb-item active">Catring Food</li>
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
                            <a href="{{route('superadmin.cateringfood.add')}}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i> Add
                                Catring Food</a>
                        </div>
                    </div>

                    <div class="">
                        <table class="table table-centered text-center border" id="">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">Total Quantity</th>
                                    <th class="text-center">Per Lauch Cost</th>
                                    <th class="text-center">Total Cost</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allFood as $allFood)
                                <tr>
                                    <td>
                                        {{ $allFood->order_date->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $allFood->order_date->format('l') }}
                                    </td>
                                    <td>
                                      {{ $allFood->quantity }}
                                    </td>
                                    <td>
                                      {{ $allFood->per_cost }}
                                    </td>
                                    
                                    <td>
                                      {{ $allFood->total_cost }}
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item" href="{{ route('superadmin.cateringfood.view',Crypt::encrypt($allFood->id)) }}"><i class="mdi mdi-view-agenda"></i>View</a></li>
                                                <li><a class="dropdown-item" href="{{ route('superadmin.cateringfood.edit',Crypt::encrypt($allFood->id)) }}"><i class="mdi mdi-receipt-text-edit"></i>Edit</a></li>
                                                <li>
                                                    <form action="{{ route('superadmin.cateringfood.delete',Crypt::encrypt($allFood->id)) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="dropdown-item  text-danger" type="sumbit"><i class="mdi mdi-delete"></i>Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                 <tr >
                                     <td></td>
                                     <td class="text-bold text-dark text-end">Total Quantity :</td>
                                     <td class="text-bold text-info">{{$allFood->sum('quantity')}}</td>
                                     <td class="text-bold text-dark text-end">Total :</td>
                                     <td class="text-bold text-info">{{$allFood->sum('total_cost')}}</td>
                                     <td></td>
                                 </tr>
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
