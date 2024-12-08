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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item">Admin</li>
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
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>Update Leave For : {{$view->admin->name}}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dashboard.superAdmin.leave.upadte') }}" method="post" >
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-6 offset-2">
                                            <input type="hidden" value="{{ $view->id }}" name="id">
                                            <input type="hidden" value="{{ $view->slug }}" name="slug">

                                            <div class="mb-3">
                                                <label class="form-label">Leave Type<span class="text-danger">* </span>:
                                                </label>
                                                <input type="text" class="form-control" name="name" value="{{ $view->leave_type }}" disabled>
                                                @error('name')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">leave Start Date<span class="text-danger">*</span> :</label>
                                                <input type="text" class="form-control"  value="{{ $view->start_date }}" disabled>
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">leave Start Date<span class="text-danger">*</span> :</label>
                                                <input type="text" class="form-control"  value="{{ $view->end_date }}" disabled>
                                                @error('email')
                                                <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <input class="form-control" type="text" value="{{ $view->reason }}" disabled>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-control" type="text" name="status">
                                                <option value="">Application Status</option>
                                                        <option class="text-warning" value="1" @if($view->status == 1) Selected @endif> Pending</option>
                                                        <option class="text-primary" value="2" @if($view->status == 2) Selected @endif> Approved</option>
                                                        <option class="text-danger" value="3" @if($view->status == 3) Selected @endif> Cancle</option>
                                                </select>
                                            </div>



                                            <button type="submit" class="btn btn-primary">Submit</button>
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
