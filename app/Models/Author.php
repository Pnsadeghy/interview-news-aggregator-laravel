<?php

namespace App\Models;

use App\Models\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasUuids, HasFactory, HasEnabledScope;

    protected $fillable = [
        'news_source_id',
        'name',
        'url',
        'is_enabled'
    ];

    protected $attributes = [
        'is_enabled' => true
    ];

    public function newsSource(): BelongsTo
    {
        return $this->belongsTo(NewsSource::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, "article_authors");
    }
}
