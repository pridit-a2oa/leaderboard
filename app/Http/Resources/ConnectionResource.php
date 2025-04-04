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
            'disclaimer' => $this->whenNotNull($this->disclaimer),
            'is_sso' => $this->is_sso,
        ];
    }
}
