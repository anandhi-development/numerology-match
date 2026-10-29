@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="row g-4">
        
        <!-- Admin Sidebar (as in wireframe Screen 10) -->
        <div class="col-lg-2">
            <div class="sidebar">
                <nav class="nav flex-column">
                    <a class="sidebar-link {{ request()->routeIs('admin.dashboard') && !request()->has('status') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
                    </a>
                    <a class="sidebar-link {{ request()->query('status') === 'pending' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['status' => 'pending']) }}">
                        <i class="bi bi-clock-history text-warning"></i> {{ __('messages.pending_reports') }}
                    </a>
                    <a class="sidebar-link {{ request()->query('status') === 'approved' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['status' => 'approved']) }}">
                        <i class="bi bi-check2-circle text-success"></i> {{ __('messages.approved_reports') }}
                    </a>
                    <a class="sidebar-link {{ request()->query('status') === 'rejected' ? 'active' : '' }}" href="{{ route('admin.reports.index', ['status' => 'rejected']) }}">
                        <i class="bi bi-x-circle text-danger"></i> {{ __('messages.rejected_reports') }}
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
            
            <!-- 4 Stat Cards Row (Pending, Approved, Emailed, Rejected - wireframe Screen 10) -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-orange">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <div class="fs-1 fw-bold">{{ $pendingCount }}</div>
                            <div class="small fw-bold text-uppercase">{{ __('messages.pending') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-green">
                        <div class="stat-icon">
                            <i class="bi bi-file-earmark-check-fill"></i>
                        </div>
                        <div>
                            <div class="fs-1 fw-bold">{{ $approvedCount }}</div>
                            <div class="small fw-bold text-uppercase">{{ __('messages.approved') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-blue">
                        <div class="stat-icon">
                            <i class="bi bi-envelope-check-fill"></i>
                        </div>
                        <div>
                            <div class="fs-1 fw-bold">{{ $emailedCount }}</div>
                            <div class="small fw-bold text-uppercase">{{ __('messages.emailed') }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="stat-card card-red">
                        <div class="stat-icon">
                            <i class="bi bi-x-octagon-fill"></i>
                        </div>
                        <div>
                            <div class="fs-1 fw-bold">{{ $rejectedCount }}</div>
                            <div class="small fw-bold text-uppercase">{{ __('messages.rejected') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports List Table -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h5 class="fw-bold text-dark mb-0">
                        {{ $statusFilter ? ucfirst($statusFilter) . ' ' . __('messages.pending_reports') : __('messages.pending_reports') }}
                    </h5>
                    
                    <!-- Status Filter Tabs -->
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary {{ empty($statusFilter) ? 'active' : '' }}">All</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ $statusFilter === 'pending' ? 'active' : '' }}">Pending</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'approved']) }}" class="btn btn-outline-success {{ $statusFilter === 'approved' ? 'active' : '' }}">Approved</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'emailed']) }}" class="btn btn-outline-primary {{ $statusFilter === 'emailed' ? 'active' : '' }}">Emailed</a>
                        <a href="{{ route('admin.reports.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger {{ $statusFilter === 'rejected' ? 'active' : '' }}">Rejected</a>
                    </div>
                </div>

                @if($reports->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                        <p class="mb-0">No reports found in this category.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('messages.user_label') }}</th>
                                    <th scope="col">{{ __('messages.person1') }}</th>
                                    <th scope="col">{{ __('messages.person2') }}</th>
                                    <th scope="col">{{ __('messages.score') }}</th>
                                    <th scope="col">{{ __('messages.status') }}</th>
                                    <th scope="col">{{ __('messages.created_at') }}</th>
                                    <th scope="col" class="text-center">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $index => $rep)
                                    <tr>
                                        <td class="fw-bold text-secondary">{{ $reports->firstItem() + $index }}</td>
                                        <td class="small">
                                            <div class="fw-semibold text-dark">{{ $rep->user->name }}</div>
                                            <div class="text-muted">{{ $rep->user->email }}</div>
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
                                        <td class="small text-muted">{{ $rep->created_at->format('d-m-Y') }}</td>
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
                                                        <button type="submit" class="btn btn-sm btn-success py-1 px-3 rounded-2 fw-semibold" title="Approve">
                                                            {{ __('messages.approve') }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.reports.reject', $rep) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger py-1 px-3 rounded-2 fw-semibold" title="Reject" onclick="return confirm('Are you sure you want to reject this report?')">
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

                    <div class="mt-4">
                        {{ $reports->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
