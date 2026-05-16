@extends('layouts.admin')

@section('page-title', 'Settings')
@section('page-icon', 'gear')
@section('page-subtitle', 'Manage your account information, password, and security.')

@section('content')

<div class="row g-4">

    {{-- ── Profile Information ── --}}
    <div class="col-12">
        <div class="rounded-4 overflow-hidden" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08)">

            <div class="d-flex align-items-center gap-3 px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.07)">
                <div style="width:36px;height:36px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-person-fill" style="color:#a5b4fc"></i>
                </div>
                <div>
                    <div style="font-weight:600;font-size:.92rem;color:#fff">Profile Information</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,0.35)">Update your name and email address</div>
                </div>
            </div>

            <div class="p-4">
                @if(session('status') === 'profile-updated')
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4 py-2">
                        <i class="bi bi-check-circle-fill"></i> Profile updated successfully.
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback" style="color:#fca5a5;font-size:.78rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback" style="color:#fca5a5;font-size:.78rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex align-items-center gap-3 mt-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Save Changes
                            </button>
                            <div style="width:36px;height:36px;background:rgba(99,102,241,0.12);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <span style="font-weight:700;color:#a5b4fc;font-size:.8rem">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <div style="font-size:.82rem;font-weight:600;color:#fff">{{ auth()->user()->name }}</div>
                                <div style="font-size:.72rem;color:rgba(255,255,255,0.3)">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Change Password ── --}}
    <div class="col-12">
        <div class="rounded-4 overflow-hidden" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08)">

            <div class="d-flex align-items-center gap-3 px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.07)">
                <div style="width:36px;height:36px;background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-lock-fill" style="color:#fcd34d"></i>
                </div>
                <div>
                    <div style="font-weight:600;font-size:.92rem;color:#fff">Change Password</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,0.35)">Use a long, random password to stay secure</div>
                </div>
            </div>

            <div class="p-4">
                @if(session('status') === 'password-updated')
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4 py-2">
                        <i class="bi bi-check-circle-fill"></i> Password updated successfully.
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                   autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback" style="color:#fca5a5;font-size:.78rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                   autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback" style="color:#fca5a5;font-size:.78rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                   autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback" style="color:#fca5a5;font-size:.78rem">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="bi bi-shield-lock me-1"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Account Info ── --}}
    <div class="col-md-6">
        <div class="rounded-4 p-4 h-100" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08)">
            <div class="d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-info-circle" style="color:#67e8f9"></i>
                <span style="font-weight:600;font-size:.88rem;color:#fff">Account Details</span>
            </div>
            <div class="d-flex flex-column gap-3">
                @foreach([
                    ['bi-person','Name', auth()->user()->name],
                    ['bi-envelope','Email', auth()->user()->email],
                    ['bi-shield-check','Role', ucfirst(auth()->user()->role ?? 'admin')],
                    ['bi-calendar3','Member Since', auth()->user()->created_at->format('M d, Y')],
                ] as [$icon, $label, $value])
                <div class="d-flex align-items-center gap-3">
                    <div style="width:32px;height:32px;background:rgba(255,255,255,0.05);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi {{ $icon }}" style="color:rgba(255,255,255,0.4);font-size:.85rem"></i>
                    </div>
                    <div>
                        <div style="font-size:.7rem;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:.08em">{{ $label }}</div>
                        <div style="font-size:.85rem;color:#fff;font-weight:500">{{ $value }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Danger Zone ── --}}
    <div class="col-md-6">
        <div class="rounded-4 p-4 h-100" style="background:rgba(239,68,68,0.04);border:1px solid rgba(239,68,68,0.18)">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-triangle-fill" style="color:#fca5a5"></i>
                <span style="font-weight:600;font-size:.88rem;color:#fca5a5">Danger Zone</span>
            </div>
            <p style="font-size:.82rem;color:rgba(255,255,255,0.4);line-height:1.6;margin-bottom:1.25rem">
                Once your account is deleted, all data will be permanently removed. This action cannot be undone.
            </p>

            <button type="button" class="btn btn-sm px-4"
                    style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;font-size:.82rem"
                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash3 me-1"></i> Delete My Account
            </button>
        </div>
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#0f172a;border:1px solid rgba(239,68,68,0.25);border-radius:16px">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div style="width:56px;height:56px;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.25);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
                        <i class="bi bi-trash3-fill" style="color:#fca5a5;font-size:1.4rem"></i>
                    </div>
                    <h5 style="color:#fff;font-weight:700;margin-bottom:.5rem">Delete Account?</h5>
                    <p style="color:rgba(255,255,255,0.4);font-size:.85rem;margin:0">
                        This will permanently delete your account and all associated data. Enter your password to confirm.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.82rem">Your Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="Enter your password to confirm">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback" style="color:#fca5a5;font-size:.78rem">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn flex-fill"
                                style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.35);color:#fca5a5;font-weight:600">
                            <i class="bi bi-trash3 me-1"></i> Yes, Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
</script>
@endif

@endsection
