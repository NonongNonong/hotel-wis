<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'mobile_num' => ['nullable', 'string', 'max:20', 'unique:guests,mobile_num'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {
            // If admin already created a guest record for this email, link to it
            $guest = Guest::where('email_add', $request->email)->first();

            if ($guest) {
                // Update name fields if blank
                $guest->update([
                    'fname'      => $guest->fname ?: $request->fname,
                    'lname'      => $guest->lname ?: $request->lname,
                    'mobile_num' => $guest->mobile_num ?: ($request->mobile_num ?: null),
                ]);
            } else {
                $guest = Guest::create([
                    'fname'      => $request->fname,
                    'lname'      => $request->lname,
                    'email_add'  => $request->email,
                    'mobile_num' => $request->mobile_num ?: null,
                ]);
            }

            return User::create([
                'name'     => $request->fname . ' ' . $request->lname,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'guest',
                'guest_id' => $guest->id,
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('guest.dashboard');
    }
}
