<?php

namespace App\Jobs;

use App\Mail\UserResetPasswordLinkMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserResetPasswordLinkMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $token;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $token)
    {

        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Generate and send password reset link
        Mail::to($this->user)->send(new UserResetPasswordLinkMail(
            $this->email,
            $this->token
        ));
    }
}
