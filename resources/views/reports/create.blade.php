@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Breadcrumb Navigation (Left-aligned) --}}
            <div class="d-flex align-items-center text-muted small mb-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-house-door me-1"></i>{{ __('messages.dashboard') }}
                </a>
                <i class="bi bi-chevron-right mx-2" style="font-size: 0.75rem;"></i>
                <span class="text-dark fw-semibold">{{ __('messages.new_report') }}</span>
            </div>

            <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                
                <div class="text-center mb-5">
                    <span class="badge px-3 py-2 rounded-pill fw-semibold mb-2" style="background-color: #f3e8ff; color: #6b21a8;">
                        <i class="bi bi-suit-heart-fill me-1"></i> Numerology Comparison
                    </span>
                    <h2 class="fw-bold text-dark mb-1">{{ __('messages.create_compat_report') }}</h2>
                    <p class="text-secondary small">{{ __('messages.create_report_desc') }}</p>
                </div>

                <form method="POST" action="{{ route('reports.calculate') }}">
                    @csrf

                    <div class="row g-4 mb-5">
                        
                        <!-- Person 1 Column -->
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 border h-100" style="background-color: #fafaf9; border-color: #e5e7eb !important;">
                                <div class="d-flex align-items-center gap-2 mb-4 text-primary">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-0">{{ __('messages.person1_details') }}</h5>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('messages.first_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="p1_first_name" class="form-control rounded-3 py-2 @error('p1_first_name') is-invalid @enderror" value="{{ old('p1_first_name') }}" placeholder="e.g. Arun" required pattern="[a-zA-Z\s]+" title="Letters and spaces only">
                                    @error('p1_first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('messages.last_name') }}</label>
                                    <input type="text" name="p1_last_name" class="form-control rounded-3 py-2 @error('p1_last_name') is-invalid @enderror" value="{{ old('p1_last_name') }}" placeholder="e.g. Kumar">
                                    @error('p1_last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('messages.dob') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="p1_dob" class="form-control rounded-3 py-2 @error('p1_dob') is-invalid @enderror" value="{{ old('p1_dob') }}" max="{{ date('Y-m-d') }}" required>
                                    </div>
                                    @error('p1_dob')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Person 2 Column -->
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 border h-100" style="background-color: #fafaf9; border-color: #e5e7eb !important;">
                                <div class="d-flex align-items-center gap-2 mb-4 text-danger">
                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person-heart"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-0">{{ __('messages.person2_details') }}</h5>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('messages.first_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="p2_first_name" class="form-control rounded-3 py-2 @error('p2_first_name') is-invalid @enderror" value="{{ old('p2_first_name') }}" placeholder="e.g. Priya" required pattern="[a-zA-Z\s]+" title="Letters and spaces only">
                                    @error('p2_first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('messages.last_name') }}</label>
                                    <input type="text" name="p2_last_name" class="form-control rounded-3 py-2 @error('p2_last_name') is-invalid @enderror" value="{{ old('p2_last_name') }}" placeholder="e.g. Raman">
                                    @error('p2_last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('messages.dob') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="p2_dob" class="form-control rounded-3 py-2 @error('p2_dob') is-invalid @enderror" value="{{ old('p2_dob') }}" max="{{ date('Y-m-d') }}" required>
                                    </div>
                                    @error('p2_dob')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-brand-primary btn-lg px-5 py-3 shadow-sm rounded-pill fw-bold">
                            <i class="bi bi-stars me-2"></i> {{ __('messages.calculate_compatibility') }}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection
