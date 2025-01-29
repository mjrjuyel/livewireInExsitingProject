@extends('layouts.employe')

@section('css')
<link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/libs/dropify/css/dropify.min.css" />
<link href="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endsection

@section('content')

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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">My Profile</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                                <h3 class="card_header"><i class="fa-solid fa-shirt header_icon"></i>Edit My Profile
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.employe.profileSettingUpdate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-5 offset-1">
                                <input type="hidden" name="id" value="{{$edit->id}}">
                                <input type="hidden" name="slug" value="{{$edit->emp_slug}}">
                                <div class="mb-3">
                                    <label class="form-label">Name<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{ $edit->emp_name }}" placeholder="Enter Name">
                                    @error('name')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $edit->emp_phone }}" placeholder="Enter Phone">
                                    @error('phone')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Designation</label>
                                    <select type="text" class="form-control" name="desig" disabled>
                                        <option value="">Select One</option>
                                        @foreach($designation as $desig)
                                        <option value="{{ $desig->id }}" @if($edit->emp_desig_id == $desig->id) selected @endif>{{ $desig->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('desig')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group clearfix">
                                    <label>Date of Birth <span class="text-danger">*</span> :</label> </label>
                                    <div>
                                        <input class="form-control" id="humanfd-datepicke" name="dob" value="{{$edit->emp_dob}}" type="text">
                                    </div>
                                    @error('dob')
                                    <small class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row mt-3">
                                    <label class="form-label text-primary">Change Password ?</label>
                                    <div class="col-6">

                                        <div class="mb-3">
                                            <label class="form-label">Old Password<span class="text-danger">*</span>:</label>
                                            <input type="password" class="form-control" name="oldpass">
                                            @error('oldpass')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
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

                                <div class="mb-3">
                                    <label class="form-label">Email<span class="text-danger">*</span> :</label>
                                    <input type="email" class="form-control" name="email" value="{{ $edit->email ?? old('email') }}" placeholder="Enter email">
                                    @error('email')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Parmanent Addres<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" name="add" value="{{ $edit->emp_address }}" placeholder="Enter Present Address">
                                    @error('add')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- data-provide="datepicker" --}}
                                <div class="mb-3">
                                    <label class="form-label">Joining Date<span class="text-danger">*</span> :</label>
                                    <input type="text" class="form-control" id="humanfd-datepicker" name="join" value="{{ $edit->emp_join }}" disabled placeholder="Joining From">
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
                                        @error('pic')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-5">
                                            @if ($edit->emp_image != '')
                                            <img src="{{ asset('uploads/employe/profile/'.$edit->emp_image) }}" class="img-fluid" alt="" style="width:80px height:80px; object-fit:cover; border-radius:10px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Employe Status</label>
                                        <select type="text" class="form-control text-first" name="status" disabled>
                                            <option value="1" class="text-primary" @if($edit->emp_status == 1) Selected @endif>Active</option>
                                            <option value="2" class="text-warning" @if($edit->emp_status == 2) Selected @endif>Suspend</option>
                                            <option value="0" class="text-danger" @if($edit->emp_status == 0) Selected @endif>Recycle Bin</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                              <section>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label>Email : <span class="text-info">(Alternate Email)</span></label>
                                            <div>
                                                <input class="form-control" value="{{$edit->email2 ?? old('email2') }}" name="email2" type="email1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Present Address</label>
                                            <div>
                                                <input name="preAdd" type="text" value="{{$edit->emp_present }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end row -->

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label>Phone Number<span>(optional)</span></label>
                                            <div>
                                                <input name="phone2" value="{{$edit->emp_phone2 ?? old('phone2') }}" type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label>Emergency Contact Number <span class="text-danger">*</span> :</label>
                                            <input name="emerPhone" type="number" value="{{$edit->emp_emer_contact }}" class="required form-control">
                                            @error('emerPhone')
                                            <small class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label>Emergency Contact Name <span class="text-danger">*</span> :</label>
                                            <input name="emerName" type="number" value="{{$edit->emp_emer_name }}" class="required form-control">
                                            @error('emerName')
                                            <small class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group clearfix">
                                            <label>Emgerncy Contact Relationship <span class="text-danger">*</span> :</label>

                                            <input name="emerRelation" type="text" value="{{$edit->emp_emer_relation }}" class="required form-control">
                                            @error('emerRelation')
                                            <small class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div><!-- end row -->

                            </section>

                            <div class="row">
                                <div class="col-5 offset-5">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
