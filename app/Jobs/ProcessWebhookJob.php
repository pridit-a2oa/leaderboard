<?php

namespace App\Jobs;

use App\Models\Contribution;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJob extends SpatieProcessWebhookJob
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $call = $this->webhookCall;

        $data = json_decode($call->payload['data']);

        $contribution = Contribution::firstOrCreate([
            'email' => $data->email,
        ]);

        $contribution->webhook()->associate($call->id);
        $contribution->save();

        if ($contribution->wasRecentlyCreated) {
            $user = User::where('email', $data->email)
                ->verified()
                ->first();

            if ($user) {
                // Associate the contribution with the user
                $contribution->user()->associate($user->id);
                $contribution->save();

                // Assign supporter role
                $user->syncRoles('supporter');
            }
        }
    }
}
