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
        'is_visible',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_score',
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
    protected function formattedScore(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => number_format($attributes['score'], 0, ',')
        );
    }

    /**
     * Interact with the character's updated at.
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => preg_replace(
                '/\d+ seconds?/',
                'less than a minute',
                Carbon::parse($value)->diffForHumans([
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
     */
    public function scopeRankable(Builder $query): void
    {
        $query->fromRaw('(SELECT *, ROW_NUMBER() OVER (PARTITION BY name ORDER BY score desc, updated_at desc) AS RN FROM characters WHERE is_visible = 1) x')
            ->where('RN', 1)
            ->where('score', '>', 0)
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
