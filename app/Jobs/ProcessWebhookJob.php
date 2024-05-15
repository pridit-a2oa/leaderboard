<?php

namespace App\Jobs;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJob extends SpatieProcessWebhookJob
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
        //
    }
}
