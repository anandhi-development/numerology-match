@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row g-4">
        
        <!-- Left Sidebar (as in wireframe Screen 4) -->
        <div class="col-lg-3">
            <div class="sidebar">
                <nav class="nav flex-column">
                    <a class="sidebar-link active" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-fill"></i> {{ __('messages.dashboard') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('reports.create') }}">
                        <i class="bi bi-plus-circle"></i> {{ __('messages.new_report') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('reports.index') }}">
                        <i class="bi bi-journal-text"></i> {{ __('messages.my_reports') }}
                    </a>
                    <hr class="my-2 text-muted">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link text-danger border-0 bg-transparent w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="col-lg-9">
            
            <!-- Welcome Header Card -->
            <div class="card border-0 rounded-4 p-4 p-md-5 mb-4 shadow-sm bg-white text-center text-md-start">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold text-dark mb-2">
                            {{ __('messages.welcome_user', ['name' => Auth::user()->first_name ?? Auth::user()->name]) }}
                        </h2>
                        <p class="text-secondary mb-3 mb-md-0 fs-6">
                            {{ __('messages.dashboard_lead') }}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('reports.create') }}" class="btn btn-brand-primary btn-sm shadow-sm">
                            {{ __('messages.create_new_report') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Row (Total Reports, Pending, Approved) -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card card-purple bg-white border">
                        <div class="stat-icon" style="background-color: #f3e8ff; color: #7e22ce;">
                            <i class="bi bi-files"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-dark">{{ $totalReports }}</div>
                            <div class="text-secondary small fw-semibold">{{ __('messages.total_reports') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card card-orange bg-white border">
                        <div class="stat-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-dark">{{ $pendingReports }}</div>
                            <div class="text-secondary small fw-semibold">{{ __('messages.pending') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card card-green bg-white border">
                        <div class="stat-icon">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div>
                            <div class="fs-2 fw-bold text-dark">{{ $approvedReports }}</div>
                            <div class="text-secondary small fw-semibold">{{ __('messages.approved') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reports Table -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">{{ __('messages.my_reports') }}</h5>
                    <a href="{{ route('reports.index') }}" class="small text-primary text-decoration-none fw-semibold">
                        {{ __('messages.view_all') }} <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @if($recentReports->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                        <p class="mb-3">{{ __('messages.no_reports_yet') }}</p>
                        <a href="{{ route('reports.create') }}" class="btn btn-brand-primary btn-sm">
                            {{ __('messages.create_new_report') }}
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('messages.person1') }}</th>
                                    <th scope="col">{{ __('messages.person2') }}</th>
                                    <th scope="col">{{ __('messages.score') }}</th>
                                    <th scope="col">{{ __('messages.status') }}</th>
                                    <th scope="col">{{ __('messages.created_at') }}</th>
                                    <th scope="col" class="text-end">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReports as $index => $rep)
                                    <tr>
                                        <td class="fw-bold text-secondary">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-dark">{{ $rep->person1_full_name }}</td>
                                        <td class="fw-semibold text-dark">{{ $rep->person2_full_name }}</td>
                                        <td>
                                            <span class="badge bg-light text-success border border-success-subtle fw-bold px-2 py-1">
                                                {{ $rep->compatibility_score }}%
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-status badge-{{ $rep->status }}">
                                                {{ __('messages.' . $rep->status) }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">{{ $rep->created_at->format('d-m-Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('reports.show', $rep) }}" class="btn btn-sm btn-outline-primary py-1 px-2 rounded-2">
                                                {{ __('messages.view') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
