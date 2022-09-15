<?php

namespace App\Models;

use App\Contracts\HasImages;
use App\Contracts\HasTags;
use App\Contracts\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class DatingCard extends Model implements HasTags, HasImages, HasUser
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получение тегов анкеты.
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Получение фоток анкеты.
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Скоп для возврата лайкнутых/дизлайкнутых/не отмеченных анкет.
     *
     * @param Builder $query
     * @param mixed $likeStatus
     * @return void
     */
    public function scopeLiked(Builder $query, mixed $likeStatus = null): void
    {
        $currentDatingCardId = auth()->user()->datingCard->id;
            
        if (is_null($likeStatus)) {
            $query->whereNotIn('id', function ($query) use ($currentDatingCardId) {
                $query->select('liked_id')
                    ->from('likes')
                    ->where('liker_id', $currentDatingCardId);
            }); 
        } else {
            $query->whereIn('id', function ($query) use ($currentDatingCardId, $likeStatus) {
                $query->select('liked_id')
                    ->from('likes')
                    ->where('liker_id', $currentDatingCardId)
                    ->where('is_liked', $likeStatus);
            });
        }
    }
}
