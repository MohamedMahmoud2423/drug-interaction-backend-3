<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \App\Http\Controllers\API\Response as ResponseA;
use App\Models\AccessToken;

class Authentication_API
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    use ResponseA;
    public function handle(Request $request, Closure $next): Response
    {
        $BearerTokenArr = explode('|', $request->bearerToken());
        if (count($BearerTokenArr) == 0){
            return $this->ResponseAPI("error", 401, "Wrong Token");
        }elseif (count($BearerTokenArr) == 1){
            $BearerToken = $BearerTokenArr[0];
        }else{
            $BearerToken = $BearerTokenArr[count($BearerTokenArr) - 1];
        }
        $access_token = AccessToken::where('token', $BearerToken ?? null)->first();
        if (empty($access_token)){
            return $this->ResponseAPI("error", 401, "Wrong Token");
        }else{
            Auth()->login($access_token->user);
            return $next($request);
        }
    }
}
