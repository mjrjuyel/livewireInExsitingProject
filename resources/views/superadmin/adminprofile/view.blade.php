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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>
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
                        <div class="col-md-12">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i class="mdi mdi-face-man-profile header_icon"></i>My Profile 
                                        </h3>
                                    </div>

                                    <div class="col-md-5 text-end"><a href="{{route('superadmin.profile',Crypt::encrypt(Auth::user()->id))}}" class="btn btn-bg btn-info btn_header"><i class="mdi mdi-circle-edit-outline btn_icon"></i>Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="row mt-3">
                                        <div class="col-5 offset-1 text-end">

                                        <div class="card text-center">
                                                   @if($view->image != '')
                                                    <img src="{{ asset('uploads/adminprofile/'.$view->image) }}"  alt="" style="width:100%; height:400px; object-fit:contain;">
                                                    @else
                                                    <img src="{{ asset('uploads/adminprofile/img.jpg') }}"  alt="" style="width:100%; object-fit:contain;">
                                                    @endif
                                            <div class="card-body">
                                                <h5 class="card-title">Name : {{$view->name}}</h5>
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                <a href="{{route('superadmin.profile',Crypt::encrypt(Auth::user()->id))}}" class="btn btn-bg btn-info btn_header"><i class="mdi mdi-circle-edit-outline btn_icon"></i>Edit My Profile</a>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="col-5">

                                            <div class="mb-3">
                                                <label class="form-label">Email @:
                                                </label>
                                                 <h3 class="text-dark"><a href="mailto:{{ $view->email }}">{{ $view->email }}</a> </h3>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">My Designation :
                                                </label>
                                                 <h3 class="text-dark"> {{ optional($view->designation)->title }}</h3>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">My Role :
                                                </label>
                                                 <h3 class="text-dark"> {{ optional($view->role)->role_name }}</h3>
                                            </div>
                                    </div>
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
