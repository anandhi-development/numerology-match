@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="sidebar">
                <nav class="nav flex-column">
                    <a class="sidebar-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid"></i> {{ __('messages.dashboard') }}
                    </a>
                    <a class="sidebar-link" href="{{ route('reports.create') }}">
                        <i class="bi bi-plus-circle"></i> {{ __('messages.new_report') }}
                    </a>
                    <a class="sidebar-link active" href="{{ route('reports.index') }}">
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

        <!-- Reports List Column -->
        <div class="col-lg-9">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
                
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold text-dark mb-1">{{ __('messages.my_reports') }}</h3>
                        <p class="text-secondary small mb-0">Browse and manage all your generated numerology compatibility reports</p>
                    </div>
                    <a href="{{ route('reports.create') }}" class="btn btn-brand-primary btn-sm px-3 py-2">
                        <i class="bi bi-plus-circle me-1"></i> {{ __('messages.create_new_report') }}
                    </a>
                </div>

                @if($reports->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x fs-1 d-block mb-3 text-secondary"></i>
                        <h5>No reports found</h5>
                        <p class="text-secondary small mb-3">You haven't generated any compatibility reports yet.</p>
                        <a href="{{ route('reports.create') }}" class="btn btn-brand-primary">
                            {{ __('messages.create_new_report') }}
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th scope="col" style="width: 5%;">#</th>
                                    <th scope="col" style="width: 20%;">{{ __('messages.person1') }}</th>
                                    <th scope="col" style="width: 20%;">{{ __('messages.person2') }}</th>
                                    <th scope="col" style="width: 10%;">{{ __('messages.score') }}</th>
                                    <th scope="col" style="width: 15%;">{{ __('messages.status') }}</th>
                                    <th scope="col" style="width: 12%;">{{ __('messages.created_at') }}</th>
                                    <th scope="col" class="text-end" style="width: 18%;">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $index => $rep)
                                    <tr>
                                        <td class="fw-bold text-secondary">{{ $reports->firstItem() + $index }}</td>
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
                                            <div class="d-flex align-items-center justify-content-end gap-1">
                                                
                                                <!-- View button -->
                                                <a href="{{ route('reports.show', $rep) }}" class="btn btn-sm btn-outline-secondary py-1 px-2 rounded-2" title="{{ __('messages.view') }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <!-- Email Button (Only enabled when approved or emailed) -->
                                                @if($rep->isApproved())
                                                    <form action="{{ route('reports.email', $rep) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2 rounded-2" title="{{ __('messages.email_action') }}">
                                                            <i class="bi bi-envelope"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2 rounded-2 opacity-50" disabled title="{{ __('messages.only_approved_can_email') }}">
                                                        <i class="bi bi-envelope"></i>
                                                    </button>
                                                @endif

                                                <!-- Download PDF -->
                                                <a href="{{ route('reports.download', $rep) }}" class="btn btn-sm btn-outline-success py-1 px-2 rounded-2" title="{{ __('messages.download') }}">
                                                    <i class="bi bi-download"></i>
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
