<?php

namespace App\Listeners;

use App\Events\studentAttemptsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class updateExamScoreListener
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
     * @param  studentAttemptsEvent  $event
     * @return void
     */
    public function handle(studentAttemptsEvent $event)
    {
        //
    }
}
