<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebhookCallResource extends JsonResource
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
            'url' => parse_url($this->url)['path'],
            'headers' => json_encode($this->headers),
            'payload' => json_decode($this->payload['data'] ?? json_encode($this->payload)),
            'exception' => $this->exception,
            'created_at' => $this->created_at,
            'formatted_created_at' => $this->formatted_created_at,
            'relations' => [
                'contribution' => $this->contribution,
            ],
        ];
    }
}
