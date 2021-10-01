<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\comentarios_y_sugerencias as Comentarios;


class CrearComentario extends Component
{
	public $nombre, $email, $tipo, $comentarios_y_sugerencias;

    public function render()
    {
        return view('livewire.crear-comentario');
    }

    public function mount()
    {
      $this->tipo = "neutral";
    }

    public function resetInput()
    {
        $this->nombre = null;
        $this->email = null;
        $this->tipo = null;
        $this->comentarios_y_sugerencias = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:2',
            'email' => 'required|email:rfc,dns',
            'tipo' => 'required',
            'comentarios_y_sugerencias' => 'required|min:5|max:250'
        ],
        [
            'email.email' => 'Debes ingresar un email válido',
        ]);
        Comentarios::create([
            'nombre' => $this->nombre,
            'email' => $this->email,
            'tipo' => $this->tipo,
            'comentarios_y_sugerencias' => $this->comentarios_y_sugerencias,
        ]);
        $this->resetInput();
        session()->flash('message', 'Su comentario ha sido enviado exitosamente');
    }
}