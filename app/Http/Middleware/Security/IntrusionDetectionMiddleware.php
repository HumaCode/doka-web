<?php

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Master\SystemLog;

class IntrusionDetectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $suspiciousPaths = [
            '.env',
            '.git',
            'wp-admin',
            'wp-login.php',
            'phpinfo',
            'config.php',
            'database.php',
            'id_rsa',
            '.aws',
            'console',
            '_debugbar'
        ];

        $path = $request->path();

        foreach ($suspiciousPaths as $suspicious) {
            if (str_contains(strtolower($path), $suspicious)) {
                SystemLog::create([
                    'event_type' => 'attack_attempt',
                    'severity' => 'danger',
                    'description' => "Percobaan akses ilegal ke file/path sensitif: {$path}",
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'path' => $path,
                    'method' => $request->method(),
                    'metadata' => [
                        'query_params' => $request->all(),
                        'headers' => $request->headers->all()
                    ]
                ]);

                // We can either let it 404 or abort
                abort(403, 'Akses Dilarang oleh Sistem Keamanan DokaWeb.');
            }
        }

        return $next($request);
    }
}
