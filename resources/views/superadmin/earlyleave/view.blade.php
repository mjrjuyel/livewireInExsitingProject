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
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">Early Leave</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>!{{$view->employe->emp_name}}!
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.earlyleave.update') }}" method="post">
                                @csrf

                                <div class="row mt-3">
                                    <div class="col-5 offset-1">
                                        <input type="hidden" value="{{ $view->id }}" name="id">

                                        <div class="mb-3">
                                            <label class="form-label">Leave Type<span class="text-danger">* </span>:
                                            </label>
                                            @if($view->leave_type_id != 0) {{$view->leavetype->type_title}}
                                            @else
                                            Other Reason : {{$view->other_type}}
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Submitted Date<span class="text-danger">* </span>:
                                            </label>
                                            {{$view->created_at->format('d-M-Y')}}
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">leave Date<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control" name="start" value="{{ $view->leave_date->format('d-M-Y') }}" disabled>

                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">leave Start Time<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control" value="{{ displayTime($view->start) }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">leave End Time<span class="text-danger">*</span> :</label>
                                            <input type="text" class="form-control" value="{{displayTime($view->end)}}" disabled>
                                        </div>

                                        <div class="mb-3">
                                            <div class="text-dark">Leave Description:</div>
                                            <div class="mt-2">{!! $view->detail !!}</div>
                                        </div>

                                        <hr>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" type="text" name="status">
                                                <option value="">Application Status</option>
                                                <option class="text-warning" value="1" @if($view->status == 1) Selected @endif> Pending</option>
                                                <option class="text-primary" value="2" @if($view->status == 2) Selected @endif> Approved</option>
                                                <option class="text-danger" value="3" @if($view->status == 3) Selected @endif> Cancle</option>
                                                <option class="text-info" value="4" @if($view->status == 4) Selected @endif> Feedback</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-5">


                                        <div class="mb-3">
                                            <label class="form-label">Request Leave For (hours) <span class="text-danger">* </span>:
                                            </label>
                                            <h4 class="text-danger">{{convertTime($view->total_hour)}}</h4>
                                        </div>


                                        {{-- <div class="mb-3">
                                                <label class="form-label">Modified date<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" id="humanfd-datepicker" name="end" class="form-control" value="" placeholder="If Reduce Date" placeholder="">
                                                @error('end')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div> --}}
                                    <div class="mb-3">
                                        <label class="text-dark">Application sent From:</label>
                                        <span class="mt-2">{{ $view->submit_by }} Dashboard</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-dark">Application Created At:</label>
                                        <span class="mt-2">{{formatDate($view->created_at)}} </span>
                                    </div>

                                    @if($view->updated_at)
                                    <div class="mb-3">
                                        <label class="text-dark">Application Edited At:</label>
                                        <span class="mt-2">{{formatDate($view->updated_at)}} </span>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label">Feedback</label>
                                        @if($view->comments != '')
                                        <textarea class="form-control" rows="4" style="resize:none" type="text" name="comment">{{ $view->comments }}</textarea>
                                        @else
                                        <textarea class="form-control" rows="4" style="resize:none" type="text" name="comment" placeholder="Some Feedback"></textarea>
                                        @endif
                                    </div>

                                    <hr>
                                    {{-- <h4 class="text-info">Click Here to Customize leave Days From Applicant Total Days</h4>
                                    <label class="form-label text-danger">
                                        <input type="checkbox" name="unpaidLeave" value="1" id="unpaidLeaveCheckbox">Want To Customize Un-Paid leave
                                    </label>

                                    <div id="unpaidLeaveFields" style="display: none;">
                                        <label for="unpaidDays">Un-Paid Leave Days:</label>
                                        <input class="form-control" type="number" id="unpaidDays" name="unpaidDay" min="0" max="">

                                        <input type="hidden" name="total_leave" value="">
                                    </div> --}}

                                </div>
                                <div class="row">
                                    <div class="col-4 offset-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
