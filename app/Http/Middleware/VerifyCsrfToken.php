<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'forgot-password',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip CSRF verification for excluded routes
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return $next($request);
            }
        }

        // For other routes, verify CSRF token
        if ($request->isMethod('POST') ||
            $request->isMethod('PUT') ||
            $request->isMethod('DELETE') ||
            $request->isMethod('PATCH')) {

            // Check if token is present
            if (!$request->hasHeader('X-CSRF-TOKEN') &&
                !$request->input('_token') &&
                !$request->hasCookie('XSRF-TOKEN')) {

                abort(419, 'Halaman Kedaluwarsa: Token CSRF tidak ditemukan');
            }

            // Get tokens
            $sessionToken = Session::token();
            $userToken = $request->input('_token') ??
                $request->header('X-CSRF-TOKEN') ??
                $request->cookie('XSRF-TOKEN');

            // Better validation that checks hash too
            if (!$this->tokensMatch($sessionToken, $userToken)) {
                abort(419, 'Halaman Kedaluwarsa: Token CSRF tidak cocok');
            }
        }

        return $next($request);
    }

    /**
     * Determine if the session and input CSRF tokens match.
     * Similar to how Laravel internally checks tokens.
     *
     * @param string $sessionToken
     * @param string $userToken
     * @return bool
     */
    protected function tokensMatch($sessionToken, $userToken)
    {
        if (!$sessionToken || !$userToken) {
            return false;
        }

        return hash_equals($sessionToken, $userToken);
    }
}
