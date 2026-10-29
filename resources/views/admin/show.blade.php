@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <!-- Back Link (as in wireframe Screen 11) -->
    <div class="mb-4">
        <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="text-decoration-none fw-semibold text-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back_to_pending') }}
        </a>
    </div>

    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
        
        <div class="row g-4 align-items-center mb-5">
            
            <!-- Left Column: Report Details (as in wireframe Screen 11) -->
            <div class="col-lg-7">
                <h4 class="fw-bold text-dark mb-4">{{ __('messages.report_details') }}</h4>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 35%;" class="text-secondary small fw-bold">{{ __('messages.user_email') }}:</th>
                                <td class="fw-semibold text-dark">{{ $report->user->email }} ({{ $report->user->name }})</td>
                            </tr>
                            <tr>
                                <th class="text-secondary small fw-bold">{{ __('messages.person1') }}:</th>
                                <td class="fw-semibold text-dark">{{ $report->person1_full_name }} ({{ $report->p1_dob->format('d-m-Y') }})</td>
                            </tr>
                            <tr>
                                <th class="text-secondary small fw-bold">{{ __('messages.person2') }}:</th>
                                <td class="fw-semibold text-dark">{{ $report->person2_full_name }} ({{ $report->p2_dob->format('d-m-Y') }})</td>
                            </tr>
                            <tr>
                                <th class="text-secondary small fw-bold">{{ __('messages.compatibility_score') }}:</th>
                                <td>
                                    <span class="fs-5 fw-bolder text-success">{{ $report->compatibility_score }}%</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary small fw-bold">{{ __('messages.status') }}:</th>
                                <td>
                                    <span class="badge-status badge-{{ $report->status }}">
                                        {{ __('messages.' . $report->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary small fw-bold">{{ __('messages.created_at') }}:</th>
                                <td class="text-muted">{{ $report->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Analysis Summary excerpt -->
                <div class="mt-4 p-3 rounded-3 bg-light border">
                    <div class="small fw-bold text-secondary mb-1">Result Summary (English):</div>
                    <div class="small text-muted mb-2">{{ $report->summary_en }}</div>
                    @if($report->summary_ta)
                        <div class="small fw-bold text-secondary mb-1">Result Summary (Tamil):</div>
                        <div class="small text-muted">{{ $report->summary_ta }}</div>
                    @endif
                </div>
            </div>

            <!-- Right Column: PDF Preview Card (as in wireframe Screen 11) -->
            <div class="col-lg-5 text-center">
                <div class="p-4 rounded-4 border bg-light shadow-sm d-inline-block w-100" style="max-width: 340px;">
                    <!-- Decorative sample miniature -->
                    <div class="p-3 bg-white border rounded-3 mb-3 shadow-xs" style="border: 2px dashed #d4af37 !important;">
                        <div class="text-center">
                            <span class="badge bg-purple-subtle text-purple mb-1 px-2 py-1" style="background-color: #f3e8ff; color: #6b21a8; font-size: 0.65rem;">
                                ENNKANITHAM
                            </span>
                            <div class="fw-bold text-dark small" style="font-size: 0.8rem;">Compatibility Report</div>
                            <div class="d-flex justify-content-center align-items-center gap-2 my-2 text-muted" style="font-size: 0.75rem;">
                                <span>{{ $report->p1_first_name }}</span>
                                <span class="text-danger">&hearts;</span>
                                <span>{{ $report->p2_first_name }}</span>
                            </div>
                            <div class="badge bg-success-subtle text-success fw-bold px-3 py-1 mb-2">
                                {{ $report->compatibility_score }}%
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('reports.pdf', $report) }}" target="_blank" class="btn btn-primary btn-sm px-4 py-2 rounded-3 w-100 fw-semibold">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> {{ __('messages.view_full_pdf') }}
                    </a>
                </div>
            </div>

        </div>

        <!-- Action Buttons (Approve & Send Email | Reject - wireframe Screen 11) -->
        <div class="d-flex justify-content-center gap-3 pt-4 border-top flex-wrap">
            
            <form action="{{ route('admin.reports.approve_email', $report) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg px-4 py-3 fw-bold rounded-3 shadow-sm">
                    <i class="bi bi-send-check-fill me-2"></i> {{ __('messages.send_email_btn') }}
                </button>
            </form>

            <form action="{{ route('admin.reports.approve', $report) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-success btn-lg px-4 py-3 fw-semibold rounded-3">
                    <i class="bi bi-check-lg me-1"></i> Approve Only
                </button>
            </form>

            <form action="{{ route('admin.reports.reject', $report) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg px-4 py-3 fw-bold rounded-3 shadow-sm" onclick="return confirm('Are you sure you want to reject this report?')">
                    <i class="bi bi-x-circle-fill me-2"></i> {{ __('messages.reject_btn') }}
                </button>
            </form>

        </div>

    </div>

</div>
@endsection
