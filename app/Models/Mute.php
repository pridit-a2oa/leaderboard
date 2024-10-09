<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reason_id',
        'guid',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'characters',
    ];

    /**
     * Get the characters impacted by the mute.
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'guid', 'guid');
    }

    /**
     * Get the reason for the mute.
     */
    public function reason(): BelongsTo
    {
        return $this->belongsTo(MuteReason::class);
    }

    /**
     * Interact with the mute's created at.
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
