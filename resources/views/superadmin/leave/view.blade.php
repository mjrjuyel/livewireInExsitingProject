@extends('layouts.superAdmin')

@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet">
<link href="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item">Super Admin</li>
                    <li class="breadcrumb-item active">Update</li>
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
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>Update Leave For : {{$view->employe->emp_name}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('superadmin.leave.update') }}" method="post">
                                    @csrf

                                    <div class="row mt-3">
                                        <div class="col-5 offset-1">
                                            <input type="hidden" value="{{ $view->id }}" name="id">
                                            <input type="hidden" value="{{ $view->slug }}" name="slug">

                                            <div class="mb-3">
                                                <label class="form-label">Leave Type<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" name="name" value="{{ $view->leavetype->type_title }}" disabled>
                                                @error('name')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">leave Start Date<span class="text-danger">*</span> :</label>
                                                <input type="text" class="form-control" name="start" value="{{ $view->start_date->format('d-M-Y') }}" placeholder="{{ $view->start_date->format('d-M-Y') }}" disabled>
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">leave Start Date<span class="text-danger">*</span> :</label>
                                                <input type="text" class="form-control" value="{{ $view->end_date->format('d-M-Y') }}" disabled>
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <input class="form-control" type="text" value="{{ $view->reason }}" disabled>
                                            </div>
                                            <hr>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-control" type="text" name="status">
                                                    <option value="">Application Status</option>
                                                    <option class="text-warning" value="1" @if($view->status == 1) Selected @endif> Pending</option>
                                                    <option class="text-primary" value="2" @if($view->status == 2) Selected @endif> Approved</option>
                                                    <option class="text-danger" value="3" @if($view->status == 3) Selected @endif> Cancle</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-5">

                                            @if($view->unpaid_request != 1)
                                            <div class="mb-3">
                                                <label class="form-label">Request Leave For<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" value="{{ $view->total_day }} days" disabled>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Remain Paid Leave In an Annual Year {{ date('Y')}}<span class="text-danger">*</span> :</label>
                                               @if($view->paid_remaining_month != null)
                                                    @if($view->paid_remaining_month >= 1) 
                                                        @if($view->paid_remaining_month == 1)
                                                            <input type="text" class="form-control" value="{{$view->paid_remaining_month}} Day" disabled>
                                                        @elseif($view->paid_remaining_month <= 3)
                                                            <input type="text" class="form-control" value="{{ $view->paid_remaining_month }}Days" disabled>
                                                        @endif
                                                    @else
                                                        <input type="text" class="form-control text-danger" value="Yearly Leave Limit Reached " disabled>
                                                    @endif
                                               @else
                                               <input type="text" class="form-control text-primary" value="{{$defaultValue->month_limit}}" disabled>
                                               @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Remain Paid Leave In an Annual Year {{ date('Y')}}<span class="text-danger">*</span> :</label>
                                                @if($view->paid_remaining_year != null) 
                                                    @if($view->paid_remaining_year >= 1) 
                                                            @if($view->paid_remaining_year == 1)
                                                                <input type="text" class="form-control" value="{{$view->paid_remaining_year}} Day" disabled>
                                                            @elseif($view->paid_remaining_year <= 14)
                                                                <input type="text" class="form-control" value="{{ $view->paid_remaining_year }}Days" disabled>
                                                            @endif
                                                    @else
                                                        <input type="text" class="form-control text-danger" value="Yearly Leave Limit Reached" disabled>
                                                    @endif
                                                @else
                                                    <input type="text" class="form-control text-primary" value="{{$defaultValue->year_limit}}" disabled>
                                                @endif
                                            </div>

                                            @else
                                            <div class="mb-3">
                                                <label class="form-label">Request Unpaid Leave<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control text-danger" value="{{ $view->total_day }} days" disabled>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Total Non Paid leave in {{ date('Y')}}<span class="text-danger">*</span> :</label>
                                               @if($view->total_unpaid != null)
                                                    @if($view->total_unpaid >= 1) 
                                                        @if($view->total_unpaid == 1)
                                                            <input type="text" class="form-control" value="{{$view->total_unpaid}} Day" disabled>
                                                        @else
                                                            <input type="text" class="form-control" value="{{ $view->total_unpaid }}Days" disabled>
                                                        @endif
                                                    @endif
                                               @else
                                               <input type="text" class="form-control text-primary" value="Not yet" disabled>
                                               @endif
                                            </div>

                                            @endif

                                            

                                            <div class="mb-3">
                                                <label class="form-label">Modified date<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" id="humanfd-datepicker" name="end" class="form-control" value="" placeholder="If Reduce Date" placeholder="">
                                                @error('end')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Feedback</label>
                                                @if($view->comments != '')
                                                <textarea class="form-control" rows="4" style="resize:none" type="text" name="comment">{{ $view->comments }}</textarea>
                                                @else
                                                <textarea class="form-control" rows="4" style="resize:none" type="text" name="comment" placeholder="Some Feedback"></textarea>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-4 offset-4">
                                                @if($view->status == 2)
                                                  <a href="{{route('superadmin.leave')}}" class="btn btn-primary">Back To Index</a>
                                                @elseif($view->status != 2)
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                 @endif
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
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>

@endsection
