<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Services\Notifications\NotificationManager;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * Index with filters and pagination
     */
    public function index(IndexAppointmentRequest $request): View
    {
        $validated = $request->validated();

        $query = Appointment::query();

        if (!empty($validated['date_from'])) {
            $query->where('scheduled_at', '>=', Carbon::parse($validated['date_from'])->startOfDay());
        }

        if (!empty($validated['date_to'])) {
            $query->where('scheduled_at', '<=', Carbon::parse($validated['date_to'])->endOfDay());
        }

        if (!empty($validated['egn'])) {
            $query->where('egn', $validated['egn']); // точен match според заданието
        }

        // Cache
        $cacheKey = 'appointments_index_' . md5(json_encode($validated) . '_page_' . request('page', 1));

        $appointments = Cache::remember($cacheKey, now()->addSeconds(30), function () use ($query) {
            return $query->orderBy('scheduled_at', 'desc')->paginate(10);
        });

        return view('appointments.index', [
            'appointments' => $appointments,
            'filters' => [
                'date_from' => $validated['date_from'] ?? null,
                'date_to' => $validated['date_to'] ?? null,
                'egn'  => $validated['egn'] ?? null,
            ],
        ]);
    }

    /**
     * Create new appointment view
     */
    public function create(): View
    {
        return view('appointments.create', [
            'allowedNotificationMethods' => Appointment::allowedNotificationMethods(),
        ]);
    }

    /**
     * Storee the appointment NotificationManager
     */
    public function store(StoreAppointmentRequest $request, NotificationManager $notifier): RedirectResponse
    {
        $appointment = Appointment::create($request->validated());

        // Get the corresponding message / NotificationManager Dependency Injection
        $popup = $notifier->notify($appointment);

        Cache::flush();

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', $popup);
    }

    /**
     * Show appointment details + upcoming appointments
     */
    public function show(Appointment $appointment): View
    {
        $upcomingForSameClient = Appointment::query()
            ->where('egn', $appointment->egn)
            ->where('id', '<>', $appointment->id)
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->limit(10)
            ->get();

        return view('appointments.show', [
            'appointment' => $appointment,
            'upcomingForSameClient' => $upcomingForSameClient,
        ]);
    }

    /**
     * Edit appointment view
     */
    public function edit(Appointment $appointment): View
    {
        return view('appointments.edit', [
            'appointment' => $appointment,
            'allowedNotificationMethods' => Appointment::allowedNotificationMethods(),
        ]);
    }

    /**
     * Update the appointment
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        Cache::flush();

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'Промените са запазени успешно.');
    }

    /**
     * Delete the appointment
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        Cache::flush();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Часът беше изтрит успешно.');
    }
}
