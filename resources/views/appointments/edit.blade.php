@extends('layouts.app')

@section('title','Редакция на час')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Редакция на час #{{ $appointment->id }}</h1>
        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-outline-secondary">Детайли</a>
    </div>

    <form method="post" action="{{ route('appointments.update', $appointment) }}" class="card card-body shadow-sm">
        @csrf
        @method('PUT')
        @include('appointments._form', [
            'appointment' => $appointment,
            'allowedNotificationMethods' => \App\Models\Appointment::allowedNotificationMethods()
        ])

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Запази промените</button>
            <a class="btn btn-outline-secondary" href="{{ route('appointments.show', $appointment) }}">Отказ</a>
        </div>
    </form>
@endsection
