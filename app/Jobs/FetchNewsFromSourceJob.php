<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class FetchNewsFromSourceJob
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("---------------------------------------------------");
    }
}
