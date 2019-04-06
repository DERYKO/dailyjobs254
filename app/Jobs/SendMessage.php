<?php

namespace App\Jobs;

use AfricasTalking\SDK\AfricasTalking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    public $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $AT       = new AfricasTalking(getenv('AFRICAS_TALKING_USERNAME'), getenv('AFRICAS_TALKING_KEY'));
        $sms      = $AT->sms();
        $sms->send([
            'to'      => $this->user->phone,
            'message' => $this->message
        ]);

    }
}
