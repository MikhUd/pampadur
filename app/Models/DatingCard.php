<?php

namespace App\Models;

use App\Contracts\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;

class DatingCard extends Model implements HasTags
{
    use HasFactory;

    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'dating_cards';

    /**
     * Атрибуты, для которых запрещено массовое заполнение.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * Получение пользователя по анкете.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получение тегов анкеты.
     *
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
