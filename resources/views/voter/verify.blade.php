@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div style="width:100%;max-width:480px;padding:0 1rem;">

        <!-- Icon & Title -->
        <div class="text-center mb-4">
            <div style="width:72px;height:72px;background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;box-shadow:0 12px 32px rgba(99,102,241,0.4);">
                <i class="bi bi-shield-lock-fill text-white" style="font-size:1.8rem;"></i>
            </div>
            <h3 class="fw-bold text-white mb-1">Identity Verification</h3>
            <p style="color:rgba(255,255,255,0.45);font-size:.9rem;">
                Verify your identity to vote in<br>
                <strong class="text-white">{{ $election->title }}</strong>
            </p>
        </div>

        @if(session('error'))
            <div class="d-flex align-items-center gap-3 mb-4 p-3" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:#fca5a5;">
                <i class="bi bi-x-circle-fill fs-5 flex-shrink-0"></i>
                <span style="font-size:.88rem;">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:#fca5a5;">
                @foreach($errors->all() as $error)
                    <div style="font-size:.88rem;"><i class="bi bi-dot"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Card -->
        <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:20px;padding:2rem;">

            @if($hasVoterList)
                <!-- Info -->
                <div class="mb-4 p-3" style="background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:12px;">
                    <div class="d-flex gap-3">
                        <i class="bi bi-info-circle-fill flex-shrink-0 mt-1" style="color:#a5b4fc;"></i>
                        <div>
                            <p class="fw-semibold mb-1" style="color:#a5b4fc;font-size:.85rem;">How to verify</p>
                            <p style="color:rgba(255,255,255,0.5);font-size:.83rem;margin:0;">
                                Enter your <strong style="color:#fff;">{{ strtoupper(str_replace('_', ' ', $uniqueColumn)) }}</strong> exactly as registered in the voters list for this election.
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('voter.verify.submit', $election->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label style="color:rgba(255,255,255,0.7);font-size:.85rem;font-weight:600;display:block;margin-bottom:.5rem;">
                            {{ strtoupper(str_replace('_', ' ', $uniqueColumn)) }}
                            <span style="color:#ef4444;">*</span>
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.3);">
                                <i class="bi bi-person-badge"></i>
                            </span>
                            <input type="text" name="unique_value"
                                   style="width:100%;background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.12);color:#fff;border-radius:10px;padding:.7rem 1rem .7rem 2.8rem;font-size:.9rem;outline:none;transition:border-color .2s;"
                                   placeholder="Enter your {{ strtolower(str_replace('_', ' ', $uniqueColumn)) }}"
                                   value="{{ old('unique_value') }}" required autofocus
                                   onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                        </div>
                        <p style="color:rgba(255,255,255,0.3);font-size:.78rem;margin-top:.4rem;">Your unique identifier assigned for this election.</p>
                    </div>

                    <!-- Logged in as -->
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:.85rem;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p style="color:rgba(255,255,255,0.4);font-size:.75rem;margin:0;">Verifying as</p>
                            <p style="color:#fff;font-weight:600;font-size:.88rem;margin:0;">{{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:12px;padding:.85rem;font-size:.95rem;font-weight:600;cursor:pointer;transition:opacity .2s;display:flex;align-items:center;justify-content:center;gap:.5rem;"
                            onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <i class="bi bi-shield-check"></i> Verify & Proceed to Vote
                    </button>
                </form>

            @else
                <div class="mb-4 p-3" style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:12px;">
                    <div class="d-flex gap-3">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1" style="color:#fcd34d;"></i>
                        <p style="color:rgba(255,255,255,0.6);font-size:.85rem;margin:0;">
                            No voter list uploaded for this election. You may proceed. Each voter can only vote <strong style="color:#fff;">once</strong>.
                        </p>
                    </div>
                </div>
                <form method="POST" action="{{ route('voter.verify.submit', $election->id) }}">
                    @csrf
                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;border-radius:12px;padding:.85rem;font-size:.95rem;font-weight:600;cursor:pointer;">
                        <i class="bi bi-arrow-right-circle me-2"></i>Proceed to Vote
                    </button>
                </form>
            @endif

            <div style="border-top:1px solid rgba(255,255,255,0.08);margin-top:1.5rem;padding-top:1.5rem;">
                <a href="{{ route('voter.dashboard') }}" style="display:flex;align-items:center;justify-content:center;gap:.5rem;color:rgba(255,255,255,0.4);font-size:.88rem;text-decoration:none;transition:color .2s;"
                   onmouseover="this.style.color='rgba(255,255,255,0.8)'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                    <i class="bi bi-arrow-left"></i> Back to Elections
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
