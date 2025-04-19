<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Profile as ModelProfile;

class Profile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth()->user() ?? null;
        if(empty($user->profile)){
            ModelProfile::create([
                'user_id' => $user->id
            ]);
        }
        return $next($request);
    }
}
