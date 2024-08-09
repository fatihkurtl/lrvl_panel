<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerRegisterForm extends Component
{
    public $first_name, $last_name, $email, $password, $password_confirmation, $phone;

    public function submit()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'phone' => 'required|string|regex:/[0-9]{3}-[0-9]{3}-[0-9]{4}/|unique:customers,phone',
        ]);

        Customer::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'Registration successful.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.register');
    }
}
