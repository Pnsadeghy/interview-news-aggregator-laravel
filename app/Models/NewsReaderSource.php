<?php

namespace App\Models;

use App\Casts\Json;
use App\Models\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsReaderSource extends Model
{
    use HasUuids, HasFactory, HasEnabledScope;

    protected $fillable = [
        'name',
        'is_enabled',
        'api_url',
        'api_key',
        'reader_class',
        'request_data'
    ];

    protected $attributes = [
        'is_enabled' => true,
        'api_url' => '',
        'api_key' => '',
        'reader_class' => '',
        'request_data' => []
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'request_data' => Json::class
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
