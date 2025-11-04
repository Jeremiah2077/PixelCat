<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPhotographerStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('photographer')->check()) {
            $photographer = auth('photographer')->user();

            if ($photographer->status !== 'active') {
                auth('photographer')->logout();

                return redirect()
                    ->route('filament.photographer.auth.login')
                    ->with('error', '您的账号尚未激活，请联系管理员。');
            }
        }

        return $next($request);
    }
}
