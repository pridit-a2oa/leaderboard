<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MuteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reason_id' => $this->reason_id,
            'guid' => $this->guid,
            'characters_count' => min($this->characters_count, 99),
            'relations' => [
                'characters' => CharacterResource::collection($this->whenLoaded('characters')),
                'reason' => $this->reason,
            ],
        ];
    }
}
