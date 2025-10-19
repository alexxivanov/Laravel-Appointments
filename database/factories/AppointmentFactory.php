<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        // Generate EGN with 10 digits, for dev uses
        $egn = str_pad((string)$this->faker->numberBetween(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);

        return [
            'scheduled_at' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'client_name' => $this->faker->name(),
            'egn' => $egn,
            'description' => $this->faker->optional()->sentence(),
            'notification_method' => $this->faker->randomElement(Appointment::allowedNotificationMethods()),
        ];
    }
}
