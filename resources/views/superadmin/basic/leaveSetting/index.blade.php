@extends('layouts.superAdmin')

@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet">
<link href="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/multiselect/css/multi-select.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" />

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

                    <li class="breadcrumb-item active">Leave Setting</li>
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
                                <h3 class="card_header"><i class="mdi mdi-office-building-cog header_icon"></i>Leave Setting Info
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('portal.leavesetting.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-5 offset-1">

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label">Maximum paid leave in a year<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="text" class="form-control" name="year" value="{{$setting->year_limit}}">
                                            @error('year')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label">Maximum paid Leave in a Month<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="text" class="form-control" name="month" value="{{$setting->month_limit}}">
                                            @error('month')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5 ">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label">Weekend Off Day<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <select class="form-control" name="weekoff" data-placeholder="Choose ...">
                                                <optgroup label="Weekly Off Day">
                                                    <option value="1" {{ $setting->weekoffday == 1 ? 'selected' : '' }}>Monday</option>
                                                    <option value="2" {{ $setting->weekoffday == 2 ? 'selected' : '' }}>Tuesday</option>
                                                    <option value="3" {{ $setting->weekoffday == 3 ? 'selected' : '' }}>Wednesday</option>
                                                    <option value="4" {{ $setting->weekoffday == 4 ? 'selected' : '' }}>Thursday</option>
                                                    <option value="5" {{ $setting->weekoffday == 5 ? 'selected' : '' }}>Friday</option>
                                                    <option value="6" {{ $setting->weekoffday == 6 ? 'selected' : '' }}>Saturday</option>
                                                    <option value="7" {{ $setting->weekoffday == 7 ? 'selected' : '' }}>Sunday</option>
                                                </optgroup>

                                            </select>
                                            @error('weekoff')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label">Special Off Day and Govt Holiday <span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="text" id="multiple-datepicker" class="form-control" name="specialoff" value="{{$setting->specialoffday}}">
                                            @error('specialOff')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <h4 class="text-info">Special Off Day List</h4>
                <hr>
            </div>
            <div class="row">
                @foreach($groupByMonth as $month => $dates)
                <div class="col-md-3 col-xl-3">
                    @php
                    $convertMonth = new DateTime($month);
                    @endphp
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="mdi mdi-calendar-range float-end m-0 h2 text-muted"></i>
                            <h6 class="text-info text-uppercase">{{$convertMonth->format('F')}}</h6>
                            <span>Dates</span>
                            <ul class="list-group">

                                @foreach($dates as $date)
                                @php
                                $convert = new DateTime($date);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$convert->format('Y-m-d')}}
                                    <span class="badge badge-primary text-info badge-pill">{{$convert->format('D')}}</span>
                                </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> <!-- end row -->
        </div>
    </div>
</div>
</div>

</div> <!-- container -->
<!--end Footer -->
@endsection

@section('js')
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/jquery.quicksearch/jquery.quicksearch.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/select2/js/select2.min.js"></script>

@endsection
