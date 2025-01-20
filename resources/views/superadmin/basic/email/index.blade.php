@extends('layouts.superAdmin')

@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/@adactive/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" />
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
                <h4 class="font-18 mb-0">Dashboard | SuperAdmin</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">SuperAdmin</a></li>

                    <li class="breadcrumb-item active">Email</li>
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
                                <h3 class="card_header"><i class="mdi mdi-email header_icon"></i>Set Application Email
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('superadmin.email.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-8 offset-2">

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label">Current Email<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <input type="text" class="form-control" name="" value="{{$setting->email}}" disabled>
                                            
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="">
                                            <label class="form-label">Insert Active Email Address For Admin<span class="text-danger">*
                                                </span>:
                                            </label>
                                            <div class="tags-default">
                                                <input type="text" name="emailAdd" data-role="tagsinput" value="{{$setting->email}}" placeholder="Add More Email" />
                                                @error('emailAdd')
                                                 <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="card-header bg-info">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card_header"  ><i class="mdi mdi-email header_icon"></i>Daily Report Receive in Email?
                                </h3>
                            </div>
                        </div>
                    </div>
                    @php
                        $date = now()->format('Y-m-d');
                        $totalReports = App\Models\DailyReport::whereDate('created_at', $date)->count();
                        $admin = App\Models\AdminEmail::first();

                        echo $admin;
                        
                    @endphp
                    {{$totalReports}}
                    <form action="" method="post" enctype="">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-6 text-end">
                                <div class="row mb-3">
                                    <h6>Basic</h6>
                                    <p class="sub-header">
                                        Yes or No?
                                    </p>
                                    <div class="switchery-demo">
                                       @if($setting->email_report != '')
                                       <input type="checkbox" value="1" data-id="{{$setting->email_report}}" id="active_feature" data-plugin="switchery" data-color="#3db9dc" checked/>
                                       @else
                                       <input type="checkbox" value="1" data-id="{{$setting->email_report}}" id="active_feature" data-plugin="switchery" data-color="#3db9dc"  />
                                       @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                              </div>
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
<script>
     $('body').on("change", "#active_feature", function () {
       var Id = $(this).data('id');
       alert(Id);
    });
</script>
@endsection

@section('js')

<script src="{{ asset('contents/admin') }}/assets/libs/@adactive/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/mohithg-switchery/switchery.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/jquery.quicksearch/jquery.quicksearch.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/libs/@adactive/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/js/pages/form-advanced.js"></script>
@endsection
