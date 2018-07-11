<?php

namespace App\Http\Middleware;

use Closure;

class MarkNotificationAsRead
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
         if($request-&gt;has('read')) {
            $notification = $request-&gt;user()-&gt;notifications()-&gt;where('id', $request-&gt;read)-&gt;first();
            if($notification) {
                $notification-&gt;markAsRead();
            }
        }
        return $next($request);
    }
}
