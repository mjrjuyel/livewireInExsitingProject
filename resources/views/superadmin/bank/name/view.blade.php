@extends('layouts.superAdmin')
@section('superAdminContent')
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

                    <li class="breadcrumb-item active">Bank Name </li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i class="mdi mdi-bank header_icon"></i>{{$view->bank_name}}
                                        </h3>
                                    </div>
                                    <div class="col-md-3 text-end"><a href="{{route('superadmin.bank_name')}}" class="btn btn-bg btn-primary btn_header ">
                                            <i class="mdi mdi-bank btn_icon"></i>All Bank Name </a>
                                    </div>
                                    <div class="col-md-2"><a href="{{route('superadmin.bank_name.edit',Crypt::encrypt($view->id))}}" class="btn btn-bg btn-primary btn_header"><i class="mdi mdi-pencil-off btn_icon"></i>Edit</a>
                                    </div>
                                </div>
                            </div>

                            @php
                            use Carbon\Carbon;
                            // Get the UTC time as a string
                           if($view->updated_at != ''){
                             $createdAt = Carbon::createFromFormat('Y-m-d h:i:s', $view->updated_at, 'UTC');
                            // Now convert it to the user's timezone
                            $createdAtInUserTimezone = $createdAt->timezone(config('app.timezone'));
                            // Output the formatted time
                            echo $createdAtInUserTimezone->format('Y-m-d h:i:s A');
                           }
                            @endphp

                            <table class="table border view_table">
                                <tr>
                                    <td>Bank Name</td>
                                    <td>:</td>
                                    <td>{{ $view->bank_name }}</td>
                                </tr>

                                <tr>
                                    <td>Branches </td>
                                    <td>:</td>
                                    <td>@foreach( $view->bankbranch as $branch)
                                        <button class="btn btn-info mt-1">{{$branch->bank_branch_name}}</button>
                                        @endforeach</td>
                                </tr>

                                <tr>
                                    <td>Under The Branche Have</td>
                                    <td>:</td>
                                    <td>
                                        @foreach( $view->employe as $employe)
                                        <button class="btn btn-info mt-1">{{$employe->emp_name}}</button>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bank Info Creator</td>
                                    <td>:</td>
                                    <td>{{ $view->creator->name }}</td>
                                </tr>
                                <tr>
                                    <td>Bank Info Editor</td>
                                    <td>:</td>
                                    <td>{{ optional($view->editor)->name }}</td>
                                </tr>
                                <tr>
                                    <td>Bank Name Created At</td>
                                    <td>:</td>
                                    <td>{{ formatDate($view->created_at) }}</td>
                                </tr>
                                <tr>
                                    <td>Bank Name Edited At</td>
                                    <td>:</td>
                                    <td>@if($view->updated_at)
                                     {{ formatDate($view->updated_at)}}
                                     @endif
                                    </td>
                                </tr>
                            </table>

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
