<?php

namespace App\Console;

use App\HistoryDetail;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $openReservations = Reservation::where('status', 'new')->orWhere('status', 'underpaid')->get();

            if ($openReservations->count() > 0) {
                foreach($openReservations as $openReservation) {
                    if (Carbon::parse($openReservation->created_at)->startOfDay()->gte(now()->startOfDay())) {
                        HistoryDetail::create([
                            'reservation_id' => $openReservation->id,
                            'updated_by' => 1,
                            'log' => 'reservation closed by the system',
                            'remarks' => 'expired reservation',
                        ]);

                        $openReservation->status = 'expired';
                        $openReservation->receive_payment = 0;
                        $openReservation->save();
                    }
                }
            }
        })->dailyAt('23:00'); // daily at 11:00pm

        $schedule->command('queue:work')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
