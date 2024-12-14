<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('contents/admin')}}/assets/images/favicon.ico">
    <!-- Vendor css -->
    <link href="{{asset('contents/admin')}}/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{asset('contents/admin')}}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href="{{asset('contents/admin')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme Config Js -->
    <script src="{{asset('contents/admin')}}/assets/js/config.js"></script>
</head>

<body class="authentication-bg bg-primary">

    <div class="account-pages pt-5 my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="account-card-box bg-light rounded-2 p-2">
                        <div class="card mb-0 border border-primary border-4">
                            <div class="card-body p-4">

                                <div class="text-center">
                                    <div class="my-3">
                                        <a href="index.html">
                                            <span><img src="{{asset('contents/admin')}}/assets/images/logo-dark.png" alt="" height="28"></span>
                                        </a>
                                    </div>
                                    <h5 class="text-muted text-uppercase py-3 font-16">Sign In </h5>
                                     <h5 class="text-muted text-uppercase py-3 font-16">Super Admin </h5>
                                </div>

                                <form action="{{ route('login') }}" method="POST" class=" mt-2">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input class="form-control" type="email" name="email" value="{{old('email')}}" required placeholder="Enter your Email">
                                        @error('email')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control" type="password" name="password" required="" id="password" placeholder="Enter your password">
                                        @error('password')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group text-center mb-3">
                                        <button class="btn btn-success btn-block waves-effect waves-light w-100" type="submit"> Log In </button>
                                    </div>

                                    <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i>
                                        Forgot your password?</a>

                                </form>

                                <div class="text-center mt-4">
                                    <h5 class="text-muted py-2"><b>Sign in with</b></h5>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-facebook waves-effect font-14 waves-light mt-3">
                                                <i class="fab fa-facebook-f me-1"></i> Facebook
                                            </button>

                                            <button type="button" class="btn btn-twitter waves-effect font-14 waves-light mt-3">
                                                <i class="fab fa-twitter me-1"></i> Twitter
                                            </button>

                                            <button type="button" class="btn btn-googleplus waves-effect font-14 waves-light mt-3">
                                                <i class="fab fa-google-plus-g me-1"></i> Google+
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Don't have an account? <a href="auth-register.html" class="text-white ms-1"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <!-- Vendor js -->
    <script src="{{asset('contents/admin')}}/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{asset('contents/admin')}}/assets/js/app.js"></script>

</body>


<!-- Mirrored from coderthemes.com/uplon/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2024 09:35:25 GMT -->

</html>
