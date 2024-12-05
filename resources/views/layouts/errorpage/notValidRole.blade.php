@extends('layouts.admin')
@section('content')
<div class="page-container">

    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0">404 Error (alt)</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Error Pages</a></li>

                    <li class="breadcrumb-item active">404 Error (alt)</li>
                </ol>
            </div>
        </div>



    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="text-center">
                <div class="font-80 text-dark">4<i class="mdi mdi-emoticon-sad-outline mx-2"></i>4</div>
                <h3 class="text-uppercase">Page not Found</h3>
                <p class="text-muted mt-4">
                    It's looking like you may have taken a wrong turn. You have no access for this route. Here's a
                    little that might
                    help you get back on track.
                </p>

                <a class="btn btn-info mt-3" href="{{route('dashboard')}}">Return Home</a>
            </div> <!-- end /.text-center-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection