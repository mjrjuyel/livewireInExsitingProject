@extends('layouts.employe')
@section('content')

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

                    <li class="breadcrumb-item active">Admin</li>
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
                                <h3 class="card_header"><i class="fa-solid fa-shirt header_icon"></i>Profile
                                    Update
                                </h3>
                            </div>

                            <div class="col-md-2 text-end"><a href="{{ route('dashboard.admin') }}" class="btn btn-bg btn-primary btn_header ">
                                    <i class="fa-brands fa-servicestack btn_icon"></i>All Admin</a>
                            </div>
                            <div class="col-md-2"><a href="{{ url('dashboard/admin/view/'.$edit->slug) }}" class="btn btn-bg btn-primary btn_header"><i class="uil-edit btn_icon"></i>View</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('dashboard.admin.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-8 offset-2">
                                <input type="hidden" value="{{ $edit->id }}" name="id">
                                <input type="hidden" value="{{ $edit->slug }}" name="slug">

                                <div class="mb-3">
                                    <label class="form-label">Name<span class="text-danger">* </span>:
                                    </label>
                                    <input type="text" class="form-control" name="name" value="{{ $edit->name }}" placeholder="Enter email">
                                    @error('name')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email<span class="text-danger">*</span> :</label>
                                    <input type="email" class="form-control" name="email" value="{{ $edit->email }}" placeholder="Enter email">
                                    @error('email')
                                    <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label">Image<span class="text-danger">*</span>:</label>
                                            <input type="file" class="form-control" name="image">
                                            <small id="emailHelp" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        @if($edit->image != '')
                                        <img src="{{ asset('uploads/admin/profile/'.$edit->image) }}" class="img-fluid" alt="" style="width:50px; height:100px; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select type="text" class="form-control" name="role">
                                        @foreach($role as $role)
                                        <option value="{{ $role->id }}" @if($edit->role_id ==$role->id)
                                            Selected @endif>{{ $role->role_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Designation</label>
                                    <select type="text" class="form-control" name="designation">
                                        <option value="">Select One</option>
                                        @foreach($designation as $role)
                                        <option value="{{ $role->id }}" @if($edit->designation_id == $role->id)
                                            Selected @endif>{{ $role->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">
                                    </small>
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
