<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Metric extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'created_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'integer',
        ];
    }

    /**
     * Scope a query to only include results between a specific time period.
     */
    protected function scopeReport(Builder $query, CarbonPeriod $period): void
    {
        $query->whereBetween('created_at', [
            $period->getStartDate()->startOfDay(),
            $period->getEndDate()->endOfDay(),
        ])
            ->selectRaw('`key`, `value`, DATE(created_at) as date');
    }

    /**
     * Get the metrics between a specific time period and apply mapping to conform to
     * chart.js for display.
     */
    public static function getData(CarbonPeriod $period)
    {
        $dates = collect($period)->map(fn ($date) => $date->format('Y-m-d'));

        return self::report($period)
            ->get()
            ->groupBy('key')
            ->map(function (Collection $items, string $key) use ($dates) {
                $counts = $items->keyBy('date');

                return [
                    'label' => sprintf(' %s', __($key)),
                    'data' => $dates->map(function ($date) use ($counts) {
                        return $counts->get($date)?->value ?? 0;
                    })->toArray(),
                ];
            })->values()->toArray();
    }
}
