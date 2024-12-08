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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>

                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-layers float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Orders</h6>
                    <h3 class="my-3" data-plugin="counterup">1,587</h3>
                    <span class="badge bg-success me-1"> +11% </span> <span class="text-muted">From previous
                        period</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-paypal float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Revenue</h6>
                    <h3 class="my-3">$<span data-plugin="counterup">46,782</span></h3>
                    <span class="badge bg-danger me-1"> -29% </span> <span class="text-muted">From previous
                        period</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-chart float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Average Price</h6>
                    <h3 class="my-3">$<span data-plugin="counterup">15.9</span></h3>
                    <span class="badge bg-danger me-1"> 0% </span> <span class="text-muted">From previous
                        period</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="icon-rocket float-end m-0 h2 text-muted"></i>
                    <h6 class="text-muted text-uppercase mt-0">Product Sold</h6>
                    <h3 class="my-3" data-plugin="counterup">1,890</h3>
                    <span class="badge bg-warning me-1"> +89% </span> <span class="text-muted">Last
                        year</span>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

</div> <!-- container -->

<!-- Footer Start -->
<footer class="footer">
    <div class="page-container">
        <div class="row">
            <div class="col-md-12 text-center">
                <script>
                document.write(new Date().getFullYear())
                </script> © Uplon - By <span
                    class="fw-semibold text-decoration-underline text-primary">Coderthemes</span>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div>
<!-- end Footer -->
@endsection