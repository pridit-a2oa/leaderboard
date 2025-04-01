<?php

namespace App\Models;

use App\Casts\FormattedTimestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\WebhookClient\Models\WebhookCall as SpatieWebhookCall;

class WebhookCall extends SpatieWebhookCall
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'headers' => 'array',
            'payload' => 'json',
            'formatted_created_at' => FormattedTimestamp::class,
        ];
    }

    /**
     * Get the contribution associated with the webhook call.
     */
    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }
}
