<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;
use Closure;
use JWTAuth;

class CandidateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(empty($request->bearerToken())) {

            return response()->json([
                'success' => false,
                'message' => 'unauthenticated',
                 'status' =>'Verify Bearer Token',
            ], 200);
            header('Content-Type: application/json', 'Accept: application/json');
        }

       
        if(!auth('candidate-api')->authenticate()){
            return response()->json([
                    'success' => false,
                    'message' => 'unauthenticated',
                     'status'=>'Candidate Not Login',
                ], 200);
            header('Content-Type: application/json', 'Accept: application/json');
            
                return $this->successResponse($data, 'Candidate has been successfully login!', $this->success());

            
        }

        return $next($request);
    }
}
