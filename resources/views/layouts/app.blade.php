<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ENN KANITHAM') }} - {{ __('messages.app_tagline') }}</title>

    <!-- Bootstrap 5.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts for English & Tamil -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Tamil:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #5b21b6;
            --brand-primary-dark: #431407;
            --brand-purple: #4a154b;
            --brand-violet: #6b21a8;
            --brand-pink: #ec4899;
            --brand-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Noto Sans Tamil', sans-serif;
            background-color: var(--brand-bg);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            padding: 12px 0;
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--brand-purple);
            letter-spacing: 0.5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo:hover {
            color: var(--brand-violet);
        }

        .logo-emblem {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #7c3aed, #db2777);
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .lang-switch-btn {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .lang-switch-btn.active {
            background-color: #f3e8ff;
            color: var(--brand-violet);
            border: 1px solid #d8b4fe;
        }
        .lang-switch-btn.inactive {
            color: #64748b;
        }
        .lang-switch-btn.inactive:hover {
            color: var(--brand-violet);
        }

        .btn-brand-primary {
            background-color: var(--brand-violet);
            border-color: var(--brand-violet);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 6px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-brand-primary:hover {
            background-color: #581c87;
            border-color: #581c87;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-brand-outline {
            border: 1.5px solid #d1d5db;
            color: #374151;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-brand-outline:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        /* Global button font size reduction */
        .btn {
            font-size: 0.82rem;
        }
        .btn-lg {
            font-size: 0.88rem;
            padding: 8px 20px;
        }
        .btn-sm {
            font-size: 0.78rem;
        }

        /* App Sidebar */
        .sidebar {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            padding: 20px 14px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: #4b5563;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 4px;
            transition: all 0.15s ease;
        }

        .sidebar-link:hover {
            background-color: #f5f3ff;
            color: var(--brand-violet);
        }

        .sidebar-link.active {
            background-color: #f3e8ff;
            color: var(--brand-violet);
            font-weight: 700;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 14px;
            padding: 22px 20px;
            border: 1px solid transparent;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card.card-orange {
            background-color: #fff7ed;
            border-color: #ffedd5;
            color: #c2410c;
        }
        .stat-card.card-orange .stat-icon {
            background-color: #ffedd5;
            color: #ea580c;
        }

        .stat-card.card-green {
            background-color: #f0fdf4;
            border-color: #dcfce7;
            color: #15803d;
        }
        .stat-card.card-green .stat-icon {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .stat-card.card-blue {
            background-color: #eff6ff;
            border-color: #dbeafe;
            color: #1d4ed8;
        }
        .stat-card.card-blue .stat-icon {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .stat-card.card-red {
            background-color: #fef2f2;
            border-color: #fee2e2;
            color: #b91c1c;
        }
        .stat-card.card-red .stat-icon {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .stat-card.card-purple {
            background-color: #faf5ff;
            border-color: #f3e8ff;
            color: #7e22ce;
        }
        .stat-card.card-purple .stat-icon {
            background-color: #f3e8ff;
            color: #9333ea;
        }

        /* Status Badges */
        .badge-status {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            text-transform: capitalize;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #b45309;
        }
        .badge-approved {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-emailed {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        .badge-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        /* Footer */
        footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            padding: 24px 0;
            font-size: 0.88rem;
            color: #64748b;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="brand-logo" href="{{ route('home') }}">
                <div class="logo-emblem">
                    <i class="bi bi-stars"></i>
                </div>
                <span>{{ __('messages.app_name') }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('home') ? 'fw-bold text-primary' : 'text-secondary' }}" href="{{ route('home') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-secondary" href="{{ route('home') }}#about">{{ __('messages.about') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-secondary" href="{{ route('home') }}#services">{{ __('messages.services') }}</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Language Switcher Pill -->
                    <div class="border rounded-pill p-1 d-flex align-items-center bg-light">
                        <a href="{{ route('lang.switch', 'en') }}" class="lang-switch-btn {{ app()->getLocale() === 'en' ? 'active' : 'inactive' }}">English</a>
                        <a href="{{ route('lang.switch', 'ta') }}" class="lang-switch-btn {{ app()->getLocale() === 'ta' ? 'active' : 'inactive' }}">தமிழ்</a>
                    </div>

                    <!-- Auth State Navigation -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-brand-outline">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-brand-primary">{{ __('messages.sign_up') }}</a>
                    @else
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm fw-bold px-3 py-1 rounded-pill">
                                <i class="bi bi-shield-lock-fill me-1"></i> {{ __('messages.admin_portal') }}
                            </a>
                        @endif

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 border-0 bg-light rounded-pill px-3 py-1" type="button" data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 700; font-size: 0.85rem;">
                                    {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold text-dark">{{ Auth::user()->first_name ?? Auth::user()->name }}</span>
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-danger ms-1" style="font-size: 0.65rem;">ADMIN</span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('dashboard') }}">
                                        <i class="bi bi-grid me-2 text-primary"></i> {{ __('messages.dashboard') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('reports.index') }}">
                                        <i class="bi bi-journal-text me-2 text-info"></i> {{ __('messages.my_reports') }}
                                    </a>
                                </li>
                                @if(Auth::user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item py-2 text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-shield-lock me-2"></i> {{ __('messages.admin_portal') }}
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> {{ __('messages.logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Alerts -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                <i class="bi bi-info-circle-fill fs-5"></i>
                <div>{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-1 fw-bold text-dark">{{ __('messages.app_name') }} &mdash; {{ __('messages.app_tagline') }}</p>
            <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                &copy; {{ date('Y') }} {{ __('messages.app_name') }}. All rights reserved. &bull; In accordance with Vedic &amp; Pythagorean Numerology principles.
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
