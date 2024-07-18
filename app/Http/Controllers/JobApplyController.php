<?php

namespace App\Http\Controllers;

use App\Models\JobApply;
use App\Models\PostJob;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Auth;
use Mail;

class JobApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dat = PostJob::get();

        return response()->json([
           'status'   => true,
           'message'   => 'Job Apply List',
            'data'      => $dat
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applyjob(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'candidate_id' =>'required',
        ]);
        
        foreach($data['job_id'] as $job_id){
            $jobs = PostJob::with('recruiter')->find($job_id);
            
            $obj = new JobApply();
            $obj->candidate_id = auth()->guard('candidate-api')->user()->id;
            $obj->job_id = $job_id;
            $obj->recruiter_id = $jobs->recruiter->id;
            $obj->date = date('Y-m-d');
            $obj->save();

            Mail::to($jobs->recruiter->email)->send(new SendMail());
        };

        return response()->json([
           'status'   => true,
           'message'   => 'Job Apply Successfully'
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function applicants()
    {
        $data = JobApply::select('id', 'job_id', 'candidate_id', 'recruiter_id')->with(['candidate', 'job'])->where('recruiter_id', auth()->guard('recruiter-api')->user()->id)->orderBy('id', 'desc')->get();
        return response()->json([
           'status'   => true,
           'message'   => 'Job Apply List',
            'data'      => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function show(JobApply $jobApply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function edit(JobApply $jobApply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobApply $jobApply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobApply $jobApply)
    {
        //
    }
}
