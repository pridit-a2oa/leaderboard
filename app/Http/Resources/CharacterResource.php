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
            'guid' => $this->when(! $this->is_hidden, $this->guid),
            'name' => $this->when(! $this->is_hidden, $this->name),
            'avatar_url' => $this->when(! $this->is_hidden, $this->avatar_url),
            'score' => $this->when(! $this->is_hidden, $this->score),
            'is_hidden' => $this->is_hidden,
            'is_highest_score' => $this->when(! $this->is_hidden, $this->whenLoaded('user') ? $this->is_highest_score : false),
            'formatted_score' => $this->when(! $this->is_hidden, $this->formatted_score),
            'formatted_last_seen_at' => $this->when(! $this->is_hidden, $this->formatted_last_seen_at),
            'statistics' => $this->when(! $this->is_hidden && $this->statistics->isNotEmpty(), StatisticResource::collection($this->whenLoaded('statistics'))),
            'user' => [
                'gravatar_url' => $this->when(! $this->is_hidden && $this->user && $this->user->preferences->contains('name', 'gravatar') && $this->user->preferences->where('name', 'gravatar')->first()->pivot->value, $this->whenLoaded('user') ? $this->user->gravatar_url : false),
                'role' => $this->when(! $this->is_hidden && $this->user, $this->whenLoaded('user') ? $this->user->roles->value('name') : false),
            ],
        ];
    }
}
