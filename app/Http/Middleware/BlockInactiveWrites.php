<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockInactiveWrites
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->status === 'inactive' && ! $request->isMethodSafe() && ! $request->routeIs('logout')) {
            return back()->with('warning', 'Akun inactive tidak bisa mengubah data.');
        }

        return $next($request);
    }
}