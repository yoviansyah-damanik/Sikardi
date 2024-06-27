<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->data->supervisor) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('No supervisor found. Please confirm with the staff to assign a supervisor.'));

            return to_route('home');
        }

        return $next($request);
    }
}
