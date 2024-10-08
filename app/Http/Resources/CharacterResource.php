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
            $this->mergeWhen(! $this->is_hidden || auth()->user() && auth()->user()->hasRole('admin'), [
                'user_id' => $this->when($this->user_id, $this->user_id),
                'guid' => $this->guid,
                'name' => $this->name,
                'avatar_url' => $this->avatar_url,
                'score' => $this->score,
                'is_muted' => $this->mute()->exists(),
                'is_highest_score' => $this->whenLoaded('user') ? $this->is_highest_score : false,
                'formatted_score' => $this->formatted_score,
                'formatted_last_seen_at' => $this->formatted_last_seen_at,
            ]),
            'relations' => [
                'statistics' => $this->when(! $this->is_hidden && $this->statistics->isNotEmpty(), StatisticResource::collection($this->whenLoaded('statistics'))),
                'user' => [
                    'gravatar_url' => $this->when(! $this->is_hidden && $this->user && $this->user->preferences->contains('name', 'gravatar') && $this->user->preferences->where('name', 'gravatar')->first()->pivot->value, $this->whenLoaded('user') ? $this->user->gravatar_url : false),
                    'role' => $this->when(! $this->is_hidden, $this->whenLoaded('user') ? $this->user->roles->value('name') : false),
                ],
            ],
            'is_hidden' => $this->is_hidden,
        ];
    }
}
