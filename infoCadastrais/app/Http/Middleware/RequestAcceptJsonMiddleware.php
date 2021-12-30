<?php

namespace App\Http\Middleware;

use Closure;

class RequestAcceptJsonMiddleware
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
        if (!$request->isMethod('get')) {
            //
            $accept = $request->header('accept');
            if($accept  != 'application/json'){
                return response()->json(['Retorno apenas em formato Json'],406);
            }

            $contentType = $request->header('content-type');
            if($contentType  != 'application/json'){
                return response()->json(['Aceito apenas conteudo em formato Json'],407);
            }
        }
        else{
            $request->header('content-type','application/json');
            $request->header('accept','application/json');
        }
   
        return $next($request);
    }
}