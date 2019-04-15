<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\JobApplied;
use App\Job;
use App\Jobs\SendMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ApplicationController extends Controller
{
    public function index()
    {
        $jobs = Job::where('owner_id', Auth::id())->with('applications')->get();
        return response()->json(['jobs' => $jobs]);
    }

    public function store(Request $request)
    {
        $applicant = Application::create([
            'applicant_id' => Auth::id(),
            'job_owner_id' => $request->owner_id,
            'job_id' => $request->job_id,
            'cover_letter' => $request->cover_letter,
        ]);
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'aa68d5472e9a5c7b6fad',
            '470434d919deba02dfcd',
            '762292',
            $options
        );

        $data['job'] = $applicant->job;
        $data['user'] = User::where('id', $applicant->applicant_id)->first();
        $pusher->trigger('my-channel', 'my-event', $data);
        return response()->json(['message' => 'application saved']);
    }

    public function update(Request $request)
    {
        Application::where('job_id', $request->job_id)->where('applicant_id', $request->applicant_id)->first()->update([
            'accepted' => true,
        ]);
        $applicant = Application::where('job_id', $request->job_id)->where('applicant_id', $request->applicant_id)->first();
        $applicant->job->update([
            'active' => false
        ]);
        $this->dispatch(new SendMessage(User::where('id', $applicant->applicant_id)->first(), $this->getMessage($applicant)));
        Application::where('job_id', $request->job_id)->where('applicant_id', '!=', $request->applicant_id)
            ->get()
            ->each(function ($application) {
                $this->dispatch(new SendMessage(User::where('id', $application->applicant_id)->first(), $this->message($application)));
                $application->delete();
            });
        $jobs = Job::where('owner_id', Auth::id())->with('applications')->get();
        return response()->json(['jobs' => $jobs]);
    }

    public function getMessage($applicant)
    {
        return 'Success!! ' . 'Your application for ' . $applicant->job->title . ' was successful. Please wait for further instruction';
    }

    public function message($application)
    {
        return 'Hello ' . User::where('id', $application->applicant_id)->first() . ', Your for ' . $application->job->title . ' was not successful. Please keep applying to increase your hustle chances';
    }
}
