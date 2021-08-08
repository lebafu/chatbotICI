<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\comentarios_y_sugerencias as Comentarios;
//use App\comentarios_y_sugerencias as Comentarios;

class CrearComentario extends Component
{
	public $nombre, $email, $comentarios_y_sugerencias;

    public function render()
    {
        return view('livewire.crear-comentario');
    }

    public function resetInput()
    {
        $this->nombre = null;
        $this->email = null;
        $this->comentarios_y_sugerencias = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:2',
            'email' => 'required|email:rfc,dns',
            'comentarios_y_sugerencias' => 'required|min:5|max:250'
        ]);
        Comentarios::create([
            'nombre' => $this->nombre,
            'email' => $this->email,
            'comentarios_y_sugerencias' => $this->comentarios_y_sugerencias,
        ]);
        $this->resetInput();
    }
}