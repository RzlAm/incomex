<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function shouldRun(): bool
    {
        $now = now();
        $last = $this->last_run_at;

        $hour = $this->hour ?? 0;
        $minute = $this->minute ?? 0;

        $scheduledTime = now()->setTime($hour, $minute);

        switch ($this->schedule_type) {
            case 'daily':
                return (
                    (!$last || $last->lt($now->copy()->startOfDay())) &&
                    $now->gte($scheduledTime)
                );

            case 'monthly':
                return (
                    $now->day == $this->day &&
                    (!$last || $last->lt($now->copy()->startOfMonth())) &&
                    $now->gte($scheduledTime)
                );

            case 'yearly':
                return (
                    $now->day == $this->day &&
                    $now->month == $this->month &&
                    (!$last || $last->lt($now->copy()->startOfYear())) &&
                    $now->gte($scheduledTime)
                );

            case 'hourly':
                return (
                    (!$last || $last->diffInMinutes($now) >= 60) &&
                    $now->minute >= $minute
                );

            default:
                return false;
        }
    }

    protected $casts = [
        'last_run_at' => 'datetime',
    ];
}
