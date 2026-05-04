<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use App\Models\User;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Log Activity';

        // Ambil semua user untuk pilihan filter
        $users = User::orderBy('username')->get();

        // Ambil parameter filter
        $user_id = $request->user_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        // Query log tanpa paginate
        $logs = LogActivity::with('user')
            ->when($user_id, function($q) use ($user_id) {
                return $q->where('user_id', $user_id);
            })
            ->when($date_from, function($q) use ($date_from) {
                return $q->whereDate('created_at', '>=', $date_from);
            })
            ->when($date_to, function($q) use ($date_to) {
                return $q->whereDate('created_at', '<=', $date_to);
            })
            ->orderBy('created_at', 'desc')
            ->get();  // ← tidak pakai paginate

        return view('stepproses.logactivity', compact('title', 'logs', 'users'));
    }
}
