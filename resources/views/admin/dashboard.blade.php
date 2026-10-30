@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4" style="font-size: 0.82rem;">
    <div class="row g-4">
        
        <!-- Admin Sidebar (as in wireframe Screen 10) -->
        <div class="col-lg-2">
            <div class="sidebar">
                <nav class="nav flex-column" style="font-size: 0.8rem;">
                    <a class="sidebar-link {{ request()->routeIs('admin.dashboard') && !request()->has('status') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('admin.reports.index') && !request()->has('status') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-journals text-primary"></i> {{ __('messages.all_reports') }}
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people-fill text-info"></i> {{ __('messages.users') }}
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

        <!-- Admin Content Area -->
        <div class="col-lg-10">
            
            <!-- 4 Stat Cards Row -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-orange" style="padding: 14px 16px;">
                        <div class="stat-icon" style="width: 40px; height: 40px; font-size: 1.1rem;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $pendingCount }}</div>
                            <div style="font-size: 0.72rem;" class="fw-bold text-uppercase">{{ __('messages.pending') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-green" style="padding: 14px 16px;">
                        <div class="stat-icon" style="width: 40px; height: 40px; font-size: 1.1rem;">
                            <i class="bi bi-file-earmark-check-fill"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $approvedCount }}</div>
                            <div style="font-size: 0.72rem;" class="fw-bold text-uppercase">{{ __('messages.approved') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-blue" style="padding: 14px 16px;">
                        <div class="stat-icon" style="width: 40px; height: 40px; font-size: 1.1rem;">
                            <i class="bi bi-envelope-check-fill"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $emailedCount }}</div>
                            <div style="font-size: 0.72rem;" class="fw-bold text-uppercase">{{ __('messages.emailed') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-red" style="padding: 14px 16px;">
                        <div class="stat-icon" style="width: 40px; height: 40px; font-size: 1.1rem;">
                            <i class="bi bi-x-octagon-fill"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold">{{ $rejectedCount }}</div>
                            <div style="font-size: 0.72rem;" class="fw-bold text-uppercase">{{ __('messages.rejected') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports List Table -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-3">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h6 class="fw-bold text-dark mb-0">
                        {{ $statusFilter ? ucfirst($statusFilter) . ' ' . __('messages.pending_reports') : __('messages.pending_reports') }}
                    </h6>
                    
                    <!-- Status Filter Tabs -->
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary {{ empty($statusFilter) ? 'active' : '' }}">{{ __('messages.all_reports') }}</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ $statusFilter === 'pending' ? 'active' : '' }}">{{ __('messages.pending') }}</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'approved']) }}" class="btn btn-outline-success {{ $statusFilter === 'approved' ? 'active' : '' }}">{{ __('messages.approved') }}</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'emailed']) }}" class="btn btn-outline-primary {{ $statusFilter === 'emailed' ? 'active' : '' }}">{{ __('messages.emailed') }}</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger {{ $statusFilter === 'rejected' ? 'active' : '' }}">{{ __('messages.rejected') }}</a>
                    </div>
                </div>

                @if($reports->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                        <p class="mb-0 small">No reports found in this category.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0" style="font-size: 0.8rem;">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="py-2">#</th>
                                    <th scope="col" class="py-2">{{ __('messages.user_label') }}</th>
                                    <th scope="col" class="py-2">{{ __('messages.person1') }}</th>
                                    <th scope="col" class="py-2">{{ __('messages.person2') }}</th>
                                    <th scope="col" class="py-2">{{ __('messages.score') }}</th>
                                    <th scope="col" class="py-2">{{ __('messages.status') }}</th>
                                    <th scope="col" class="py-2">{{ __('messages.created_at') }}</th>
                                    <th scope="col" class="py-2 text-center">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $index => $rep)
                                    <tr>
                                        <td class="fw-bold text-secondary">{{ $reports->firstItem() + $index }}</td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $rep->user->name }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $rep->user->email }}</div>
                                        </td>
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
                                        <td class="text-muted">{{ $rep->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                
                                                <!-- Review / Show button -->
                                                <a href="{{ route('admin.reports.show', $rep) }}" class="btn btn-sm btn-outline-primary py-1 px-2 rounded-2" title="Review">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <!-- Quick Approve (Green) -->
                                                @if($rep->status === 'pending')
                                                    <form action="{{ route('admin.reports.approve', $rep) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success py-1 px-2 rounded-2 fw-semibold" title="Approve">
                                                            {{ __('messages.approve') }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.reports.reject', $rep) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger py-1 px-2 rounded-2 fw-semibold" title="Reject" onclick="return confirm('Are you sure you want to reject this report?')">
                                                            {{ __('messages.reject_btn') }}
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- PDF View -->
                                                <a href="{{ route('reports.pdf', $rep) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1 px-2 rounded-2" title="View PDF">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $reports->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
