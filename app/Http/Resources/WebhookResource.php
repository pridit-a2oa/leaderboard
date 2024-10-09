<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebhookResource extends JsonResource
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
            'headers' => $this->headers,
            'payload' => stripslashes($this->payload),
            'exception' => $this->exception,
            'relations' => [
                'contribution' => $this->contribution,
            ],
        ];
    }
}
