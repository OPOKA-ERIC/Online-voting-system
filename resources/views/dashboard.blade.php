<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold"><i class="bi bi-check2-square me-2"></i>Online Voting System</span>
    <div class="d-flex align-items-center gap-3">
        <span class="text-white-50">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button class="btn btn-sm btn-outline-light">Logout</button>
        </form>
    </div>
</nav>

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body p-5 text-center">
            <i class="bi bi-person-check-fill text-success" style="font-size:3rem;"></i>
            <h4 class="mt-3 fw-bold">Welcome, {{ auth()->user()->name }}!</h4>
            <p class="text-muted">You are logged in as a <strong>{{ auth()->user()->role }}</strong>.</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">Logout</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
