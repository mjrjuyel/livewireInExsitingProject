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
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="card_header"><i
                                                class="fa-solid fa-user header_icon"></i>{{$view->emp_name}}
                                        </h3>
                                    </div>
                                    <div class="col-md-5 text-end"><a href="{{route('dashboard.employe')}}"
                                            class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i>All Employee</a>
                                    </div>
                                </div>
                            </div>

                            <table class="table border view_table">
                                <tr>
                                    <td>Employee Name</td>
                                    <td>:</td>
                                    <td>{{ $view->emp_name }}</td>
                                </tr>
                                 <tr>
                                    <td>Employee Status</td>
                                    <td>:</td>
                                    @if($view->emp_status == 1 )
                                    <td class="text-primary"> Active</td>
                                    @elseif($view->emp_status == 0 )
                                    <td class="text-warning"> DeActive</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Profile Picture</td>
                                    <td>:</td>
                                    <td>@if($view->image != '')
                                        <img src="{{ asset('uploads/employe/profile/'.$view->image) }}" class="img-fluid"
                                            alt="" style="width:200px; object-fit:cover;">
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employee Joining Date</td>
                                    <td>:</td>
                                    <td class="text-primary">{{$view->emp_join->format('D-m-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td>:</td>
                                    <td>
                                        <button class="btn bg-primary">{{optional($view->emp_role)->role_name}}</button> : As a Employe Dashboard
                                    </td>
                                </tr>
                                <tr>
                                    <td>Designation</td>
                                    <td>:</td>
                                    <td>
                                        <button class="btn bg-primary">{{optional($view->emp_desig)->title}}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Employee Email</td>
                                    <td>:</td>
                                    <td>{{$view->email}}</td>
                                </tr>

                                <tr>
                                    <td>Employee Phone</td>
                                    <td>:</td>
                                    <td>{{$view->emp_phone}}</td>
                                </tr>

                                <tr>
                                    <td>Employee Address</td>
                                    <td>:</td>
                                    <td>{{$view->emp_address}}</td>
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