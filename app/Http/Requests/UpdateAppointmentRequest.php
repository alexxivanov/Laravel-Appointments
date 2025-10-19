<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Rules\ValidEgn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'client_name' => $this->client_name ? trim($this->client_name) : null,
            'egn' => $this->egn ? preg_replace('/\D/', '', $this->egn) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'scheduled_at' => ['required', 'date', 'after:now'],
            'client_name' => ['required', 'string', 'min:2', 'max:120'],
            'egn' => ['required', new ValidEgn],
            'description' => ['nullable', 'string', 'max:1000'],
            'notification_method' => ['required', 'string', Rule::in(Appointment::allowedNotificationMethods())],
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.required' => 'Моля, въведете дата и час.',
            'scheduled_at.date' => 'Невалиден формат на дата/час.',
            'scheduled_at.after' => 'Часът трябва да е в бъдеще.',
            'client_name.required' => 'Имената са задължителни.',
            'client_name.min' => 'Имената трябва да са поне :min символа.',
            'client_name.max' => 'Имената трябва да са до :max символа.',
            'egn.required' => 'ЕГН е задължително.',
            'description.max' => 'Описанието трябва да е до :max символа.',
            'notification_method.required' => 'Изберете метод за уведомление.',
            'notification_method.in' => 'Невалиден метод за уведомление.',
        ];
    }
}
