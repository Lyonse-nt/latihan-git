<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Guestbook;
use App\Models\HallOfFame;
use App\Models\Member;
use App\Models\Project;
use App\Models\Quote;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'members' => Member::count(),
            'projects' => Project::count(),
            'events' => Event::count(),
            'galleries' => Gallery::count(),
            'quotes' => Quote::count(),
            'guestbook' => Guestbook::count(),
            'hall_of_fame' => HallOfFame::count(),
            'users' => User::count(),
        ];

        // Fetch recent activities
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentActivities'));
    }
}
