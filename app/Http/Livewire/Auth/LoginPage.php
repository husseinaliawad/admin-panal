<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class LoginPage extends Component
{


    public $email = '';
    public $password = '';
    
    public function save(){
        // dd('Login wurde aufgerufen', $this->email, $this->password);
        $this->email = trim($this->email); // <--- DAS HINZUFÜGEN!
        $this->validate([
            'email'=> 'required|email|max:255|exists:users,email',
            'password'=>'required|min:6|max:255',
        ]);

        if(!auth()->attempt(['email'=>$this->email, 'password' => $this->password])){
            session()->flash('error','Invalid credentials');
            return;
        }
        return redirect()->intended();

       
    }


    
      
        
    
    
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
