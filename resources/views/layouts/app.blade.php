<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'License Portal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f6f8fb; color: #102033; }
        .navbar { background: #fff; box-shadow: 0 10px 30px rgba(16, 32, 51, .06); }
        .brand-mark { width: 36px; height: 36px; border-radius: 12px; display: inline-grid; place-items: center; color: #fff; background: linear-gradient(135deg, #13b981, #2563eb); }
        .card { border: 1px solid rgba(16, 32, 51, .08); border-radius: 16px; box-shadow: 0 18px 45px rgba(16, 32, 51, .06); }
        .stat-card { min-height: 120px; }
        .btn-primary { background: linear-gradient(135deg, #13b981, #2563eb); border: 0; }
        .badge-active { background: #d1fae5; color: #047857; }
        .badge-suspended { background: #fee2e2; color: #b91c1c; }
        .badge-expired { background: #fef3c7; color: #92400e; }
        .table td, .table th { vertical-align: middle; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('licenses.index') }}">
                <span class="brand-mark"><i class="bi bi-shield-lock"></i></span>
                License Portal
            </a>
            @if (session('license_portal_authenticated'))
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-secondary btn-sm" type="submit">Logout</button>
                </form>
            @endif
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
