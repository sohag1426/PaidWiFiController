<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCustomerMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->exists('verified_mobile')) {

            $value = $request->session()->get('verified_mobile');

            if ($value == 0) {

                $mobile = $request->session()->get('authenticated_customer_mobile');

                return redirect()->route('customer.mobile.verification', ['mobile' => $mobile]);
            }
        }

        return $next($request);
    }
}
