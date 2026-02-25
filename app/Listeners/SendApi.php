<?php

namespace App\Listeners;

use App\Events\NewEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
class SendApi
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewEvent $event): void
    {
        $emails = ['kvraghul2018@gmail.com'];
        Mail::send('email', [], function($message) use ($emails)
        {    
            $message->to($emails)->subject('This is test e-mail');  
            $message->from('raghul@oceansoftwares.in','Rahul');  
        });
    }
}
