<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $egn = $this->egn ? preg_replace('/\D/', '', $this->egn) : null;
        $this->merge(['egn' => $egn]);
    }

    public function rules(): array
    {
        return [
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'egn'  => ['nullable', 'digits:10'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_from.date' => 'Невалидна начална дата.',
            'date_to.date' => 'Невалидна крайна дата.',
            'date_to.after_or_equal' => 'Крайната дата трябва да е >= началната.',
            'egn.digits' => 'ЕГН за филтър трябва да е от 10 цифри.',
        ];
    }
}
