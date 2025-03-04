<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DailyReport;
use App\Models\AdminEmail;
use DateTime;
use DateInterval;
use DatePeriod;

class DailyReportDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-report-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleteEnabled = AdminEmail::first();

        if ($deleteEnabled->delete_report == 1) {

        $deleted = DailyReport::where('created_at', '<', now()->subDays(40))->delete();
        $this->info(" old reports deleted successfully.");

        }else{
            $this->info("Old reports deletion is disabled.");
        }
    }
}
