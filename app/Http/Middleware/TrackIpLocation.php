<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\IpLog;

class TrackIpLocation
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $ip = $request->ip();

            // Cek apakah IP ini sudah dicatat hari ini
            $exists = IpLog::where('user_id', $user->id)
                ->where('ip_address', $ip)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (!$exists) {
                try {
                    $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,lat,lon");

                    $proxyCheck = Http::get("https://ipapi.co/{$ip}/json/");
                    $isProxy = false;
                    if ($proxyCheck->ok() && isset($proxyCheck['proxy'])) {
                        $isProxy = $proxyCheck['proxy'] == true;
                    }
                    if ($response->ok() && $response['status'] === 'success') {
                        IpLog::create([
                            'user_id'    => $user->id,
                            'ip_address' => $ip,
                            'city'       => $response['city'],
                            'region'     => $response['regionName'],
                            'country'    => $response['country'],
                            'lat'        => $response['lat'],
                            'lon'        => $response['lon'],
                            'is_proxy'   => $isProxy,
                        ]);
                    }
                } catch (\Exception $e) {
                    // Abaikan jika API gagal
                }
            }
        }

        return $next($request);
    }
}
