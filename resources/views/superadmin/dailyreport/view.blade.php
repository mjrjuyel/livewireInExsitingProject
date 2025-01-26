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
                        <div class="col-md-8 offset-md-2">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>Daily Report of :- {{$view->employe->emp_name}}!
                                        </h3>
                                    </div>

                                    <div class="col-md-5 text-end">
                                        <a href="{{route('superadmin.dailyreport')}}" class="btn btn-primary card_header text-end"><i class="mdi mdi-eye-circle-outline header_icon"></i>All Report
                                        </a>
                                    </div>
                                </div>
                            </div>

                            
                            <table class="table border view_table">

                                <tr>
                                    <td>Submit By</td>
                                    <td>:</td>
                                    <td>
                                        {{$view->employe->emp_name}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employe As a</td>
                                    <td>:</td>
                                    <td>
                                        {{$view->employe->emp_desig->title}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Work Details</td>
                                    <td>:</td>
                                    <td class="text-danger">
                                        {!! $view->detail !!}
                                    </td>
                                </tr>

                                
                                <tr>
                                    <td>Submited Date</td>
                                    <td>:</td>

                                    <td>{{$view->submit_date->format('d-M-Y ')}}</td>
                                </tr>

                                <tr>
                                    <td>Data Editor</td>
                                    <td>:</td>
                                    <td class="text-danger">{{optional($view->report_editor)->name}}</td>
                                </tr>

                                <tr>
                                    <td>Created At</td>
                                    <td>:</td>
                                    <td>{{formatDate($view->created_at)}}</td>
                                </tr>
                                <tr>
                                    <td>Edited At</td>
                                    <td>:</td>
                                    <td>@if($view->updated_at)
                                    {{formatDate($view->updated_at)}}
                                    @endif
                                    </td>
                                </tr>
                            </table>

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
