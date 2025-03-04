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
                    <li class="breadcrumb-item active">Update Profile</li>
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
                                        <h3 class="card_header"><i class="mdi mdi-face-man-profile header_icon"></i>Update MyProfile
                                        </h3>
                                    </div>
                                     <div class="col-md-5 text-end"><a href="{{route('portal.view.profile',Crypt::encrypt(Auth::user()->id))}}" class="btn btn-bg btn-info btn_header"><i class="mdi mdi-view-dashboard-outline btn_icon"></i>View Data</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('portal.profile.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-5 offset-1">
                                            <input type="hidden" value="{{ $user->id }}" name="id">
                                            <input type="hidden" value="{{ $user->slug }}" name="slug">

                                            <div class="mb-3">
                                                <label class="form-label">Name<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Enter email">
                                                @error('name')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email<span class="text-danger">*</span> :</label>
                                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Enter email">
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                {{-- @if($user->roles->name == "Super Admin")
                                                    <select class="form-control" type="text" name="role">
                                                      @foreach($roles as $role)
                                                       <option value="{{$role->name}}" {{in_array($role->id,$ModelRoles) ? 'Selected' : ''}}>{{$role->name}}</option>
                                                       @endforeach
                                                    </select>
                                                @else --}}
                                                    <select class="form-control" type="text" name="role">
                                                    <option value="">Select One</option>
                                                      @foreach($roles as $role)
                                                       
                                                       <option value="{{$role->name}}" {{in_array($role->id,$ModelRoles) ? 'Selected' : ''}}>{{$role->name}}</option>
                                                       @endforeach
                                                    </select>
                                                {{-- @endif --}}
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Designation</label>
                                                @if($user->designation_id != null)
                                                <input class="form-control" type="text" value="{{ $user->designation->title }}" disabled>
                                                @else
                                                <input class="form-control" type="text" value="Not Yet" disabled>
                                                @endif
                                            </div>

                                            <div class="row">
                                                <div class="col-8">
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
                                                <div class="col-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">New Password<span class="text-danger">*</span>:</label>
                                                        <input type="password" class="form-control" name="newpass">
                                                        @error('newpass')
                                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-5">

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Image<span class="text-danger">*</span>:</label>
                                                        <input type="file" class="dropify" name="image">
                                                        @error('image')
                                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    @if($user->image != '')
                                                    <img src="{{ asset('uploads/adminprofile/'.$user->image) }}" class="img-fluid" style="width:100%; height:auto; object-fit:cover; border-radius:10px;">
                                                    @endif
                                                </div>
                                            </div>

                                            
                                        </div>

                                    </div>
                                    <div class="card-footer bg-info">
                                        <div class="row">
                                            <div class="col-md-6 offset-3 text-center">
                                              <button type="submit" class="btn btn-dark">Update</button>
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
