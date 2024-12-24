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

                                    <form action="{{ route('superadmin.employe.insert') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div>
                                            <h3 class="text-info">Personal Information :-</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Full Name <span class="text-danger">*</span> :</label>
                                                            <div>
                                                                <input class="form-control" id="userName2" name="name" value="{{old('name')}}" type="text">
                                                            </div>
                                                            @error('name')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Date of Birth</label>
                                                            <div>
                                                                <input class="form-control" id="humanfd-datepicke" name="dob" type="text">
                                                            </div>
                                                            @error('dob')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label>Profile Picture <span class="text-danger">*</span> :</label>
                                                            <input name="pic" type="file" class="dropify">

                                                            @error('pic')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <fieldset class="row mt-5">
                                                            <legend class="col-form-label col-sm-6 pt-0">Gender <span class="text-danger">*</span> :</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="Male">
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
                                                                @error('gender')
                                                                <small class="form-text text-warning">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </fieldset>
                                                    </div>



                                                    <div class="col-sm-4">
                                                        <fieldset class="row mt-5">
                                                            <legend class="col-form-label col-sm-6 pt-0">Maritial Status <span class="text-danger">*</span> :</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="marriage"  value="Married">
                                                                    <label class="form-check-label">
                                                                        Married
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="marriage" value="Single">
                                                                    <label class="form-check-label" >
                                                                        Single
                                                                    </label>
                                                                </div>

                                                                @error('marriage')
                                                                <small class="form-text text-warning">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label> Password <span class="text-danger">*</span> :</label>
                                                            <input name="pass" type="password" class="form-control">
                                                            @error('pass')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group clearfix">
                                                            <label >Confirm Password <span class="text-danger">*</span> :</label>
                                                            <input name="repass" type="password" class="form-control">
                                                            @error('repass')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
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
                                                            <label for="userName2">Email<span class="text-danger">*</span> :</label>
                                                            <input class="required form-control" id="userName2" value="{{old('email')}}" name="email" type="email">
                                                            @error('email')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Email : <span class="text-info">(Alternate Email)</span></label>
                                                            <div>
                                                                <input class="form-control" id="userName2" value="{{old('email2')}}" name="email2" type="email1">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label>Phone Number <span class="text-danger">*</span> :</label>
                                                            <input name="phone" type="number" value="{{old('phone')}}" class="form-control">
                                                            @error('phone')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="address2">Phone Number<span>(optional)</span></label>
                                                            <div>
                                                                <input id="address2" name="phone2" value="{{old('phone2')}}" type="number" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Emergency Contact Number <span class="text-danger">*</span> :</label>
                                                            <input id="email2" name="emerPhone" type="number" value="{{old('emerPhone')}}" class="required form-control">
                                                            @error('emerPhone')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="address2">Emgerncy Contact Relationship <span class="text-danger">*</span> :</label>

                                                            <input id="address2" name="emerRelation" type="text" value="{{old('emerRelation')}}" class="required form-control">
                                                            @error('emerRelation')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Parmanent Address <span class="text-danger">*</span> :</label>
                                                            <input id="email2" name="add" type="text" class="required form-control" value="{{old('add')}}">
                                                            @error('add')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>



                                                    <div class="col-sm-4">
                                                        <fieldset class="row mt-3">
                                                            <legend class="col-form-label col-sm-6 pt-0">Same As Parmanent?<span class="text-danger">*</span> :</legend>
                                                            <div class="col-sm-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sameAdd" id="gridRadios1" value="1">
                                                                    <label class="form-check-label" for="gridRadios1">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sameAdd" id="gridRadios2" value="0">
                                                                    <label class="form-check-label" for="gridRadios2">
                                                                        No
                                                                    </label>
                                                                </div>
                                                                @error('sameAdd')
                                                                <small class="form-text text-warning">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="address2">Present Address</label>
                                                            <div>
                                                                <input id="address2" name="preAdd" type="text" value="{{old('preAdd')}}" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                            </section>

                                            <h3 class="text-info mt-5">Job Details :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">

                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Department</label>
                                                            <select type="text" class="form-control" name="department">
                                                                <option value="">Select One</option>
                                                                @foreach($department as $depart)
                                                                <option value="{{ $depart->id }}">{{ $depart->depart_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('department')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                     
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Designation <span class="text-danger">*</span> :</label>
                                                            <select type="text" class="form-control" name="desig" value="{{old('desig')}}">
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

                                                    

                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employement Type<span class="text-danger">*</span> :</label>
                                                            <select type="text" class="form-control" name="empType">
                                                                <option value="">Select One</option>
                                                                <option value="Full Time">Full Time </option>
                                                                <option value="Part Time">Part Time</option>
                                                                <option value="Frelance">Frelance</option>
                                                                <option value="Contract">Contract</option>
                                                                <option value="Internship">Internship</option>
                                                                <option value="Remote">Remote</option>
                                                            </select>
                                                            @error('empType')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div><!-- end row -->
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Joining Date<span class="text-danger">*</span> :</label>
                                                            <input type="text" class="form-control" id="humanfd-datepicker" name="join" value="{{ old('join') }}" placeholder="Joining From">
                                                            @error('join')
                                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Reporting Manager<span class="text-danger">*</span> :</label>
                                                            <select type="text" class="form-control" name="reporting">
                                                                <option value="">Select One</option>
                                                                @foreach($report as $employe)
                                                                <option value="{{$employe->id}}">{{$employe->emp_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('reporting')
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
                                                    <legend class="col-form-label col-sm-3 pt-0">Select One<span class="text-danger">*</span> :</legend>
                                                    <div class="col-sm-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="id_type" value="national_id" onclick="showInput('national_id_input')">
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
                                                        @error('id_type')
                                                        <small class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-sm-5">
                                                        <div id="national_id_input" class="hiddenInput">
                                                            <label for="national_id" class="form-label">National ID/Passport Number:</label>
                                                            <input type="text" id="national_id" class="form-control" value="{{old('id_number')}}" name="id_number">

                                                        </div>
                                                        <div id="ssn_input" class="hiddenInput">
                                                            <label for="ssn" class="form-label">Social Security Number (SSN):</label>
                                                            <input type="text" id="ssn" class="form-control" value="{{old('id_number')}}" name="id_number">

                                                        </div>
                                                        <div id="driver_license_input" class="hiddenInput">
                                                            <label for="driver_license" class="form-label">Driver’s License Number:</label>
                                                            <input type="text" id="driver_license" value="{{old('id_number')}}" class="form-control" name="id_number">

                                                        </div>
                                                        @error('id_number')
                                                        <small class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </fieldset>
                                            </section>

                                            <h3 class="text-info mt-5">Education And Experience :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    {{-- <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="userName2">Institute HSC:- <span class="text-danger">*</span> :</label>
                                                            <input class="required form-control" id="userName2" name="hsc" type="text">
                                                            @error('hsc')
                                                            <small class="form-text text-warning">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group clearfix">
                                                    <label for="userName2">Passing Year HSC:- <span class="text-danger">*</span> :</label>
                                                    <input class="required form-control" id="userName2" name="hscYear" type="text">
                                                    @error('hscYear')
                                                    <small class="form-text text-warning">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                        </div> --}}
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label for="">Last Academic Degree :- <span class="text-danger">*</span> :</label>
                                                <input class="required form-control" id="" value="{{old('degree')}}" name="degre" type="text">
                                                @error('degree')
                                                <small class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group clearfix">
                                                <label for="userName2">Passing Year:- <span class="text-danger">*</span> :</label>
                                                <input class="required form-control" id="userName2" value="{{old('degreYear')}}" name="degreYear" type="date">
                                                @error('degreYear')
                                                <small class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                </div><!-- end row -->

                                </section>

                                <h3 class="text-info mt-5">Banking Information :-</h3>
                                <hr class="text-info">
                                <section>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label for="userName2">Bank Name <span class="text-danger">*</span> :</label>
                                                <div>
                                                    <select class="required form-control" name="bankName" type="text" id="bankName">
                                                    <option value="">Select a Bank</option>
                                                        @foreach($bankName as $bank)
                                                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bankName')
                                                    <small class="form-text text-warning">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label for="email2">Branch Name</label>
                                                <div>
                                                    <select class="required form-control" name="bankBranch" type="text">
                                                        @foreach($bankBranch as $branch)
                                                        <option value="{{$branch->id}}">{{$branch->bank_branch_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bankBranch')
                                                    <small class="form-text text-warning">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label class="form-label" for="userName2">Account No <span class="text-danger">*</span> :</label>
                                                <div>
                                                    <input class="form-control" name="accountNumber" value="{{old('accountNo')}}" type="number">
                                                </div>
                                                @error('accountNumber')
                                                <small class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label class="form-label" for="userName2">Account Name <span class="text-danger">*</span> :</label>
                                                <div>
                                                    <input class="form-control" name="accountName" value="{{old('accountName')}}" type="text">
                                                </div>
                                                @error('accountName')
                                                <small class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                    </div><!-- end row -->

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label>IFSC/Sort Code</label>
                                                <div>
                                                    <input id="address2" name="sortCode" value="{{old('sortCode')}}" type="number" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label>Swift Code</label>
                                                <div>
                                                    <input id="address2" name="swiftCode" value="{{old('swiftCode')}}" type="number" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end row -->
                                </section>



                                {{-- <h3 class="text-info mt-5">Tax And Legal Details :-</h3>
                                            <hr class="text-info">
                                            <section>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label >Taxpayer Identification Number(TIN)</label>
                                                                <input class="form-control" name="tin" type="number">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label class="form-label" for="userName2">Work Visa/Permit Number *</label>
                                                                <input class="form-control" name="permitNum" type="number">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group clearfix">
                                                            <label for="email2">Insurance Details</label>
                                                            <input class="form-control" name="insurance" type="text">
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>IFSC/Sort Code</label>
                                                            <input id="address2" name="sortCode" type="number" class="form-control">
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                            </section> --}}

                                <h3 class="text-info mt-5">Company Specific Field :-</h3>
                                <hr class="text-info">
                                <section>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label>Office Branch<span class="text-danger">*</span> :</label>
                                                <div>
                                                    <select class="required form-control" name="OffBranch" type="text">
                                                        <option value="">Select A Branch </option>
                                                        @foreach($officeBranch as $office)
                                                        <option value="{{$office->id}}">{{$office->branch_name}} </option>
                                                        @endforeach

                                                    </select>
                                                    @error('OffBranch')
                                                    <small class="form-text text-warning">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label class="form-label" for="userName2">Access Card Number <span class="text-danger">*</span> :</label>
                                                <div>
                                                    <input class="form-control" value="{{old('accessCard')}}" name="accessCard" type="number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label for="email2">System/IT Requirement</label>
                                                <div>
                                                    <input class="form-control" value="{{old('syste')}}" name="system" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end row -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label>Work Schedule </label>
                                                <input name="schedule" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div><!-- end row -->
                                </section>

                                <h3 class="text-info mt-5">Declarations and Agreements :-</h3>
                                <hr class="text-info">
                                <section>
                                    <div class="row">

                                        <div class="col-sm-3 offset-sm-2">
                                            <div class="form-group clearfix">

                                                <label for="acceptTerms-2">I agree with the Terms and Conditions.<span class="text-danger">*</span> : </label>
                                                <input id="acceptTerms-2" name="accept" type="checkbox" value="1" class="form-check-input text-info">

                                            </div>
                                            @error('accept')
                                            <small class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group clearfix">
                                                <label class="form-label" for="userName2">Upload Signature <span class="text-danger">*</span> :</label>
                                                <input class="dropify" name="signature" type="file">
                                                @error('signature')
                                                <small class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </section>

                            </div>
                            <div class="card-footer bg-primary">
                                <div class="row">
                                    <div class="col-md-6 offset-3 text-center">
                                        <button type="submit" class="btn btn-dark">Submit</button>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
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

    $("#bankName").change(function(){
        var id = $(this).val();
        alert(id)
      //  $.ajax({
         //   url: "{{url('/get-childid/')}}/"+id,
        //    type: "get",
      //      success: function(data){
    //            $('select[name="childcategory"]').empty();
               // $.each(data,function(key,data){
             //       $('select[name="childcategory"]').append('<option value="'+data.id+'">'+data.child_cat_title+'</option>');
           //     })
         //   }
       // })
    })

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
