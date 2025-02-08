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

                    <li class="breadcrumb-item active">Promotion List</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        
                    </div>

                    <div class="">
                        <table class="table table-centered text-center" id="">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Promotion Date</th>
                                    <th class="text-center">Employee Type</th>
                                    <th class="text-center">Salary</th>
                                    <th class="text-center">ProMotion Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allPromotion as $promotion)
                                <tr>
                                    <td>
                                        {{ optional($promotion->designation)->title }}
                                    </td>

                                    <td>
                                        {{optional($promotion->department)->depart_name}}
                                    </td>

                                    <td>
                                        {{$promotion->pro_date->format('d-M-Y')}}
                                    </td>
                                    <td>
                                        {{optional($promotion)->emp_type}}
                                    </td>
                                    <td>
                                        {{optional($promotion)->salary}}
                                    </td>
                                    <td>
                                        {{optional($promotion)->pro_status}}
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item" href="{{ route('superadmin.designation.view',$promotion->id) }}"><i class="mdi mdi-view-agenda"></i>View</a></li>

                                                <li><a href="#" class="dropdown-item waves-effect waves-light text-warning" data-bs-toggle="modal" data-bs-target="#promotion"><i class="mdi mdi-receipt-text-edit">
                                                        </i>Edit</a>
                                                </li>
                                                <li><a href="#" id="delete" class="dropdown-item waves-effect waves-light text-danger" data-id="{{$promotion->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="mdi mdi-delete-alert">
                                                        </i>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                        {{-- edit --}}
                                        <div id="promotion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content bg-warning">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Upgrade {{$promotion->employe->emp_name}} Designation ?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <form action="{{route('admin.promotion.update')}}" method="post">
                                                        @csrf
                                                        <div class="modal-body modal_body">
                                                            <div class="row">
                                                                <div class="col-md-6 offset-md-3">
                                                                    <div class="form-group clearfix">
                                                                        <label>Name<span class="text-danger">*</span> :</label>
                                                                        <select type="text" class="form-control" name="employe">
                                                                            <option value="{{ $promotion->emp_id }}">{{ $promotion->employe->emp_name }}</option>
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
                                                                            <option value="{{ $depart->id }}" {{$promotion->depart_id == $depart->id || old('department') == $depart->id ? 'Selected' : '' }}>{{ $depart->depart_name }}
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
                                                                            <option value="{{$designation->id}}" {{ $promotion->desig_id == $designation->id || old('desig') == $designation->id ? 'Selected' : ''}}>{{$designation->title}}</option>
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
                                                                            <option value="Full Time" @if($promotion->emp_type == 'Full Time') Selected @elseif(old('empType') == 'Full Time') Selected @endif>Full Time </option>
                                                                            <option value="Part Time" @if($promotion->emp_type == 'Part Time') Selected @elseif(old('empType') == 'Part Time') Selected @endif>Part Time</option>
                                                                            <option value="Freelance" @if($promotion->emp_type == 'Freelance') Selected @elseif(old('empType') == 'Freelance') Selected @endif>Frelance</option>
                                                                            <option value="Contract" @if($promotion->emp_type == 'Contract') Selected @elseif(old('empType') == 'Contract') Selected @endif>Contract</option>
                                                                            <option value="Internship" @if($promotion->emp_type == 'Internship') Selected @elseif(old('empType') == 'Internship') Selected @endif>Internship</option>
                                                                            <option value="Remote" @if($promotion->emp_type == 'Remote') Selected @elseif(old('empType') == 'Remote') Selected @endif>Remote</option>
                                                                            <option value="Hybrid" @if($promotion->emp_type == 'Hybrid') Selected @elseif(old('empType') == 'Hybrid') Selected @endif>Hybrid</option>
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
                                                                        <input class="required form-control" id="salary" value="{{$promotion->salary ?? old('salary')}}" name="salary" type="number">
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
                                                                                <input class="form-check-input" type="radio" name="status" id="gender1" {{$promotion->pro_status == 'Promoted'|| old('status') == 'Promoted' ? 'checked' : '' }} value="Promoted">
                                                                                <label class="form-check-label" for="gender1">
                                                                                    Promoted
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio" name="status" id="gender2" value="Demoted" {{$promotion->pro_status == 'Demoted'|| old('status') == 'Demoted' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="gender2">
                                                                                    Demoted
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio" name="status" id="gender3" value="Unchanged"{{$promotion->pro_status == 'Unchanged' || old('status') == 'Unchanged' ? 'Checked' : ''}}>
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

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Yes</button>
                                                        </div>
                                                    </form>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>

                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>

</div> <!-- container -->

{{-- soft delete MOdal  --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Office Depart Info? </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('superadmin.designation.delete')}}" method="post">
                @method('delete')
                @csrf
                <div class="modal-body modal_body">
                    <h5 class="font-16">Are You Sure Want to Delete ?</h5>
                    <input type="hidden" name="id" id="modal_id" value="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@endsection
