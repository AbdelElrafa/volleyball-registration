<?php

namespace App\Notifications;

use App\Models\Signup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Spatie\IcalendarGenerator\Components\Event;

class SignupUpdatedConfirmation extends Notification
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
        $manageUrl = URL::signedRoute('signups.edit', $this->signup);

        $calendar = $this->signup->getCalendarEvent(fn (Event $event) => $event
            ->alertMinutesBefore(30, 'Magnolia Green Volleyball at Arbor Walk is going to start in thirty minutes.')
            ->url($manageUrl)
        );

        return (new MailMessage())
            ->subject($this->signup->event_date->format('l, F jS, Y').' Magnolia Green Volleyball Registration Updated')
            ->greeting("Hello {$user->name},")
            ->line('Your registration has been updated for this weeks volleyball pickup games on '.$this->signup->event_date->format('l, F jS, Y').'.')
            ->line('To unregister or update your reminder preferences click the "Manage Registration" button below.')
            ->action('Manage Registration', URL::signedRoute('signups.edit', $this->signup))
            ->line('You will '.($user->shouldReceiveReminders() ? '' : 'not ').'receive weekly registration reminders.')
            ->line('Click the "Manage Registration" button above to update your registration reminder preferences.')
            ->attachData($calendar->toString(), "{$this->signup->uuid}.ics");
    }
}
