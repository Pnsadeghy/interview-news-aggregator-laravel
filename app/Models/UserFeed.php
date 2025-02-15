<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserFeed extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'is_default'
    ];

    protected $attributes = [
        'is_default' => false
    ];

    public function newsSources(): BelongsToMany
    {
        return $this->belongsToMany(NewsSource::class, "user_feed_news_sources");
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "user_feed_categories");
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, "user_feed_authors");
    }
}
