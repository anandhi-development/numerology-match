<?php

namespace App\Http\Controllers;

use App\Mail\ReportMail;
use App\Models\Report;
use App\Services\NumerologyService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    protected NumerologyService $numerology;

    public function __construct(NumerologyService $numerology)
    {
        $this->numerology = $numerology;
    }

    /**
     * Display a listing of user's reports (Screen 8).
     */
    public function index(): View
    {
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    /**
     * Show form to compare 2 profiles (Screen 5).
     */
    public function create(): View
    {
        return view('reports.create');
    }

    /**
     * Calculate compatibility and preview result (Screen 6).
     */
    public function calculate(Request $request): View
    {
        $validated = $request->validate([
            'p1_first_name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'p1_last_name' => ['nullable', 'string', 'max:50'],
            'p1_dob' => ['required', 'date', 'before_or_equal:today'],
            'p2_first_name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'p2_last_name' => ['nullable', 'string', 'max:50'],
            'p2_dob' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $result = $this->numerology->compareProfiles(
            [
                'first_name' => $validated['p1_first_name'],
                'last_name' => $validated['p1_last_name'] ?? '',
                'dob' => $validated['p1_dob'],
            ],
            [
                'first_name' => $validated['p2_first_name'],
                'last_name' => $validated['p2_last_name'] ?? '',
                'dob' => $validated['p2_dob'],
            ]
        );

        return view('reports.result', [
            'input' => $validated,
            'result' => $result,
            'report' => null, // preview mode
        ]);
    }

    /**
     * Save the calculated compatibility report (status: pending).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'p1_first_name' => ['required', 'string', 'max:50'],
            'p1_last_name' => ['nullable', 'string', 'max:50'],
            'p1_dob' => ['required', 'date'],
            'p2_first_name' => ['required', 'string', 'max:50'],
            'p2_last_name' => ['nullable', 'string', 'max:50'],
            'p2_dob' => ['required', 'date'],
        ]);

        $calc = $this->numerology->compareProfiles(
            [
                'first_name' => $validated['p1_first_name'],
                'last_name' => $validated['p1_last_name'] ?? '',
                'dob' => $validated['p1_dob'],
            ],
            [
                'first_name' => $validated['p2_first_name'],
                'last_name' => $validated['p2_last_name'] ?? '',
                'dob' => $validated['p2_dob'],
            ]
        );

        $report = Report::create([
            'user_id' => Auth::id(),
            'p1_first_name' => $validated['p1_first_name'],
            'p1_last_name' => $validated['p1_last_name'] ?? null,
            'p1_dob' => $validated['p1_dob'],
            'p1_life_path' => $calc['person1']['life_path'],
            'p1_destiny' => $calc['person1']['destiny'],
            'p1_soul' => $calc['person1']['soul'],
            'p1_personality' => $calc['person1']['personality'],
            'p2_first_name' => $validated['p2_first_name'],
            'p2_last_name' => $validated['p2_last_name'] ?? null,
            'p2_dob' => $validated['p2_dob'],
            'p2_life_path' => $calc['person2']['life_path'],
            'p2_destiny' => $calc['person2']['destiny'],
            'p2_soul' => $calc['person2']['soul'],
            'p2_personality' => $calc['person2']['personality'],
            'compatibility_score' => $calc['compatibility_score'],
            'summary_en' => $calc['summary_en'],
            'summary_ta' => $calc['summary_ta'],
            'status' => 'pending',
        ]);

        return redirect()->route('reports.show', $report)->with('success', __('messages.saved_pending_notice'));
    }

    /**
     * Display a specific report (Screen 6).
     */
    public function show(Report $report): View
    {
        $this->authorizeView($report);

        return view('reports.result', [
            'report' => $report,
            'result' => [
                'person1' => [
                    'first_name' => $report->p1_first_name,
                    'last_name' => $report->p1_last_name,
                    'full_name' => $report->person1_full_name,
                    'dob' => $report->p1_dob->format('Y-m-d'),
                    'life_path' => $report->p1_life_path,
                    'destiny' => $report->p1_destiny,
                    'soul' => $report->p1_soul,
                    'personality' => $report->p1_personality,
                ],
                'person2' => [
                    'first_name' => $report->p2_first_name,
                    'last_name' => $report->p2_last_name,
                    'full_name' => $report->person2_full_name,
                    'dob' => $report->p2_dob->format('Y-m-d'),
                    'life_path' => $report->p2_life_path,
                    'destiny' => $report->p2_destiny,
                    'soul' => $report->p2_soul,
                    'personality' => $report->p2_personality,
                ],
                'compatibility_score' => $report->compatibility_score,
                'summary_en' => $report->summary_en,
                'summary_ta' => $report->summary_ta,
            ],
            'input' => null,
        ]);
    }

    /**
     * Generate & stream/download PDF (Screen 7).
     */
    public function pdf(Report $report): Response
    {
        $this->authorizeView($report);

        $pdf = Pdf::loadView('reports.pdf', compact('report'))
            ->setPaper('a4', 'portrait');

        $fileName = 'Numerology-Match-' . $report->p1_first_name . '-' . $report->p2_first_name . '.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Download PDF attachment.
     */
    public function downloadPdf(Report $report): Response
    {
        $this->authorizeView($report);

        $pdf = Pdf::loadView('reports.pdf', compact('report'))
            ->setPaper('a4', 'portrait');

        $fileName = 'Numerology-Match-' . $report->p1_first_name . '-' . $report->p2_first_name . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * User action to email report (strictly gated to approved reports).
     */
    public function sendEmail(Report $report): RedirectResponse
    {
        $this->authorizeView($report);

        if (!$report->isApproved()) {
            return back()->with('error', __('messages.only_approved_can_email'));
        }

        try {
            Mail::to($report->user->email)->send(new ReportMail($report));

            $report->update([
                'status' => 'emailed',
                'emailed_at' => now(),
            ]);

            return back()->with('success', 'Report has been sent to ' . $report->user->email . ' with PDF attached.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    /**
     * Guard view to owner or admin.
     */
    private function authorizeView(Report $report): void
    {
        if (Auth::id() !== $report->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access to this report.');
        }
    }
}
