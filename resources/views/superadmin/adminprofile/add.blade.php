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
                <h4 class="font-18 mb-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item">Super Admin</li>
                    <li class="breadcrumb-item active">Add Admin</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i class="mdi mdi-face-man-profile header_icon"></i>Add New Admin
                                        </h3>
                                    </div>
                                     <div class="col-md-5 text-end"><a href="{{route('superadmin.admin')}}" class="btn btn-bg btn-info btn_header"><i class="mdi mdi-view-dashboard-outline btn_icon"></i>View Data</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('superadmin.admin.insert') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-5 offset-1">

                                            <div class="mb-3">
                                                <label class="form-label">Full Name<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                                @error('name')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">User Name<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" name="user" value="{{ old('user') }}" placeholder="Enter Name">
                                                @error('user')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email<span class="text-danger">*</span> :</label>
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email">
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                    <select class="form-control" type="text" value="{{ old('role->role_name') }}" name="role">
                                                      @foreach($role as $role)
                                                       <option value="{{$role->id}}" @if(Auth::user()->role_id == $role->id ) Selected @endif>{{$role->role_name}}</option>
                                                       @endforeach
                                                    </select>
                                            </div>

                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">Password<span class="text-danger">*</span>:</label>
                                                        <input type="password" class="form-control" name="pass">
                                                        @error('pass')
                                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-8">
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

                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Image<span class="text-danger">*</span>:</label>
                                                        <input type="file" class="dropify" name="pic">
                                                        <small id="emailHelp" class="form-text text-muted"></small>

                                                        @error('pic')
                                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        </div>

                                    </div>
                                    <div class="card-footer bg-info">
                                        <div class="row">
                                            <div class="col-md-6 offset-3 text-center">
                                              <button type="submit" class="btn btn-dark">Save</button>
                                            </div>
                                            <div class="col-md-5">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>

</div> <!-- container -->
@endsection
@section('js')
<script src="{{asset('contents/admin')}}/assets/libs/dropify/js/dropify.min.js"></script>
<!-- File Upload Demo js -->
<script src="{{asset('contents/admin')}}/assets/js/pages/form-fileupload.js"></script>
<!-- Init js-->
<script src="{{asset('contents/admin')}}/assets/js/pages/form-pickers.js"></script>
@endsection
