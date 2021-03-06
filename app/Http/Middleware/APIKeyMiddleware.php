<?php
/**
 * APIKeyMiddleware
 * @category    Middleware
 * @author      
 */
namespace App\Http\Middleware;

use Closure;

/**
 * This middleware is to check the api key
 * @category     Middleware
 * @author       
 */
class APIKeyMiddleware
{
    
    public function handle($request, Closure $next)
    {
        if($request->header('api-key')===env('API_KEY')){
            return $next($request);
        }else{
            return response()->json([
                'message' => 'API Key failed',
            ], 401);
      }
    }
}
