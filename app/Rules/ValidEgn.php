<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEgn implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $egn = (string)$value;

        if (!preg_match('/^\d{10}$/', $egn)) {
            $fail('ЕГН трябва да съдържа точно 10 цифри.');
            return;
        }

        // Validate the date in the EGN
        $yy = (int)substr($egn, 0, 2);
        $mm = (int)substr($egn, 2, 2);
        $dd = (int)substr($egn, 4, 2);

        $year = $yy;
        if ($mm >= 1 && $mm <= 12) {
            $year += 1900;
        } elseif ($mm >= 21 && $mm <= 32) {
            $mm  -= 20;
            $year += 1800;
        } elseif ($mm >= 41 && $mm <= 52) {
            $mm  -= 40;
            $year += 2000;
        } else {
            $fail('Невалиден месец в ЕГН.');
            return;
        }

        if (!checkdate($mm, $dd, $year)) {
            $fail('Невалидна дата в ЕГН.');
            return;
        }

        // COntrol number with weights
        $weights = [2,4,8,5,10,9,7,3,6];
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$egn[$i] * $weights[$i];
        }
        $checksum = $sum % 11;
        if ($checksum === 10) { $checksum = 0; }

        if ($checksum !== (int)$egn[9]) {
            $fail('Невалидна контролна цифра на ЕГН.');
        }
    }
}
