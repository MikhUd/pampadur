<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\DatingCard;
use App\Models\UserRole;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const DEFAULT_USER_ROLE_CODE = 'xdDsklw3w';

    /**
     * Атрибуты доступные для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_code',
        'latitude',
        'longitude',
        'birth_date',
    ];

    protected $dates = [
        'birth_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Установка хэша для пароля.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Получение роли пользователя.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_code', 'code');
    }

    /**
     * Получение анкеты пользователя.
     *
     * @return HasOne
     */
    public function datingCard(): HasOne
    {
        return $this->hasOne(DatingCard::class);
    }

    /**
     * Получение изображений анкеты у пользователя.
     *
     * @return HasManyThrough
     */
    public function images(): HasManyThrough
    {
        return $this->hasManyThrough(Image::class, DatingCard::class, 'user_id', 'imageable_id', 'id', 'id');
    }
}
