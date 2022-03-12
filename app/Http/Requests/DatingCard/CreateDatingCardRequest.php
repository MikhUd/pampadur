<?php

namespace App\Http\Requests\DatingCard;

use Illuminate\Foundation\Http\FormRequest;

class CreateDatingCardRequest extends FormRequest
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
            'name' => 'required|min:5|max:30',
            'about' => 'required|min:20|max:500',
            'birth_date' => 'required|date',
            'tags'  => 'array',
            'tags.*' => [
                'required',
                'string',
                'regex:/^[А-Яа-яA-Za-zёЁ0-9\-\s]+$/u',
            ],
            'gender' => 'required|integer|in:1,2',
            'seeking_for' => 'required|integer|in:1,2',
            'images' => 'array',
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
            'birth_date' => json_decode($this->birth_date),
            'seeking_for' => (int)json_decode($this->seeking_for),
            'gender' => (int)json_decode($this->seeking_for),
            'tags' => json_decode($this->tags),
        ]);
    }
}
