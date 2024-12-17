<?php

namespace Modules\Iorder\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Iwebhooks\Jobs\DispatchWebhooks;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->app->booted(function () {

      $hours = setting("iorder::hoursToNotify", null, false);
      //Check id is active the webhook job
      if (isset($hours) && $hours > 0) {
        //Create instance about schedule
        $schedule = $this->app->make(Schedule::class);
        $schedule->call(function () use ($hours) {
          \Modules\Iorder\Jobs\CheckPendingOrdersJob::dispatch($hours);
        })->dailyAt('14:00');
      }
    });
  }

}
