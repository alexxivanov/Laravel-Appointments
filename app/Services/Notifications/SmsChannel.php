<?php

namespace App\Services\Notifications;

use App\Models\Appointment;

class SmsChannel implements NotificationChannelInterface
{
    public static function key(): string
    {
        return 'sms';
    }

    public function notify(Appointment $appointment): string
    {
        return "Успешно запазихте час! Клиентът ще бъде уведомен чрез SMS.";
    }
}
