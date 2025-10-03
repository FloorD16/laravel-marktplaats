<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Ad;
use App\Models\Message;
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
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['email_notifications'] = $request->has('email_notifications');

        $user = User::create($validated);

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

            return redirect()->route('dashboard');
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
        $request->validate(['email' => 'required|email']);
        
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT 
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm()
    {
        return view('users.resetform');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function dashboard()
    {
        $ads = Ad::where('user_id', Auth::id())->paginate(5);

        $messages = Message::with('sender')
            ->whereHas('ad', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('users.dashboard', compact('ads', 'messages'));
    }

    public function profile()
    {
        $user = User::find(Auth::id());

        return view('users.profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $user = User::find(Auth::id());

        if ($field === 'email_notifications') {
            $user->email_notifications = $value === 'on' ? true : false;
        } elseif (in_array($field, ['name', 'email', 'password'])) {
            $user->$field = $field === 'password' ? bcrypt($value) : $value;
        }

        $user->save();

        return redirect()->back();
    }
}
