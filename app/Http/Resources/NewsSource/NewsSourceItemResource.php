<?php

namespace App\Http\Resources\NewsSource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class
NewsSourceItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "url" => $this->url
        ];
    }
}
