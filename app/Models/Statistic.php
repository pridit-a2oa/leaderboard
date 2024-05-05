<?php

namespace App\Models;

use App\Models\Statistic;
use App\Models\CharacterStatistic;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
}
