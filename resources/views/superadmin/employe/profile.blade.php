@extends('layouts.superAdmin')
@section('superAdminContent')
<div class="page-container">
    <div class="page-title-box">

        <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="font-18 mb-0"> Dashboard Of: <span class="text-primary">{{$view->name}}</span></h4>
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
                                        <h3 class="card_header"><i class="fa-solid fa-user header_icon"></i>{{$view->name}}
                                        </h3>
                                    </div>
                                    <div class="col-md-2 offset-md-3"><a href="{{route('portal.employe.editprofile',Crypt::encrypt($view->id))}}" class="btn btn-bg btn-primary btn_header"><i class="fa-solid fa-pen-to-square
                                            btn_icon"></i>Edit</a>
                                    </div>
                                </div>
                            </div>

                            <table class="table border view_table">
                                <tr>
                                    <td>Employe Name</td>
                                    <td>:</td>
                                    <td>{{ $view->name }}</td>
                                </tr>

                                <tr>
                                    <td>Employe Status</td>
                                    <td>:</td>
                                    <td>@if($view->status == 1)
                                        <button type="button" class="btn btn-warning ">
                                            Active
                                        </button>
                                        @elseif($view->status == 2)
                                        <button type="button" class="btn btn-primary ">
                                            Suspend
                                        </button>
                                        @elseif($view->status == 0)
                                        <button type="button" class="btn btn-warning">
                                            Recycle Bin
                                        </button>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>Profile Picture</td>
                                    <td>:</td>
                                    <td>@if($view->image != '')
                                        <img src="{{ asset('uploads/employe/profile/'.$view->image) }}" class="img-fluid" alt="" style="width:200px; object-fit:cover;">
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
                                    <td>{{ $view->address }}</td>
                                </tr>

                                <tr>
                                    <td>Designation</td>
                                    <td>:</td>
                                    <td> 
                                    <button class="btn bg-primary">{{ $activeDesig != '' ? $activeDesig->emp_desig->title : optional($view->emp_desig)->title}}</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Employe Joining Date</td>
                                    <td>:</td>
                                    <td>{{$view->join_date->format('d-M-Y')}}</td>
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
                                    <li class="list-group-item text-danger">Reporting Manager : {{optional($view->reporting)->name}}</li>
                                    <li class="list-group-item">Department : {{$activeDesig != '' ? $activeDesig->department->depart_name : optional($view->department)->depart_name}}</li>
                                    <li class="list-group-item">Designation : {{$activeDesig != '' ? $activeDesig->designemp_desig->title : optional($view->emp_desig)->title}}</li>
                                    <li class="list-group-item">Employee Job Type : {{$activeDesig != '' ? $activeDesig->emp_type : $view->emp_type}}</li>
                                    <li class="list-group-item">Employee Salary : {{$activeDesig != '' ? $activeDesig->salary : 'Not Yet'}}</li>
                                    <li class="list-group-item text-info">Promotion Status : {{$activeDesig != '' ? $activeDesig->pro_status : '----'}}</li>
                                    <li class="list-group-item text-info">Employee Promotion Date : {{$activeDesig != '' ? $activeDesig->pro_date->format('d-M-Y') : $view->join_date->format('Y-M-d')}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Joining Information</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Joinig Date : @if($view->join_date != ''){{ $view->join_date->format('d-M-Y')}} @endif</li>
                                    <li class="list-group-item">Office Located In : {{optional($view->officeBranch)->branch_name}}</li>
                                    <li class="list-group-item">Office Id Card Number : {{$view->office_id_number}}</li>
                                    <li class="list-group-item">Work Schedule : {{$view->office_work_schedule}}</li>
                                    @if($view->resign){
                                        <li class="list-group-item">Work Schedule : {{$view->resign->format('d-M-Y')}}</li>
                                    }
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Evaluation</h5>
                                </div>
                               @php
                                if($EmpEva == null){
                                $end_date = new DateTime($view->join_date->format('Y-m-d'));
                                $end_date->modify('+1 year');
                                }
                                @endphp
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Last Evaluation Date : @if($EmpEva != ''){{$EmpEva->eva_last_date}} @else {{$view->join_date->format('d-M-Y')}} @endif</li>
                                    <li class="list-group-item">Next Evaluation Date: @if($EmpEva != ''){{$EmpEva->eva_next_date}} @else {{$end_date->format('d-M-Y')}} @endif</li>
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
                                    <li class="list-group-item">Date Of Birth : @if($view->dob != ''){{ $view->dob->format('d-M-Y')}} @endif</li>
                                    <li class="list-group-item">Marriage Status : {{$view->marriage}}</li>
                                    <li class="list-group-item">Personal Number : <a href="tel:{{$view->phone}}">{{$view->phone}}</a></li>
                                    @if($view->phone2 != '')
                                    <li class="list-group-item">Personal Number : <a href="tel:{{$view->phone2}}">{{$view->phone2}}</a></li>
                                    @endif
                                    <li class="list-group-item">Email : <a href="mailto:{{$view->email}}">{{$view->email}}</a></li>
                                    @if($view->email2 != '')
                                    <li class="list-group-item">AlterNate Email : <a href="mailto:{{$view->email2}}">{{$view->email2}}</a></li>
                                    @endif

                                    <li class="list-group-item">Parmanent Address : {{$view->address}}</li>
                                    <li class="list-group-item">Present Address : {{$view->present}}</li>

                                    <h5 class="card-title text-info" style="padding:10px 0px 10px 15px;">Emergency Contact Information :-</h5>

                                    <li class="list-group-item">Emergency Contact Number : <a href="tel:{{$view->emer_contact}}">{{$view->emer_contact}}</a></li>

                                    @if($view->emer_name != '')
                                    <li class="list-group-item">Who : {{$view->emer_name}}</li>
                                    @endif
                                    @if($view->emer_relation != '')
                                    <li class="list-group-item">Who : {{$view->emer_relation}}</li>
                                    @endif

                                    @if($view->id_type == 'national_id')
                                    <li class="list-group-item">Identity Type : National Id</li>
                                    <li class="list-group-item">Id Number : {{$view->id_number}}</li>
                                    @elseif($view->id_type == 'ssn')
                                    <li class="list-group-item">Identity Type : Social Security Number</li>
                                    <li class="list-group-item">Id Number : {{$view->id_number}}</li>
                                    @elseif($view->id_type == 'driver_license')
                                    <li class="list-group-item">Identity Type : Driver License</li>
                                    <li class="list-group-item">Id Number : {{$view->id_number}}</li>
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
                                    <li class="list-group-item">Account Name : {{$view->bank_account_name}}</li>
                                    <li class="list-group-item">Account Number : {{$view->bank_account_number}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Education and Skills</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Last Academic Degree : {{$view->rec_degree}}</li>
                                    <li class="list-group-item">Passing Year: {{$view->rec_year}}</li>
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
