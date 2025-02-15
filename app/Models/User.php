<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasUuids, HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generate default user feed
     */
    public static function boot(): void
    {
        parent::boot();

        static::created(function ($user) {
           UserFeed::factory()->create([
               'user_id' => $user->id,
               'title' => 'Default',
               'is_default' => true
           ]);
        });
    }

    #region Relations
    public function feeds(): HasMany
    {
        return $this->hasMany(UserFeed::class);
    }

    public function defaultFeed(): HasOne
    {
        return $this->hasOne(UserFeed::class)->where('is_default', true);
    }
    #endregion

    /**
     * Generate Api auth token
     */
    public function generateAuthToken(): string
    {
        return $this->createToken(config("app.key"))->plainTextToken;
    }
}
