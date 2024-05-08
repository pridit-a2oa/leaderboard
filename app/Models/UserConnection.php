<?php

namespace App\Models;

use App\Models\Connection;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserConnection extends Pivot
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name'
    ];

    /**
     * Determine the name of the connection.
     */
    protected function getNameAttribute(): String
    {
        return $this->connection()->first()->name;
    }
}
