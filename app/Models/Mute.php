<?php

namespace App\Models;

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
}
