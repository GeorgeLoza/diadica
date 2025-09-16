<?php

namespace App\Livewire\User;

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserCreate extends Component
{
    //varaibles
    public $name;
    public $email;
    public $rol;
    public $estado;
    public $password;
    public $empresa;
    public $razon_social;
    public $nit;

    //rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'rol' => 'required|string|max:50',
        'estado' => 'required|string|max:50',
        'password' => 'required|string',
        'empresa' => 'required|string|max:255',
        'razon_social' => 'required|string|max:255',
        'nit' => 'required|string|max:255',
    ];

    public function createUser()
    {
        try {
            $this->validate();

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'rol' => $this->rol,
                'estado' => $this->estado,
                'password' => Hash::make($this->password),
                'empresa' => $this->empresa,
                'razon_social' => $this->razon_social,
                'nit' => $this->nit,
            ]);
            Flux::modal('default')->close('crear-usuario');
            $this->reset();
            session()->flash('success', 'Usuario creado exitosamente.');
            $this->redirectRoute('user.index', navigate: true);
        } catch (\Throwable $th) {
            // Handle the exception, log it or show an error message
            session()->flash('error', 'Error al crear el usuario: ' . $th->getMessage());
            Flux::modal('default')->close('crear-usuario');
            $this->reset();
            $this->redirectRoute('user.index', navigate: true);
        }
    }
    public function render()
    {
        return view('livewire.user.user-create');
    }
}
