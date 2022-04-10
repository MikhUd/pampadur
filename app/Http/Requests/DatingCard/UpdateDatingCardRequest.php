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
            'name' => 'min:5|max:30',
            'about' => 'min:20|max:500',
            'birth_date' => 'integer|max:' . strtotime('-18 years'),
            'tags'  => 'array|min:2',
            'tags.*' => 'string|regex:/^[А-Яа-яA-Za-zёЁ]+$/u',
            'gender' => 'integer|in:1,2',
            'seeking_for' => 'integer|in:1,2',
            'coords' => 'array',
            'images' => 'array|min:2',
            'images.*' => 'array|min:2|max:2',
            'images.*.id' => 'integer',
            'images.*.image' => [
                'required',
                'file',
                'mimes:jpg,png',
                'max:10240',
            ],
        ];
    }
}
