<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\JobApplyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('candidate/register', [RegisterController::class, 'register']);
Route::post('candidate/login', [CandidateController::class, 'login']);

Route::group(['prefix' => 'candidate', 'middleware' => ['jwt.verify', 'auth.candidate']], function(){
   
    Route::get('logout', [CandidateController::class, 'logout']);

    Route::get('jobs', [JobApplyController::class, 'index']);
    Route::post('job-apply', [JobApplyController::class,'applyjob']);

});

Route::post('recruiter/sinup', [RegisterController::class, 'sinup']);
Route::post('recruiter/login', [RecruiterController::class, 'login']);

Route::group(['prefix' => 'recruiter', 'middleware' => ['jwt.verify', 'auth.recruiter']], function(){
   
    Route::get('logout', [RecruiterController::class, 'logout']);

    /* Post Job */
    Route::apiResource('post-job', PostJobController::class);
    Route::get('post-job/status/{id}', [PostJobController::class, 'statusChange']);

    ///* Allicants */
    Route::get('applicants', [JobApplyController::class, 'applicants']);

});