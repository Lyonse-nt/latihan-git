<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Cari member berdasarkan email user yang login
        $member = Member::where('email', $user->email)->first();
        
        return view('member.dashboard.index', compact('user', 'member'));
    }
}
