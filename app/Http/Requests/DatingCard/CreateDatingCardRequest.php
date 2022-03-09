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
        return false;
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
            'tags' => 'required|array',
            'gender' => 'required|string|in:male,female',
            'seeking_for' => 'required|string|in:male,female',
            'photo' => 'required|file|mimes:jpg,png|max:10240',
        ];
    }
}
