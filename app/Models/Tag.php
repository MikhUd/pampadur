<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\DatingCard;

class Tag extends Model
{
    use HasFactory;

    /**
     * Атрибуты доступные для массового заполнения.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Получение анкет по тегу.
     *
     * @return MorphedByMany
     */
    public function datingCards()
    {
        return $this->morphedByMany(DatingCard::class, 'taggable');
    }

}
