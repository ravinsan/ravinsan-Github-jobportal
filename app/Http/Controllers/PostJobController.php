<?php

namespace App\Http\Controllers;

use App\Models\PostJob;
use Illuminate\Http\Request;
use Auth;
use App\Models\Recruiter;

class PostJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = PostJob::query()->with('recruiter')->where('recruiter_id', auth()->guard('recruiter-api')->user()->id)->orderBy('id', 'desc');
        $records = $records->get();
        return response()->json([
           'status'   => true,
           'message'   => 'Post Job List',
            'data'      => $records
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $store = PostJob::create($data);

        return response()->json([
           'status'   => true,
           'message'   => 'Post Job Created Successfully',
            'data'      => $store
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostJob  $postJob
     * @return \Illuminate\Http\Response
     */
    public function show(PostJob $postJob)
    {
        $edit = PostJob::where('recruiter_id', auth()->guard('recruiter-api')->user()->id)->find($postJob->id);

        return response()->json([
           'status'   => true,
           'message'   => 'Post Job Details',
            'data'      => $edit
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostJob  $postJob
     * @return \Illuminate\Http\Response
     */
    public function edit(PostJob $postJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostJob  $postJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostJob $postJob)
    {
        $data = $request->all();
        $update = PostJob::where('recruiter_id', auth()->guard('recruiter-api')->user()->id)->where('id', $postJob->id)->first();
        $update = $update->update($data);

        return response()->json([
           'status'   => true,
           'message'   => 'Post Job Updated Successfully',
            'data'      => $update
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostJob  $postJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostJob $postJob)
    {
        $delete = PostJob::where('recruiter_id', auth()->guard('recruiter-api')->user()->id)->find($postJob->id);
        $delete = $delete->delete();
        return response()->json([
           'status'   => true,
           'message'   => 'Post Job Deleted Successfully',
            'data'      => $delete
        ], 200);
    }

    public function statusChange($id)
    {
        $sch    = PostJob::where('recruiter_id', auth()->guard('recruiter-api')->user()->id)->where('id', $id)->first();
        if($sch->status == '1'){
            $status = '0';
        }else{
            $status = '1';
        }
        $value     = array('status' => $status);
        $change    = PostJob::where('id', $id)->update($value);
        return response()->json([
           'status'   => true,
           'message'   => 'Post Job Status Changed Successfully',
            'data'      => $change
        ], 200);
    }

}    
