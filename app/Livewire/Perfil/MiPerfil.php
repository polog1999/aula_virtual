<?php

namespace App\Livewire\Perfil;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MiPerfil extends Component
{
    public $user;
    public $isModalOpen = false;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.perfil.mi-perfil');
    }
}