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
            $this->mergeWhen(! $this->is_hidden || auth()->user() && (auth()->user()->id === $this->user_id || auth()->user()->hasRole('admin')), [
                'user_id' => $this->when($this->user_id, $this->user_id),
                'id64' => $this->when($this->user_id !== auth()->user()?->id && $this->user?->preferences->firstWhere('name', 'steam')?->pivot->value, null, $this->id64),
                'name' => $this->name,
                'avatar_url' => $this->avatar_url,
                'score' => $this->score,
                'last_seen_at' => $this->last_seen_at,
                'max_score' => $this->max_score,
                'formatted_score' => $this->formatted_score,
                'formatted_last_seen_at' => $this->formatted_last_seen_at,
                'is_muted' => $this->whenLoaded('mute'),
            ]),
            'is_hidden' => $this->is_hidden,
            'relations' => [
                'statistics' => ! $this->is_hidden && $this->user_id !== null ? StatisticResource::collection($this->whenLoaded('statistics')) : [],
                'user' => [
                    $this->mergeWhen(! $this->is_hidden, [
                        'gravatar_url' => $this->when($this->user?->preferences->firstWhere('name', 'gravatar')?->pivot->value, $this->user?->gravatar_url),
                        'role' => $this->user?->roles->value('name'),
                    ]),
                ],
            ],
        ];
    }
}
