<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserRole extends Model
{
    use HasFactory;

    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Атрибуты, для которых запрещено массовое заполнение.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'code'
    ];

    /**
     * Получение пользователей по роли.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_code', 'code');
    }
}
