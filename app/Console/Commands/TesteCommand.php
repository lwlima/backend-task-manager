<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class TesteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:teste-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task = Task::find(5);
        $explodedWorkedHours = explode(':', $task->worked_hours);
        $explodedDiff = explode(':', (new Carbon($task->finished_at))->diff($task->started_at)->format('%H:%i:%s'));
        $seconds = $explodedWorkedHours[2] + $explodedDiff[2];
        $minutes = $seconds > 59 ? $explodedWorkedHours[1] + $explodedDiff[1] + intval($seconds / 60) : $explodedWorkedHours[1] + $explodedDiff[1];
        $hours = $minutes > 59 ? $explodedWorkedHours[0] + $explodedDiff[0] + intval($minutes / 60) : $explodedWorkedHours[0] + $explodedDiff[0];

        $explodedWorkedHours[2] = $seconds > 59 ? $seconds % 60 : $seconds;
        $explodedWorkedHours[1] = $minutes > 59 ? $minutes % 60 : $minutes;
        $explodedWorkedHours[0] = $hours;
        dump(implode(':', $explodedWorkedHours));
    }
}
