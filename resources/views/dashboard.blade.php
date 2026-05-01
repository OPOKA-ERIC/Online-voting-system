<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #0f172a; color: #fff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    </style>
</head>
<body>
<div class="text-center p-5">
    <div style="width:70px;height:70px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
        <i class="bi bi-person-check-fill text-white" style="font-size:2rem;"></i>
    </div>
    <h4 class="fw-bold">Welcome, {{ auth()->user()->name }}!</h4>
    <p style="color:rgba(255,255,255,0.45);">You are logged in as a <strong class="text-white">{{ auth()->user()->role }}</strong>.</p>
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="{{ route('voter.dashboard') }}" class="btn btn-primary px-4">
            <i class="bi bi-check2-square me-2"></i>Go to Elections
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-outline-light px-4">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
