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

                    <li class="breadcrumb-item active">Admin</li>
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
                                <h3 class="card_header"><i class="mdi mdi-account-plus header_icon"></i>Add Employee

                                </h3>
                            </div>

                            <div class="col-md-2 offset-md-2 text-end"><a href="{{ route('superadmin.employe') }}" class="btn btn-bg btn-primary btn_header ">
                                    <i class="mdi mdi-account-group-outline btn_icon"></i>All Employee</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Employee</h4>
                                    <p class="card-subtitle">
                                        Your awesome text goes here.Your awesome text goes here.
                                    </p>
                                </div>
                                <div class="card-body pt-2">

                                    <form id="" action="#">
                                        <div>
                                            <h3 class="text-info">Personal Information</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Full Name</label>
                                                            <div>
                                                                <input class="form-control" id="userName2" name="name" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Date of Birth</label>
                                                            <div>
                                                                <input class="form-control" id="humanfd-datepicke" name="dateofbirth" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label>Profile Picture *</label>
                                                            <div>
                                                                <input name="pic" type="file" class="dropify">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <fieldset class="row mt-5">
                                                            <legend class="col-form-label col-sm-6 pt-0">Gender *</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="Male" checked>
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Male
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="Female">
                                                                    <label class="form-check-label" for="gridRadios2">
                                                                        Female
                                                                    </label>
                                                                </div>
                                                                <div class="form-check disabled">
                                                                    <input class="form-check-input" type="radio" name="gender" id="gridRadios3" value="option3">
                                                                    <label class="form-check-label" for="gridRadios3">
                                                                        None Binary
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>



                                                    <div class="col-sm-4">
                                                        <fieldset class="row mt-5">
                                                            <legend class="col-form-label col-sm-6 pt-0">Maritial Status *</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="marriage" id="gridRadios1" value="Married" checked>
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Married
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="marriage" id="gridRadios2" value="Sinlge">
                                                                    <label class="form-check-label" for="gridRadios2">
                                                                        Single
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label for="password2"> Password *</label>

                                                            <div>
                                                                <input id="password2" name="pass" type="text" class="required form-control">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label for="confirm2">Confirm Password *</label>
                                                            <div>
                                                                <input id="confirm2" name="repass" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div><!-- end row -->


                                            </section>

                                            <h3 class="text-info mt-5">Contact Information :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Email 1 *</label>
                                                            <div>
                                                                <input class="required form-control" id="userName2" name="email1" type="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Email 2</label>
                                                            <div>
                                                                <input class="form-control" id="userName2" name="email2" type="email">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Phone Number *</label>
                                                            <div>
                                                                <input id="email2" name="phone1" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="address2">Phone Number<span>(optional)</span></label>
                                                            <div>
                                                                <input id="address2" name="phone2" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Emergency Contact Number *</label>
                                                            <div>
                                                                <input id="email2" name="emerPhone" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="address2">Emgerncy Contact Relationship *</label>
                                                            <div>
                                                                <input id="address2" name="relation" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Parmanet Address *</label>
                                                            <div>
                                                                <input id="email2" name="parAdd" type="text" class="required form-control" value="{{old('parAdd')}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <fieldset class="row mt-3">
                                                            <legend class="col-form-label col-sm-6 pt-0">Same*</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="same" id="gridRadios1" value="1" checked>
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="same" id="gridRadios2" value="0">
                                                                    <label class="form-check-label" for="gridRadios2">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <label for="address2">Present Address</label>
                                                            <div>
                                                                <input id="address2" name="preAdd" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                            </section>

                                            <h3 class="text-info mt-5">Job Details :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Designation</label>
                                                            <select type="text" class="form-control" name="desig">
                                                                <option value="">Select One</option>
                                                                @foreach($designation as $desig)
                                                                <option value="{{ $desig->id }}">{{ $desig->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('desig')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Department</label>
                                                            <select type="text" class="form-control" name="department">
                                                                <option value="">Select One</option>
                                                                @foreach($designation as $desig)
                                                                <option value="{{ $desig->id }}">{{ $desig->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('department')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Joining Date<span class="text-danger">*</span> :</label>
                                                            <input type="text" class="form-control" id="humanfd-datepicker" name="join" value="{{ old('join') }}" placeholder="Joining From">
                                                            @error('join')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employement Type</label>
                                                            <select type="text" class="form-control" name="desig">
                                                                <option value="">Select One</option>
                                                                <option value="1">Full Time </option>
                                                                <option value="2">Part Time</option>
                                                                <option value="3">Frelance</option>
                                                                <option value="4">Contract</option>
                                                                <option value="5">Internship</option>
                                                                <option value="6">Remote</option>
                                                            </select>
                                                            @error('employeType')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Reporting Manager<span class="text-danger">*</span> :</label>
                                                            <select type="text" class="form-control" name="reporting">
                                                                <option value="">Select One</option>
                                                                <option value="1">Full Time </option>
                                                                <option value="2">Part Time</option>
                                                                <option value="3">Frelance</option>
                                                                <option value="4">Contract</option>
                                                                <option value="5">Internship</option>
                                                                <option value="6">Remote</option>
                                                            </select>
                                                            @error('reporting')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employement Type</label>
                                                            <select type="text" class="form-control" name="desig">
                                                                <option value="">Select One</option>
                                                                <option value="1">Full Time </option>
                                                                <option value="2">Part Time</option>
                                                                <option value="3">Frelance</option>
                                                                <option value="4">Contract</option>
                                                                <option value="5">Internship</option>
                                                                <option value="6">Remote</option>
                                                            </select>
                                                            @error('desig')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                            </section>

                                            <h3 class="text-info mt-5">Identy Verification :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <fieldset class="row mt-3">
                                                    <legend class="col-form-label col-sm-3 pt-0">Select One*</legend>
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="id_type" value="national_id" onclick="showInput('national_id_input')" checked>
                                                            <label class="form-check-label" for="gridRadios1">
                                                                National ID/Passport Number
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="id_type" value="ssn" onclick="showInput('ssn_input')">
                                                            <label class="form-check-label" for="gridRadios2">
                                                                Social Security Number (SSN) (or local equivalent)
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="id_type" value="driver_license" onclick="showInput('driver_license_input')">
                                                            <label class="form-check-label" for="gridRadios2">
                                                                Driver’s License Number (if applicable)
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5 offset-sm-3">
                                                        <div id="national_id_input" class="hiddenInput">
                                                            <label for="national_id" class="form-label">National ID/Passport Number:</label>
                                                            <input type="text" id="national_id" class="form-control" name="national_id">
                                                        </div>
                                                        <div id="ssn_input" class="hiddenInput">
                                                            <label for="ssn" class="form-label">Social Security Number (SSN):</label>
                                                            <input type="text" id="ssn" class="form-control" name="ssn">
                                                        </div>
                                                        <div id="driver_license_input" class="hiddenInput">
                                                            <label for="driver_license" class="form-label">Driver’s License Number:</label>
                                                            <input type="text" id="driver_license" class="form-control" name="driver_license">
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div class="form-group clearfix">
                                                    <div class="col-lg-12">
                                                        <!-- Input fields -->
                                                        <div id="national_id_input" class="hiddenInput">
                                                            <label for="national_id">National ID/Passport Number:</label>
                                                            <input type="text" id="national_id" name="national_id">
                                                        </div>
                                                        <div id="ssn_input" class="hiddenInput">
                                                            <label for="ssn">Social Security Number (SSN):</label>
                                                            <input type="text" id="ssn" name="ssn">
                                                        </div>
                                                        <div id="driver_license_input" class="hiddenInput">
                                                            <label for="driver_license">Driver’s License Number:</label>
                                                            <input type="text" id="driver_license" name="driver_license">
                                                        </div>
                                                        <input id="acceptTerms-2" name="acceptTerms2" type="checkbox" class="form-check-input required">
                                                        <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
                                                    </div>
                                                </div>
                                            </section>

                                            <h3 class="text-info mt-5">Education And Experience :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Email 1 *</label>
                                                            <div>
                                                                <input class="required form-control" id="userName2" name="email1" type="email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Email 2</label>
                                                            <div>
                                                                <input class="form-control" id="userName2" name="email2" type="email">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Phone Number *</label>
                                                            <div>
                                                                <input id="email2" name="phone1" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="address2">Phone Number<span>(optional)</span></label>
                                                            <div>
                                                                <input id="address2" name="phone2" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Emergency Contact Number *</label>
                                                            <div>
                                                                <input id="email2" name="emerPhone" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="address2">Emgerncy Contact Relationship *</label>
                                                            <div>
                                                                <input id="address2" name="relation" type="text" class="required form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Parmanet Address *</label>
                                                            <div>
                                                                <input id="email2" name="parAdd" type="text" class="required form-control" value="{{old('parAdd')}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <fieldset class="row mt-3">
                                                            <legend class="col-form-label col-sm-6 pt-0">Same*</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="same" id="gridRadios1" value="1" checked>
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="same" id="gridRadios2" value="0">
                                                                    <label class="form-check-label" for="gridRadios2">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                            <label for="address2">Present Address</label>
                                                            <div>
                                                                <input id="address2" name="preAdd" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                            </section>

                                            <h3 class="text-info mt-5">Banking Information :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                @php
                                                function getBanksAndBranchesInBangladesh() {
                                                // Banks with branches
                                                return [
                                                'AB Bank Limited' => [
                                                'Motijheel Branch',
                                                'Dhanmondi Branch',
                                                'Gulshan Branch',
                                                'Chittagong Branch',
                                                ],
                                                'Agrani Bank Limited' => [
                                                'Motijheel Corporate Branch',
                                                'Uttara Branch',
                                                'Mirpur Branch',
                                                'Chittagong EPZ Branch',
                                                ],
                                                'Al-Arafah Islami Bank Limited' => [
                                                'Mohakhali Branch',
                                                'Panthapath Branch',
                                                'Kawran Bazar Branch',
                                                'Chittagong Branch',
                                                ],
                                                'BRAC Bank Limited' => [
                                                'Banani Branch',
                                                'Uttara Branch',
                                                'Bashundhara Branch',
                                                'Sylhet Branch',
                                                ],
                                                'Dutch-Bangla Bank Limited' => [
                                                'Motijheel Branch',
                                                'Uttara Branch',
                                                'Dhanmondi Branch',
                                                'Rajshahi Branch',
                                                ],
                                                'Islami Bank Bangladesh Limited' => [
                                                'Paltan Branch',
                                                'Dhanmondi Branch',
                                                'Chittagong Branch',
                                                'Sylhet Branch',
                                                ],
                                                'Janata Bank Limited' => [
                                                'Motijheel Branch',
                                                'Kawran Bazar Branch',
                                                'Mirpur Branch',
                                                'Comilla Branch',
                                                ],
                                                'Sonali Bank Limited' => [
                                                'Motijheel Corporate Branch',
                                                'Gulshan Branch',
                                                'Kawran Bazar Branch',
                                                'Sylhet Branch',
                                                ],
                                                'Trust Bank Limited' => [
                                                'Banani Branch',
                                                'Bashundhara Branch',
                                                'Motijheel Branch',
                                                'Cox’s Bazar Branch',
                                                ],
                                                ];
                                                }

                                                $bankName = getBanksAndBranchesInBangladesh();
                                                @endphp

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Bank Name *</label>
                                                            <div>
                                                                <select class="required form-control" name="bankName" type="text">
                                                                    @foreach($bankName as $bankName => $branch)
                                                                    <option value="">{{$bankName}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label class="form-label" for="userName2">Account No *</label>
                                                            <div>
                                                                <input class="form-control" name="accountNo" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Branch Name</label>
                                                            <div>
                                                                <select class="required form-control" name="bankName" type="text">
                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label>IFSC/Sort Code</label>
                                                            <div>
                                                                <input id="address2" name="sortCode" type="number" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                            </section>

                                            <h3 class="text-info mt-5">Tax And Legal Details :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label >Taxpayer Identification Number(TIN)</label>
                                                            <div>
                                                                <input class="form-control" name="tin" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label class="form-label" for="userName2">Work Visa/Permit Number *</label>
                                                            <div>
                                                                <input class="form-control" name="permitNum" type="number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Insurance Details</label>
                                                            <div>
                                                                <select class="form-control" name="insurance" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>IFSC/Sort Code</label>
                                                            <div>
                                                                <input id="address2" name="sortCode" type="number" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                            </section>

                                            <h3 class="text-info mt-5">Company Specific Field :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label>Office Branch</label>
                                                            <div>
                                                                <select class="required form-control" name="ComBranch" type="text">
                                                                    <option value="">Select A Branch </option>
                                                                    <option value="">Mirpur </option>
                                                                    <option value="">Gulsan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label class="form-label" for="userName2">Access Card Number *</label>
                                                            <div>
                                                                <input class="form-control" name="accesscard" type="number">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">System/IT Requirement</label>
                                                            <div>
                                                                <select class="form-control" name="system" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label>Work Schedule </label>
                                                            <div>
                                                                <input name="schedule" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                            </section>

                                            <h3 class="text-info mt-5">Declarations and Agreements :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <input id="acceptTerms-2" name="accept" type="checkbox" class="form-check-input required">
                                                            <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label class="form-label" for="userName2">Upload Signature *</label>
                                                            <div>
                                                                <input class="dropify" style="width:100px; height: 200px;" name="signature" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </section>

                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>


</div>
</div>
</div> <!-- container -->
<!--end Footer -->
<script>
    function showInput(inputId) {
        // Hide all input fields and disable them
        document.querySelectorAll('.hiddenInput').forEach(el => {
            el.style.display = 'none';
            el.querySelector('input').disabled = true;
        });

        // Show the selected input field and enable it
        const activeField = document.getElementById(inputId);
        activeField.style.display = 'block';
        activeField.querySelector('input').disabled = false;
    }

    // Ensure only active fields are submitted
    document.getElementById('identityForm').addEventListener('submit', function(event) {
        const visibleFields = Array.from(document.querySelectorAll('.hiddenInput'))
            .filter(el => el.style.display === 'block');

        if (visibleFields.length === 0 || visibleFields[0].querySelector('input').value.trim() === '') {
            event.preventDefault();
            alert('Please fill out the selected field.');
        }
    });

</script>

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
