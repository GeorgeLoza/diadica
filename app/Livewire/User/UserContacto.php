<?php

namespace App\Livewire\User;

use App\Models\Contacto_usuario;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class UserContacto extends Component
{
    public $userId;
    public $user;
    public $contactos = [];

    // Form fields
    public $contacto_id;
    public $nombre;
    public $cargo;
    public $telefono;
    public $direccion;
    public $correo;

    public $modo = 'crear'; // 'crear' o 'editar'

    #[On('contactos')]
    public function setContacto($id)
    {
        $this->userId = $id;
        $this->user = User::find($this->userId);
        $this->resetForm();
        $this->loadContactos();
        Flux::modal('modal-contacto')->show();
    }

    public function loadContactos()
    {
        $this->contactos = Contacto_usuario::where('usuario_id', $this->userId)->get();
    }

    public function resetForm()
    {
        $this->contacto_id = null;
        $this->nombre = '';
        $this->cargo = '';
        $this->telefono = '';
        $this->direccion = '';
        $this->correo = '';
        $this->modo = 'crear';
    }

    public function guardarContacto()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:255',
        ]);

        if ($this->modo === 'crear') {
            Contacto_usuario::create([
                'usuario_id' => $this->userId,
                'nombre' => $this->nombre,
                'cargo' => $this->cargo,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'correo' => $this->correo,
            ]);
        } else {
            $contacto = Contacto_usuario::where('usuario_id', $this->userId)
                ->where('id', $this->contacto_id)
                ->first();
            if ($contacto) {
                $contacto->update([
                    'nombre' => $this->nombre,
                    'cargo' => $this->cargo,
                    'telefono' => $this->telefono,
                    'direccion' => $this->direccion,
                    'correo' => $this->correo,
                ]);
            }
        }

        $this->resetForm();
        $this->loadContactos();
    }

    public function editarContacto($id)
    {
        $contacto = Contacto_usuario::where('usuario_id', $this->userId)
            ->where('id', $id)
            ->first();
        if ($contacto) {
            $this->contacto_id = $contacto->id;
            $this->nombre = $contacto->nombre ?? '';
            $this->cargo = $contacto->cargo ?? '';
            $this->telefono = $contacto->telefono ?? '';
            $this->direccion = $contacto->direccion ?? '';
            $this->correo = $contacto->correo ?? '';
            $this->modo = 'editar';
        }
    }
    public function eliminarContacto($id)
    {
        $contacto = Contacto_usuario::where('usuario_id', $this->userId)
            ->where('id', $id)
            ->first();
        if ($contacto) {
            $contacto->delete();
            $this->loadContactos();
        }
    }
    public function render()
    {
        return view('livewire.user.user-contacto');
    }
}
