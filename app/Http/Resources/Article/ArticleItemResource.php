<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Author\AuthorItemResource;
use App\Http\Resources\Category\CategoryItemResource;
use App\Http\Resources\NewsSource\NewsSourceItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleItemResource extends JsonResource
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
            "slug" => $this->slug,
            "url" => $this->url,
            "title" => $this->title,
            "description" => $this->description,
            "body" => $this->body,
            "image" => $this->image_url,
            "published_at" => $this->published_at,
            'source' => new NewsSourceItemResource($this->newsSource),
            "categories" => CategoryItemResource::collection($this->categories),
            "authors" => AuthorItemResource::collection($this->authors)
        ];
    }
}
