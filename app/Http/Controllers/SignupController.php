<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use App\Models\User;
use App\Notifications\SignupCreatedConfirmation;
use App\Notifications\SignupDeletedConfirmation;
use App\Notifications\SignupUpdatedConfirmation;
use App\Support\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SignupController extends Controller
{
    public function __construct()
    {
        $this->middleware('signed')->only('show');
    }

    public function create(): View
    {
        $cutoff = now()->greaterThan(now()->parse('3pm'))
            ? now()->next('saturday at 3pm')
            : now()->subDay()->next('saturday at 3pm');

        return view('signups.create')
            ->with('cutoff', $cutoff)
            ->with('successfulRegistration', session('successfulRegistration'))
            ->with('deletedRegistration', session('deletedRegistration'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|email:rfc,dns',
            'cutoff' => 'required|date|after_or_equal:today',
            'receive_reminders' => 'required|boolean',
        ]);

        $user = User::query()->updateOrCreate(['email' => $data['email']], [
            'name' => $data['name'],
            'receive_reminders' => $data['receive_reminders'],
        ]);

        $signup = Signup::create([
            'event_date' => $data['cutoff'],
            'user_id' => $user->id,
        ]);

        $user->notify(new SignupCreatedConfirmation($signup));

        return redirect()->action([self::class, 'create'])->with('successfulRegistration', true);
    }

    public function edit(Signup $signup): View
    {
        return view('signups.edit')->with('signup', $signup)->with('successfulUpdate', session('successfulUpdate'));
    }

    public function update(Request $request, Signup $signup): RedirectResponse
    {
        $data = $request->validate([
            'receive_reminders' => 'required|boolean',
        ]);

        $user = Type::instanceOf(User::class, $signup->user);

        $user->update([
            'receive_reminders' => $data['receive_reminders'],
        ]);

        $user->notify(new SignupUpdatedConfirmation($signup));

        return redirect()->action([self::class, 'edit'], $signup)->with('successfulUpdate', true);
    }

    public function destroy(Signup $signup): RedirectResponse
    {
        $signup->delete();

        $user = Type::instanceOf(User::class, $signup->user);

        $user->notify(new SignupDeletedConfirmation($signup));

        return redirect()->action([self::class, 'create'])->with('deletedRegistration', true);
    }
}
