<?php

namespace App\Http\Middleware;

use App\Models\Schedule;
use App\Models\Transaction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckScheduleExecution
{
    public function handle(Request $request, Closure $next): Response
    {
        $schedules = Schedule::all();

        foreach ($schedules as $schedule) {
            if ($schedule->shouldRun()) {
                Transaction::create([
                    'wallet_id'     => $schedule->wallet_id,
                    'category_id'   => $schedule->category_id,
                    'type'          => $schedule->type,
                    'amount'        => $schedule->amount,
                    'description'   => $schedule->description,
                    'date_time'     => now(),
                ]);

                $schedule->last_run_at = now();
                $schedule->save();
            }
        }

        return $next($request);
    }
}
