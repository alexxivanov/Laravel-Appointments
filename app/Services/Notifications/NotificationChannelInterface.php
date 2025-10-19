<?php

namespace App\Services\Notifications;

use App\Models\Appointment;

interface NotificationChannelInterface
{
    public function notify(Appointment $appointment): string;

    public static function key(): string;
}
