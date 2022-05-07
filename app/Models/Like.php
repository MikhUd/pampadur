<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'likes';

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Связь карточки пользователя оставившего лайк
     *
     * @return BelongsTo
     */
    public function datingCard(): BelongsTo
    {
        return $this->belongsTo(DatingCard::class, 'liker_id', 'id');
    }

    /**
     * Скоуп для лайка
     *
     * @return void
     */
    public function scopeLiked(Builder $query): void
    {
        $query->where('is_liked', 1);
    }
}
