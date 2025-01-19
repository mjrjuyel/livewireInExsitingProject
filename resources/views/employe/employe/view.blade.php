@extends('layouts.employe')
@section('content')
<div class="page-container">
    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0"> Dashboard Of: <span class="text-primary">{{$view->emp_name}}</span></h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

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
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>{{$view->emp_name}}
                                        </h3>
                                    </div>
                                    <div class="col-md-2 offset-md-3"><a href="{{route('dashboard.employe.profileSettings',$view->emp_slug)}}" class="btn btn-bg btn-primary btn_header"><i class="fa-solid fa-pen-to-square
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
                                        <button type="button" class="btn btn-primary ">
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
                                        <img src="{{ asset('uploads/employe/profile/'.$view->emp_image) }}" class="img-fluid" alt="" style="width:200px; object-fit:cover;">
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
                                    <td>{{$view->emp_join->format('d-M-Y')}}</td>
                                </tr>

                                <tr>
                                    <td>Employe Creator</td>
                                    <td>:</td>
                                    <td>{{optional($view->creator)->name}}</td>
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
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Employee Details</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                 <li class="list-group-item text-danger">Reporting Manager : {{optional($view->reporting)->emp_name}}</li>
                                    <li class="list-group-item">Department : {{optional($view->department)->depart_name}}</li>
                                    <li class="list-group-item">Designation : {{optional($view->emp_desig)->title}}</li>
                                    <li class="list-group-item">Employee Job Type : {{$view->emp_type}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Joining Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Joinig Date : {{$view->emp_join->format('d-M-Y')}}</li>
                                    <li class="list-group-item">Office Located In : {{optional($view->officeBranch)->branch_name}}</li>
                                    <li class="list-group-item">Office Id Card Number : {{$view->emp_office_id_number}}</li>
                                    <li class="list-group-item">Work Schedule : {{$view->emp_office_work_schedule}}</li>
                                    @if($view->emp_resign){
                                        <li class="list-group-item">Work Schedule : {{$view->emp_resign->format('d-M-Y')}}</li>
                                    }
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Contact Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Gender : {{$view->gender}}</li>
                                    <li class="list-group-item">Date Of Birth : {{$view->emp_dob->format('d-M-Y')}}</li>
                                    <li class="list-group-item">Marriage Status : {{$view->marriage}}</li>
                                    <li class="list-group-item">Personal Number : <a href="tel:{{$view->emp_phone}}">{{$view->emp_phone}}</a></li>
                                    @if($view->emp_phone2 != '')
                                    <li class="list-group-item">Personal Number : <a href="tel:{{$view->emp_phone2}}">{{$view->emp_phone2}}</a></li>
                                    @endif
                                    <li class="list-group-item">Email : <a href="mailto:{{$view->email}}">{{$view->email}}</a></li>
                                    @if($view->email2 != '')
                                    <li class="list-group-item">AlterNate Email : <a href="mailto:{{$view->email2}}">{{$view->email2}}</a></li>
                                    @endif

                                    <li class="list-group-item">Parmanent Address : {{$view->emp_address}}</li>
                                    <li class="list-group-item">Present Address : {{$view->emp_present}}</li>

                                    <h5 class="card-title text-info" style="padding:10px 0px 10px 15px;">Emergency Contact Information :-</h5>

                                    <li class="list-group-item">Emergency Contact Number : <a href="tel:{{$view->emp_emer_contact}}">{{$view->emp_emer_contact}}</a></li>

                                    @if($view->emp_emer_relation != '')
                                    <li class="list-group-item">Who : {{$view->emp_emer_relation}}</li>
                                    @endif

                                    @if($view->emp_id_type == 'national_id')
                                    <li class="list-group-item">Identity Type : National Id</li>
                                    <li class="list-group-item">Id Number : {{$view->emp_id_number}}</li>
                                    @elseif($view->emp_id_type == 'ssn')
                                    <li class="list-group-item">Identity Type : Social Security Number</li>
                                    <li class="list-group-item">Id Number : {{$view->emp_id_number}}</li>
                                    @elseif($view->emp_id_type == 'driver_license')
                                    <li class="list-group-item">Identity Type : Driver License</li>
                                    <li class="list-group-item">Id Number : {{$view->emp_id_number}}</li>
                                    @endif

                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Bank Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-info">Bank Name : {{optional($view->bankName)->bank_name}}</li>
                                    <li class="list-group-item">Branch Name : {{optional($view->bankBranch)->bank_branch_name}}</li>
                                    <li class="list-group-item">Account Name : {{$view->emp_bank_account_name}}</li>
                                    <li class="list-group-item">Account Number : {{$view->emp_bank_account_number}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Education and Skills</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Last Academic Degree : {{$view->emp_rec_degree}}</li>
                                    <li class="list-group-item">Passing Year: {{$view->emp_rec_year}}</li>
                                </ul>
                            </div>
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
