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

                    <li class="breadcrumb-item active">Daily Report</li>
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
                                <h3 class="card_header"><i class="fa-solid fa-book header_icon"></i>Daily Report Edit Form
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('dashboard.dailyreport.update')}}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-5 offset-2">
                            <input type="hidden" name="id" value="{{$edit->id}}">
                             <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Office Check in Time<span class="text-danger">* </span>:
                                            </label>
                                            <input type="time" name="checkin" class="form-control"  value="{{\Carbon\Carbon::parse($edit->check_in)->format('H:i')}}" placeholder="">

                                            @error('checkin')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Office Check in Time<span class="text-danger">* </span>:
                                            </label>
                                            <input type="time" name="checkout" class="form-control" value="{{ \Carbon\Carbon::parse($edit->check_out)->format('H:i') }}" placeholder="">

                                            @error('checkout')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Current User Name <span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" class="form-control" value="{{$edit->employe->emp_name}}" placeholder="Enter Daily Report" disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Date of Work<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" id="humanfd-datepicker"  class="form-control" onfocus="disablePastDates()" value="{{$edit->submit_date}}" disabled>
                                   
                                    @error('submit_date')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Details About Your Today's Activity<span class="text-danger">* </span>:
                                    </label>

                                    <textarea type="text" style="resize:none;" id="editor" rows="4" name="detail" class="form-control" value="" placeholder="What You Have Done Today?">{{$edit->detail}}</textarea>
                                    @error('detail')
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

<script>
function disablePastDates() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = yyyy + '-' + mm + '-' + dd;
  document.getElementById("inline-datepicker").setAttribute("min", today);
}
</script>
<!--end Footer -->
@endsection
@section('js')
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>

{{-- chechk editpor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
       ClassicEditor.create(document.querySelector('#editor')).catch(error => {
                console.error(error);
            });
    </script>

@endsection
