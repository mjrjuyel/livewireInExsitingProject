@extends('layouts.superAdmin')
@section('superAdminContent')
@if(Session::has('success'))
<script type="text/javascript">
swal({
    title: "Success!",
    text: "{{ Session::get('success') }}",
    icon: "success",
    button: "OK",
    timer: 5000,
});
</script>
@endif
@if(Session::has('error'))
<script type="text/javascript">
swal({
    title: "Opps!",
    text: "{{ Session::get('error') }}",
    icon: "error",
    button: "OK",
    timer: 5000,
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Bank Branch</li>
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
                                <h3 class="card_header"><i class="mdi mdi-bank-transfer header_icon"></i>Bank Branch Update
                                </h3>
                            </div>

                            <div class="col-md-4 text-end"><a href="{{route('portal.bank_branch')}}"
                                    class="btn btn-bg btn-primary btn_header ">
                                    <i class="mdi mdi-bank-transfer btn_icon"></i>All Bank Branch</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('portal.bank_branch.update')}}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-6 offset-2">
                            <input type="hidden" name="id" value="{{$edit->id}}">

                            <div class="mb-3">
                                    <label class="form-label">Bank Name<span class="text-danger">* </span>:
                                    </label>
                                    <select type="text" class="form-control" name="bank_id" value="">

                                    @foreach($bankName as $value)
                                        <option value="{{$value->id}}" @if($edit->bank_id == $value->id) Selected @endif>{{$value->bank_name}}</option>    
                                    @endforeach

                                    </select>
                                    @error('bank_id')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                            </div>

                            
                                <div class="mb-3">
                                    <label class="form-label">Bank Branch Name<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{$edit->bank_branch_name}}"
                                        placeholder="Enter Bank Branch">
                                    @error('name')
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
@endsection