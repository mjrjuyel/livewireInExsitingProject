@extends('layouts.employe')
@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet">
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

@if(Session::has('unpaid'))
<script type="text/javascript">
    swal({
            title: "Are you sure?"
            , text: "You will not be able to recover this imaginary file!"
            , type: "warning"
            , showCancelButton: true
            , confirmButtonColor: "#DD6B55"
            , confirmButtonText: "Yes, delete it!"
            , cancelButtonText: "No, cancel plx!"
            , closeOnConfirm: false
            , closeOnCancel: false
        }
        , function(isConfirm) {
            if (isConfirm) {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });

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

                    <li class="breadcrumb-item active">Leave</li>
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
                                <h3 class="card_header"><i class="mdi mdi-coffee-off header_icon"></i>Leave Application Form
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('dashboard.leave.insert')}}" method="post">
                    
                            @csrf
                            <div class="row mt-3">
                                <div class="col-6 offset-2">
                                    <div class="mb-3">
                                   
                                        <label class="form-label">Leave Type<span class="text-danger">* </span>:
                                        </label>
                                        <select type="text" class="form-control" name="leave_type" placeholder="Enter Leave">
                                            <option value="">Select A Type</option>
                                            @foreach($leaveType as $type)
                                            <option value="{{$type->id}}">{{$type->type_title}}</option>
                                            @endforeach
                                            <option value="0" id="other_reason">Other</option>
                                        </select>
                                        @error('leave_type')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    
                                    <div class="mb-3 leave_type" style="display:none;">
                                        <label class="form-label text-danger">Write Short Type<span class="text-danger"> :</span>:
                                        </label>
                                        <input type="text" name="others" class="form-control" placeholder="Personal Reason">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Start From<span class="text-danger">* </span>:
                                        </label>
                                        <input type="text" id="humanfd-datepicker" name="start" class="form-control" placeholder="">
                                        @error('start')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">To End<span class="text-danger">* </span>:
                                        </label>
                                        {{-- data-provide="datepicker" --}}
                                        <input type="text" id="humanfd-datepicke" name="end" class="form-control" placeholder="">
                                        @error('end')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Short Reason<span class="text-danger">* </span>:
                                        </label>

                                        <textarea type="text" style="resize:none;" rows="4" name="reason" class="form-control" placeholder="Write Some Reason">{{old('reason')}}</textarea>

                                        @error('reason')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>

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
<script>
  $(document).ready(function(){
    
    $('.leave_type').hide();
    $('body').on('change', 'select[name="leave_type"]', function() {
        if ($(this).val() === "0") {
            $('.leave_type').show();
        } else {
            $('.leave_type').hide(); 
        }
    });
  });
</script>
@endsection
@section('js')
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>
<script src="{{ asset('contents/admin') }}/assets/js/custom.js"></script>

@endsection
