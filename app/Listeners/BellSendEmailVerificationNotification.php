<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class BellSendEmailVerificationNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        //
        // $details = [
        //     'title' => 'Mail from Bigbellwork.com',
        //     'body' => 'This is for testing email using smtp'
        // ];

        $user = $event->user;
        Mail::to('bell_2530@hotmail.com')->send(new \App\Mail\EmailVerificationMail($user));
    }
}
