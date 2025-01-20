<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyReport;  // Use your report model
use App\Models\Leave;  // Use your report model
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportSummaryMail;
use App\Models\AdminEmail;

class SendDailyReportSummary extends Command
{
    protected $signature = 'app:send-daily-report-summary';
    protected $description = 'Command description';

    public function __construct(){
        parent::__construct();
    }
    public function handle()
    {
        $date = now('UTC')->format('Y-m-d');

        $totalReports = DailyReport::whereDate('created_at', $date)->count();
        $totalEmployees = DailyReport::whereDate('created_at', $date)->distinct('submit_by')->count();

        $totalLeaves = Leave::whereDate('created_at', $date)->count();
        $totalLeaveEmploye = Leave::whereDate('created_at', $date)->distinct('emp_id')->count();
        
        $adminEmail = AdminEmail::first();  // Replace with dynamic config or database value
        $email = explode(',',$adminEmail->email);
        $summaryData = [
            'date' => $date,
            'totalReports' => $totalReports,
            'totalEmployees' => $totalEmployees,

            'totalLeaves' => $totalLeaves,
            'totalLeaveEmploye' => $totalLeaveEmploye,
        ];

        // Send email
        foreach($email as $value){
        Mail::to($value)->send(new DailyReportSummaryMail($summaryData));
        }
       $this->info('Daily report summary email sent successfully.');
    }
}
