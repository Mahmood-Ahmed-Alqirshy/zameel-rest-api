<?php

namespace App\Http\Middleware;

use App\Authorization\AuthorizationRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role_id !== AuthorizationRole::SUPERADMIN->id())
            throw new UnauthorizedException('You are not authorized to access this endpoint.');

        return $next($request);
    }
}
