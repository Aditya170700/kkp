<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $code = 401;
        $error = [
            'code_response' => $code,
            'data' => null,
            'message' => null,
        ];

        if (!auth()->user()->email_verified_at) {
            $error['message'] = 'Email belum terverifikasi';

            return response()->json($error, $code);
        }

        if (!auth()->user()->is_verified) {
            $error['message'] = 'User belum diverifikasi, hubungi admin';

            return response()->json($error, $code);
        }

        return $next($request);
    }
}
