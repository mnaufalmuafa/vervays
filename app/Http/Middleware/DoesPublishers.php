<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class DoesPublishers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = session('id');
        if (User::doesUserAmongThePublishers($userId)) {
            return $next($request);
        }
        User::bePublisher($userId);
        return redirect()->route('dashboard-publisher');
    }
}
