@extends('layouts.app')

@section('title','Нов час')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Добавяне на нов час</h1>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Назад</a>
    </div>

    <form method="post" action="{{ route('appointments.store') }}" class="card card-body shadow-sm">
        @csrf
        @include('appointments._form', ['allowedNotificationMethods' => \App\Models\Appointment::allowedNotificationMethods()])

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary" type="submit">Запази</button>
            <button class="btn btn-outline-secondary" type="reset">Изчисти</button>
        </div>
    </form>
@endsection
