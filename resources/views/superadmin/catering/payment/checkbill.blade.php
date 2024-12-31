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

                    <li class="breadcrumb-item active">Department </li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-sm-start">
                            <h4 class="text-uppercase mt-0">{{ config('app.name', 'Laravel') }} Catering Expense </h4>
                        </div>
                        <div class="float-sm-end mt-4 mt-sm-0">
                            <h5>Invoice # <br>
                                <small>2016-04-23654789</small>
                            </h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="float-sm-start mt-4">
                                <address>
                                    <strong>Current Payment Details.</strong><br>
                                     Food Catering Service
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                            <div class="mt-4 text-sm-end">
                                <p><strong>View Month : </strong>{{$parseDate->format('d-M-Y')}}</p>
                                <p><strong>Order ID: </strong> #123456</p>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Total Quantity</th>
                                            <th>Cost Each Meal</th>
                                            <th>Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($runningMonth as $allFood)
                                        <tr>
                                            <td>
                                                {{ $allFood->order_date->format('d-M-Y') }}
                                            </td>
                                            <td>
                                                {{ $allFood->quantity }}
                                            </td>
                                            <td>
                                                {{ $allFood->per_cost }}
                                            </td>

                                            <td>
                                                {{ $allFood->total_cost }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-bold text-dark text-end">Total Meal This Month :</td>
                                            <td class="text-bold text-info">{{$runningMonth->sum('quantity')}}</td>
                                            <td class="text-bold text-dark text-end">Total :</td>
                                            <td class="text-bold text-info">{{$runningMonth->sum('total_cost')}}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                        @php
                            
                            $preDue = ($preTotalCost-$preTotalPayment) - $runningPayment;

                            $subtotal = $runningMonth->sum('total_cost') + $preDue;

                            $totalDue = $runningMonth->sum('total_cost') + $preDue;
                        @endphp
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="clearfix mt-5">
                                <h5 class="small"><b>Current Month History ( {{date('M-Y')}})</b></h5>

                                <small class="text-info">
                                    <p><b>Current Month Total Cost:  </b>{{number_format($runningMonth->sum('total_cost'),'2','.','')}}</p>
                                    <p><b>Current Month Total Payment </b> :  {{number_format($runningPayment,'2','.','')}}</p>
                                </small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-end mt-4">
                                <p><b>Current Month Total:  </b>{{number_format($runningMonth->sum('total_cost'),'2','.','')}}</p>

                                <p class="text-danger">Previous Dues <span class="text-info">( Pre Month Due : {{number_format($preTotalCost-$preTotalPayment,'2','.','')}} - Running Month Payment {{$runningPayment}} )</span> :  {{number_format($preDue,'2','.','')}}</p>


                                <p class="text-info">SubTotal : {{number_format($subtotal,'2','.','')}}</p>
                                <hr>
                                <h3>Total Due : {{number_format($totalDue,'2','.','')}}</h3>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
                            @if($totalDue <= 0)
                                <a href="#" class="btn btn-primary waves-effect waves-light">All Due Paid</a>
                            @else
                                <a href="{{route('superadmin.cateringpayment.add')}}" class="btn btn-primary waves-effect waves-light">Pay Bill</a>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

</div> <!-- container -->
@endsection
