<?php

namespace App\Http\Controllers;

use App\Application;
use App\Job;
use App\Jobs\JobTranscation;
use App\Transcation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()) {
            $jobs = array();
            foreach (Job::where('active',1)->where('owner_id','!=',Auth::id())->with('user')->get() as $job) {
                if (Application::where('job_id', $job->id)->where('applicant_id', Auth::id())->exists()) {

                }else{
                    array_push($jobs, $job);
                }

            }
            return response()->json(['data' => $jobs]);
        } else {
            return response()->json(['data' => Job::get()]);

        }
    }

    public function job(Request $request, $id)
    {
        return Job::where('id', $id)->first();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'rules' => 'required',
            'duration' => 'required|integer',
            'pay_amount' => 'required',
            'job_location_address' => 'required'
        ]);
        if (Auth::check()) {
            $phone = '0711536733';
            $job = Job::create([
                'title' => $request->input('title'),
                'owner_id' => Auth::id(),
                'description' => $request->input('description'),
                'start_time' => $request->input('start_time'),
                'rules' => $request->input('rules'),
                'duration' => $request->input('duration'),
                'pay_amount' => $request->input('pay_amount'),
                'job_location_address' => serialize($request->input('job_location_address')),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return response()->json(['data'=>$job]);

        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
