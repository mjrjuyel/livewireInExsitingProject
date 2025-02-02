@extends('layouts.superAdmin')

@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet">
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
                                                <label class="form-label">leave Start Date<span class="text-danger">*</span> :</label>
                                                <input type="text" class="form-control" name="start" value="{{ $view->start_date->format('d-M-Y') }}" placeholder="{{ $view->start_date->format('d-M-Y') }}" disabled>
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">leave End Date<span class="text-danger">*</span> :</label>
                                                <input type="text" class="form-control" value="{{ $view->end_date->format('d-M-Y') }}" disabled>
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                
                                                <div >{!! $view->reason !!}</div>
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
                                                <label class="form-label">Request Leave For<span class="text-danger">* </span>:
                                                </label>
                                                @if($view->total_unpaid + $view->total_paid <= 1) 
                                                    <span class="text-danger">
                                                    {{ $view->total_unpaid + $view->total_paid }} Day
                                                    </span>
                                                    @else
                                                    <span class="text-danger">
                                                        {{ $view->total_unpaid + $view->total_paid }} Days
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Request Paid Leave <span class="text-danger">* </span>:
                                                </label>
                                                 @if($view->total_paid <= 1) 
                                                     @if($view->total_paid == 1) 
                                                    <span class="text-danger">
                                                    {{ $view->total_paid  }} Day
                                                    </span>
                                                    @else
                                                    0 Day
                                                    @endif
                                                @else
                                                    <span class="text-danger">
                                                        {{ $view->total_paid }} Days
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Request Un-Paid Leave <span class="text-danger">* </span>:
                                                </label>
                                                 @if($view->total_unpaid <= 1) 
                                                    @if($view->total_unpaid == 1) 
                                                    <span class="text-danger">
                                                    {{ $view->total_unpaid  }} Day
                                                    </span>
                                                    @else
                                                    0 Day
                                                    @endif
                                                @else
                                                    <span class="text-danger">
                                                        {{ $view->total_unpaid }} Days
                                                    </span>
                                                @endif
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
@section('js')
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>
<!-- CKEditor CDN -->
     <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
       ClassicEditor.create(document.querySelector('#editor')).catch(error => {
                console.error(error);
            });
    </script>

@endsection
