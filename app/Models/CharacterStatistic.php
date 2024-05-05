<?php

namespace App\Models;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CharacterStatistic extends Pivot
{
    /**
     * Get the statistics for the character.
     */
    public function statistic(): BelongsTo
    {
        return $this->belongsTo(Statistic::class);
    }
}
