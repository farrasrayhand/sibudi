<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\EmploymentStatus;
use App\Models\Guestbook;
use App\Models\Personil;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('login');
        }

        $employmentStatuses = EmploymentStatus::withCount('personils')
            ->orderBy('name')
            ->get();
        $bidangs = Bidang::withCount('personils')
            ->orderBy('name')
            ->get();
        $personils = Personil::with(['bidang', 'employmentStatus'])
            ->orderBy('name')
            ->get();
        $guestbooks = Guestbook::orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.index', compact(
            'employmentStatuses',
            'bidangs',
            'personils',
            'guestbooks'
        ));
    }
}
