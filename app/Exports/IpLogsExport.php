<?php

namespace App\Exports;

use App\Models\IpLog;
use Maatwebsite\Excel\Concerns\FromCollection;

class IpLogsExport implements FromCollection
{
    public function collection()
    {
        return IpLog::with('user')->latest()->get()->map(function ($log) {
            return [
                'User' => $log->user->name ?? '-',
                'IP Address' => $log->ip_address,
                'City' => $log->city,
                'Region' => $log->region,
                'Country' => $log->country,
                'Latitude' => $log->lat,
                'Longitude' => $log->lon,
                'VPN/Proxy' => $log->is_proxy ? 'Ya' : 'Tidak',
                'Waktu' => $log->created_at->format('d-m-Y H:i'),
            ];
        });
    }
}
