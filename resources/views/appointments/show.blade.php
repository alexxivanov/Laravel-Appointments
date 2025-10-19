@extends('layouts.app')

@section('title','Детайли за час')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Час #{{ $appointment->id }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-primary">Редакция</a>
            <form method="post" action="{{ route('appointments.destroy', $appointment) }}" data-confirm="Сигурни ли сте, че искате да изтриете часа?">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger">Изтрий</button>
            </form>
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Назад</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Информация</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Дата/час</dt>
                        <dd class="col-sm-8">{{ $appointment->scheduled_at->format('d.m.Y H:i') }}</dd>
                        <dt class="col-sm-4">Клиент</dt>
                        <dd class="col-sm-8">{{ $appointment->client_name }}</dd>
                        <dt class="col-sm-4">ЕГН</dt>
                        <dd class="col-sm-8"><code>{{ $appointment->egn }}</code></dd>
                        <dt class="col-sm-4">Метод</dt>
                        <dd class="col-sm-8">{{ strtoupper($appointment->notification_method) }}</dd>
                        <dt class="col-sm-4">Описание</dt>
                        <dd class="col-sm-8">{{ $appointment->description ?: '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">Предстоящи часове за същия клиент</div>
                <div class="card-body">
                    @if($upcomingForSameClient->isEmpty())
                        <p class="text-muted mb-0">Няма други предстоящи часове.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($upcomingForSameClient as $u)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $u->scheduled_at->format('d.m.Y H:i') }}</span>
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('appointments.show', $u) }}">Детайли</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
