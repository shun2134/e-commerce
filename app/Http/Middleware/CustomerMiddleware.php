<?php

namespace App\Http\Middleware;

use App\Models\Users\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Get the authenticated user's email
            $email = Auth::user()->email;

            // Check if the email exists in the Admin table
            $customer = Customer::where('email', $email)->first();

            if ($customer) {
                // User's email exists in the Admin table
                return $next($request);
            }
        }

        return redirect()->route('home')->with('error', 'Please Login as Customer user!');
    }
}
