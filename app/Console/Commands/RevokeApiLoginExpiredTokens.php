<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class RevokeApiLoginExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:Api-Token-Delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Expired token!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PersonalAccessToken::where('expires_at', '<', Carbon::now())->delete();
        $this->info('Expired tokens deleted successfully.');
    }
}
