<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'icon' => $this->icon,
            'pivot' => [
                'character_id' => $this->pivot->character_id,
                'statistic_id' => $this->pivot->statistic_id,
                'value' => $this->pivot->value,
                'formatted_value' => $this->pivot->formatted_value,
            ],
        ];
    }
}
