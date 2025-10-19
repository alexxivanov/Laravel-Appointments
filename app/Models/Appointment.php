<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    protected $fillable = [
        'scheduled_at',
        'client_name',
        'egn',
        'description',
        'notification_method',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];


    public static function allowedNotificationMethods(): array
    {
        return ['sms', 'email'];
    }
}
