<?php

namespace App\Models;

use Closure;
use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class Signup extends Model
{
    use BindsOnUuid, GeneratesUuid, HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'event_date' => 'immutable_datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCalendarEvent(Closure $eventModifier = null): Calendar
    {
        $event = Event::create()
            ->uniqueIdentifier($this->uuid)
            ->name('Magnolia Green Volleyball at Arbor Walk')
            ->organizer('contact@magnoliagreenvolleyball.com', 'Abdel ELrafa')
            ->startsAt($this->event_date)
            ->endsAt($this->event_date->addHours(3))
            ->address('6745 Begonia Dr, Moseley, VA 23120')
            ->addressName('Arbor Walk')
            ->coordinates(37.408940, -77.726030)
            ->url(url('/'));

        if ($eventModifier) {
            $response = $eventModifier($event);

            if ($response) {
                $event = $response;
            }
        }

        return Calendar::create('Magnolia Green Volleyball at Arbor Walk')
            ->event($event);
    }
}
