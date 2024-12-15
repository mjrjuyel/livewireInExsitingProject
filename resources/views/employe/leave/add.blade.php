@extends('layouts.employe')
@section('css')
<link href="{{ asset('contents/admin') }}/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet">
<link href="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
<link href="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endsection
@section('content')
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

@if(Session::has('unpaid'))
<script type="text/javascript">
    swal({
            title: "Are you sure?"
            , text: "You will not be able to recover this imaginary file!"
            , type: "warning"
            , showCancelButton: true
            , confirmButtonColor: "#DD6B55"
            , confirmButtonText: "Yes, delete it!"
            , cancelButtonText: "No, cancel plx!"
            , closeOnConfirm: false
            , closeOnCancel: false
        }
        , function(isConfirm) {
            if (isConfirm) {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });

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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>

                    <li class="breadcrumb-item"><a href="javascript: void(0);">Navigation</a></li>

                    <li class="breadcrumb-item active">Leave</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header bg-dark">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card_header"><i class="fa-solid fa-shirt header_icon"></i>Leave Application Form
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('dashboard.leave.insert')}}" method="post">

                        @php

                        function countDaysExcludingDynamicAndWeeklyOffs($startDate, $endDate, $weeklyOffs = [], $specialOffDates = []) {
                        // Create DateTime objects for the start and end dates
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);

                        // Include the end date in the calculation
                        $end->modify('+1 day');

                        // Create a DatePeriod with a 1-day interval
                        $interval = new DateInterval('P1D');
                        $period = new DatePeriod($start, $interval, $end);

                        $totalDays = 0;

                        // Iterate over each day in the period
                            foreach ($period as $date) {
                            // Exclude if the day is a weekly off OR a special off date
                                if (!in_array($date->format('N'), $weeklyOffs) && !in_array($date->format('Y-m-d'), $specialOffDates)) {
                                    $totalDays++;
                                    }
                            }

                            return $totalDays;
                        }

                        function calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates) {
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);

                        $paidLeaveLimitPerMonth = 3;
                        $totalPaidLeaveLimit = 14;
                        $remainingPaidLeaves = $totalPaidLeaveLimit;

                        $leaveSummary = [];
                        $currentDate = $start;

                        // Loop through each month in the range
                        while ($currentDate <= $end) {
                            
                            $currentMonth=$currentDate->format('Y-m');
                            $monthStart = new DateTime($currentDate->format('Y-m-01'));
                            $monthEnd = new DateTime($currentDate->format('Y-m-t'));

                            // Adjust the range for the first and last months
                            $monthStart = max($currentDate, $monthStart);
                            $monthEnd = min($end, $monthEnd);

                            // Count valid leave days in the current month
                            $daysInMonth = countDaysExcludingDynamicAndWeeklyOffs(
                            $monthStart->format('Y-m-d'),
                            $monthEnd->format('Y-m-d'),
                            $weeklyOffs,
                            $specialOffDates
                            );

                            // Determine paid and unpaid leaves for the month
                            $paidLeaves = min($daysInMonth, $paidLeaveLimitPerMonth, $remainingPaidLeaves);
                            $unpaidLeaves = $daysInMonth - $paidLeaves;

                            // Reduce remaining paid leave balance
                            $remainingPaidLeaves -= $paidLeaves;

                            // Save the summary for the current month
                            $leaveSummary[$currentMonth] = [
                            'totalDays' => $daysInMonth,
                            'paidLeaves' => $paidLeaves,
                            'unpaidLeaves' => $unpaidLeaves,
                            ];

                            // Move to the next month
                            $currentDate->modify('first day of next month');
                            }

                            return $leaveSummary;
                            }

                            // Example usage:
                            $startDate = '2023-12-31';
                            $endDate = '2024-01-02';

                            // Define weekly offs (e.g., 7 = Sunday)
                            $weeklyOffs = [7]; // Every Sunday

                            // Define dynamic special off-days (specific dates)
                            $specialOffDates = [
                            '2023-12-25', // Example: Christmas
                            '2024-01-01', // New Year's Day
                            ];

                            $leaveSummary = calculateLeaves($startDate, $endDate, $weeklyOffs, $specialOffDates);

                            // Output the result
                            foreach ($leaveSummary as $month => $details) {
                            echo "Month: $month\n";
                            echo "Total Leave Days: " . $details['totalDays'] . "\n";
                            echo "Paid Leaves: " . $details['paidLeaves'] . "\n";
                            echo "Unpaid Leaves: " . $details['unpaidLeaves'] . "\n";
                            echo "--------------------------\n";
                            }

                            @endphp
                            @csrf
                            <div class="row mt-3">
                                <div class="col-6 offset-2">
                                    <div class="mb-3">
                                        <label class="form-label">Leave Type<span class="text-danger">* </span>:
                                        </label>
                                        <select type="text" class="form-control" name="leave_type" placeholder="Enter Leave">
                                            <option value="">Select A Type</option>
                                            @foreach($leaveType as $type)
                                            <option value="{{$type->id}}">{{$type->type_title}}</option>
                                            @endforeach
                                        </select>
                                        @error('leave_type')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Start From<span class="text-danger">* </span>:
                                        </label>
                                        <input type="text" id="humanfd-datepicker" name="start" class="form-control" placeholder="">
                                        @error('start')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">To End<span class="text-danger">* </span>:
                                        </label>
                                        {{-- data-provide="datepicker" --}}
                                        <input type="text" id="inline-datepicker" name="end" class="form-control" placeholder="">
                                        @error('end')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Short Reason<span class="text-danger">* </span>:
                                        </label>

                                        <textarea type="text" style="resize:none;" rows="4" name="reason" class="form-control" placeholder="Write Some Reason"></textarea>

                                        @error('reason')
                                        <small id="emailHelp" class="form-text text-warning">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>
                            </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div>
</div>

</div> <!-- container -->

<!--end Footer -->
@endsection
@section('js')
<script src="{{ asset('contents/admin') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('contents/admin') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Init js-->
<script src="{{ asset('contents/admin') }}/assets/js/pages/form-pickers.js"></script>

@endsection
