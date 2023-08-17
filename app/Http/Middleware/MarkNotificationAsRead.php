<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notify_id = $request->query('notify_id');
        if ($notify_id && Auth::check()) {
            $user = Auth::user();
            $notification = $user->notifications()->find($notify_id);
            if ($notification && $notification->unread()) {
                $notification->markAsRead();
            }
        }
        return $next($request);
    }
}
