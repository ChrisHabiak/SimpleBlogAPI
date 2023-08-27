<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;

class SendEmailOnRegistrationListener
{

    public function handle(UserRegisteredEvent $event)
    {
        Mail::to($event->user)->send(new UserRegisteredMail());
    }
}
