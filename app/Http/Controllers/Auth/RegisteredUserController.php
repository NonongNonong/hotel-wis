<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname'      => ['required', 'string', 'max:100'],
            'lname'      => ['required', 'string', 'max:100'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile_num' => ['nullable', 'string', 'max:20'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $guest = Guest::create([
            'fname'      => $request->fname,
            'lname'      => $request->lname,
            'email_add'  => $request->email,
            'mobile_num' => $request->mobile_num,
        ]);

        $user = User::create([
            'name'     => $request->fname . ' ' . $request->lname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guest',
            'guest_id' => $guest->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('guest.dashboard');
    }
}
