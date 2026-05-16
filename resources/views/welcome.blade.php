<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VoteSecure • Modern Online Voting</title>
    <meta name="description" content="VoteSecure is the most secure and beautiful online voting platform. Run fair, transparent elections for universities, corporations, and governments. Start free today.">

    <!-- Tailwind CSS CDN (for modern utility-first styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter + Satoshi (more premium feel) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Space+Grotesk:wght@500;600;700&amp;display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Space+Grotesk:wght@500;600;700&amp;display=swap');

        :root {
            --primary: 99 102 241;
        }
        
        * { 
            font-family: 'Inter', system-ui, sans-serif; 
        }
        
        .heading-font {
            font-family: 'Space Grotesk', sans-serif;
        }

        body { 
            background-color: #0a0f1c; 
            color: #fff; 
            overflow-x: hidden;
        }

        /* Glassmorphism & Modern Effects */
        .glass {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar {
            background: rgba(10, 15, 28, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .vote-option {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .vote-option:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0.0, 0.2, 1);
        }
        
        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px -12px rgb(99 102 241 / 0.25);
        }

        .stat-number {
            font-feature-settings: "tnum";
        }

        /* Mobile menu */
        #mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 49;
            background: rgba(7,11,22,0.98);
            backdrop-filter: blur(24px);
            flex-direction: column;
            padding: 6rem 2rem 2rem;
        }
        #mobile-menu.open { display: flex; }
        #mobile-menu a {
            font-size: 1.5rem;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            padding: .75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            transition: color .2s;
        }
        #mobile-menu a:hover { color: #fff; }
        #mobile-menu .menu-ctas { margin-top: 2rem; display: flex; flex-direction: column; gap: .75rem; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; }
        .hamburger span { display: block; width: 22px; height: 2px; background: #fff; border-radius: 2px; transition: all .3s; }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
        @media (max-width: 768px) { .hamburger { display: flex; } }

        /* Subtle grid background */
        .bg-grid {
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* Hero enhancements */
        .hero {
            min-height: 100vh;
            background:
                radial-gradient(ellipse 80% 60% at 50% -10%, rgba(99,102,241,0.28) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 80% 60%, rgba(168,85,247,0.15) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 10% 80%, rgba(251,146,60,0.10) 0%, transparent 60%),
                linear-gradient(160deg, #070b16 0%, #0d1425 100%);
        }

        @keyframes hero-float {
            0%,100% { transform: translateY(0px) rotate(0deg) scale(1); }
            33%      { transform: translateY(-30px) rotate(2deg) scale(1.02); }
            66%      { transform: translateY(-15px) rotate(-1deg) scale(0.99); }
        }
        @keyframes orb-drift {
            0%,100% { transform: translate(0,0); }
            50%      { transform: translate(40px,-50px); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        @keyframes count-up {
            from { opacity:0; transform: translateY(12px); }
            to   { opacity:1; transform: translateY(0); }
        }
        @keyframes badge-in {
            from { opacity:0; transform: translateY(-8px) scale(0.95); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }
        @keyframes card-in {
            from { opacity:0; transform: translateY(24px); }
            to   { opacity:1; transform: translateY(0); }
        }

        .hero-orb-1 {
            position:absolute; border-radius:50%; pointer-events:none;
            width:700px; height:700px;
            top:-20%; right:-15%;
            background: radial-gradient(circle, rgba(129,140,248,0.18) 0%, transparent 70%);
            animation: orb-drift 20s ease-in-out infinite;
        }
        .hero-orb-2 {
            position:absolute; border-radius:50%; pointer-events:none;
            width:600px; height:600px;
            bottom:-25%; left:-10%;
            background: radial-gradient(circle, rgba(251,146,60,0.10) 0%, transparent 70%);
            animation: orb-drift 28s ease-in-out infinite reverse;
        }
        .hero-orb-3 {
            position:absolute; border-radius:50%; pointer-events:none;
            width:400px; height:400px;
            top:40%; left:40%;
            background: radial-gradient(circle, rgba(217,70,239,0.08) 0%, transparent 70%);
            animation: orb-drift 35s ease-in-out infinite 5s;
        }

        .shimmer-text {
            background: linear-gradient(90deg, #818cf8, #c084fc, #67e8f9, #818cf8);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 4s linear infinite;
        }

        .hero-badge { animation: badge-in 0.6s ease both; }
        .hero-headline { animation: card-in 0.7s ease 0.1s both; }
        .hero-sub { animation: card-in 0.7s ease 0.2s both; }
        .hero-btns { animation: card-in 0.7s ease 0.3s both; }
        .hero-trust { animation: card-in 0.7s ease 0.4s both; }
        .hero-card { animation: card-in 0.8s ease 0.35s both; }

        .vote-card-wrap {
            animation: hero-float 8s ease-in-out infinite;
        }

        .trust-pill {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            transition: all 0.3s;
        }
        .trust-pill:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.18);
            transform: translateY(-2px);
        }

        .stat-card {
            background: rgba(255,255,255,0.035);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .stat-card:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(99,102,241,0.3);
            transform: translateY(-4px);
        }
        .stat-card .stat-number {
            animation: count-up 0.8s ease both;
        }
    </style>
</head>
<body class="bg-grid">

<!-- NAVBAR -->
<nav class="navbar fixed top-0 left-0 right-0 z-50 py-5 px-6">
    <div class="max-w-screen-2xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-x-3">
            <div class="w-9 h-9 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                <i class="bi bi-shield-check text-white text-2xl"></i>
            </div>
            <span class="heading-font text-2xl font-semibold tracking-tighter">VoteSecure</span>
        </div>
        
        <div class="hidden md:flex items-center gap-x-8 text-sm font-medium">
            <a href="{{ route('features') }}" class="hover:text-indigo-400 transition-colors">Features</a>
            <a href="{{ route('elections') }}" class="hover:text-indigo-400 transition-colors">Elections</a>
            <a href="{{ route('security') }}" class="hover:text-indigo-400 transition-colors">Security</a>
            <a href="{{ route('pricing') }}" class="hover:text-indigo-400 transition-colors">Pricing</a>
        </div>

        <div class="flex items-center gap-x-3">
            <a href="{{ route('login') }}"
               class="hidden md:block px-6 py-2.5 text-sm font-medium hover:bg-white/10 rounded-2xl transition-all">
                Log in
            </a>
            <a href="{{ route('register') }}"
               class="hidden md:flex px-6 py-2.5 bg-white text-slate-900 hover:bg-white/90 font-semibold rounded-2xl transition-all items-center gap-x-2">
                <i class="bi bi-person-plus"></i>
                Get Started
            </a>
            <!-- Hamburger -->
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- MOBILE MENU -->
<div id="mobile-menu">
    <a href="{{ route('features') }}">Features</a>
    <a href="{{ route('elections') }}">Elections</a>
    <a href="{{ route('security') }}">Security</a>
    <a href="{{ route('pricing') }}">Pricing</a>
    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('contact') }}">Contact</a>
    <div class="menu-ctas">
        <a href="{{ route('login') }}" style="font-size:1rem;border:1px solid rgba(255,255,255,0.15);border-radius:14px;text-align:center;padding:.85rem;">Log in</a>
        <a href="{{ route('register') }}" style="font-size:1rem;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:14px;text-align:center;padding:.85rem;color:#fff;border:none;">Get Started Free</a>
    </div>
</div>

<!-- HERO -->
<section class="hero relative flex items-center pt-24 pb-16 overflow-hidden" style="min-height:100vh">

    <!-- Ambient orbs -->
    <div class="hero-orb-1"></div>
    <div class="hero-orb-2"></div>
    <div class="hero-orb-3"></div>

    <!-- Noise texture overlay -->
    <div class="absolute inset-0 pointer-events-none opacity-[0.025]" style="background-image:url('data:image/svg+xml,%3Csvg viewBox=\'0 0 256 256\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noise\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noise)\'/%3E%3C/svg%3E');background-size:200px"></div>

    <div class="relative max-w-screen-xl mx-auto px-6 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- ── LEFT CONTENT ── -->
            <div class="space-y-8">

                <!-- Pill badge -->
                <div class="hero-badge inline-flex items-center gap-x-3 rounded-full px-5 py-2.5 text-xs font-semibold tracking-widest" style="background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.3)">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-emerald-300">LIVE</span>
                    </span>
                    <span class="w-px h-3 bg-white/20"></span>
                    <span class="text-indigo-200 tracking-widest">SECURE &nbsp;•&nbsp; TRANSPARENT &nbsp;•&nbsp; VERIFIABLE</span>
                </div>

                <!-- Headline -->
                <div class="hero-headline">
                    <h1 class="heading-font text-white" style="font-size:clamp(3rem,6.5vw,5.5rem);line-height:1.02;font-weight:700;letter-spacing:-0.02em">
                        Democracy,<br>
                        <span class="shimmer-text">Reimagined.</span>
                    </h1>
                </div>

                <!-- Subtext -->
                <p class="hero-sub text-lg text-slate-400 max-w-lg leading-relaxed">
                    The most secure and beautiful online voting platform.
                    Cast your vote with <span class="text-white font-medium">confidence</span>.
                    Results you can <span class="text-white font-medium">trust</span>.
                </p>

                <!-- CTA buttons -->
                <div class="hero-btns flex flex-wrap gap-4">
                    <a href="{{ route('register') }}"
                       class="group relative px-8 py-4 rounded-2xl font-semibold text-lg overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                       style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#a855f7);box-shadow:0 8px 40px rgba(99,102,241,0.4)">
                        <span class="relative z-10 flex items-center gap-x-2.5">
                            <i class="bi bi-rocket-takeoff"></i>
                            Start Voting Free
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>

                    <a href="#demo"
                       class="group px-8 py-4 rounded-2xl font-medium text-lg flex items-center gap-x-2.5 transition-all duration-300 hover:bg-white/8"
                       style="border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.85)">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.08)">
                            <i class="bi bi-play-fill text-white text-sm"></i>
                        </span>
                        Watch Demo
                    </a>
                </div>

                <div class="hero-trust flex flex-wrap gap-3 pt-2">
                    @php
                        $trustItems = [
                            ['bi-shield-check',    'emerald', 'Encrypted',                    'Every Vote'],
                            ['bi-people-fill',     'sky',     number_format($stats['voters']), 'Voters'],
                            ['bi-check2-square',   'violet',  number_format($stats['votes']),  'Votes Cast'],
                            ['bi-calendar2-check', 'amber',   $stats['elections'],              'Elections'],
                        ];
                    @endphp
                    @foreach($trustItems as [$icon,$color,$val,$label])
                    <div class="trust-pill flex items-center gap-x-2.5 px-4 py-2.5 rounded-2xl">
                        <i class="bi {{ $icon }} text-{{ $color }}-400 text-base"></i>
                        <div class="leading-tight">
                            <div class="text-white text-sm font-semibold">{{ $val }}</div>
                            <div class="text-slate-500 text-xs">{{ $label }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ── RIGHT: SVG ILLUSTRATION + VOTING CARD ── -->
            <div class="hero-card relative flex justify-center" id="demo">

                <!-- SVG Illustration background -->
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;z-index:0;opacity:0.18;">
                    <svg viewBox="0 0 520 520" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:520px;">
                        <!-- Outer circle ring -->
                        <circle cx="260" cy="260" r="240" stroke="url(#ringGrad)" stroke-width="1.5" stroke-dasharray="8 6"/>
                        <circle cx="260" cy="260" r="190" stroke="url(#ringGrad2)" stroke-width="1" stroke-dasharray="4 8" opacity="0.6"/>

                        <!-- Ballot box body -->
                        <rect x="155" y="210" width="210" height="160" rx="18" fill="url(#boxGrad)" stroke="rgba(99,102,241,0.6)" stroke-width="1.5"/>
                        <!-- Ballot box slot -->
                        <rect x="220" y="198" width="80" height="18" rx="9" fill="url(#slotGrad)"/>
                        <!-- Ballot paper going in -->
                        <rect x="238" y="155" width="44" height="58" rx="6" fill="url(#paperGrad)" stroke="rgba(165,180,252,0.5)" stroke-width="1"/>
                        <!-- Lines on ballot paper -->
                        <rect x="245" y="165" width="30" height="3" rx="1.5" fill="rgba(165,180,252,0.6)"/>
                        <rect x="245" y="173" width="22" height="3" rx="1.5" fill="rgba(165,180,252,0.4)"/>
                        <rect x="245" y="181" width="26" height="3" rx="1.5" fill="rgba(165,180,252,0.4)"/>
                        <!-- Checkmark on ballot -->
                        <path d="M248 192 L253 198 L263 186" stroke="#4ade80" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>

                        <!-- People icons around the box -->
                        <!-- Person 1 (left) -->
                        <circle cx="110" cy="270" r="18" fill="url(#person1Grad)" opacity="0.9"/>
                        <circle cx="110" cy="263" r="7" fill="rgba(255,255,255,0.3)"/>
                        <path d="M96 288 Q110 278 124 288" stroke="rgba(255,255,255,0.3)" stroke-width="2" fill="none"/>

                        <!-- Person 2 (right) -->
                        <circle cx="410" cy="270" r="18" fill="url(#person2Grad)" opacity="0.9"/>
                        <circle cx="410" cy="263" r="7" fill="rgba(255,255,255,0.3)"/>
                        <path d="M396 288 Q410 278 424 288" stroke="rgba(255,255,255,0.3)" stroke-width="2" fill="none"/>

                        <!-- Person 3 (top left) -->
                        <circle cx="155" cy="155" r="15" fill="url(#person3Grad)" opacity="0.8"/>
                        <circle cx="155" cy="149" r="6" fill="rgba(255,255,255,0.3)"/>
                        <path d="M143 170 Q155 162 167 170" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" fill="none"/>

                        <!-- Person 4 (top right) -->
                        <circle cx="365" cy="155" r="15" fill="url(#person4Grad)" opacity="0.8"/>
                        <circle cx="365" cy="149" r="6" fill="rgba(255,255,255,0.3)"/>
                        <path d="M353 170 Q365 162 377 170" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" fill="none"/>

                        <!-- Connection lines from people to box -->
                        <line x1="128" y1="270" x2="155" y2="270" stroke="rgba(99,102,241,0.4)" stroke-width="1" stroke-dasharray="4 3"/>
                        <line x1="392" y1="270" x2="365" y2="270" stroke="rgba(99,102,241,0.4)" stroke-width="1" stroke-dasharray="4 3"/>
                        <line x1="165" y1="162" x2="200" y2="220" stroke="rgba(99,102,241,0.3)" stroke-width="1" stroke-dasharray="4 3"/>
                        <line x1="355" y1="162" x2="320" y2="220" stroke="rgba(99,102,241,0.3)" stroke-width="1" stroke-dasharray="4 3"/>

                        <!-- Shield icon bottom -->
                        <path d="M260 340 L240 350 L240 368 Q240 382 260 390 Q280 382 280 368 L280 350 Z" fill="url(#shieldGrad)" opacity="0.9"/>
                        <path d="M252 368 L257 374 L268 360" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>

                        <!-- Small floating dots -->
                        <circle cx="180" cy="320" r="4" fill="#6366f1" opacity="0.6"/>
                        <circle cx="340" cy="320" r="4" fill="#06b6d4" opacity="0.6"/>
                        <circle cx="200" cy="170" r="3" fill="#f59e0b" opacity="0.5"/>
                        <circle cx="320" cy="170" r="3" fill="#22c55e" opacity="0.5"/>
                        <circle cx="130" cy="220" r="3" fill="#a855f7" opacity="0.5"/>
                        <circle cx="390" cy="220" r="3" fill="#ec4899" opacity="0.5"/>

                        <defs>
                            <linearGradient id="ringGrad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#6366f1"/>
                                <stop offset="100%" stop-color="#06b6d4"/>
                            </linearGradient>
                            <linearGradient id="ringGrad2" x1="1" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#a855f7"/>
                                <stop offset="100%" stop-color="#f59e0b"/>
                            </linearGradient>
                            <linearGradient id="boxGrad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="rgba(99,102,241,0.3)"/>
                                <stop offset="100%" stop-color="rgba(79,70,229,0.15)"/>
                            </linearGradient>
                            <linearGradient id="slotGrad" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#6366f1"/>
                                <stop offset="100%" stop-color="#06b6d4"/>
                            </linearGradient>
                            <linearGradient id="paperGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="rgba(255,255,255,0.15)"/>
                                <stop offset="100%" stop-color="rgba(165,180,252,0.1)"/>
                            </linearGradient>
                            <linearGradient id="person1Grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#6366f1"/>
                                <stop offset="100%" stop-color="#8b5cf6"/>
                            </linearGradient>
                            <linearGradient id="person2Grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#06b6d4"/>
                                <stop offset="100%" stop-color="#10b981"/>
                            </linearGradient>
                            <linearGradient id="person3Grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#f59e0b"/>
                                <stop offset="100%" stop-color="#ef4444"/>
                            </linearGradient>
                            <linearGradient id="person4Grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#a855f7"/>
                                <stop offset="100%" stop-color="#ec4899"/>
                            </linearGradient>
                            <linearGradient id="shieldGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#22c55e"/>
                                <stop offset="100%" stop-color="#16a34a"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <!-- Glow behind card -->
                <div class="absolute inset-0 rounded-3xl blur-3xl opacity-30" style="background:linear-gradient(135deg,#6366f1,#a855f7)"></div>

                <div class="vote-card-wrap relative w-full max-w-sm">

                    <!-- Floating top badge -->
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20 whitespace-nowrap inline-flex items-center gap-x-2 px-5 py-2 rounded-full text-xs font-semibold" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.35);color:#34d399;backdrop-filter:blur(12px)">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        LIVE ELECTION IN PROGRESS
                    </div>

                    <!-- Floating right badge -->
                    <div class="absolute -right-4 top-1/3 z-20 flex items-center gap-x-2 px-4 py-2.5 rounded-2xl text-xs" style="background:rgba(10,15,28,0.9);border:1px solid rgba(255,255,255,0.12);backdrop-filter:blur(16px)">
                        <i class="bi bi-graph-up-arrow text-emerald-400"></i>
                        <div>
                            <div class="text-white font-semibold text-xs">Live Results</div>
                            <div class="text-slate-500 text-[10px]">Updating now</div>
                        </div>
                    </div>

                    <!-- Floating bottom-left badge -->
                    <div class="absolute -left-4 bottom-16 z-20 flex items-center gap-x-2 px-4 py-2.5 rounded-2xl text-xs" style="background:rgba(10,15,28,0.9);border:1px solid rgba(255,255,255,0.12);backdrop-filter:blur(16px)">
                        <i class="bi bi-lock-fill text-indigo-400"></i>
                        <div>
                            <div class="text-white font-semibold text-xs">Encrypted</div>
                            <div class="text-slate-500 text-[10px]">End-to-end</div>
                        </div>
                    </div>

                    <!-- Main card -->
                    <div class="relative rounded-3xl overflow-hidden" style="background:rgba(13,18,32,0.92);border:1px solid rgba(255,255,255,0.1);backdrop-filter:blur(24px);box-shadow:0 32px 80px rgba(0,0,0,0.6),0 0 0 1px rgba(99,102,241,0.1)">

                        <!-- Card header gradient bar -->
                        <div class="h-1 w-full" style="background:linear-gradient(90deg,#6366f1,#a855f7,#67e8f9)"></div>

                        <div class="p-7">
                            @php
                                $cardGradients = [
                                    'linear-gradient(135deg,#6366f1,#8b5cf6)',
                                    'linear-gradient(135deg,#f59e0b,#ef4444)',
                                    'linear-gradient(135deg,#06b6d4,#10b981)',
                                    'linear-gradient(135deg,#a855f7,#ec4899)',
                                    'linear-gradient(135deg,#10b981,#3b82f6)',
                                ];
                                $heroPosition = $heroElection?->positions->first();
                                $heroCandidates = $heroPosition?->candidates ?? collect();
                            @endphp
                            <!-- Election meta -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25);color:#34d399">
                                        <i class="bi bi-circle-fill text-[8px] animate-pulse"></i>
                                        {{ $heroElection ? strtoupper($heroElection->status) : 'DEMO' }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-white text-xs font-medium">{{ $heroElection?->title ?? 'Student Council 2026' }}</div>
                                    <div class="text-slate-500 text-[10px] font-mono mt-0.5">
                                        @if($heroElection)
                                            Closes {{ $heroElection->end_date->diffForHumans() }}
                                        @else
                                            Closes in 12h 45m
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Position label -->
                            <div class="mb-5">
                                <div class="text-slate-400 text-xs uppercase tracking-widest mb-1">Position</div>
                                <h3 class="heading-font text-xl font-bold text-white">{{ $heroPosition?->name ?? 'President' }}</h3>
                            </div>

                            <!-- Candidates -->
                            <div class="space-y-2.5">
                                @if($heroCandidates->count())
                                    @foreach($heroCandidates->take(3) as $i => $candidate)
                                    @php $initials = collect(explode(' ', $candidate->name))->map(fn($w) => strtoupper($w[0]))->take(2)->implode(''); @endphp
                                    <div onclick="selectCandidate(this)" class="vote-option group cursor-pointer rounded-2xl p-3.5 flex items-center gap-3.5 border {{ $i === 0 ? 'border-indigo-500/50' : 'border-white/[0.06] hover:border-white/15' }} transition-all" style="background:{{ $i === 0 ? 'rgba(99,102,241,0.08)' : 'rgba(255,255,255,0.02)' }}">
                                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0" style="background:{{ $cardGradients[$i % count($cardGradients)] }}">{{ $initials }}</div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-sm text-white">{{ $candidate->name }}</div>
                                            <div class="text-xs text-slate-400 truncate">{{ $candidate->bio ?? '—' }}</div>
                                        </div>
                                        <i class="bi {{ $i === 0 ? 'bi-check-circle-fill text-indigo-400' : 'bi-circle text-slate-600' }} text-2xl flex-shrink-0"></i>
                                    </div>
                                    @endforeach
                                @else
                                    {{-- Fallback demo candidates --}}
                                    @foreach([['AK','Alice Kamau','Innovation & Unity Party','linear-gradient(135deg,#6366f1,#8b5cf6)',true],['BO','Brian Okello','Future Forward','linear-gradient(135deg,#f59e0b,#ef4444)',false],['CM','Carol Mutesi','Equity Alliance','linear-gradient(135deg,#06b6d4,#10b981)',false]] as [$init,$name,$party,$grad,$selected])
                                    <div onclick="selectCandidate(this)" class="vote-option group cursor-pointer rounded-2xl p-3.5 flex items-center gap-3.5 border {{ $selected ? 'border-indigo-500/50' : 'border-white/[0.06] hover:border-white/15' }} transition-all" style="background:{{ $selected ? 'rgba(99,102,241,0.08)' : 'rgba(255,255,255,0.02)' }}">
                                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0" style="background:{{ $grad }}">{{ $init }}</div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-sm text-white">{{ $name }}</div>
                                            <div class="text-xs text-slate-400 truncate">{{ $party }}</div>
                                        </div>
                                        <i class="bi {{ $selected ? 'bi-check-circle-fill text-indigo-400' : 'bi-circle text-slate-600' }} text-2xl flex-shrink-0"></i>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Submit button -->
                            <button id="demoSubmitBtn" onclick="submitDemoVote()"
                                    class="mt-6 w-full py-3.5 rounded-2xl font-semibold text-base transition-all hover:brightness-110 active:scale-[0.98]"
                                    style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#a855f7);box-shadow:0 4px 24px rgba(99,102,241,0.35)">
                                Submit My Vote Securely
                            </button>

                            <!-- Inline success state (hidden by default) -->
                            <div id="demoSuccess" class="mt-4 hidden">
                                <div class="rounded-2xl p-4 text-center" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25)">
                                    <div class="text-2xl mb-1">🎉</div>
                                    <div class="text-emerald-400 font-semibold text-sm">Vote Recorded!</div>
                                    <div class="text-slate-400 text-xs mt-1">Your ballot is encrypted &amp; stored securely.</div>
                                    <button onclick="resetDemo()" class="mt-3 text-xs text-indigo-400 hover:text-indigo-300 transition-colors underline underline-offset-2">Try again →</button>
                                </div>
                            </div>

                            <!-- Footer note -->
                            <div class="mt-4 flex items-center justify-center gap-x-2 text-[10px] text-slate-600">
                                <i class="bi bi-lock-fill text-indigo-500/60"></i>
                                <span>End-to-end encrypted &nbsp;•&nbsp; Anonymous &nbsp;•&nbsp; Immutable</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── STATS BAR ── -->
        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                $statItems = [
                    [$stats['elections'] > 0 ? $stats['elections'] : '0', 'Elections Run',      'bi-calendar2-check',  'indigo', '0 0 24px rgba(99,102,241,0.2)'],
                    [$stats['voters'] > 0 ? number_format($stats['voters']) : '0', 'Voters Registered', 'bi-people-fill',      'sky',    '0 0 24px rgba(14,165,233,0.2)'],
                    [$stats['votes'] > 0 ? number_format($stats['votes']) : '0',   'Votes Cast',        'bi-check2-square',    'violet', '0 0 24px rgba(139,92,246,0.2)'],
                    [$stats['positions'] > 0 ? $stats['positions'] : '0', 'Positions Created', 'bi-person-badge-fill','emerald','0 0 24px rgba(16,185,129,0.2)'],
                ];
            @endphp
            @foreach($statItems as [$val,$label,$icon,$color,$shadow])
            <div class="stat-card rounded-2xl px-6 py-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.05);box-shadow:{{ $shadow }}">
                    <i class="bi {{ $icon }} text-{{ $color }}-400 text-lg"></i>
                </div>
                <div>
                    <div class="stat-number heading-font text-2xl font-bold {{ $color === 'emerald' ? 'text-emerald-400' : 'text-white' }}">{{ $val }}</div>
                    <div class="text-slate-500 text-xs mt-0.5">{{ $label }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="relative py-28 overflow-hidden bg-[#0a0f1c]">

    <!-- Background glow -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-violet-600/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative max-w-screen-xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center mb-20">
            <span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Powerful Features</span>
            <h2 class="heading-font text-5xl font-bold mt-3">Built for <span style="background:linear-gradient(90deg,#818cf8,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent">trust and scale</span></h2>
            <p class="text-slate-400 mt-4 text-lg max-w-xl mx-auto">Every feature is designed around one principle: your election must be unquestionable.</p>
        </div>

        <!-- Top row: Security (wide) + Mobile -->
        <div class="grid md:grid-cols-5 gap-6 mb-6">

            <!-- Security card (spans 3 cols) -->
            <div class="feature-card group md:col-span-3 relative rounded-3xl p-8 border border-white/[0.07] hover:border-indigo-500/30 transition-all duration-500 overflow-hidden" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 0% 0%,rgba(99,102,241,0.07),transparent 60%)"></div>

                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6" style="background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.2)">🔒</div>
                <h3 class="text-2xl font-semibold mb-3">Military-grade Security</h3>
                <p class="text-slate-400 mb-8">End-to-end encryption, blockchain audit trail, biometric options, and zero-knowledge proofs keep every ballot tamper-proof.</p>

                <div class="grid grid-cols-3 gap-3">
                    @foreach([
                        ['bi-person-check','indigo','Voter Verification','Every voter is uniquely authenticated before casting.'],
                        ['bi-link-45deg','violet','Immutable Ledger','Votes are written to an append-only blockchain trail.'],
                        ['bi-shield-check','emerald','No Single Point','Distributed architecture eliminates central failure.'],
                    ] as [$icon,$color,$title,$desc])
                    <div class="rounded-2xl p-4 border border-white/[0.06] hover:border-{{ $color }}-500/30 transition-colors" style="background:rgba(255,255,255,0.02)">
                        <i class="bi {{ $icon }} text-{{ $color }}-400 text-xl mb-3 block"></i>
                        <div class="font-medium text-sm mb-1">{{ $title }}</div>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile First card (spans 2 cols) -->
            <div class="feature-card group md:col-span-2 relative rounded-3xl p-8 border border-white/[0.07] hover:border-sky-500/30 transition-all duration-500 overflow-hidden" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 100% 0%,rgba(14,165,233,0.07),transparent 60%)"></div>

                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6" style="background:rgba(14,165,233,0.12);border:1px solid rgba(14,165,233,0.2)">📱</div>
                <h3 class="text-2xl font-semibold mb-3">Mobile First</h3>
                <p class="text-slate-400 mb-8">Works perfectly on every device. SMS &amp; email reminders. Offline ballot queuing for low-connectivity areas.</p>

                <div class="space-y-3">
                    @foreach([
                        ['bi-phone','Responsive on all devices'],
                        ['bi-bell','SMS & email reminders'],
                        ['bi-wifi-off','Offline ballot queuing'],
                        ['bi-translate','20+ language support'],
                    ] as [$icon,$label])
                    <div class="flex items-center gap-3 text-sm">
                        <div class="w-8 h-8 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="bi {{ $icon }} text-sky-400 text-sm"></i>
                        </div>
                        <span class="text-slate-300">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bottom row: Live Chart (wide) + Extra stat card -->
        <div class="grid md:grid-cols-5 gap-6">

            <!-- Live Chart card (spans 3 cols) -->
            <div class="feature-card group md:col-span-3 relative rounded-3xl p-8 border border-white/[0.07] hover:border-amber-500/30 transition-all duration-500 overflow-hidden" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 50% 100%,rgba(245,158,11,0.06),transparent 60%)"></div>

                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-4" style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.2)">📊</div>
                        <h3 class="text-2xl font-semibold">Real-time Insights</h3>
                        <p class="text-slate-400 mt-1 text-sm">Live dashboards, turnout analytics, and instant result visualization.</p>
                    </div>
                    @if(!empty($chartData))
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full flex-shrink-0" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25);color:#34d399">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        LIVE
                    </span>
                    @endif
                </div>

                @if(!empty($chartData))
                <!-- Real data chart -->
                <div class="mb-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-slate-400 truncate max-w-[60%]">{{ $chartData['title'] }}</span>
                        <span class="text-xs text-slate-500">{{ $chartData['total'] }} votes cast</span>
                    </div>
                </div>
                <div class="space-y-3" id="liveChart">
                    @foreach($chartData['candidates'] as $i => $candidate)
                    @php
                        $colors = ['from-indigo-500 to-violet-500','from-amber-400 to-orange-500','from-cyan-400 to-emerald-500','from-pink-400 to-rose-500','from-sky-400 to-blue-500'];
                        $bar = $colors[$i % count($colors)];
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-slate-300 font-medium">{{ $candidate['name'] }}</span>
                            <span class="text-slate-400">{{ $candidate['votes'] }} votes · <span class="text-white font-semibold">{{ $candidate['percentage'] }}%</span></span>
                        </div>
                        <div class="h-2.5 rounded-full bg-white/5 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r {{ $bar }} transition-all duration-1000"
                                 style="width:{{ $candidate['percentage'] }}%"
                                 data-width="{{ $candidate['percentage'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-600 mt-4 flex items-center gap-1">
                    <i class="bi bi-arrow-repeat"></i> Updates every 30 seconds
                </p>

                @else
                <!-- Fallback animated demo chart -->
                <div class="space-y-3" id="liveChart">
                    @foreach([
                        ['Alice Kamau','from-indigo-500 to-violet-500',62],
                        ['Brian Okello','from-amber-400 to-orange-500',28],
                        ['Carol Mutesi','from-cyan-400 to-emerald-500',10],
                    ] as [$name,$bar,$pct])
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-slate-300 font-medium">{{ $name }}</span>
                            <span class="text-white font-semibold">{{ $pct }}%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-white/5 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r {{ $bar }} transition-all duration-1000"
                                 style="width:{{ $pct }}%"
                                 data-width="{{ $pct }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-600 mt-4 flex items-center gap-1">
                    <i class="bi bi-info-circle"></i> Demo data — live results appear once elections are active
                </p>
                @endif
            </div>

            <!-- Stats / extra features card (spans 2 cols) -->
            <div class="md:col-span-2 flex flex-col gap-6">

                <!-- Instant results -->
                <div class="feature-card group flex-1 relative rounded-3xl p-6 border border-white/[0.07] hover:border-emerald-500/30 transition-all duration-500 overflow-hidden" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 100% 100%,rgba(16,185,129,0.07),transparent 60%)"></div>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl mb-4" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.2)">⚡</div>
                    <h3 class="font-semibold text-lg mb-2">Instant Results</h3>
                    <p class="text-slate-400 text-sm">Tallied and published automatically the moment polls close. Zero manual counting.</p>
                </div>

                <!-- Audit trail -->
                <div class="feature-card group flex-1 relative rounded-3xl p-6 border border-white/[0.07] hover:border-violet-500/30 transition-all duration-500 overflow-hidden" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 0% 100%,rgba(139,92,246,0.07),transparent 60%)"></div>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl mb-4" style="background:rgba(139,92,246,0.12);border:1px solid rgba(139,92,246,0.2)">🔗</div>
                    <h3 class="font-semibold text-lg mb-2">Open Audit Trail</h3>
                    <p class="text-slate-400 text-sm">Every action is logged on an append-only ledger. Independent observers can verify results without accessing voter identities.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="relative py-28 overflow-hidden bg-gradient-to-b from-[#0a0f1c] to-[#0d1220]">

    <!-- Background glow -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative max-w-screen-xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center mb-20">
            <span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">How It Works</span>
            <h2 class="heading-font text-5xl font-bold mt-3">3 steps. <span style="background:linear-gradient(90deg,#818cf8,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent">30 seconds.</span></h2>
            <p class="text-slate-400 mt-4 text-lg">Vote securely from anywhere in the world — on any device.</p>
        </div>

        <!-- Steps -->
        <div class="relative grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">

            <!-- Connector line (desktop only) -->
            <div class="hidden md:block absolute top-14 left-[calc(16.66%+2rem)] right-[calc(16.66%+2rem)] h-px" style="background:linear-gradient(90deg,transparent,rgba(99,102,241,0.4),rgba(168,85,247,0.4),transparent)"></div>

            <!-- Step 1 -->
            <div class="hiw-card group relative rounded-3xl p-8 border border-white/[0.07] hover:border-indigo-500/30 transition-all duration-500 hover:-translate-y-2" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 50% 0%,rgba(99,102,241,0.08),transparent 70%)"></div>

                <!-- Step number -->
                <div class="relative w-14 h-14 rounded-2xl flex items-center justify-center mb-6 font-bold text-xl" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);box-shadow:0 8px 32px rgba(99,102,241,0.35)">
                    01
                    <!-- Pulse ring -->
                    <span class="absolute inset-0 rounded-2xl animate-ping opacity-20" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)"></span>
                </div>

                <h4 class="font-semibold text-xl mb-3 text-white">Verify Identity</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">Authenticate securely using your national ID, student email, or biometric login — all in seconds.</p>

                <!-- Mini feature pills -->
                <div class="flex flex-wrap gap-2">
                    <span class="text-xs px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300">🪪 National ID</span>
                    <span class="text-xs px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300">📧 Email OTP</span>
                    <span class="text-xs px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300">🔏 Biometric</span>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="hiw-card group relative rounded-3xl p-8 border border-white/[0.07] hover:border-violet-500/30 transition-all duration-500 hover:-translate-y-2" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 50% 0%,rgba(139,92,246,0.08),transparent 70%)"></div>

                <div class="relative w-14 h-14 rounded-2xl flex items-center justify-center mb-6 font-bold text-xl" style="background:linear-gradient(135deg,#8b5cf6,#a855f7);box-shadow:0 8px 32px rgba(139,92,246,0.35)">
                    02
                </div>

                <h4 class="font-semibold text-xl mb-3 text-white">Review Candidates</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">Explore rich candidate profiles, read manifestos, watch video pitches, and browse community Q&amp;A.</p>

                <div class="flex flex-wrap gap-2">
                    <span class="text-xs px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-300">📋 Manifestos</span>
                    <span class="text-xs px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-300">🎥 Video Pitch</span>
                    <span class="text-xs px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-300">💬 Q&amp;A</span>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="hiw-card group relative rounded-3xl p-8 border border-white/[0.07] hover:border-fuchsia-500/30 transition-all duration-500 hover:-translate-y-2" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:radial-gradient(circle at 50% 0%,rgba(217,70,239,0.08),transparent 70%)"></div>

                <div class="relative w-14 h-14 rounded-2xl flex items-center justify-center mb-6 font-bold text-xl" style="background:linear-gradient(135deg,#a855f7,#d946ef);box-shadow:0 8px 32px rgba(217,70,239,0.35)">
                    03
                </div>

                <h4 class="font-semibold text-xl mb-3 text-white">Cast &amp; Confirm</h4>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">Submit your encrypted ballot, receive an instant digital receipt, and watch live results update in real time.</p>

                <div class="flex flex-wrap gap-2">
                    <span class="text-xs px-3 py-1 rounded-full bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-300">🔒 Encrypted</span>
                    <span class="text-xs px-3 py-1 rounded-full bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-300">🧾 Receipt</span>
                    <span class="text-xs px-3 py-1 rounded-full bg-fuchsia-500/10 border border-fuchsia-500/20 text-fuchsia-300">📊 Live Results</span>
                </div>
            </div>
        </div>

        <!-- Bottom time badge -->
        <div class="flex justify-center mt-14">
            <div class="inline-flex items-center gap-x-3 rounded-2xl px-6 py-3 border border-white/[0.08]" style="background:rgba(255,255,255,0.03)">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/15 flex items-center justify-center">
                    <i class="bi bi-lightning-charge-fill text-emerald-400 text-sm"></i>
                </div>
                <span class="text-sm text-slate-300">Average time to cast a vote: <span class="text-white font-semibold">28 seconds</span></span>
            </div>
        </div>

    </div>
