<?php

namespace App\Http\Requests\Like;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'liker_id' => 'required|exists:dating_cards,id',
            'liked_id' => 'required|exists:dating_cards,id',
            'is_liked' => 'required|integer|in:0,1',
            'date' => 'required|integer|',
        ];
    }
}
