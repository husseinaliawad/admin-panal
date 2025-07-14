<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class RegisterPage extends Component
{

    public $name = '';
public $email = '';
public $password = '';


    public function save(){
        $this->validate([
            'name'=> 'required|max:255',
            'email'=> 'required|email|unique:users|max:255',
            'password'=>'required|min:6|max:255',
        ]);
// save to databais
        $user=User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>$this->password,
        ]);

        // login user
        auth()->login($user);

        // redirect to home page 
        return redirect()->intended('/');
    }
    public function render()
    {
        // dd($this->name, $this->email, $this->password);
        return view('livewire.auth.register-page');
    }
    
}
