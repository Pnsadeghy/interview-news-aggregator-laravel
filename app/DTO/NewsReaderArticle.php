<?php

namespace App\DTO;

class NewsReaderArticle
{
    public function __construct(
        public string $title,
        public string $url,
        public string|null $imageUrl,
        public string|null $description,
        public string|null $body,
        public string $date,
        public string|null $sourceTitle,
        public string|null $sourceUrl,
        public array $categories = [],
        public array $authors = []
    ) {}
}
