<?php

namespace App\Notifications;

use App\Models\Signup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\EventStatus;

class SignupDeletedConfirmation extends Notification
{
    use Queueable;

    public function __construct(protected Signup $signup)
    {
        //
    }

    /**
     * @return array<class-string>
     */
    public function via(User $notifiable): array
    {
        return [MailChannel::class];
    }

    public function toMail(User $user): MailMessage
    {
        $calendar = $this->signup->getCalendarEvent(fn (Event $event) => $event
            ->status(EventStatus::cancelled())
        );

        return (new MailMessage())
            ->subject($this->signup->event_date->format('l, F jS, Y').' Magnolia Green Volleyball Registration Deleted')
            ->greeting("Hello {$user->name},")
            ->line('Your registration has been deleted for this weeks volleyball pickup games on '.$this->signup->event_date->format('l, F jS, Y').'.')
            ->line('You will '.($user->shouldReceiveReminders() ? 'still' : 'not').' receive weekly registration reminders.')
            ->attachData($calendar->toString(), "{$this->signup->uuid}.ics");
    }
}
