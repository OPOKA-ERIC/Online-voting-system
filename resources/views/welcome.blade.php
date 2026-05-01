<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Voting System</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #0f172a; color: #fff; overflow-x: hidden; }

        /* ── Navbar ── */
        .navbar { background: rgba(15,23,42,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.07); }
        .navbar-brand { font-weight: 800; font-size: 1.2rem; }
        .navbar-brand .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-right: .5rem;
        }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0f172a 100%);
            display: flex; align-items: center;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: -200px; left: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.3);
            color: #a5b4fc;
            padding: .4rem 1rem; border-radius: 50px;
            font-size: .82rem; font-weight: 500;
            margin-bottom: 1.5rem;
        }
        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 800; line-height: 1.15;
            margin-bottom: 1.2rem;
        }
        .hero h1 span {
            background: linear-gradient(90deg, #6366f1, #06b6d4);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p { color: rgba(255,255,255,0.6); font-size: 1.1rem; line-height: 1.7; max-width: 520px; }
        .btn-hero-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none; color: #fff;
            padding: .75rem 2rem; border-radius: 10px;
            font-weight: 600; font-size: 1rem;
            transition: all .2s;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,0.4); color: #fff; }
        .btn-hero-outline {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,0.2); color: #fff;
            padding: .75rem 2rem; border-radius: 10px;
            font-weight: 600; font-size: 1rem;
            transition: all .2s;
        }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.08); color: #fff; border-color: rgba(255,255,255,0.4); }

        /* ── Stats Bar ── */
        .stats-bar {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; padding: 1.5rem 2rem;
            margin-top: 3rem;
        }
        .stat-item { text-align: center; }
        .stat-item .stat-number { font-size: 1.8rem; font-weight: 800; color: #fff; }
        .stat-item .stat-label { font-size: .8rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: .08em; }
        .stat-divider { width: 1px; background: rgba(255,255,255,0.1); }

        /* ── Floating Card ── */
        .hero-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 2rem;
            backdrop-filter: blur(10px);
        }
        .vote-option {
            background: rgba(255,255,255,0.05);
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 1rem 1.2rem;
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: .75rem; cursor: pointer;
            transition: all .2s;
        }
        .vote-option:hover, .vote-option.selected {
            border-color: #6366f1;
            background: rgba(99,102,241,0.15);
        }
        .vote-option .avatar {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .9rem; flex-shrink: 0;
        }

        /* ── Features ── */
        .features { background: #0f172a; padding: 6rem 0; }
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; padding: 2rem;
            height: 100%; transition: all .2s;
        }
        .feature-card:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(99,102,241,0.3);
            transform: translateY(-4px);
        }
        .feature-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 1.2rem;
        }
        .feature-card h5 { font-weight: 700; margin-bottom: .5rem; }
        .feature-card p { color: rgba(255,255,255,0.5); font-size: .9rem; line-height: 1.6; margin: 0; }

        /* ── How It Works ── */
        .how-it-works { background: linear-gradient(135deg, #0f172a, #1e3a5f); padding: 6rem 0; }
        .step-number {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1.1rem; flex-shrink: 0;
        }
        .step-connector { width: 2px; height: 40px; background: rgba(99,102,241,0.3); margin: .5rem auto; }

        /* ── CTA ── */
        .cta-section {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #06b6d4 100%);
            padding: 5rem 0; text-align: center;
        }

        /* ── Footer ── */
        footer { background: #080e1a; padding: 2rem 0; border-top: 1px solid rgba(255,255,255,0.06); }
    </style>
</head>
<body>

<!-- ══════════ NAVBAR ══════════ -->
<nav class="navbar navbar-expand-lg sticky-top px-4 py-3">
    <a class="navbar-brand text-white d-flex align-items-center" href="/">
        <div class="logo-icon"><i class="bi bi-shield-check text-white"></i></div>
        VoteSecure
    </a>
    <div class="ms-auto d-flex gap-2">
        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light px-3">Log In</a>
        @endif
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-sm px-3" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:8px;">Register</a>
        @endif
    </div>
</nav>

<!-- ══════════ HERO ══════════ -->
<section class="hero">
    <div class="container py-5" style="position:relative;z-index:1;">
        <div class="row align-items-center g-5">

            <!-- Left -->
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="bi bi-shield-check-fill"></i> Secure & Transparent Voting
                </div>
                <h1>Your Vote.<br><span>Your Voice.</span><br>Your Future.</h1>
                <p>A modern, secure online voting platform that ensures every vote counts. Participate in elections with confidence — fast, fair, and fully transparent.</p>
                <div class="d-flex gap-3 flex-wrap mt-4">
                    <a href="{{ route('register') }}" class="btn btn-hero-primary">
                        <i class="bi bi-person-plus me-2"></i>Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-hero-outline">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Log In
                    </a>
                </div>

                <!-- Stats -->
                <div class="stats-bar">
                    <div class="row g-0 align-items-center">
                        <div class="col stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Secure</div>
                        </div>
                        <div class="col-auto stat-divider mx-3" style="height:40px;"></div>
                        <div class="col stat-item">
                            <div class="stat-number">1</div>
                            <div class="stat-label">Vote Per Person</div>
                        </div>
                        <div class="col-auto stat-divider mx-3" style="height:40px;"></div>
                        <div class="col stat-item">
                            <div class="stat-number">Live</div>
                            <div class="stat-label">Results</div>
                        </div>
                        <div class="col-auto stat-divider mx-3" style="height:40px;"></div>
                        <div class="col stat-item">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Available</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Mock Voting Card -->
            <div class="col-lg-6">
                <div class="hero-card">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <span class="badge" style="background:rgba(34,197,94,0.2);color:#4ade80;padding:.4rem .8rem;border-radius:6px;font-size:.8rem;">
                            <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i> Election Active
                        </span>
                        <span class="text-white-50 small ms-auto">Student Guild Elections 2025</span>
                    </div>

                    <p class="text-white-50 small mb-3">Select your preferred candidate:</p>

                    <div class="vote-option selected">
                        <div class="avatar" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">AK</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Alice Kamau</div>
                            <div class="text-white-50 small">Presidential Candidate</div>
                        </div>
                        <i class="bi bi-check-circle-fill text-primary fs-5"></i>
                    </div>

                    <div class="vote-option">
                        <div class="avatar" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">BO</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Brian Okello</div>
                            <div class="text-white-50 small">Presidential Candidate</div>
                        </div>
                        <i class="bi bi-circle text-white-50 fs-5"></i>
                    </div>

                    <div class="vote-option">
                        <div class="avatar" style="background:linear-gradient(135deg,#06b6d4,#22c55e);">CM</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Carol Mutesi</div>
                            <div class="text-white-50 small">Presidential Candidate</div>
                        </div>
                        <i class="bi bi-circle text-white-50 fs-5"></i>
                    </div>

                    <button class="btn w-100 mt-3 fw-semibold" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border-radius:10px;padding:.75rem;">
                        <i class="bi bi-check2-square me-2"></i>Submit Vote
                    </button>

                    <p class="text-center text-white-50 mt-3 mb-0" style="font-size:.78rem;">
                        <i class="bi bi-lock-fill me-1"></i>Your vote is encrypted and anonymous
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══════════ FEATURES ══════════ -->
<section class="features">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-1">Why Choose VoteSecure?</h2>
            <p class="text-white-50 mt-2">Everything you need for a fair and transparent election.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:rgba(99,102,241,0.15);">
                        <i class="bi bi-shield-lock-fill text-primary"></i>
                    </div>
                    <h5>Secure Voting</h5>
                    <p>Each voter can only vote once per election. Database-level constraints prevent any duplicate votes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:rgba(245,158,11,0.15);">
                        <i class="bi bi-bar-chart-fill" style="color:#f59e0b;"></i>
                    </div>
                    <h5>Live Results</h5>
                    <p>Watch results update in real-time with visual charts and candidate standings after you vote.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:rgba(6,182,212,0.15);">
                        <i class="bi bi-calendar2-check" style="color:#06b6d4;"></i>
                    </div>
                    <h5>Scheduled Elections</h5>
                    <p>Elections automatically open and close based on set dates. Status updates instantly — no manual work needed.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:rgba(34,197,94,0.15);">
                        <i class="bi bi-people-fill" style="color:#22c55e;"></i>
                    </div>
                    <h5>Candidate Profiles</h5>
                    <p>View candidate photos and biographies before casting your vote to make an informed decision.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:rgba(239,68,68,0.15);">
                        <i class="bi bi-person-check-fill" style="color:#ef4444;"></i>
                    </div>
                    <h5>Admin Control</h5>
                    <p>Admins manage elections and candidates through a dedicated dashboard with full CRUD capabilities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background:rgba(139,92,246,0.15);">
                        <i class="bi bi-phone-fill" style="color:#8b5cf6;"></i>
                    </div>
                    <h5>Mobile Friendly</h5>
                    <p>Fully responsive design — vote from any device, anywhere, at any time during the election period.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ HOW IT WORKS ══════════ -->
<section class="how-it-works">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-1">How It Works</h2>
            <p class="text-white-50 mt-2">Three simple steps to cast your vote.</p>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-md-3 text-center">
                <div class="step-number mx-auto mb-3">1</div>
                <h5 class="fw-bold">Create Account</h5>
                <p class="text-white-50 small">Register with your name and email to get voter access.</p>
            </div>
            <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-right text-white-50 fs-3"></i>
            </div>
            <div class="col-md-3 text-center">
                <div class="step-number mx-auto mb-3">2</div>
                <h5 class="fw-bold">Browse Elections</h5>
                <p class="text-white-50 small">View all active elections and candidate profiles on your dashboard.</p>
            </div>
            <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-right text-white-50 fs-3"></i>
            </div>
            <div class="col-md-3 text-center">
                <div class="step-number mx-auto mb-3">3</div>
                <h5 class="fw-bold">Cast Your Vote</h5>
                <p class="text-white-50 small">Select your candidate, submit, and view live results instantly.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ CTA ══════════ -->
<section class="cta-section">
    <div class="container">
        <h2 class="fw-bold fs-1 mb-3">Ready to Make Your Voice Heard?</h2>
        <p class="mb-4" style="color:rgba(255,255,255,0.8);font-size:1.1rem;">Join the platform and participate in elections that matter to you.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light fw-bold px-5 py-3" style="border-radius:10px;color:#4f46e5;">
                <i class="bi bi-person-plus me-2"></i>Register Now
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light fw-bold px-5 py-3" style="border-radius:10px;">
                <i class="bi bi-box-arrow-in-right me-2"></i>Log In
            </a>
        </div>
    </div>
</section>

<!-- ══════════ FOOTER ══════════ -->
<footer>
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-icon" style="width:28px;height:28px;background:linear-gradient(135deg,#f59e0b,#ef4444);border-radius:6px;display:inline-flex;align-items:center;justify-content:center;">
                <i class="bi bi-shield-check text-white" style="font-size:.75rem;"></i>
            </div>
            <span class="fw-bold text-white">VoteSecure</span>
        </div>
        <p class="text-white-50 small mb-0">© {{ date('Y') }} Online Voting System. Built with Laravel.</p>
        <div class="d-flex gap-3">
            <a href="{{ route('login') }}" class="text-white-50 small text-decoration-none">Login</a>
            <a href="{{ route('register') }}" class="text-white-50 small text-decoration-none">Register</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Candidate selection interaction on hero card
    document.querySelectorAll('.vote-option').forEach(option => {
        option.addEventListener('click', function () {
            document.querySelectorAll('.vote-option').forEach(o => {
                o.classList.remove('selected');
                o.querySelector('i').className = 'bi bi-circle text-white-50 fs-5';
            });
            this.classList.add('selected');
            this.querySelector('i').className = 'bi bi-check-circle-fill text-primary fs-5';
        });
    });
</script>
</body>
</html>
