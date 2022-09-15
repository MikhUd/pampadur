<?php

namespace App\Http\Requests\DatingCard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDatingCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:dating_cards,id',
            'name' => 'required|min:5|max:30',
            'about' => 'required|min:20|max:500',
            'tags'  => 'required|array|min:2',
            'tags.*' => 'required|string|regex:/^[А-Яа-яA-Za-zёЁ]+$/u',
            'seeking_for' => 'required|integer|in:1,2',
            'images' => 'required|array|min:2',
            'images.*' => [
                'required',
                'file',
                'mimes:jpg,png',
                'max:10240',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => json_decode($this->name),
            'about' => json_decode($this->about),
            'seeking_for' => (int)json_decode($this->seeking_for),
            'tags' => json_decode($this->tags),
        ]);
    }
}
