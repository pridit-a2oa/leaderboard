<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Statistic;
use App\Models\CharacterStatistic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Character extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'name',
        'score',
        'is_visible',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    /**
     * Interact with the character's score.
     */
    protected function score(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => number_format($value, 0, ',')
        );
    }

    /**
     * Interact with the character's updated at.
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => Carbon::parse($value)->diffForHumans()
        );
    }

    /**
     * The statistics that belong to the character.
     */
    public function statistics(): BelongsToMany
    {
        return $this->belongsToMany(Statistic::class)->withPivot('value');
    }

    /**
     * Scope a query to only include characters with score and visible.
     */
    public function scopeRankable(Builder $query): void
    {
        $query->where('score', '>=', 1)
            ->where('is_visible', 1);
    }

    /**
     * Scope a query to only include linkable characters.
     */
    public function scopeLinkable(Builder $query): void
    {
        $query->whereNull('user_id');
    }
}
