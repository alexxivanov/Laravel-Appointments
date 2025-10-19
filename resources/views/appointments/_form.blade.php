@php
    $appointment = $appointment ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Дата и час <span class="text-danger">*</span></label>
        <input type="datetime-local" name="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror" value="{{ old('scheduled_at', optional(optional($appointment)->scheduled_at)->format('Y-m-d\TH:i')) }}">
        @error('scheduled_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-help">Трябва да е бъдещ момент.</div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Имена на клиента <span class="text-danger">*</span></label>
        <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" value="{{ old('client_name', $appointment->client_name ?? '') }}" maxlength="120">
        @error('client_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">ЕГН <span class="text-danger">*</span></label>
        <input type="text" name="egn" class="form-control @error('egn') is-invalid @enderror" value="{{ old('egn', $appointment->egn ?? '') }}" inputmode="numeric" maxlength="10">
        @error('egn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Описание</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" maxlength="1000">{{ old('description', $appointment->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Нотификация <span class="text-danger">*</span></label>
        <select name="notification_method" class="form-select @error('notification_method') is-invalid @enderror">
            <option value="">-- Изберете --</option>
            @foreach ($allowedNotificationMethods as $m)
                <option value="{{ $m }}" @selected(old('notification_method', $appointment->notification_method ?? '') === $m)>
                {{ strtoupper($m) }}
                </option>
            @endforeach
        </select>
        @error('notification_method')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>
</div>
