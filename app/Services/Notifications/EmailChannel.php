<?php

namespace App\Services\Notifications;

use App\Models\Appointment;

class EmailChannel implements NotificationChannelInterface
{
    public static function key(): string
    {
        return 'email';
    }

    public function notify(Appointment $appointment): string
    {
        return "Успешно запазихте час! Клиентът ще бъде уведомен чрез Email.";
    }
}
