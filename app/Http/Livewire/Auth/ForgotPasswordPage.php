<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPasswordPage extends Component
{
    public $email;
    public $successMessage = null;
    public $errorMessage = null;

    public function save()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        // Versuche, den Reset-Link zu senden
        $status = Password::sendResetLink([
            'email' => $this->email
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            // $this->successMessage = 'Wir haben dir einen Link zum Zurücksetzen des Passworts geschickt!';
            // $this->errorMessage = null;
            session()->flash('success','Password reset link has been sent to your email address');
            $this->email='';
        }
        //  else {
            // $this->errorMessage = 'Diese E-Mail-Adresse wurde nicht gefunden.';
            // $this->successMessage = null;
        // }
    }

    public function render()
    {
        return view('livewire.auth.forgot-page');
    }
}
