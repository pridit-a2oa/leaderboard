<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_linkable' => 'boolean',
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
     * Scope a query to only include characters with score.
     */
    public function scopeRankable(Builder $query): void
    {
        $query->where('score', '>=', 1);
    }

    /**
     * Scope a query to only include linkable characters.
     */
    public function scopeLinkable(Builder $query): void
    {
        $query->whereNull('user_id');
    }
}
