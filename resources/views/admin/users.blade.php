@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="row g-4">
        
        <!-- Admin Sidebar -->
        <div class="col-lg-2">
            <div class="sidebar">
                <nav class="nav flex-column">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('admin.reports.index', ['status' => 'pending']) }}">
                        <i class="bi bi-clock-history text-warning"></i> {{ __('messages.pending_reports') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('admin.reports.index', ['status' => 'approved']) }}">
                        <i class="bi bi-check2-circle text-success"></i> {{ __('messages.approved_reports') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('admin.reports.index', ['status' => 'rejected']) }}">
                        <i class="bi bi-x-circle text-danger"></i> {{ __('messages.rejected_reports') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-journals text-primary"></i> {{ __('messages.all_reports') }}
                    </a>
                    <a class="sidebar-link active" href="{{ route('admin.users.index') }}">
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

        <!-- Users Table -->
        <div class="col-lg-10">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">{{ __('messages.users') }}</h5>
                    <span class="badge bg-light text-secondary border px-3 py-2">Total Users: {{ $users->total() }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Reports Generated</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $u)
                                <tr>
                                    <td class="fw-bold text-secondary">{{ $users->firstItem() + $index }}</td>
                                    <td class="fw-semibold text-dark">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        <span class="badge {{ $u->role === 'admin' ? 'bg-danger' : 'bg-primary' }} text-uppercase" style="font-size: 0.7rem;">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1">
                                            {{ $u->reports_count }} reports
                                        </span>
                                    </td>
                                    <td class="small text-muted">{{ $u->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
