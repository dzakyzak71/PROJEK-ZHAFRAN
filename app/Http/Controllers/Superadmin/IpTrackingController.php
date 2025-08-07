<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IpLog;
use App\Models\User;
use App\Exports\IpLogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class IpTrackingController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user_id;
        $users = User::all();

        $ipLogs = IpLog::with('user')
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('superadmin.pages.components.tracking-ip', compact('ipLogs', 'users'));
    }

    public function export()
    {
        return Excel::download(new IpLogsExport, 'log-ip.xlsx');
    }

    public function clearOldLogs()
    {
        $deleted = IpLog::where('created_at', '<', Carbon::now()->subDays(30))->delete();

        return redirect()->route('superadmin.tracking')->with('success', "$deleted log IP lama telah dihapus.");
    }
}
