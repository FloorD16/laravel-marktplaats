<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'field' => 'required|string',
            'value' => 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('value', 'required|string|max:255|min:3', function ($input) {
            return $input->field === 'name';
        });

        $validator->sometimes('value', 'required|string|email|max:255|unique:users', function ($input) {
            return $input->field === 'email';
        });

        $validator->sometimes('value', 'required|string|min:8', function ($input) {
            return $input->field === 'password';
        });

        $validator->sometimes('value', 'nullable|boolean', function ($input) {
            return $input->field === 'email_notifications';
        });
    }

    public function attributes()
    {
        return [
            'value' => $this->field,
        ];
    }
}
