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
                        <div class="row float-end">
                           <div class="col-md-12">
                             @can('View Payment')
                             <a href="{{route('superadmin.cateringpayment')}}" class="btn btn-primary" style="display:inline-flex; gap:4px;">
                                <span class="menu-icon" style="fonst-size:14px"><i class="mdi mdi-history"></i></span>
                                <span class="menu-text"> Payment History </span>
                             </a>
                             @endcan
                           </div>
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
                                            <th>Payment Date</th>
                                            <th>Payment Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($runningPaymentAll as $payment)
                                        <tr>
                                            <td>
                                                {{ $payment->payment_date->format('d-M-Y') }}
                                            </td>
                                            <td>
                                                {{ $payment->payment }}
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-bold text-dark text-end">Total Payment In {{date('F')}}:</td>
                                            <td class="text-bold text-info">{{$runningPaymentAll->sum('payment')}}.00</td>
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
                                    <p><b>Current Month Total Meal Quantity: </b>{{($runningMonth->sum('quantity'))}}</p>
                                    <p><b>Current Month Total Cost: </b>{{number_format($runningMonth->sum('total_cost'),'2','.','')}}</p>
                                    <p><b>Current Month Total Payment </b> : {{number_format($runningPayment,'2','.','')}}</p>
                                </small>
                            </div>
                        </div>
                        @php
                        $previousDue = $preTotalCost-$preTotalPayment;
                        // pre extra paymnent
                        $preExtraBalance = $preTotalPayment - $preTotalCost;

                        $AllTotalDue = ($previousDue > 0 ? $previousDue : 0) + $runningMonth->sum('total_cost');
                        $alltotalPayment = ($preExtraBalance > 0 ? $preExtraBalance : 0) + $runningPayment;
                        $AfterPaymentDue = $AllTotalDue - $alltotalPayment;

                        @endphp
                        <div class="col-sm-6">
                            <div class="text-end mt-4">
                                <p><b>Current ( {{date('M-Y')}}) Month Total Meal Cost: </b>{{number_format($runningMonth->sum('total_cost'),'2','.','')}}</p>
                                <p class="text-danger">Past Months Previous Dues <span class="text-info">: @if($previousDue > 0){{number_format($previousDue,'2','.','')}} @else 0.00 @endif </p>
                                <hr>
                                <p class="text-success"><b>Current ( {{date('M-Y')}}) Month Total Payment : <span class="text-info">@if($runningPayment > 0){{number_format($runningPayment,'2','.','')}} @else 0.00 @endif </p>

                                <p class="text-success"><b>Past Months Extra Balance : <span class="text-info">@if($preExtraBalance > 0){{number_format($preExtraBalance,'2','.','')}} @else 0.00 @endif </p>

                                <hr>
                                <h3 class="text-danger">Total Due : @if($AfterPaymentDue > 0){{number_format($AfterPaymentDue,'2','.','')}} @else 0.00 @endif</h3>
                                <hr>
                                <h3 class="text-success">Extra Balance : @if($AfterPaymentDue < 0){{ $AfterPaymentDue * -1 }}.00 @else 0.00 @endif</h3>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
                            @can('Add Payment')
                            <a href="{{route('superadmin.cateringpayment.add')}}" class="btn btn-primary waves-effect waves-light">Pay Bill</a>
                            @endcan
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
