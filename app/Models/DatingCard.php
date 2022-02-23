<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;

class DatingCard extends Model
{
    use HasFactory;

    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'dating_cards';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
