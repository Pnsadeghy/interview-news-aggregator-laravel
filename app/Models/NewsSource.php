<?php

namespace App\Models;

use App\Models\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsSource extends Model
{
    use HasUuids, HasFactory, HasEnabledScope;

    protected $fillable = [
        'title',
        'url',
        'is_enabled'
    ];

    protected $attributes = [
        'is_enabled' => true
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
