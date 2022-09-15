<?php

namespace App\Http\Requests\Like;

use App\Models\Like;
use Carbon\Carbon;
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
            'date' => 'required|date',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'liker_id' => $this->liker_id ? $this->liker_id : strval(auth()->user()->datingCard->id),
            'date' => Carbon::now()->toDateString(),
        ]);
    }
}
