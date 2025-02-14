<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsSource extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'api_url',
        'api_key',
        'reader_class',
        'request_data'
    ];

    protected $attributes = [
        'api_url' => '',
        'api_key' => '',
        'reader_class' => '',
        'request_data' => []
    ];

    protected $casts = [
        'request_data' => Json::class
    ];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}
