@extends('layouts.superAdmin')

@section('css')
<link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/libs/dropify/css/dropify.min.css" type="text/css" />
@endsection

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
                <h4 class="font-18 mb-0">Dashboard | SuperAdmin</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">SuperAdmin</a></li>

                    <li class="breadcrumb-item active">Basic</li>
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
                                <h3 class="card_header"><i class="fa-solid fa-shirt header_icon"></i>Basic Information
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('portal.basic.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-8 offset-2">
                                <input type="hidden" name="id" value="{{$basic->id}}">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Main Logo<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="file" class="dropify form-control" name="Mlogo">
                                            @error('Mlogo')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6 mt-5">
                                        @if($basic->Mlogo != '')
                                        <img src="{{asset('uploads/basic/'.$basic->Mlogo)}}" class="img-fluid" alt="" style="width:50%; height:auto; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Footer Logo<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="file" class="dropify form-control" name="Flogo">
                                            @error('Flogo')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6 mt-5">
                                        @if($basic->Flogo != '')
                                        <img src="{{asset('uploads/basic/'.$basic->Flogo)}}" class="img-fluid" alt="" style="width:50%; height:auto; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Favion<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="file" class=" dropify form-control" name="favlogo">
                                            @error('favLogo')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        @if($basic->favlogo != '')
                                        <img src="{{asset('uploads/basic/'.$basic->favlogo)}}" class="img-fluid" alt="" style="width:50%; height:auto; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Copy Rights<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="text" class="form-control" name="copyright" value="{{$basic->copyright}}">
                                            @error('copyright')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 bg-dark">
                                        <h3 class="card_header"><i class="mdi mdi-currency-usd header_icon"></i>Catering Currency
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <h6 class="">Select Currency</h6>
                                <form action="{{route('portal.basic.currency')}}" method="post">
                                    @method('post')
                                    @csrf
                                    <select class="form-control" name="name" data-toggle="select2">
                                        <option>Choose One</option>
                                        <option value="৳" {{$currency->currency_icon == "৳" ? 'Selected':''}}>৳</option>
                                        <option value="$" {{$currency->currency_icon == "$" ? 'Selected':''}}>$</option>
                                        <option value="£" {{$currency->currency_icon == "£" ? 'Selected':''}}>£</option>
                                        <option value="₹" {{$currency->currency_icon == "₹" ? 'Selected':''}}>₹</option>
                                    </select>
                                    @error('name')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror

                                    <button type="submit" class="btn btn-primary mt-3 text-right">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Application Time Zone</h5>
                            </div>
                            <div class="card-body pt-2">
                                <form action="{{route('portal.basic.time')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-8 offset-2">

                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="">
                                                        <label class="form-label">Current Time Zone<span class="text-danger">*
                                                            </span>:
                                                        </label>
                                                        <input type="text" class="form-control" name="" value="{{$time->name}}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                            $timeZoneList = timezone_identifiers_list();
                                            @endphp
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="">
                                                        <label class="form-label">Select Time Zone for your Application<span class="text-danger">*
                                                            </span>:
                                                        </label>
                                                        <select class="form-control" data-toggle="select2" name="name" data-placeholder="Choose ...">
                                                            @foreach($timeZoneList as $name)
                                                            <option value="{{$name}}" @if($time->name == $name) Selected @endif>{{$name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('month')
                                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 bg-dark">
                                        <h3 class="card_header"><i class="mdi mdi-currency-usd header_icon"></i>Office Time Schedule
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <h6 class="">Select Start And End Time</h6>
                                <form action="{{route('portal.basic.officetime')}}" method="post">
                                    @method('post')
                                    @csrf

                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Starting Time<span class="text-danger">* </span>:
                                            @if($officeTime != '' && $officeTime->office_start != '')
                                            <input type="time" name="start" class="form-control" value="{{ \Carbon\Carbon::parse(displayTime($officeTime->office_start))->format('H:i') }}" placeholder="">
                                            @else
                                            <input type="time" name="start" class="form-control" value="{{ \Carbon\Carbon::parse('11:00 AM')->format('H:i') }}" placeholder="">
                                            @endif
                                            @error('start')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ending Time<span class="text-danger">* </span>:
                                            </label>
                                            @if($officeTime != '' && $officeTime->office_end != '')
                                            <input type="time" name="end" class="form-control" value="{{ \Carbon\Carbon::parse(displayTime($officeTime->office_end))->format('H:i') }}" placeholder="">
                                            @else
                                            <input type="time" name="end" class="form-control" value="{{ \Carbon\Carbon::parse('11:00 AM')->format('H:i') }}" placeholder="">
                                            @endif
                                            @error('end')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                    <button type="submit" class="btn btn-primary mt-3 text-right">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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

@endsection
