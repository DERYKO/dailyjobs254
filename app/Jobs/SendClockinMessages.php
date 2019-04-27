<?php

namespace App\Jobs;

use App\Job;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendClockinMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Job::where('start_time','>', now()->addHour(3)->toDateTimeString())
            ->where('start_time','<=',now()->addHour(1)->toDateTimeString())
            ->where('active',true)
            ->get()->each(function ($job){
                self::dispatch(new SendMessage(User::where('id',$job->applicant_id)->first(),'Hello, in 2hrs you should be clocking in for your job entitled '.$job->title.'. Please observe time to maintain a good profile and get chances of getting more jobs.'));
            });
    }
}
