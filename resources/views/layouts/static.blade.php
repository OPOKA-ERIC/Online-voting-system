<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') • VoteSecure</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        .heading-font { font-family: 'Space Grotesk', sans-serif; }
        body { background-color: #0a0f1c; color: #fff; }
        .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); }
        .gradient-text { background: linear-gradient(90deg,#6366f1,#a5b4fc,#67e8f9); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav style="background:rgba(10,15,28,0.85);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,0.08)" class="fixed top-0 left-0 right-0 z-50 py-5 px-6">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-x-3">
            <div class="w-9 h-9 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center">
                <i class="bi bi-shield-check text-white text-xl"></i>
            </div>
            <span class="heading-font text-2xl font-semibold tracking-tighter">VoteSecure</span>
        </a>
        <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-white transition flex items-center gap-x-1">
            <i class="bi bi-arrow-left"></i> Back to Home
        </a>
    </div>
</nav>

<!-- Content -->
<main class="pt-28 pb-24 px-6 max-w-screen-md mx-auto">
    @yield('content')
</main>

<!-- Mini Footer -->
<footer class="border-t border-white/[0.07] py-8 text-center text-xs text-slate-500">
    © {{ date('Y') }} VoteSecure, Inc. All rights reserved.
</footer>

</body>
</html>
