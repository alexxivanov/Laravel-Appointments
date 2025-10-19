<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * GET /api/v1/appointments  filters, pagination
     */
    public function index(IndexAppointmentRequest $request): JsonResponse
    {
        $v = $request->validated();

        $q = Appointment::query();

        if (!empty($v['date_from'])) {
            $q->where('scheduled_at', '>=', Carbon::parse($v['date_from'])->startOfDay());
        }
        if (!empty($v['date_to'])) {
            $q->where('scheduled_at', '<=', Carbon::parse($v['date_to'])->endOfDay());
        }
        if (!empty($v['egn'])) {
            $q->where('egn', $v['egn']);
        }

        $cacheKey = 'appointments_index_' . md5(json_encode($v) . '_page_' . request('page', 1));

        $appointments = Cache::remember($cacheKey, now()->addSeconds(30), function () use ($q) {
            return $q->orderBy('scheduled_at', 'desc')->paginate(10);
        });


        return response()->json(AppointmentResource::collection($appointments));
    }

    /**
     * POST /api/v1/appointments
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $appointment = Appointment::create($request->validated());

        Cache::flush();

        return response()->json(new AppointmentResource($appointment), 201);
    }

    /**
     * GET /api/v1/appointments/{appointment}
     */
    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json(new AppointmentResource($appointment));
    }

    /**
     * PUT/PATCH /api/v1/appointments/{appointment}
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $appointment->update($request->validated());

        Cache::flush();

        return response()->json(new AppointmentResource($appointment));
    }

    /**
     * DELETE /api/v1/appointments/{appointment}
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();

        Cache::flush();

        return response()->json(null, 204);
    }
}
