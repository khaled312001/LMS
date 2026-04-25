@extends('layouts.default')
@push('title', get_phrase('My profile'))
@push('meta')@endpush

@push('css')
<style>
    :root {
        --sba-primary: #6366f1;
        --sba-primary-2: #8b5cf6;
        --sba-accent: #06b6d4;
        --sba-success: #10b981;
        --sba-warning: #f59e0b;
        --sba-danger: #ef4444;
        --sba-dark: #0f172a;
        --sba-dark-2: #1e1b4b;
        --sba-muted: #64748b;
        --sba-border: #e2e8f0;
        --sba-bg: #f8fafc;
        --sba-surface: #ffffff;
    }

    /* Page wrapper — same rhythm as my-courses */
    .sba-profile-page {
        background: var(--sba-bg);
        padding-top: 140px;
        padding-bottom: 80px;
    }
    .sba-profile-page .profile-banner-area { display: none !important; }
    .sba-profile-page .container { max-width: 1240px; }
    .sba-profile-page > .container > .row { align-items: flex-start; }

    /* ---------- Hero banner with profile identity ---------- */
    .sba-profile-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 45%, #4c1d95 100%);
        border-radius: 24px;
        padding: 36px 36px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 45px -22px rgba(15, 23, 42, 0.45);
        margin-bottom: 28px;
    }
    .sba-profile-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 90% -10%, rgba(236, 72, 153, 0.35), transparent 50%),
            radial-gradient(circle at 0% 110%, rgba(6, 182, 212, 0.3), transparent 45%);
        pointer-events: none;
    }
    .sba-profile-hero > * { position: relative; z-index: 1; }

    .sba-hero-row {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .sba-avatar-frame {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        flex-shrink: 0;
        background: linear-gradient(135deg, #fff 0%, #c7d2fe 100%);
        padding: 4px;
        box-shadow: 0 18px 40px -14px rgba(99, 102, 241, 0.65);
    }
    .sba-avatar-frame img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #fff;
    }
    .sba-avatar-edit {
        position: absolute;
        inset-inline-end: 0;
        bottom: 4px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 6px 14px rgba(99, 102, 241, 0.45);
        transition: transform .2s ease, box-shadow .2s ease;
        font-size: 0.95rem;
    }
    .sba-avatar-edit:hover {
        transform: translateY(-2px) scale(1.06);
        box-shadow: 0 10px 22px rgba(99, 102, 241, 0.55);
        color: #fff;
    }

    .sba-hero-info { flex: 1; min-width: 220px; }
    .sba-hero-info h2 {
        font-weight: 900;
        font-size: 1.8rem;
        margin: 0 0 6px;
        color: #fff;
        line-height: 1.25;
    }
    .sba-hero-info .sba-hero-email {
        color: rgba(255,255,255,0.82);
        font-size: 0.95rem;
        margin: 0 0 12px;
        word-break: break-all;
    }
    .sba-hero-chips {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .sba-hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 100px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 700;
        backdrop-filter: blur(6px);
    }
    .sba-hero-chip i { font-size: 0.85rem; opacity: 0.85; }

    /* Quick stat badges */
    .sba-profile-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 24px;
    }
    .sba-pstat {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 14px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background .25s, transform .25s;
    }
    .sba-pstat:hover { background: rgba(255,255,255,0.14); transform: translateY(-2px); }
    .sba-pstat-ico {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex: 0 0 auto;
    }
    .sba-pstat-ico.bg-violet  { background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: #fff; }
    .sba-pstat-ico.bg-cyan    { background: linear-gradient(135deg, #06b6d4, #0e7490); color: #fff; }
    .sba-pstat-ico.bg-emerald { background: linear-gradient(135deg, #10b981, #047857); color: #fff; }
    .sba-pstat-num {
        font-weight: 900; font-size: 1.15rem; color: #fff; line-height: 1.1;
    }
    .sba-pstat-lbl {
        color: rgba(255,255,255,0.78); font-size: 0.78rem; font-weight: 600;
    }

    /* ---------- Section heading ---------- */
    .sba-sec-head {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
    }
    .sba-sec-head .sba-sec-ico {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(139,92,246,0.12));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--sba-primary);
    }
    .sba-sec-head h3 {
        margin: 0;
        font-weight: 900;
        font-size: 1.15rem;
        color: var(--sba-dark);
    }
    .sba-sec-head .sba-sec-sub {
        margin: 2px 0 0;
        font-size: 0.85rem;
        color: var(--sba-muted);
    }

    /* ---------- Cards ---------- */
    .sba-card {
        background: var(--sba-surface);
        border: 1px solid var(--sba-border);
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 22px;
        box-shadow: 0 10px 30px -22px rgba(15, 23, 42, 0.18);
        transition: box-shadow .3s ease, transform .3s ease;
    }
    .sba-card:hover { box-shadow: 0 25px 55px -28px rgba(15, 23, 42, 0.25); }

    /* ---------- Form fields ---------- */
    .sba-field { margin-bottom: 18px; }
    .sba-field label {
        display: block;
        font-weight: 700;
        font-size: 0.82rem;
        color: var(--sba-dark);
        margin-bottom: 8px;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }
    .sba-input-wrap {
        position: relative;
    }
    .sba-input-wrap > i.sba-input-ico {
        position: absolute;
        top: 50%;
        inset-inline-start: 14px;
        transform: translateY(-50%);
        color: var(--sba-muted);
        font-size: 0.95rem;
        pointer-events: none;
    }
    .sba-card .form-control,
    .sba-card .tagify {
        width: 100%;
        background: #f8fafc !important;
        border: 1.5px solid var(--sba-border) !important;
        border-radius: 14px !important;
        padding: 13px 16px 13px 42px !important;
        font-size: 0.95rem !important;
        color: var(--sba-dark) !important;
        transition: all .25s ease;
        box-shadow: none !important;
    }
    [dir="rtl"] .sba-card .form-control,
    [dir="rtl"] .sba-card .tagify {
        padding: 13px 42px 13px 16px !important;
    }
    .sba-card textarea.form-control {
        padding-left: 16px !important;
        padding-right: 16px !important;
        min-height: 120px;
        line-height: 1.6;
    }
    .sba-card .form-control:focus {
        background: #fff !important;
        border-color: var(--sba-primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12) !important;
        outline: none;
    }
    .sba-card .tagify { padding: 6px 10px !important; }
    .sba-card .tagify__input { padding: 6px !important; }

    /* Save / submit buttons */
    .sba-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 800;
        padding: 13px 28px;
        border-radius: 100px;
        border: none;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all .25s ease;
        text-decoration: none !important;
    }
    .sba-btn-primary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        box-shadow: 0 12px 28px -12px rgba(99,102,241,0.6);
    }
    .sba-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 38px -14px rgba(99,102,241,0.7);
        color: #fff;
    }
    .sba-btn-ghost {
        background: #fff;
        color: var(--sba-dark);
        border: 1.5px solid var(--sba-border);
    }
    .sba-btn-ghost:hover {
        border-color: var(--sba-primary);
        color: var(--sba-primary);
    }

    .sba-form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 8px;
        padding-top: 22px;
        border-top: 1px solid var(--sba-border);
    }

    /* Two-col grid for form rows */
    .sba-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0 18px;
    }
    .sba-grid .sba-field-full { grid-column: 1 / -1; }

    @media (max-width: 768px) {
        .sba-profile-page { padding-top: 90px; padding-bottom: 50px; }
        .sba-profile-hero { padding: 24px 20px 22px; border-radius: 18px; }
        .sba-hero-info h2 { font-size: 1.3rem; }
        .sba-avatar-frame { width: 92px; height: 92px; }
        .sba-profile-stats { grid-template-columns: 1fr; }
        .sba-card { padding: 20px; border-radius: 16px; }
        .sba-grid { grid-template-columns: 1fr; }
        .sba-sec-head h3 { font-size: 1rem; }
        .sba-form-actions .sba-btn { width: 100%; }
    }

    /* Account-source banner (Google sign-in) */
    .sba-source-banner {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.96);
        border: 1px solid rgba(99,102,241,0.18);
        padding: 8px 14px 8px 8px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.82rem;
        color: var(--sba-dark);
        margin-top: 14px;
        box-shadow: 0 6px 18px -6px rgba(15,23,42,0.18);
    }
    .sba-source-badge {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
</style>
@endpush

@section('content')
@php
    $is_arabic = strtolower(session('language') ?? get_settings('language')) == 'arabic';

    // Stats (best-effort: show what exists, fall back to 0)
    $enrolled_count = \DB::table('enrollments')->where('user_id', $user_details->id)->count();
    $wishlist_count = 0;
    if (\Schema::hasTable('wishlists')) {
        $wishlist_count = \DB::table('wishlists')->where('user_id', $user_details->id)->count();
    }
    $member_since = $user_details->created_at ? \Carbon\Carbon::parse($user_details->created_at)->format('M Y') : '';

    $is_google_user = is_string($user_details->photo) && str_contains($user_details->photo, 'uploads/users/student/google_');
@endphp

<section class="course-content sba-profile-page">
    <div class="profile-banner-area"></div>
    <div class="container">
        <div class="row">
            @include('frontend.default.student.left_sidebar')

            <div class="col-lg-9">

                <!-- HERO -->
                <div class="sba-profile-hero">
                    <div class="sba-hero-row">
                        <div class="sba-avatar-frame">
                            <img src="{{ get_image($user_details->photo) }}" alt="{{ $user_details->name }}">
                            <a href="#" class="sba-avatar-edit"
                               onclick="event.preventDefault(); ajaxModal('{{ route('modal', ['frontend.default.upload_profile_pic', 'id' => $user_details->id]) }}', '{{ get_phrase('Upload picture') }}')"
                               title="{{ get_phrase('Change photo') }}" aria-label="{{ get_phrase('Change photo') }}">
                                <i class="fi-rr-camera"></i>
                            </a>
                        </div>

                        <div class="sba-hero-info">
                            <h2>{{ $is_arabic ? 'مرحبا، ' : 'Welcome, ' }}{{ $user_details->name }}</h2>
                            <p class="sba-hero-email">
                                <i class="fi-rr-envelope" style="opacity:.7;"></i>
                                {{ $user_details->email }}
                            </p>
                            <div class="sba-hero-chips">
                                <span class="sba-hero-chip">
                                    <i class="fi-rr-graduation-cap"></i>
                                    {{ $is_arabic ? 'طالب' : 'Student' }}
                                </span>
                                @if ($member_since)
                                <span class="sba-hero-chip">
                                    <i class="fi-rr-calendar"></i>
                                    {{ $is_arabic ? 'عضو منذ' : 'Joined' }} {{ $member_since }}
                                </span>
                                @endif
                                @if ($user_details->email_verified_at)
                                <span class="sba-hero-chip" style="background: rgba(16,185,129,0.18); border-color: rgba(16,185,129,0.35);">
                                    <i class="fi-rr-check-circle"></i>
                                    {{ $is_arabic ? 'بريد موثّق' : 'Verified' }}
                                </span>
                                @endif
                            </div>

                            @if ($is_google_user)
                                <div class="sba-source-banner">
                                    <span class="sba-source-badge">
                                        <svg width="14" height="14" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/><path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/><path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/><path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.792 2.237-2.231 4.166-4.087 5.571.001-.001.002-.001.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/></svg>
                                    </span>
                                    {{ $is_arabic ? 'تم التسجيل عبر Google' : 'Signed in with Google' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="sba-profile-stats">
                        <div class="sba-pstat">
                            <span class="sba-pstat-ico bg-violet"><i class="fi-rr-book-alt"></i></span>
                            <div>
                                <div class="sba-pstat-num">{{ $enrolled_count }}</div>
                                <div class="sba-pstat-lbl">{{ $is_arabic ? 'دوراتي' : 'Enrolled Courses' }}</div>
                            </div>
                        </div>
                        <div class="sba-pstat">
                            <span class="sba-pstat-ico bg-cyan"><i class="fi-rr-heart"></i></span>
                            <div>
                                <div class="sba-pstat-num">{{ $wishlist_count }}</div>
                                <div class="sba-pstat-lbl">{{ $is_arabic ? 'قائمة الأمنيات' : 'Wishlist' }}</div>
                            </div>
                        </div>
                        <div class="sba-pstat">
                            <span class="sba-pstat-ico bg-emerald"><i class="fi-rr-shield-check"></i></span>
                            <div>
                                <div class="sba-pstat-num">{{ $user_details->status ? ($is_arabic ? 'نشط' : 'Active') : ($is_arabic ? 'موقوف' : 'Inactive') }}</div>
                                <div class="sba-pstat-lbl">{{ $is_arabic ? 'حالة الحساب' : 'Account Status' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PERSONAL INFORMATION CARD -->
                <div class="sba-card">
                    <div class="sba-sec-head">
                        <span class="sba-sec-ico"><i class="fi-rr-user"></i></span>
                        <div>
                            <h3>{{ get_phrase('Personal Information') }}</h3>
                            <p class="sba-sec-sub">{{ $is_arabic ? 'حدّث بياناتك الشخصية وروابطك الاجتماعية' : 'Update your details and social links' }}</p>
                        </div>
                    </div>

                    <form action="{{ route('update.profile', $user_details->id) }}" method="POST">@csrf
                        <div class="sba-grid">
                            <div class="sba-field sba-field-full">
                                <label for="name">{{ get_phrase('Full Name') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-user"></i>
                                    <input type="text" class="form-control" name="name" value="{{ $user_details->name }}" id="name" required>
                                </div>
                            </div>

                            <div class="sba-field">
                                <label for="email">{{ get_phrase('Email Address') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-envelope"></i>
                                    <input type="email" class="form-control" name="email" value="{{ $user_details->email }}" id="email" required>
                                </div>
                            </div>

                            <div class="sba-field">
                                <label for="phone">{{ get_phrase('Phone Number') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-phone-call"></i>
                                    <input type="tel" class="form-control" name="phone" value="{{ $user_details->phone }}" id="phone">
                                </div>
                            </div>

                            <div class="sba-field">
                                <label for="website">{{ get_phrase('Website') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-globe"></i>
                                    <input type="text" class="form-control" name="website" value="{{ $user_details->website }}" id="website" placeholder="https://...">
                                </div>
                            </div>

                            <div class="sba-field">
                                <label for="facebook">{{ get_phrase('Facebook') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fa-brands fa-facebook-f"></i>
                                    <input type="text" class="form-control" name="facebook" value="{{ $user_details->facebook }}" id="facebook">
                                </div>
                            </div>

                            <div class="sba-field">
                                <label for="twitter">{{ get_phrase('Twitter') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fa-brands fa-twitter"></i>
                                    <input type="text" class="form-control" name="twitter" value="{{ $user_details->twitter }}" id="twitter">
                                </div>
                            </div>

                            <div class="sba-field">
                                <label for="linkedin">{{ get_phrase('Linkedin') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fa-brands fa-linkedin-in"></i>
                                    <input type="text" class="form-control" name="linkedin" value="{{ $user_details->linkedin }}" id="linkedin">
                                </div>
                            </div>

                            <div class="sba-field sba-field-full">
                                <label for="skills">{{ get_phrase('Skills') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-bullseye-arrow"></i>
                                    <input type="text" class="form-control tagify" name="skills" data-role="tagsinput" value="{{ $user_details->skills }}" id="skills" placeholder="{{ $is_arabic ? 'أضف مهارة...' : 'Add a skill...' }}">
                                </div>
                            </div>

                            <div class="sba-field sba-field-full">
                                <label for="biography">{{ get_phrase('Biography') }}</label>
                                <textarea name="biography" class="form-control" id="biography" rows="5" placeholder="{{ $is_arabic ? 'اكتب نبذة قصيرة عنك...' : 'Tell us a bit about yourself...' }}">{{ $user_details->biography }}</textarea>
                            </div>
                        </div>

                        <div class="sba-form-actions">
                            <button type="submit" class="sba-btn sba-btn-primary">
                                <i class="fi-rr-disk"></i>
                                {{ get_phrase('Save Changes') }}
                            </button>
                            <a href="{{ route('home') }}" class="sba-btn sba-btn-ghost">
                                <i class="fi-rr-arrow-small-left"></i>
                                {{ $is_arabic ? 'إلغاء' : get_phrase('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>

                <!-- CHANGE PASSWORD CARD -->
                <div class="sba-card">
                    <div class="sba-sec-head">
                        <span class="sba-sec-ico"><i class="fi-rr-lock"></i></span>
                        <div>
                            <h3>{{ get_phrase('Change Password') }}</h3>
                            <p class="sba-sec-sub">
                                @if ($is_google_user)
                                    {{ $is_arabic ? 'سجلت عبر Google. يمكنك تعيين كلمة مرور إضافية للدخول التقليدي.' : 'You signed in with Google. Set an additional password if you also want to log in with email.' }}
                                @else
                                    {{ $is_arabic ? 'استخدم كلمة مرور قوية لتأمين حسابك' : 'Use a strong password to keep your account safe' }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('password.change') }}" method="POST">@csrf
                        <div class="sba-grid">
                            <div class="sba-field sba-field-full">
                                <label>{{ get_phrase('Current password') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-key"></i>
                                    <input type="password" class="form-control" name="current_password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="sba-field">
                                <label>{{ get_phrase('New password') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-lock"></i>
                                    <input type="password" class="form-control" name="new_password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="sba-field">
                                <label>{{ get_phrase('Confirm password') }}</label>
                                <div class="sba-input-wrap">
                                    <i class="sba-input-ico fi-rr-lock"></i>
                                    <input type="password" class="form-control" name="confirm_password" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="sba-form-actions">
                            <button type="submit" class="sba-btn sba-btn-primary">
                                <i class="fi-rr-shield-check"></i>
                                {{ get_phrase('Update password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('js')
@endpush
