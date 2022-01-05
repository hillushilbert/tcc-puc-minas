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
          
        
        if ($request->isMethod('OPTIONS'))
        {
            return $next($request);
        }
        else if (!$request->isMethod('get')) 
        {
            //
            $accept = $request->header('accept');
            $accept = explode(', ',$accept);
            if(!in_array('application/json',$accept)){
                return response()->json(['Retorno apenas em formato Json : '.$accept],406);
            }

            $contentType = $request->header('content-type');
            $contentType = explode(';',$contentType);
            if(!in_array('application/json',$contentType)){
                return response()->json(['Content-Type deve ser application/json : '. $contentType  ],407);
            }
        }
        else
        {
            $request->header('content-type','application/json');
            $request->header('accept','application/json');
        }
   
        return $next($request);
    }
}
