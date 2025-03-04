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

                    <li class="breadcrumb-item active">Evaluation</li>
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
                                <h3 class="card_header"><i class="mdi mdi-account-hard-hat header_icon"></i>Evaluation update
                                </h3>
                            </div>

                            <div class="col-md-4 text-end"><a href="{{route('admin.evaluation',Crypt::encrypt($edit->emp_id))}}" class="btn btn-bg btn-primary btn_header ">
                                    <i class="fa-brands fa-servicestack btn_icon"></i>All Evaluation</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('admin.evaluation.update')}}" method="post">
                        @csrf
                            <div class="row mt-5">
                            <input type="hidden" name="id" value="{{$edit->id}}">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-group clearfix">
                                        <label>Name<span class="text-danger">*</span> :</label>
                                        <select type="text" class="form-control" name="employe">
                                            <option value="{{ $edit->emp_id }}">{{ $edit->employe->emp_name }}</option>
                                        </select>
                                        @error('employe')
                                        <small class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div><!-- end row -->
                            @php
                                $last_date = new DateTime($edit->eva_last_date);
                            @endphp
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-group clearfix">
                                        <label>Last Evaluation Date<span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control" id="humanfd-datepicke" name="eva_last_date" value="{{$edit->eva_last_date}}" placeholder="select Start date">
                                        @error('eva_last_date')
                                        <small class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-group clearfix">
                                        <label>Next Evaluation Date<span class="text-danger">*</span> :</label>
                                        <input type="text" class="form-control" id="humanfd-datepic" name="eva_next_date" value="{{$edit->eva_next_date}}" placeholder="Select End Date">
                                        @error('eva_next_date')
                                        <small class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary waves-effect waves-light text-center mt-3">Update</button>
                                </div>
                            </div><!-- end row -->
                            
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
