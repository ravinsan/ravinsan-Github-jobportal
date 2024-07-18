<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests\Candidate\LoginRequest;
use JWTAuth;
use Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
       $credentials = auth()->guard('candidate-api')->attempt(['email' => $request->email, 'password' => $request->password]);
       
        $token =    $credentials;

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized!',
            ], 401);
        }

        $user = auth()->guard('candidate-api')->user();
        
        $data = [
            'user'   => $user,
            'token'  => $token,
            'type'   => 'bearer',
        ];        
        return response()->json([
            'status'   => true,
            'message'   => 'Candidate Login Successfully',
             'data'      => $data
         ], 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        
        $user = auth()->guard('candidate-api')->user();

        if(empty($user))
        {
            return $this->errorResponse('You have already logged out.', $this->success());
        }

        $userTokens = $user->tokens;

        if ($userTokens) {
            $userTokens->each(function ($token, $key) {
                $token->delete();
            });
        }

        auth()->guard('candidate-api')->logout();

        $data = [];
        return response()->json([
            'status'   => true,
            'message'   => 'Candidate has been Successfully logout',
             'data'      => $data
         ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
}
