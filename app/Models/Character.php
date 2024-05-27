<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'user_id',
        'uid',
        'name',
        'score',
        'is_hidden',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_score',
        'formatted_last_seen_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_hidden' => 'boolean',
        ];
    }

    /**
     * Determine whether the character has the highest score. On clashes,
     * resolve by basing from recency (e.g. linked).
     */
    protected function isHighestScore(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->user
                ? $this->user->characters
                    ->where('is_hidden', 0)
                    ->sortByDesc('last_seen_at')
                    ->sortByDesc('score')
                    ->first()
                    ->id === $attributes['id']
                : false
        );
    }

    /**
     * Interact with the character's score.
     */
    protected function formattedScore(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => number_format($attributes['score'], 0, ',')
        );
    }

    /**
     * Interact with the character's last seen at.
     */
    protected function formattedLastSeenAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => preg_replace(
                '/\d+ seconds?/',
                'less than a minute',
                Carbon::parse($attributes['last_seen_at'])->diffForHumans([
                    'options' => Carbon::JUST_NOW,
                ])
            )
        );
    }

    /**
     * The user the character has.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The statistics that belong to the character.
     */
    public function statistics(): BelongsToMany
    {
        return $this->belongsToMany(Statistic::class)
            ->using(CharacterStatistic::class)
            ->withPivot('value')
            ->having('value', '>', 0);
    }

    /**
     * Scope a query to only include characters with score and visible,
     * filtering unique names and prioritising based on highest score and, if
     * matching, recently active.
     *
     * Additionally, impose a 60 day (inactivity point) condition unless the
     * character's linked user is a supporter/admin.
     */
    public function scopeRankable(Builder $query): void
    {
        $query->fromRaw('(SELECT *, ROW_NUMBER() OVER (PARTITION BY name ORDER BY score desc, last_seen_at) AS RN FROM characters WHERE is_hidden = 0) characters')
            ->where('RN', 1)
            ->where('score', '>', 0)
            ->where(function (Builder $query) {
                $query->where('last_seen_at', '>=', now()->subDays(42))
                    ->orWhereHas('user.roles', function (Builder $query) {
                        $query->whereIn('role_id', [2, 3]);
                    });
            })
            ->orderByDesc('score')
            ->orderBy('last_seen_at');
    }

    /**
     * Scope a query to only include linkable characters.
     */
    public function scopeLinkable(Builder $query): void
    {
        $query->whereNull('user_id');
    }
}
