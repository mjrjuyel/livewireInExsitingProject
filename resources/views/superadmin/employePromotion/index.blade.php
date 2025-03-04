@extends('layouts.superAdmin')
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
                <h4 class="font-18 mb-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name', 'Laravel') }}</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Super Admin</a></li>

                    <li class="breadcrumb-item active">Promotion List</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('Add Employee')
                        <div class="col-sm-5">
                            <a href="{{route('portal.employe.view',Crypt::encrypt($view->id))}}" class="btn btn-primary"><i class="mdi mdi-plus-circle me-2"></i>Back View</a>
                        </div>
                        @endcan
                    </div>
                    <div class="">
                        <table class="table table-centered text-center" id="">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Promotion Date</th>
                                    <th class="text-center">Employee Type</th>
                                    <th class="text-center">Salary</th>
                                    <th class="text-center">ProMotion Status</th>
                                    <th class="text-center">Promoted By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allPromotion as $promotion)
                                <tr>
                                    <td>
                                        {{ optional($promotion->employe)->name }}
                                    </td>
                                    <td>
                                        {{ optional($promotion->emp_desig)->title }}
                                    </td>

                                    <td>
                                        {{optional($promotion->department)->depart_name}}
                                    </td>

                                    <td>
                                        {{$promotion->pro_date->format('d-M-Y')}}
                                    </td>
                                    <td>
                                        {{optional($promotion)->emp_type}}
                                    </td>
                                    <td>
                                        {{optional($promotion)->salary}}
                                    </td>

                                    <td>
                                        {{optional($promotion)->pro_status}}
                                    </td>

                                    <td class="text-info">
                                        {{optional($promotion->creator)->name}}
                                    </td>


                                    <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                {{-- <li><a class="dropdown-item" href="{{ route('portal.designation.view',$promotion->id) }}"><i class="mdi mdi-view-agenda"></i>View</a></li> --}}

                                                @php
                                                $onlyEdit = App\Models\EmployeePromotion::latest('pro_date')->first();
                                                @endphp
                                               
                                                @if($onlyEdit->id == $promotion->id)
                                                 @can('Edit Employee Promotion')
                                                    <li><a href="{{route('admin.promotion.edit',Crypt::encrypt($promotion->id))}}" class="dropdown-item waves-effect waves-light text-warning"><i class="mdi mdi-receipt-text-edit">
                                                        </i>Edit</a>
                                                </li>
                                                @endcan
                                                @endif
                                                

                                                @can('Delete Employee Promotion')
                                                <li><a href="#" id="delete" class="dropdown-item waves-effect waves-light text-danger" data-id="{{$promotion->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="mdi mdi-delete-alert">
                                                        </i>Delete</a>
                                                </li>
                                                @endcan

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>

</div> <!-- container -->

{{-- soft delete MOdal  --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Employee Promotion Data </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('admin.promotion.delete')}}" method="post">
                @method('delete')
                @csrf
                <div class="modal-body modal_body">
                    <h5 class="font-16">Do You Sure Want to Delete ?</h5>
                    <input type="hidden" name="id" id="modal_id" value="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@endsection
