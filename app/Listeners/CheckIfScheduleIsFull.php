<?php

namespace App\Listeners;

use App\Events\AdjustedScheduleAvailableSlots;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckIfScheduleIsFull
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
     * @param  AdjustedScheduleAvailableSlots  $event
     * @return void
     */
    public function handle(AdjustedScheduleAvailableSlots $event)
    {
        request()->session()->flash('info', [
            'title' => 'Checked schedule slots!',
            'type' => 'error',
            'text' => 'Inside listener',
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'CONTINUE',
        ]);
    }
}
