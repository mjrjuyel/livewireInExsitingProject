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
                    <form action="{{ route('superadmin.employe.insert') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-5 offset-1">
                                <div class="mb-3">
                                    <label class="form-label">Name<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                    @error('name')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone">
                                    @error('phone')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select type="text" class="form-control" name="role">
                                        <option value="">Select Employe Role
                                        </option>
                                        @foreach($role as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

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

                                <div class="row mt-3">
                                    <label class="form-label text-primary">Provide Password</label>
                                    <div class="col-6">

                                        <div class="mb-3">
                                            <label class="form-label">Password<span class="text-danger">*</span>:</label>
                                            <input type="password" class="form-control" name="pass">
                                            @error('pass')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password<span class="text-danger">*</span>:</label>
                                            <input type="password" class="form-control" name="repass">
                                            @error('repass')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">

                                <div class="mb-3">
                                    <label class="form-label">Email<span class="text-danger">*</span> :</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email">
                                    @error('email')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Addres<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" name="add" value="{{ old('add') }}" placeholder="Enter Present Address">
                                    @error('add')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- data-provide="datepicker" --}}
                                <div class="mb-3">
                                    <label class="form-label">Joining Date<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" id="humanfd-datepicker" name="join" value="{{ old('join') }}" placeholder="Joining From">
                                    @error('join')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Profile Pic<span class="text-danger">*</span>:</label>
                                            <input type="file" class="dropify" name="pic">
                                            <small id="emailHelp" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>

                            </div>

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
@endsection
