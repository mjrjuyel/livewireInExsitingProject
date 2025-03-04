<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyReport;  // Use your report model
use App\Models\Leave;  // Use your report model
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportSummaryMail;
use App\Models\AdminEmail;
use App\Models\CateringFood;
use App\Models\CateringPayment;
use DB;

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

        $cateringFoood = CateringFood::whereDate('order_date',$date)->first();
        $totalOrderThisMonth = CateringFood::whereMonth('order_date',date('m'))->whereYear('order_date',date('Y'))->get();
        $cateringPayment = CateringPayment::whereDate('payment_date',$date)->first();  
        $totalPaymentThisMonth = CateringPayment::whereMonth('payment_date',now()->month)->whereYear('payment_date',now()->year)->get();

        $totalDue = $totalOrderThisMonth->sum('total_cost') - $totalPaymentThisMonth->sum('payment');
        $adminEmail = AdminEmail::first();  // Replace with dynamic config or database value
        $email = explode(',',$adminEmail->email);
        $summaryData = [
            'date' => $date,
            'totalReports' => $totalReports,
            'totalEmployees' => $totalEmployees,

            'totalLeaves' => $totalLeaves,
            'totalLeaveEmploye' => $totalLeaveEmploye,
            // catring Food 
            'total_order' => $cateringFoood && $cateringFoood->quantity ? $cateringFoood->quantity : '0',
            'total_cost' => $cateringFoood && $cateringFoood->total_cost ? $cateringFoood->total_cost : '00.00',

            'today_payment' => $cateringPayment && $cateringPayment->payment ? $cateringPayment->payment : '00.00',
            'total_due' =>$totalDue && $totalDue >= 0? $totalDue : '00.00', 
        ];
        
       if($adminEmail->email_summary == 1){
         // Send email
         foreach($email as $value){
            Mail::to($value)->send(new DailyReportSummaryMail($summaryData));
            }
         $this->info('Daily report summary email sent successfully.');
       }
       else{
        $this->info('Daily report summary email doesnot sent successfully.');
       }
      
    }
}
