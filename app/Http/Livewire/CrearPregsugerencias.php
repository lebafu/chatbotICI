<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\preguntas_sin_respuestas as Preguntas;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class CrearPregsugerencias extends Component
{
	public $nombre, $email, $pregunta_sin_respuesta;
    public $inputs = [];
    public $i = 1;

    public function render()
    {
        return view('livewire.crear-pregsugerencias');
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function max()
    {
        session()->flash('warning', 'Has alcanzado el limite de preguntas');
    }

    public function resetInput()
    {
        $this->nombre = null;
        $this->email = null;
        $this->pregunta_sin_respuesta = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:2',
            'email' => 'required|email:rfc,dns',
            'pregunta_sin_respuesta.0' => 'required|min:0|max:100',
            'pregunta_sin_respuesta.*' => 'required|min:0|max:100',
        ],
        [
            'email.email' => 'Debes ingresar un email válido',
            'pregunta_sin_respuesta.0.required' => 'No puedes ingresar preguntas en blanco',
            'pregunta_sin_respuesta.*.required' => 'No puedes ingresar preguntas en blanco'

        ]);

        foreach ($this->pregunta_sin_respuesta as $key => $value) {
            Preguntas::create(['nombre' => $this->nombre, 'email' => $this->email, 'pregunta_sin_respuesta' => $this->pregunta_sin_respuesta[$key]]);
        }

        $this->inputs = [];
        $this->resetInput();
        session()->flash('message', 'Sus preguntas han sido enviadas exitosamente');
    }
}