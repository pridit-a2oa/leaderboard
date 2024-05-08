<?php

namespace App\Models;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterStatistic extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Interact with the statistic value.
     */
    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => number_format($value, 0, ',')
        );
    }

    /**
     * Determine the name of the statistic.
     */
    protected function getNameAttribute()
    {
        return $this->statistic()->first()->name;
    }

    /**
     * Get the statistics for the character.
     */
    public function statistic(): BelongsTo
    {
        return $this->belongsTo(Statistic::class);
    }
}
