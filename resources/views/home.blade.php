@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Hero Section -->
    <div class="card border-0 rounded-4 overflow-hidden shadow-sm mb-5" style="background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);">
        <div class="row g-0 align-items-center">
            
            <div class="col-lg-7 p-5">
                <span class="badge bg-purple-subtle text-purple mb-3 px-3 py-2 rounded-pill fw-semibold" style="background-color: #f3e8ff; color: #6b21a8;">
                    <i class="bi bi-stars me-1"></i> {{ __('messages.app_tagline') }}
                </span>
                
                <h1 class="display-5 fw-bold text-dark mb-3" style="line-height: 1.2;">
                    {{ __('messages.hero_title') }}
                </h1>
                
                <p class="lead text-secondary mb-4 fs-5" style="max-width: 520px;">
                    {{ __('messages.hero_subtitle') }}
                </p>

                <div class="d-flex align-items-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-brand-primary btn-lg px-4 py-2 shadow-sm">
                            {{ __('messages.get_started') }} <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-brand-outline btn-lg px-4 py-2">
                            {{ __('messages.login') }}
                        </a>
                    @else
                        <a href="{{ route('reports.create') }}" class="btn btn-brand-primary btn-lg px-4 py-2 shadow-sm">
                            <i class="bi bi-plus-circle me-2"></i> {{ __('messages.create_new_report') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-brand-outline btn-lg px-4 py-2">
                            {{ __('messages.dashboard') }}
                        </a>
                    @endguest
                </div>
            </div>

            <div class="col-lg-5 text-center p-4">
                <div class="position-relative d-inline-block">
                    <!-- Romantic / Astrological Vector / Visual Illustration -->
                    <div class="p-4 rounded-4 shadow-sm" style="background: linear-gradient(145deg, #7c3aed, #db2777); color: #ffffff; max-width: 380px; margin: 0 auto;">
                        <div class="display-3 mb-3">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2">{{ __('messages.app_name') }}</h4>
                        <p class="small text-white-50 mb-3">
                            Vedic &amp; Pythagorean Numerology Compatibility
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold">Life Path</span>
                            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold">Destiny</span>
                            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold">Soul Urge</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 4 Features Bar (as in wireframe Screen 1) -->
    <div class="row g-4 text-center mb-5" id="services">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 rounded-4 p-4 shadow-sm text-center" style="background-color: #ffffff;">
                <div class="fs-1 text-danger mb-2">
                    <i class="bi bi-heart-fill"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">{{ __('messages.feat_love') }}</h6>
                <p class="small text-muted mb-0">Deep emotional harmony</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 rounded-4 p-4 shadow-sm text-center" style="background-color: #ffffff;">
                <div class="fs-1 text-primary mb-2">
                    <i class="bi bi-gem"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">{{ __('messages.feat_marriage') }}</h6>
                <p class="small text-muted mb-0">Life-long partner compatibility</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 rounded-4 p-4 shadow-sm text-center" style="background-color: #ffffff;">
                <div class="fs-1 text-purple mb-2" style="color: #6b21a8;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">{{ __('messages.feat_insight') }}</h6>
                <p class="small text-muted mb-0">Personality and vibration match</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 rounded-4 p-4 shadow-sm text-center" style="background-color: #ffffff;">
                <div class="fs-1 text-success mb-2">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">{{ __('messages.feat_report') }}</h6>
                <p class="small text-muted mb-0">Printable &amp; mobile ready PDF</p>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="card border-0 rounded-4 p-5 shadow-sm bg-white mb-5" id="about">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold text-dark mb-3">About {{ __('messages.app_name') }}</h3>
                <p class="text-secondary leading-relaxed mb-3">
                    {{ __('messages.app_name') }} evaluates compatibility by synthesizing two people's <strong>Life Path Number</strong> (derived from Date of Birth), <strong>Destiny / Expression Number</strong> (derived from the full name), <strong>Soul Urge Number</strong> (derived from vowel resonances), and <strong>Personality Number</strong>.
                </p>
                <p class="text-secondary leading-relaxed mb-0">
                    Inspired by traditional Tamil astrology and numerology wisdom as well as Pythagorean mathematics, our algorithm provides objective, uplifting insights for relationships, partnerships, and marriage.
                </p>
            </div>
            <div class="col-md-4 text-center mt-4 mt-md-0">
                <a href="{{ route('reports.create') }}" class="btn btn-brand-primary btn-lg px-4 py-2">
                    {{ __('messages.create_compat_report') }}
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
