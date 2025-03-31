<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        ];
    }

    /**
     * Get the contribution associated with the webhook call.
     */
    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    /**
     * Interact with the webhook's created at.
     */
    protected function formattedCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => preg_replace(
                '/\d+ seconds?/',
                'less than a minute',
                Carbon::parse($attributes['created_at'])->diffForHumans([
                    'options' => Carbon::JUST_NOW,
                ])
            )
        );
    }
}