</section>

<!-- TESTIMONIALS -->
<section class="relative py-24 overflow-hidden bg-[#0a0f1c]">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-violet-600/8 rounded-full blur-[100px]"></div>
    </div>
    <div class="relative max-w-screen-xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">Testimonials</span>
            <h2 class="heading-font text-4xl font-bold mt-3">Trusted by real <span style="background:linear-gradient(90deg,#818cf8,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent">organizations</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="relative rounded-3xl p-7 border border-white/[0.07] flex flex-col gap-5" style="background:rgba(255,255,255,0.03);backdrop-filter:blur(12px)">
                <div class="text-5xl leading-none font-serif" style="color:rgba(99,102,241,0.3);line-height:.8">&ldquo;</div>
                <p class="text-slate-300 text-sm leading-relaxed flex-1">{{ $testimonial->quote }}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-white/[0.06]">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 bg-gradient-to-br {{ $testimonial->gradient }}">{{ $testimonial->initials }}</div>
                    <div>
                        <div class="text-white font-semibold text-sm">{{ $testimonial->name }}</div>
                        <div class="text-slate-500 text-xs">{{ $testimonial->role }}</div>
                    </div>
                    <div class="ml-auto flex gap-0.5">
                        @for($s = 0; $s < $testimonial->rating; $s++)
                            <i class="bi bi-star-fill text-amber-400 text-xs"></i>
                        @endfor
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="relative py-24 overflow-hidden bg-gradient-to-b from-[#0a0f1c] to-[#080c18]">
    <div class="relative max-w-3xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-indigo-400 text-xs font-semibold tracking-widest uppercase">FAQ</span>
            <h2 class="heading-font text-4xl font-bold mt-3">Common <span style="background:linear-gradient(90deg,#818cf8,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent">questions</span></h2>
            <p class="text-slate-400 mt-3">Everything you need to know before you vote.</p>
        </div>
        <div class="space-y-3" id="faq">
            @foreach($faqs as $faq)
            <div class="faq-item rounded-2xl border border-white/[0.07] overflow-hidden" style="background:rgba(255,255,255,0.03)">
                <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between gap-4 px-6 py-4 text-left">
                    <span class="font-medium text-white text-sm">{{ $faq->question }}</span>
                    <i class="bi bi-plus text-slate-400 text-lg flex-shrink-0 faq-icon transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 overflow-hidden" style="max-height:0;transition:max-height .35s ease">
                    <p class="text-slate-400 text-sm leading-relaxed pb-5">{{ $faq->answer }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <p class="text-slate-500 text-sm">Still have questions? <a href="{{ route('contact') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors">Contact our team →</a></p>
        </div>
    </div>
</section>

<!-- FINAL CTA -->
<section class="relative py-32 overflow-hidden bg-[#080c18]">

    <!-- Animated background orbs -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[500px] bg-indigo-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-1/4 w-[400px] h-[300px] bg-violet-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[300px] bg-fuchsia-600/15 rounded-full blur-[100px]"></div>
    </div>

    <!-- Subtle grid overlay -->
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(255,255,255,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.025) 1px,transparent 1px);background-size:60px 60px"></div>

    <div class="relative max-w-screen-xl mx-auto px-6">

        <!-- Top label -->
        <div class="flex justify-center mb-8">
            <span class="inline-flex items-center gap-x-2 bg-white/5 border border-white/10 text-indigo-300 text-xs font-semibold tracking-widest px-5 py-2 rounded-full">
                <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-pulse"></span>
                JOIN 248,000+ VOTERS WORLDWIDE
            </span>
        </div>

        <!-- Headline -->
        <div class="text-center max-w-4xl mx-auto mb-6">
            <h2 class="heading-font font-bold text-white" style="font-size:clamp(2.5rem,5vw,4rem);line-height:1.1">
                Ready to transform<br>
                <span style="background:linear-gradient(90deg,#818cf8,#c084fc,#67e8f9);-webkit-background-clip:text;-webkit-text-fill-color:transparent">
                    your elections?
                </span>
            </h2>
            <p class="text-slate-400 mt-5 text-lg max-w-xl mx-auto">
                Set up your first election in under 5 minutes. Trusted by universities, corporations, and governments across 40+ countries.
            </p>
        </div>

        <!-- Social proof avatars -->
        <div class="flex justify-center items-center gap-3 mb-12">
            <div class="flex -space-x-3">
                @foreach([
                    ['from-indigo-400 to-violet-500','AK'],
                    ['from-amber-400 to-red-500','BO'],
                    ['from-cyan-400 to-emerald-500','CM'],
                    ['from-pink-400 to-rose-500','DM'],
                    ['from-sky-400 to-blue-500','EO'],
                ] as [$grad,$init])
                <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $grad }} border-2 border-[#080c18] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ $init }}</div>
                @endforeach
            </div>
            <div class="text-sm text-slate-400">
                <span class="text-white font-semibold">4.98 ★</span> from 2,400+ reviews
            </div>
        </div>

        <!-- CTA card -->
        <div class="max-w-3xl mx-auto rounded-3xl p-px" style="background:linear-gradient(135deg,rgba(99,102,241,0.5),rgba(168,85,247,0.3),rgba(103,232,249,0.2))">
            <div class="rounded-3xl px-10 py-12 text-center" style="background:rgba(10,15,28,0.85);backdrop-filter:blur(24px)">

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="{{ route('register') }}"
                       class="group relative px-10 py-4 rounded-2xl font-semibold text-lg overflow-hidden transition-all hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/30"
                       style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#a855f7)">
                        <span class="relative z-10 flex items-center justify-center gap-x-2">
                            <i class="bi bi-rocket-takeoff"></i>
                            Create Free Account
                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>

                    <a href="{{ route('contact') }}"
                       class="group px-10 py-4 rounded-2xl font-medium text-lg border border-white/15 text-slate-300 hover:text-white hover:border-white/30 hover:bg-white/5 transition-all flex items-center justify-center gap-x-2">
                        <i class="bi bi-calendar-check"></i>
                        Book a Demo
                    </a>
                </div>

                <!-- Trust badges row -->
                <div class="flex flex-wrap justify-center gap-x-6 gap-y-3 text-xs text-slate-500">
                    <span class="flex items-center gap-x-1.5">
                        <i class="bi bi-check-circle-fill text-emerald-400"></i>
                        No credit card required
                    </span>
                    <span class="flex items-center gap-x-1.5">
                        <i class="bi bi-check-circle-fill text-emerald-400"></i>
                        Free forever plan
                    </span>
                    <span class="flex items-center gap-x-1.5">
                        <i class="bi bi-check-circle-fill text-emerald-400"></i>
                        Cancel anytime
                    </span>
                    <span class="flex items-center gap-x-1.5">
                        <i class="bi bi-check-circle-fill text-emerald-400"></i>
                        SOC 2 certified
                    </span>
                </div>
            </div>
        </div>

        <!-- Bottom logos / org types -->
        <div class="mt-14 text-center">
            <p class="text-slate-600 text-xs tracking-widest uppercase mb-6">Trusted by organizations of all sizes</p>
            <div class="flex flex-wrap justify-center gap-x-10 gap-y-4 text-slate-500 text-sm font-medium">
                @foreach(['Universities','Student Councils','Corporations','NGOs','Government Bodies','Trade Unions'] as $org)
                <span class="flex items-center gap-x-2">
                    <i class="bi bi-building text-indigo-500/60"></i>
                    {{ $org }}
                </span>
                @endforeach
            </div>
        </div>

    </div>
</section>

<!-- FOOTER -->
<footer class="bg-[#060a14] border-t border-white/[0.07]">

    <!-- Main footer grid -->
    <div class="max-w-screen-2xl mx-auto px-6 pt-20 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-12">

            <!-- Brand column -->
            <div class="md:col-span-2 space-y-6">
                <div class="flex items-center gap-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <i class="bi bi-shield-check text-white text-lg"></i>
                    </div>
                    <span class="heading-font text-white text-2xl font-semibold">VoteSecure</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    The most trusted platform for secure, transparent, and verifiable online elections — from student councils to national referendums.
                </p>

                <!-- Social icons -->
                <div class="flex items-center gap-x-3">
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-500/20 hover:border-indigo-500/40 transition-all">
                        <i class="bi bi-twitter-x text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-500/20 hover:border-indigo-500/40 transition-all">
                        <i class="bi bi-linkedin text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-500/20 hover:border-indigo-500/40 transition-all">
                        <i class="bi bi-github text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-indigo-500/20 hover:border-indigo-500/40 transition-all">
                        <i class="bi bi-youtube text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Product links -->
            <div class="space-y-5">
                <h6 class="text-white text-xs font-semibold tracking-widest uppercase">Product</h6>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="{{ route('features') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Features</a></li>
                    <li><a href="{{ route('pricing') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Pricing</a></li>
                    <li><a href="{{ route('changelog') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Changelog</a></li>
                    <li><a href="{{ route('roadmap') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Roadmap</a></li>
                    <li><a href="{{ route('api-docs') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">API Docs</a></li>
                </ul>
            </div>

            <!-- Company links -->
            <div class="space-y-5">
                <h6 class="text-white text-xs font-semibold tracking-widest uppercase">Company</h6>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">About Us</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Blog</a></li>
                    <li><a href="{{ route('careers') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Careers</a></li>
                    <li><a href="{{ route('press') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Press Kit</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Contact</a></li>
                </ul>
            </div>

            <!-- Legal + Newsletter -->
            <div class="space-y-5">
                <h6 class="text-white text-xs font-semibold tracking-widest uppercase">Legal</h6>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Terms of Service</a></li>
                    <li><a href="{{ route('security') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Security</a></li>
                    <li><a href="{{ route('cookies') }}" class="hover:text-white transition-colors hover:translate-x-1 inline-block transition-transform">Cookie Policy</a></li>
                </ul>

                <!-- Status badge -->
                <div class="mt-6 inline-flex items-center gap-x-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs px-4 py-2 rounded-2xl">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                    All systems operational
                </div>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-white/[0.06]"></div>

    <!-- Bottom bar -->
    <div class="max-w-screen-2xl mx-auto px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
        <p>© {{ date('Y') }} VoteSecure, Inc. All rights reserved. Built with ❤️ for democracy.</p>
        <div class="flex items-center gap-x-2">
            <i class="bi bi-lock-fill text-indigo-400"></i>
            <span>SOC 2 Type II Certified &nbsp;•&nbsp; ISO 27001 &nbsp;•&nbsp; GDPR Compliant</span>
        </div>
    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tailwind script already included via CDN
    function selectCandidate(el) {
        document.querySelectorAll('.vote-option').forEach(option => {
            option.classList.remove('border-indigo-500/50');
            const icon = option.querySelector('i');
            if (icon) icon.className = 'bi bi-circle text-3xl text-slate-400';
        });
        el.classList.add('border-indigo-500/50');
        const icon = el.querySelector('i');
        if (icon) icon.className = 'bi bi-check-circle-fill text-3xl text-indigo-400';
    }

    function submitDemoVote() {
        const btn = document.getElementById('demoSubmitBtn');
        const success = document.getElementById('demoSuccess');
        btn.disabled = true;
        btn.textContent = 'Recording...';
        btn.style.opacity = '.7';
        setTimeout(() => {
            btn.style.display = 'none';
            success.classList.remove('hidden');
        }, 900);
    }

    function resetDemo() {
        const btn = document.getElementById('demoSubmitBtn');
        const success = document.getElementById('demoSuccess');
        // Reset button
        btn.style.display = '';
        btn.disabled = false;
        btn.textContent = 'Submit My Vote Securely';
        btn.style.opacity = '1';
        success.classList.add('hidden');
        // Reset candidate selection to first
        document.querySelectorAll('.vote-option').forEach((opt, i) => {
            const icon = opt.querySelector('i');
            if (i === 0) {
                opt.style.background = 'rgba(99,102,241,0.08)';
                opt.style.borderColor = 'rgba(99,102,241,0.5)';
                if (icon) { icon.className = 'bi bi-check-circle-fill text-2xl text-indigo-400 flex-shrink-0'; }
            } else {
                opt.style.background = 'rgba(255,255,255,0.02)';
                opt.style.borderColor = 'rgba(255,255,255,0.06)';
                if (icon) { icon.className = 'bi bi-circle text-2xl text-slate-600 flex-shrink-0'; }
            }
        });
    }

    // Animate chart bars on load
    document.querySelectorAll('#liveChart [data-width]').forEach(bar => {
        const target = bar.dataset.width;
        bar.style.width = '0%';
        setTimeout(() => { bar.style.width = target + '%'; }, 300);
    });

    // Auto-refresh live chart every 30s
    setInterval(() => {
        fetch(window.location.href)
            .then(r => r.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newChart = doc.getElementById('liveChart');
                const oldChart = document.getElementById('liveChart');
                if (newChart && oldChart) {
                    oldChart.innerHTML = newChart.innerHTML;
                    oldChart.querySelectorAll('[data-width]').forEach(bar => {
                        const target = bar.dataset.width;
                        bar.style.width = '0%';
                        setTimeout(() => { bar.style.width = target + '%'; }, 100);
                    });
                }
            }).catch(() => {});
    }, 30000);

    // Mobile menu toggle
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
        document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : '';
    });
    // Close on link click
    mobileMenu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            hamburger.classList.remove('open');
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
        });
    });

    // FAQ accordion
    function toggleFaq(btn) {
        const answer = btn.nextElementSibling;
        const icon = btn.querySelector('.faq-icon');
        const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';
        // Close all
        document.querySelectorAll('.faq-answer').forEach(a => a.style.maxHeight = '0px');
        document.querySelectorAll('.faq-icon').forEach(i => { i.className = 'bi bi-plus text-slate-400 text-lg flex-shrink-0 faq-icon transition-transform duration-300'; });
        if (!isOpen) {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.className = 'bi bi-dash text-indigo-400 text-lg flex-shrink-0 faq-icon transition-transform duration-300';
        }
    }

    // Scroll-to-top button
    const scrollBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => {
        scrollBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
    });
    scrollBtn.addEventListener('mouseenter', () => {
        scrollBtn.style.background = 'rgba(99,102,241,0.8)';
        scrollBtn.style.borderColor = 'rgba(99,102,241,0.5)';
        scrollBtn.style.color = '#fff';
    });
    scrollBtn.addEventListener('mouseleave', () => {
        scrollBtn.style.background = 'rgba(10,15,28,0.9)';
        scrollBtn.style.borderColor = 'rgba(255,255,255,0.12)';
        scrollBtn.style.color = 'rgba(255,255,255,0.7)';
    });

    // Loop demo chart bars when no real data
    @if(empty($chartData))
    (function loopDemoChart() {
        const bars = document.querySelectorAll('#liveChart [data-width]');
        if (!bars.length) return;
        // Animate to 0 then back to target on a loop
        function cycle() {
            bars.forEach(bar => { bar.style.width = '0%'; });
            setTimeout(() => {
                bars.forEach(bar => { bar.style.width = bar.dataset.width + '%'; });
                setTimeout(cycle, 3500);
            }, 600);
        }
        setTimeout(cycle, 2000);
    })();
    @endif

    // Simple scroll animation for navbar
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('nav');
        if (window.scrollY > 50) {
            nav.classList.add('shadow-2xl', 'bg-[#0a0f1c]');
        } else {
            nav.classList.remove('shadow-2xl', 'bg-[#0a0f1c]');
        }
    });
</script>
<!-- SCROLL TO TOP -->
<button id="scrollTop"
        onclick="window.scrollTo({top:0,behavior:'smooth'})"
        aria-label="Scroll to top"
        style="position:fixed;bottom:2rem;right:2rem;z-index:999;width:44px;height:44px;border-radius:14px;border:1px solid rgba(255,255,255,0.12);background:rgba(10,15,28,0.9);backdrop-filter:blur(12px);color:rgba(255,255,255,0.7);cursor:pointer;display:none;align-items:center;justify-content:center;transition:all .25s;box-shadow:0 8px 24px rgba(0,0,0,0.4)">
    <i class="bi bi-arrow-up" style="font-size:1rem;"></i>
</button>

</body>
</html>