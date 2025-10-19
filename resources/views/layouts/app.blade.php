<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Запазване на часове')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 4.5rem; }
        .form-help { font-size: .9rem; color: #6c757d; }
    </style>
    @stack('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('appointments.index') }}">
            <img src="{{ asset('labforty-logo.png') }}" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Превключи навигация">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('appointments.index') }}">Списък</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('appointments.create') }}">Нов час</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Грешки:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

{{-- Bootstrap Toast съобщения --}}
@if (session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Затвори"></button>
            </div>
        </div>
    </div>
@endif


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const t = document.getElementById('successToast');
        if (t) {
            const toast = new bootstrap.Toast(t, { delay: 4000 });
            toast.show();
        }
        document.querySelectorAll('form[data-confirm]').forEach(f => {
            f.addEventListener('submit', (e) => {
                const msg = f.getAttribute('data-confirm') || 'Сигурни ли сте?';
                if (!confirm(msg)) e.preventDefault();
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
