<?php

namespace App\Livewire\User;

use App\Models\Ubicaciones_usuario;
use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class UserUbicacion extends Component
{
    public $userId;
    public $user;
    public $ubicaciones = [];

    // Form fields
    public $ubicacion_id;
    public $nombre;
    public $observaciones;
    public $url_map;
    public $persona_referencia;

    public $modo = 'crear'; // 'crear' o 'editar'

    #[On('userUbicacion')]
    public function setUbicacion($id)
    {
        $this->userId = $id;
        $this->user = User::find($this->userId);
        $this->resetForm();
        $this->loadUbicaciones();
        Flux::modal('modal-ubicacion')->show();
    }

    public function loadUbicaciones()
    {
        $this->ubicaciones = Ubicaciones_usuario::where('usuario_id', $this->userId)->get();
    }

    public function resetForm()
    {
        $this->ubicacion_id = null;
        $this->nombre = '';
        $this->observaciones = '';
        $this->url_map = '';
        $this->persona_referencia = '';
        $this->modo = 'crear';
    }

    public function guardarUbicacion()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'url_map' => 'nullable|string|max:255',
            'persona_referencia' => 'nullable|string|max:255',
        ]);

        if ($this->modo === 'crear') {
            Ubicaciones_usuario::create([
                'usuario_id' => $this->userId,
                'nombre' => $this->nombre,
                'observaciones' => $this->observaciones,
                'url_map' => $this->url_map,
                'persona_referencia' => $this->persona_referencia,
            ]);
        } else {
            $ubicacion = Ubicaciones_usuario::where('usuario_id', $this->userId)
                ->where('id', $this->ubicacion_id)
                ->first();
            if ($ubicacion) {
                $ubicacion->update([
                    'nombre' => $this->nombre,
                    'observaciones' => $this->observaciones,
                    'url_map' => $this->url_map,
                    'persona_referencia' => $this->persona_referencia,
                ]);
            }
        }

        $this->resetForm();
        $this->loadUbicaciones();
    }

    public function editarUbicacion($id)
    {
        $ubicacion = Ubicaciones_usuario::where('usuario_id', $this->userId)
            ->where('id', $id)
            ->first();
        if ($ubicacion) {
            $this->ubicacion_id = $ubicacion->id;
            $this->nombre = $ubicacion->nombre ?? '';
            $this->observaciones = $ubicacion->observaciones ?? '';
            $this->url_map = $ubicacion->url_map ?? '';
            $this->persona_referencia = $ubicacion->persona_referencia ?? '';
            $this->modo = 'editar';
        }
    }

    public function eliminarUbicacion($id)
    {
        $ubicacion = Ubicaciones_usuario::where('usuario_id', $this->userId)
            ->where('id', $id)
            ->first();
        if ($ubicacion) {
            $ubicacion->delete();
            $this->loadUbicaciones();
        }
    }

    public function render()
    {
        return view('livewire.user.user-ubicacion');
    }
}
