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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item">Super Admin</li>
                    <li class="breadcrumb-item active">Profile</li>
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
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>Update MyProfile
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('superadmin.profile.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-6 offset-2">
                                            <input type="hidden" value="{{ $pass->id }}" name="id">
                                            <input type="hidden" value="{{ $pass->slug }}" name="slug">

                                            <div class="mb-3">
                                                <label class="form-label">Name<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" name="name" value="{{ $pass->name }}" placeholder="Enter email">
                                                @error('name')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email<span class="text-danger">*</span> :</label>
                                                <input type="email" class="form-control" name="email" value="{{ $pass->email }}" placeholder="Enter email">
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Image<span class="text-danger">*</span>:</label>
                                                        <input type="file" class="form-control" name="image">
                                                        <small id="emailHelp" class="form-text text-muted"></small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    @if($pass->image != '')
                                                    <img src="{{ asset('uploads/adminprofile/'.$pass->image) }}" class="img-fluid" alt="" style="width:50px; height:100px; object-fit:cover;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                @if($pass->role_id != null)
                                                <input class="form-control" type="text" value="{{ $pass->role->role_name }}" disabled>
                                                @else
                                                <input class="form-control" type="text" value="Not Yet" disabled>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Designation</label>
                                                @if($pass->designation_id != null)
                                                <input class="form-control" type="text" value="{{ $pass->designation->title }}" disabled>
                                                @else
                                                <input class="form-control" type="text" value="Not Yet" disabled>
                                                @endif
                                            </div>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Present Password<span class="text-danger">*</span>:</label>
                                                        <input type="password" class="form-control" name="oldpass">
                                                        @error('oldpass')
                                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">New Password<span class="text-danger">*</span>:</label>
                                                        <input type="password" class="form-control" name="newpass">
                                                        @error('newpass')
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
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>

</div> <!-- container -->
@endsection
