<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Dashboard | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="SupreoX" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('uploads/basic/'.$basic->favlogo)}}">
    <!-- Vendor css -->
    <link href=" {{asset('contents/admin') }}/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href=" {{asset('contents/admin') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href=" {{asset('contents/admin') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme Config Js -->
    <script src=" {{asset('contents/admin') }}/assets/js/config.js"></script>
</head>
<body class="authentication-bg bg-primary">
<div class="page-container">

    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0">404 Error</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="text-center">
                <div class="font-80 text-dark">4<i class="mdi mdi-emoticon-sad-outline mx-2"></i>4</div>
                <h3 class="text-uppercase">Sorry You have No Acces To Visit The Page !</h3>
                <p class="text-muted mt-4" style="color:red;">
                    
                    @if(Auth::user()->role_id == 2)
                    <li><span class="text-dark">It's looking like you may have taken a wrong turn.<br>You only can Create,View,Edit and Other Things</span></li>
                    @elseif(Auth::user()->role_id == 3)
                    <li><span class="text-dark">It's looking like you may have taken a wrong turn.<br>You only Access to Catering Features</span></li>
                    @endif
                </p>

                <a class="btn btn-info mt-3" href="{{route('superadmin')}}">Return Home</a>
            </div> <!-- end /.text-center-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

</div> <!-- container -->

    <!-- Vendor js -->
    <script src=" {{asset('contents/admin') }}/assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src=" {{asset('contents/admin') }}/assets/js/app.js"></script>

</body>

</html>