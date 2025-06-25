<?php

namespace App\Models;

use App\Casts\FormattedTimestamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Character extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'id64',
        'guid',
        'name',
        'score',
        'is_hidden',
        'avatar_url',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'max_score',
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
            'formatted_last_seen_at' => FormattedTimestamp::class,
            'formatted_created_at' => FormattedTimestamp::class,
        ];
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'id64' => $this->id64,
            'guid' => $this->guid,
            'name' => $this->name,
        ];
    }

    /**
     * Interact with the character's score & last seen at to determine character
     * having the highest and most recent score.
     */
    protected function maxScore(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => (int) sprintf(
                '%d%d',
                $attributes['score'],
                Carbon::parse($attributes['last_seen_at'])->timestamp
            )
        );
    }

    /**
     * Interact with the character's score.
     */
    protected function formattedScore(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => number_format(
                $attributes['score'], 0, ','
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
     * The mute associated with the character's ID64.
     */
    public function mute(): HasOne
    {
        return $this->hasOne(Mute::class, 'id64', 'id64');
    }

    /**
     * Scope a query to only include characters with sufficient score, filtering
     * uniquely based on highest score and, if clashing, recently active.
     */
    public function scopeRankable(Builder $query): void
    {
        $query->fromRaw('
            (
                SELECT *, ROW_NUMBER() OVER (
                    PARTITION BY name
                    ORDER BY score DESC, last_seen_at
                )
                AS RN FROM characters
            ) characters'
        )
            ->where('RN', 1)
            ->where('score', '>=', (int) env('VITE_CHARACTER_MIN_SCORE', 50));
    }

    /**
     * Scope a query to only include linkable characters.
     */
    public function scopeLinkable(Builder $query): void
    {
        $query->whereNull('user_id');
    }

    /**
     * Scope a query to only include characters with missing avatar URLs.
     */
    public function scopeMissingAvatar(Builder $query): void
    {
        $query->whereNull('avatar_url');
    }
}
