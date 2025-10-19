@extends('layouts.app')

@section('title','Списък с часове')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-3 mb-lg-0">Всички часове</h1>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">+ Нов час</a>
    </div>

    <form method="get" class="card card-body shadow-sm mb-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Дата от</label>
                <input type="date" name="date_from" class="form-control" value="{{ old('date_from', $filters['date_from'] ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Дата до</label>
                <input type="date" name="date_to" class="form-control" value="{{ old('date_to', $filters['date_to'] ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">ЕГН</label>
                <input type="text" name="egn" class="form-control" value="{{ old('egn', $filters['egn'] ?? '') }}" maxlength="10">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-outline-primary" type="submit">Филтрирай</button>
                <a class="btn btn-outline-secondary" href="{{ route('appointments.index') }}">Изчисти</a>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Дата/час</th>
                    <th>Клиент</th>
                    <th>ЕГН</th>
                    <th>Нотификация</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($appointments as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->scheduled_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $a->client_name }}</td>
                        <td><code>{{ $a->egn }}</code></td>
                        <td>{{ strtoupper($a->notification_method) }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('appointments.show',$a) }}">Детайли</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('appointments.edit',$a) }}">Редакция</a>
                            <form class="d-inline" method="post" action="{{ route('appointments.destroy', $a) }}" data-confirm="Сигурни ли сте, че искате да изтриете часа?">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Няма записи.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $appointments->links() }}
        </div>
    </div>
@endsection
