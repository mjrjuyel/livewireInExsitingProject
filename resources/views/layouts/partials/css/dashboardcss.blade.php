<link href="{{ asset('contents/admin') }}/assets/css/vendor.min.css" rel="stylesheet" />
<!-- App css -->
<link href="{{ asset('contents/admin') }}/assets/css/app.min.css" rel="stylesheet" id="app-style" />
<!-- Icons css -->
<link href="{{ asset('contents/admin') }}/assets/css/icons.min.css" rel="stylesheet" />
@yield('css')
<link href="{{ asset('contents/admin') }}/assets/css/style.css" rel="stylesheet">
<!-- Theme Config Js -->
<style>
 .form-control {
    display: block;
    width: 100%;
    padding: .45rem .63rem;
    font-size: .9rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    /* -webkit-appearance: none; */
    -moz-appearance: auto;
     appearance: auto; 
    background-color: var(--bs-secondary-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: .25rem;
    -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
}
</style>
<script src="{{ asset('contents/admin') }}/assets/js/config.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="{{ asset('contents/admin') }}/assets/js/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">