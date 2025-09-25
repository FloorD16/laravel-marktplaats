<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function register() {
        return view('users.register');
    }

    public function store(StoreUserRequest $request) {
        $validated = $request->validated();

        $user = new User();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

        $user->save();

        Mail::raw("Welkom {$user->name}, bedankt voor je registratie!", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Bevestiging van registratie');
            $message->from('noreply@example.com', 'Laravel-marktplaats');
        });
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('login');
        }

        return back()->withErrors([
            'email' => 'De combinatie gebruikersnaam en wachtwoord is niet correct.'
        ])->onlyInput('email');
    }

    public function login() 
    {
        
        return view('users.login');
    }

    public function sendResetLink(Request $request) 
    {
        dd('hello');
        $request->validate(['email' => 'required|email']);
        
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT 
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
