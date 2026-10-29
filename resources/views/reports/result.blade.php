@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                
                <!-- Title -->
                <div class="text-center mb-4">
                    <span class="badge px-3 py-2 rounded-pill fw-semibold mb-2" style="background-color: #f3e8ff; color: #6b21a8;">
                        <i class="bi bi-patch-check-fill me-1"></i> Analysis Complete
                    </span>
                    <h2 class="fw-bold text-dark mb-1">{{ __('messages.compatibility_result') }}</h2>
                </div>

                <!-- Two Profiles Badge Comparison (as in wireframe Screen 6) -->
                <div class="d-flex align-items-center justify-content-center gap-3 gap-md-5 p-3 rounded-4 mb-4" style="background-color: #faf5ff; border: 1px solid #f3e8ff;">
                    <!-- Person 1 -->
                    <div class="text-center">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 48px; height: 48px; font-size: 1.3rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ $result['person1']['full_name'] }}</h6>
                        <small class="text-muted">{{ date('d-m-Y', strtotime($result['person1']['dob'])) }}</small>
                    </div>

                    <!-- Heart Emblem -->
                    <div class="text-danger fs-2 animate__pulse">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <!-- Person 2 -->
                    <div class="text-center">
                        <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 48px; height: 48px; font-size: 1.3rem;">
                            <i class="bi bi-person-heart"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ $result['person2']['full_name'] }}</h6>
                        <small class="text-muted">{{ date('d-m-Y', strtotime($result['person2']['dob'])) }}</small>
                    </div>
                </div>

                <!-- Compatibility Score Card -->
                <div class="card border-0 rounded-4 p-4 text-center mb-4" style="background-color: #fff1f2; border: 1px solid #ffe4e6 !important;">
                    <div class="text-danger fw-bold small text-uppercase mb-1">
                        <i class="bi bi-heart-fill me-1"></i> {{ __('messages.compatibility_score') }}
                    </div>
                    <div class="display-3 fw-bolder text-success">
                        {{ $result['compatibility_score'] }}%
                    </div>
                </div>

                <!-- Numerology Numbers Table (as in wireframe Screen 6) -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle text-center mb-0">
                        <thead style="background-color: #f8fafc;">
                            <tr>
                                <th class="text-start ps-4 py-3 text-secondary" style="width: 40%;">{{ __('messages.category') }}</th>
                                <th class="py-3 text-primary" style="width: 30%;">{{ $result['person1']['first_name'] }}</th>
                                <th class="py-3 text-danger" style="width: 30%;">{{ $result['person2']['first_name'] }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start ps-4 fw-semibold text-dark">{{ __('messages.life_path_number') }}</td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person1']['life_path'] }}</span></td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person2']['life_path'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-start ps-4 fw-semibold text-dark">{{ __('messages.destiny_number') }}</td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person1']['destiny'] }}</span></td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person2']['destiny'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-start ps-4 fw-semibold text-dark">{{ __('messages.soul_number') }}</td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person1']['soul'] }}</span></td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person2']['soul'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-start ps-4 fw-semibold text-dark">{{ __('messages.personality_number') }}</td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person1']['personality'] }}</span></td>
                                <td><span class="badge bg-light text-dark fs-6 px-3 py-1 border">{{ $result['person2']['personality'] }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Result Reading Box -->
                <div class="card border-0 rounded-4 p-4 mb-4" style="background-color: #f8fafc; border-left: 4px solid #6b21a8 !important;">
                    <h5 class="fw-bold text-dark mb-2">{{ __('messages.result') }}</h5>
                    <p class="text-secondary leading-relaxed mb-0">
                        {{ app()->getLocale() === 'ta' ? $result['summary_ta'] : $result['summary_en'] }}
                    </p>
                    @if(app()->getLocale() === 'ta')
                        <p class="small text-muted mt-2 pt-2 border-top">
                            <em>English: {{ $result['summary_en'] }}</em>
                        </p>
                    @endif
                </div>

                <!-- Status alert if report is saved -->
                @if($report)
                    <div class="alert {{ $report->status === 'approved' || $report->status === 'emailed' ? 'alert-success' : ($report->status === 'rejected' ? 'alert-danger' : 'alert-warning') }} d-flex align-items-center justify-content-between p-3 rounded-3 mb-4">
                        <div>
                            <strong>{{ __('messages.status') }}:</strong>
                            <span class="badge-status badge-{{ $report->status }} ms-2">
                                {{ __('messages.' . $report->status) }}
                            </span>
                            @if($report->status === 'pending')
                                <div class="small mt-1 text-muted">Awaiting administrator review. Once approved, the email option will be activated.</div>
                            @elseif($report->status === 'rejected' && $report->admin_notes)
                                <div class="small mt-1 text-danger">Note: {{ $report->admin_notes }}</div>
                            @endif
                        </div>

                        <!-- Email action button if approved -->
                        @if($report->isApproved())
                            <form action="{{ route('reports.email', $report) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-envelope-fill me-1"></i> Send to My Email
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <!-- Buttons: Generate PDF & Save Report (as in wireframe Screen 6) -->
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @if($report)
                        <!-- Already saved report: View & Download PDF -->
                        <a href="{{ route('reports.pdf', $report) }}" target="_blank" class="btn btn-brand-primary btn-lg px-4 py-2">
                            <i class="bi bi-file-earmark-pdf me-1"></i> {{ __('messages.view_full_pdf') }}
                        </a>
                        <a href="{{ route('reports.download', $report) }}" class="btn btn-brand-outline btn-lg px-4 py-2">
                            <i class="bi bi-download me-1"></i> {{ __('messages.download') }}
                        </a>
                        <a href="{{ route('reports.index') }}" class="btn btn-light btn-lg px-4 py-2 border">
                            <i class="bi bi-arrow-left me-1"></i> {{ __('messages.my_reports') }}
                        </a>
                    @else
                        <!-- Preview Mode: Form to Save Report -->
                        <form method="POST" action="{{ route('reports.store') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="p1_first_name" value="{{ $input['p1_first_name'] }}">
                            <input type="hidden" name="p1_last_name" value="{{ $input['p1_last_name'] ?? '' }}">
                            <input type="hidden" name="p1_dob" value="{{ $input['p1_dob'] }}">
                            <input type="hidden" name="p2_first_name" value="{{ $input['p2_first_name'] }}">
                            <input type="hidden" name="p2_last_name" value="{{ $input['p2_last_name'] ?? '' }}">
                            <input type="hidden" name="p2_dob" value="{{ $input['p2_dob'] }}">

                            <button type="submit" class="btn btn-brand-primary btn-lg px-4 py-2 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> {{ __('messages.save_report') }}
                            </button>
                        </form>

                        <a href="{{ route('reports.create') }}" class="btn btn-brand-outline btn-lg px-4 py-2">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Recalculate
                        </a>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
