<?php

namespace App\Jobs;

use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $otp, $user;
    public function __construct($user, $otp)
    {
        $this->otp = $otp;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

       // send otp
       Mail::to($this->user)->send(new ForgotPasswordOtpMail($this->otp));
    }
}
