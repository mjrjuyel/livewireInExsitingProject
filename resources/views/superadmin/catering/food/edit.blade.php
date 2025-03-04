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

                    <li class="breadcrumb-item active">Catering Food</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header bg-dark">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card_header"><i class="mdi mdi-office-building-plus header_icon"></i>Catering Food Update
                                </h3>
                            </div>

                            <div class="col-md-4 text-end"><a href="{{route('portal.cateringfood')}}"
                                    class="btn btn-bg btn-primary btn_header ">
                                    <i class="mdi mdi-emoticon-sick-outline btn_icon"></i>All Catering Food</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('portal.cateringfood.update')}}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-3 offset-1">

                            <input type="hidden" name="id" value="{{$edit->id}}">
                                <div class="mb-3">
                                    <label class="form-label">Order Date<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" id="humanfd-datepicker" class="form-control" name="date" value="{{$edit->order_date->format('F d, Y')}}"
                                        placeholder="Date">
                                    @error('date')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Total Quantity<span class="text-danger">* </span>:
                                    </label>
                                    <input type="number" id="humanfd-datepicker" class="form-control" name="quantity" value="{{$edit->quantity}}"
                                        placeholder="Enter Total Quantity">
                                    @error('quantity')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Cost Per Quantity<span class="text-danger">* </span>:
                                    </label>
                                    <input type="number"  class="form-control" name="perCost" value="{{$edit->per_cost}}"
                                        placeholder="Each Meal Price">
                                    @error('perCost')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-6 offset-5">
                           <button type="submit" class="btn btn-primary">Update</button>
                           </div>
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>
</div>

</div> <!-- container -->

<!--end Footer -->
@endsection