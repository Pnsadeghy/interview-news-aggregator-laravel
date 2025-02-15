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
}
