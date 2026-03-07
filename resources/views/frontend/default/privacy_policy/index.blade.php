@extends('layouts.landing')
@push('title', get_phrase('Privacy Policy'))
@push('meta')@endpush
@push('css')
<style>
    .mesh-gradient-breadcrumb {
        background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 100% 100%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        padding: 180px 0 80px !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .breadcrumb-item a {
        color: var(--vibrant-primary) !important;
        font-weight: 600;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: var(--vibrant-dark) !important;
        font-weight: 700;
    }
    .policy-section {
        background-color: #f8fafc;
        padding: 80px 0;
    }
    .policy-container {
        background: #fff;
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.02);
        font-size: 1.15rem;
        line-height: 1.8;
        color: #334155;
    }
    .policy-container h1, .policy-container h2, .policy-container h3 {
        font-weight: 900;
        color: var(--vibrant-dark);
        margin-top: 40px;
        margin-bottom: 20px;
        letter-spacing: -1px;
    }
    .policy-container p {
        margin-bottom: 25px;
    }
</style>
@endpush
@section('content')
    <!-- Breadcrumb Area -->
    <section class="mesh-gradient-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Privacy Policy') }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 fw-900 g-title mb-0">{{ get_phrase('Privacy Policy') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Policy Content Section -->
    <section class="policy-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="policy-container">
                        {!! htmlspecialchars_decode(removeScripts(get_frontend_settings('privacy_policy'))) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')@endpush
