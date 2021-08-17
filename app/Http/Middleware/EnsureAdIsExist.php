<?php

namespace App\Http\Middleware;

use App\Models\Ad;
use Closure;
use Illuminate\Http\Request;

class EnsureAdIsExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ad = Ad::find($request->id);

        if (!$ad) {
            return redirect('/')->withErrors([
                'errorMessage' => 'Cant find ad'
            ]);
        }
        return $next($request);
    }
}
