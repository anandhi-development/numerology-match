<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $totalReports = Report::where('user_id', $user->id)->count();
        $pendingReports = Report::where('user_id', $user->id)->where('status', 'pending')->count();
        $approvedReports = Report::where('user_id', $user->id)->whereIn('status', ['approved', 'emailed'])->count();

        $recentReports = Report::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('totalReports', 'pendingReports', 'approvedReports', 'recentReports'));
    }
}
