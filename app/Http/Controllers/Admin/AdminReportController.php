<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ReportMail;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    /**
     * Admin Dashboard & Reports list (Screen 10).
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');

        $pendingCount = Report::where('status', 'pending')->count();
        $approvedCount = Report::where('status', 'approved')->count();
        $emailedCount = Report::where('status', 'emailed')->count();
        $rejectedCount = Report::where('status', 'rejected')->count();

        $query = Report::with('user')->latest();

        if ($statusFilter && in_array($statusFilter, ['pending', 'approved', 'emailed', 'rejected'], true)) {
            $query->where('status', $statusFilter);
        }

        $reports = $query->paginate(10);

        return view('admin.dashboard', compact(
            'reports',
            'pendingCount',
            'approvedCount',
            'emailedCount',
            'rejectedCount',
            'statusFilter'
        ));
    }

    /**
     * Admin review specific report (Screen 11).
     */
    public function show(Report $report): View
    {
        return view('admin.show', compact('report'));
    }

    /**
     * Approve report.
     */
    public function approve(Report $report): RedirectResponse
    {
        $report->update(['status' => 'approved']);

        return back()->with('success', __('messages.approved_success'));
    }

    /**
     * Reject report.
     */
    public function reject(Request $request, Report $report): RedirectResponse
    {
        $report->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes', 'Report rejected by admin.'),
        ]);

        return back()->with('info', __('messages.rejected_success'));
    }

    /**
     * Approve and immediately send email with PDF (Screen 11 button).
     */
    public function approveAndSendEmail(Report $report): RedirectResponse
    {
        try {
            // Update to approved first
            $report->update([
                'status' => 'emailed',
                'emailed_at' => now(),
            ]);

            // Dispatch email with attached PDF
            Mail::to($report->user->email)->send(new ReportMail($report));

            return redirect()->route('admin.reports.index', ['status' => 'pending'])
                ->with('success', __('messages.email_sent_success'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating email: ' . $e->getMessage());
        }
    }

    /**
     * List all users.
     */
    public function users(): View
    {
        $users = User::withCount('reports')->latest()->paginate(15);

        return view('admin.users', compact('users'));
    }
}
