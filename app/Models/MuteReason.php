<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MuteReason extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_name',
    ];

    /**
     * Interact with the mute reason's name
     */
    protected function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Str::title($attributes['name'])
        );
    }
}
