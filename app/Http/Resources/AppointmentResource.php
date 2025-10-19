<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'scheduled_at' => optional($this->scheduled_at)->toIso8601String(),
            'client_name' => $this->client_name,
            'egn' => $this->egn,
            'description' => $this->description,
            'notification_method' => $this->notification_method,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
