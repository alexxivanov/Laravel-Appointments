<?php

namespace App\Services\Notifications;

use App\Models\Appointment;
use InvalidArgumentException;

class NotificationManager
{
    /** @var array<string, NotificationChannelInterface> */
    protected array $channels = [];

    public function __construct(iterable $channels)
    {
        foreach ($channels as $channel) {
            $this->channels[$channel::key()] = $channel;
        }
    }

    public function for(string $key): NotificationChannelInterface
    {
        if (!isset($this->channels[$key])) {
            throw new InvalidArgumentException("Неподдържан канал за нотификация: {$key}");
        }
        return $this->channels[$key];
    }

    public function notify(Appointment $appointment): string
    {
        return $this->for($appointment->notification_method)->notify($appointment);
    }
}
