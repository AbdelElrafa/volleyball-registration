<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'receive_reminders' => 'boolean',
    ];

    public function shouldReceiveReminders(): bool
    {
        return $this->receive_reminders;
    }
}
