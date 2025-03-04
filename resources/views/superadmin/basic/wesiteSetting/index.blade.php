@extends('layouts.superAdmin')
@section('superAdminContent')

<div class="page-container">
    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0">Dashboard | SuperAdmin</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">SuperAdmin</a></li>

                    <li class="breadcrumb-item active">Basic</li>
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
                                <h3 class="card_header"><i class="fa-solid fa-shirt header_icon"></i>Basic Information
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('dashboard.admin.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-8 offset-2">

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Main Logo<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="file" class="form-control" name="Mlogo">
                                            @error('Mlogo')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img src="" alt="Main Logo">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Footer Logo<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="file" class="form-control" name="Flogo">
                                            @error('Flogo')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img src="" alt="Footer Logo">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="">
                                            <label class="form-label">Basic Favion<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="file" class="form-control" name="favlogo">
                                            @error('favLogo')
                                            <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img src="" alt="Footer Logo">
                                    </div>
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