@extends('layouts.admin')
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
                                                class="fa-solid fa-shirt header_icon"></i>{{$view->role_name}}
                                        </h3>
                                    </div>
                                    <div class="col-md-3 text-end"><a href="{{route('dashboard.role')}}"
                                            class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i>All Role</a>
                                    </div>
                                    <div class="col-md-2"><a href="{{url('dashboard/role/edit/'.$view->id)}}"
                                            class="btn btn-bg btn-primary btn_header"><i
                                                class="uil-edit btn_icon"></i>Edit</a>
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
                                    <td>Role</td>
                                    <td>:</td>
                                    <td>
                                        <button class="btn bg-primary">{{optional($view->role)->role_name}}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role Email</td>
                                    <td>:</td>
                                    <td>
                                        @foreach($view->admin as $admin)
                                        <button class="btn btn-primary">
                                            {{optional($admin)->name}},
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