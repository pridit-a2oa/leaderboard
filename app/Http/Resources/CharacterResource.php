<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
            'user_id' => $this->when(! $this->is_hidden && $this->user_id, $this->user_id),
            'uid' => $this->when(! $this->is_hidden, $this->uid),
            'name' => $this->when(! $this->is_hidden, $this->name),
            'score' => $this->score,
            'is_hidden' => $this->is_hidden,
            'is_highest_score' => $this->when(! $this->is_hidden, $this->whenLoaded('user') ? $this->is_highest_score : false),
            'formatted_score' => $this->formatted_score,
            'formatted_last_seen_at' => $this->when(! $this->is_hidden, $this->formatted_last_seen_at),
            'role' => $this->when(! $this->is_hidden && $this->user, $this->whenLoaded('user') ? $this->user->roles->value('name') : false),
            'statistics' => $this->when(! $this->is_hidden && $this->statistics->isNotEmpty(), StatisticResource::collection($this->whenLoaded('statistics'))),
        ];
    }
}
