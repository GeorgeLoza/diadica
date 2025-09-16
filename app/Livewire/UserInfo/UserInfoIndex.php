<?php

namespace App\Livewire\UserInfo;

use Livewire\Component;

class UserInfoIndex extends Component
{
    public $id;
    public $usuario;

    public $search = '';
    
    public function mount($id)
    {
        $this->id = $id;
        $this->usuario = auth()->user()->find($id);
    }
    public function render()
    {
        return view('livewire.user-info.user-info-index');
    }
}
