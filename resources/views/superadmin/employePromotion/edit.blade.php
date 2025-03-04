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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Promotion</li>
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
                                <h3 class="card_header"><i class="mdi mdi-account-hard-hat header_icon"></i>Promotion/Demotion Update
                                </h3>
                            </div>

                            <div class="col-md-4 text-end"><a href="{{route('admin.promotion',Crypt::encrypt($edit->emp_id))}}" class="btn btn-bg btn-primary btn_header ">
                                    <i class="fa-brands fa-servicestack btn_icon"></i>All Promotion/Demotion</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('admin.promotion.update')}}" method="post">
                        @csrf
                        <div class="row mt-5">
                        <input type="hidden" name="id" value="{{$edit->id}}">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group clearfix">
                                    <label>Name<span class="text-danger">*</span> :</label>
                                    <select type="text" class="form-control" name="employe">
                                        <option value="{{ $edit->emp_id }}">{{ $edit->employe->emp_name}}</option>
                                    </select>
                                    @error('employe')
                                    <small class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div><!-- end row -->

                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <select type="text" class="form-control" id="department" name="department">
                                        <option value="">Select One</option>
                                        @foreach($departs as $depart)
                                        <option value="{{ $depart->id }}" {{$edit->depart_id == $depart->id || old('department') == $depart->id ? 'Selected' : '' }}>{{ $depart->depart_name }}
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
                            <div class="col-md-6 offset-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Designation <span class="text-danger">*</span> :</label>
                                    <select type="text" class="form-control" name="desig">
                                        @foreach($designs as $designation)
                                        <option value="{{$designation->id}}" {{ $edit->desig_id == $designation->id || old('desig') == $designation->id ? 'Selected' : ''}}>{{$designation->title}}</option>
                                        @endforeach
                                    </select>
                                    @error('desig')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div><!-- end row -->
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Employement Type<span class="text-danger">*</span> :</label>
                                    <select type="text" class="form-control" name="empType">
                                        <option value="">Select One</option>
                                        <option value="Full Time" @if($edit->emp_type == 'Full Time') Selected @elseif(old('empType') == 'Full Time') Selected @endif>Full Time </option>
                                        <option value="Part Time" @if($edit->emp_type == 'Part Time') Selected @elseif(old('empType') == 'Part Time') Selected @endif>Part Time</option>
                                        <option value="Freelance" @if($edit->emp_type == 'Freelance') Selected @elseif(old('empType') == 'Freelance') Selected @endif>Frelance</option>
                                        <option value="Contract" @if($edit->emp_type == 'Contract') Selected @elseif(old('empType') == 'Contract') Selected @endif>Contract</option>
                                        <option value="Internship" @if($edit->emp_type == 'Internship') Selected @elseif(old('empType') == 'Internship') Selected @endif>Internship</option>
                                        <option value="Remote" @if($edit->emp_type == 'Remote') Selected @elseif(old('empType') == 'Remote') Selected @endif>Remote</option>
                                        <option value="Hybrid" @if($edit->emp_type == 'Hybrid') Selected @elseif(old('empType') == 'Hybrid') Selected @endif>Hybrid</option>
                                    </select>
                                    @error('empType')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div><!-- end row -->

                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-group clearfix">
                                    <label for="salary">Salary<span class="text-danger">*</span> :</label>
                                    <input class="required form-control" id="salary" value="{{$edit->salary ?? old('salary')}}" name="salary" type="number">
                                    @error('salary')
                                    <small class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div><!-- end row -->

                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <fieldset class="row">
                                    <legend class="col-sm-6 pt-0">Status*:</legend>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="gender1" {{$edit->pro_status == 'Promoted'|| old('status') == 'Promoted' ? 'checked' : '' }} value="Promoted">
                                            <label class="form-check-label" for="gender1">
                                                Promoted
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="gender2" value="Demoted" {{$edit->pro_status == 'Demoted'|| old('status') == 'Demoted' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender2">
                                                Demoted
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="gender3" value="Unchanged" {{$edit->pro_status == 'Unchanged' || old('status') == 'Unchanged' ? 'Checked' : ''}}>
                                            <label class="form-check-label" for="gender3">
                                                Unchanged
                                            </label>
                                        </div>
                                        @error('status')
                                        <small class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </fieldset>
                            </div>
                        </div><!-- end row -->
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
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
