<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Add this line

class OtpVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and if their OTP is empty
        if (Auth::check() && empty(Auth::user()->otp)) {
            // Redirect to the home page without showing any additional verification views
            return redirect('/whatsapp/verification');
        }

        return $next($request);
    }
}
