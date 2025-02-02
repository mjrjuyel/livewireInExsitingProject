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

                    <li class="breadcrumb-item active">Role</li>
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
                                                class="mdi mdi-shield-crown header_icon"></i>{{$view->role_name}}
                                        </h3>
                                    </div>
                                    <div class="col-md-3 text-end"><a href="{{route('superadmin.role')}}"
                                            class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i>All Role</a>
                                    </div>
                                    <div class="col-md-2"><a href="{{route('superadmin.role.edit',$view->id)}}"
                                            class="btn btn-bg btn-primary btn_header"><i
                                                class="mdi mdi-pencil-off btn_icon"></i>Edit</a>
                                    </div>
                                </div>
                            </div>

                            <table class="table border view_table">
                                <tr>
                                    <td>Role Name</td>
                                    <td>:</td>
                                    <td>{{ $view->role_name }}</td>
                                </tr>
                                <tr>
                                    <td>Role BelongsTo SuperAdmin Dashboard</td>
                                    <td>:</td>
                                    <td>
                                        @foreach($view->admin as $admin)
                                            <button class="btn bg-dark text-white">{{optional($admin)->name}}</button>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role Belong To Staff Dashboard</td>
                                    <td>:</td>
                                    <td>
                                        @foreach($view->employe as $employe)
                                        <button class="btn btn-info">
                                            {{optional($employe)->emp_name}}
                                        </button>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role Created At</td>
                                    <td>:</td>
                                    <td>{{$view->created_at->format('d-M-Y | h:i:s A')}}</td>
                                </tr>
                                <tr>
                                    <td>Role Edited At</td>
                                    <td>:</td>
                                    <td>{{optional($view->updated_at)->format('d-m-Y | h:i:s A')}}</td>
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