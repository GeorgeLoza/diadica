<?php

namespace App\Livewire\User;

use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class UserEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $rol;
    public $estado;
    public $password;
    public $empresa;
    public $razon_social;
    public $nit;

    #[On('userEdit')]
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->rol = $user->rol;
        $this->estado = $user->estado;
        $this->password = '';
        $this->empresa = $user->empresa;
        $this->razon_social = $user->razon_social;
        $this->nit = $user->nit;

        Flux::modal('edit-user')->show();
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'rol' => 'requir    ed|string|max:50',
            'estado' => 'required|string|max:50',
            'password' => 'nullable|string|min:6',
            'empresa' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'nit' => 'required|string|max:255',
        ]);

        try {
            $user = User::findOrFail($this->userId);
            $user->name = $this->name;
            $user->email = $this->email;
            $user->rol = $this->rol;
            $user->estado = $this->estado;
            if ($this->password) {
                $user->password = bcrypt($this->password);
            }
            $user->empresa = $this->empresa;
            $user->razon_social = $this->razon_social;
            $user->nit = $this->nit;
            $user->save();

            Flux::modal('edit-user')->close();
            session()->flash('success', 'Usuario actualizado exitosamente.');
            $this->reset();
            $this->redirectRoute('user.index', navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar el usuario: ' . $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.user.user-edit');
    }
}
