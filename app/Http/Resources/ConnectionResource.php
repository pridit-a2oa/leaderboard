<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ConnectionResource extends JsonResource
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
            'name' => $this->name,
            'formatted_name' => Str::title($this->name),
            'icon' => $this->icon,
            'description' => $this->whenNotNull($this->description),
            'is_oauth' => $this->is_oauth,
        ];
    }
}
