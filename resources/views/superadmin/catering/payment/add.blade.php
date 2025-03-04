@extends('layouts.superAdmin')

@section('css')
<link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/libs/dropify/css/dropify.min.css" type="text/css" />
<link href="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endsection

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
                <h4 class="font-18 mb-0">Dashboard </h4>
                <div class='text-info'>Today is : {{date('d-M-Y')}}</div>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Catering Payment</li>
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
                                <h3 class="card_header"><i class="mdi mdi-cash header_icon"></i>Catering Payment
                                </h3>
                            </div>

                            @can('View Payment')
                            <div class="col-md-4 text-end"><a href="{{route('portal.cateringpayment')}}"
                                    class="btn btn-bg btn-primary btn_header ">
                                    <i class="mdi mdi-cash-clock btn_icon"></i>Previous Payment</a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <form action="{{route('portal.cateringpayment.insert')}}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-3 offset-3">

                                <div class="mb-3">
                                    <label class="form-label">Payment Date<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" id="humanfd-datepicker" class="form-control" name="date" value="{{now()->format('Y-m-d')}}"
                                        placeholder="Date">
                                    @error('date')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    @if($totalDue > 0)
                                    <label class="form-label">Your Current Due<span class="text-danger">  {{number_format($totalDue,'2','.','')}} </span>:
                                    </label>
                                    @else
                                     <label class="form-label">Already Your Paid Amount Is Extra Than Due : <span class="text-danger">  {{number_format($totalDue,'2','.','') * -1 }} </span>
                                    </label>
                                    @endif
                                    <label class="form-label">Payment<span class="text-danger">* </span>:
                                    </label>
                                    <input type="number" class="form-control" name="amount" value="{{old('totalLunch')}}"
                                        placeholder="Enter Amount">
                                    @error('quantity')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-6 offset-5">
                           <button type="submit" class="btn btn-primary">Pay Bill</button>
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

@section('js')
<script src="{{asset('contents/admin')}}/assets/libs/dropify/js/dropify.min.js"></script>
<!-- File Upload Demo js -->
<script src="{{asset('contents/admin')}}/assets/js/pages/form-fileupload.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/clockpicker/bootstrap-clockpicker.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Init js-->
<script src="{{asset('contents/admin')}}/assets/js/pages/form-pickers.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>

<script src="{{asset('contents/admin')}}/assets/libs/jquery-validation/jquery.validate.min.js"></script>

<!-- Wizard Form Demo js -->
<script src="{{asset('contents/admin')}}/assets/js/pages/form-wizard.js"></script>
@endsection