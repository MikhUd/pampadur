<?php

namespace App\Http\Requests\Meeting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class IndexMeetingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gender' => 'nullable|integer|in:1,2',
            'distance' => 'nullable|integer|min:3',
            'birth_date_range' => 'nullable|array|min:2|max:2',
            'birth_date_range.*' => [
                'required',
                'date',
            ],
            'like_status' => 'nullable|integer|in:0,1',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'coords' => explode(',', $this->coords),
        ]);
    }

    public function messages(): array
    {
        return [
            'gender.integer' => 'Неверный тип поля gender',
            'gender.in' => 'Поле gender может иметь значение 1 или 2',
            'distance.integer' => 'Неверный тип поля distance',
            'distance.min' => 'Минимальное значение поля distance - 3км',
            'like_status.integer' => 'Неверный тип поля like_status',
            'like_status.in' => 'Поле like_status может иметь значение 0 или 1'
        ];
    }

    /**
     * Обработка исключения валидации.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
