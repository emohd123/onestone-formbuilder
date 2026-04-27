<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Add this line
use Carbon\Carbon;

class CheckPlanId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and if their OTP is empty
        if(Auth::check()){


            if (Auth::user()->otp != null && Auth::user()->plan_id == '0') {
                // Redirect to the plans page with an error message
                return redirect()->route('plans.index')->with('error', 'Please select a plan below to access and explore all available features.');
            } elseif (Auth::user()->plan_expired_date && Carbon::now()->gt(Auth::user()->plan_expired_date)) {
                // Redirect with an error message indicating that the plan has expired
                return redirect()->route('plans.index')->with('error', 'Your plan has expired. Please choose a new plan or renew plan before proceeding.');
            }


        }

        return $next($request);
    }
}
