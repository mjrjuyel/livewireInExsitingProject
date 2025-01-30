@extends('layouts.superAdmin')

@section('css')
<link href="{{ asset('contents/admin') }}/assets//libs/@adactive/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets//libs/mohithg-switchery/switchery.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets//libs/multiselect/css/multi-select.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets//libs/select2/css/select2.min.css" rel="stylesheet" />
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

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Role</li>
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
                                <h3 class="card_header"><i class="fa-solid fa-shirt header_icon"></i>Role
                                </h3>
                            </div>

                            <div class="col-md-2 text-end"><a href="{{route('superadmin.role')}}" class="btn btn-bg btn-primary btn_header ">
                                    <i class="fa-brands fa-servicestack btn_icon"></i>All Role</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('superadmin.role.insert')}}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-6 offset-2">

                                <div class="mb-3">
                                    <label class="form-label">Role Name<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Role">
                                    @error('name')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>
                                

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8 offset-md-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Permissions</h5>
                                    </div>
                                    <div class="card-body pt-2">
                                        <div class="row g-3">
                                        @foreach($permissions as $permission)
                                            <div class="col-lg-2">
                                                <p class="sub-header">
                                                   {{$permission->name}} 
                                                </p>
                                                <div class="switchery-demo">
                                                    <input type="checkbox" name="permission[]" value="{{$permission->name}}" data-plugin="switchery" data-color="#ff7aa3" />
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-5 offset-md-5">
                            <button type="submit" class="btn btn-primary">Submit
                            </button>
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
<script src="{{ asset('contents/admin') }}/assets//libs/@adactive/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/mohithg-switchery/switchery.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/multiselect/js/jquery.multi-select.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/jquery.quicksearch/jquery.quicksearch.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/select2/js/select2.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/jquery-mockjax/jquery.mockjax.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets//libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<script src="{{ asset('contents/admin') }}/assets//js/pages/form-advanced.js"></script>
@endsection
