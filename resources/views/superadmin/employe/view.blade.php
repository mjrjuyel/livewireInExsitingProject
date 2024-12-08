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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>

                    <li class="breadcrumb-item active">Employe</li>
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
                                    <div class="col-md-3 text-end"><a href="{{route('superadmin.employe')}}"
                                            class="btn btn-bg btn-primary btn_header ">
                                            <i class="fa-brands fa-servicestack btn_icon"></i>All Employe</a>
                                    </div>
                                    <div class="col-md-2"><a href="{{route('superadmin.employe.edit',$view->emp_slug)}}"
                                            class="btn btn-bg btn-primary btn_header"><i class="fa-solid fa-pen-to-square
                                            btn_icon"></i>Edit</a>
                                    </div>
                                </div>
                            </div>

                            <table class="table border view_table">
                                <tr>
                                    <td>Employe Name</td>
                                    <td>:</td>
                                    <td>{{ $view->emp_name }}</td>
                                </tr>

                                <tr>
                                    <td>Employe Status</td>
                                    <td>:</td>
                                    <td>@if($view->emp_status == 1)
                                        <button type="button" class="btn btn-warning ">
                                            Active
                                        </button>
                                        @elseif($view->emp_status == 2)
                                        <button type="button" class="btn btn-primary " >
                                            Suspend
                                        </button>
                                        @elseif($view->emp_status == 0)
                                        <button type="button" class="btn btn-warning">
                                            Recycle Bin
                                        </button>
                                        @endif
                                        </td>
                                </tr>

                                <tr>
                                    <td>Profile Picture</td>
                                    <td>:</td>
                                    <td>@if($view->emp_image != '')
                                        <img src="{{ asset('uploads/employe/profile/'.$view->emp_image) }}" class="img-fluid"
                                            alt="" style="width:200px; object-fit:cover;">
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employe Email</td>
                                    <td>:</td>
                                    <td>{{ $view->email }}</td>
                                </tr>

                                <tr>
                                    <td>Employe Addresss</td>
                                    <td>:</td>
                                    <td>{{ $view->emp_address }}</td>
                                </tr>

                                <tr>
                                    <td>Role</td>
                                    <td>:</td>
                                    <td>
                                        Working Role Is<button class="btn bg-primary"> {{optional($view->emp_role)->role_name}}</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Designation</td>
                                    <td>:</td>
                                    <td>
                                        Work As A <button class="btn bg-primary">{{optional($view->emp_desig)->title}}</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employe Joining Date</td>
                                    <td>:</td>
                                    <td>{{$view->emp_join}}</td>
                                </tr>

                                <tr>
                                    <td>Employe Creator</td>
                                    <td>:</td>
                                    <td>{{$view->creator->name}}</td>
                                </tr>
                                

                                <tr>
                                    <td>Created At</td>
                                    <td>:</td>
                                    <td>{{$view->created_at->format('d-M-Y | h:i:s A')}}</td>
                                </tr>
                                <tr>
                                    <td>Edited At</td>
                                    <td>:</td>
                                    <td>{{optional($view->updated_at)->format('d-M-Y | h:i:s A')}}</td>
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