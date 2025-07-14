<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordPage extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;
    // public $successMessage = null;
    // public $errorMessage = null;

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }
    
    public function save()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);
    
        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
    
        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Password has been reset. You can now login.');
            return redirect('/login');
        } else {
            session()->flash('error', __($status));
        }
    }
    

   

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}

