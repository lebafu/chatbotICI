<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class CrearPregunta extends Component
{
	public $nombre, $vence, $fecha_caducacion, $archivo_qna, $habilitada;
    public $inputs = [];
    public $i = 1;

    public function render()
    {
        return view('livewire.crear-pregunta');
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function resetInput()
    {
        $this->nombre = null;
        $this->vence = null;
        $this->fecha_caducacion = null;
        $this->archivo_qna = null;
        $this->habilitada = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:2',
        ],
        [
            'nombre.required' => 'Debes ingresar una respuesta',

        ]);

        ArchivoPregunta::create(['nombre' => $this->nombre, 'vence' => 'no', 'fecha_caducacion' => null, 'archivo_qna' => 'blabla', 'habilitada' => 1 ]);

        $this->inputs = [];
        $this->resetInput();
        session()->flash('message', 'Se ha añadido la pregunta y su respuesta al sistema');
    }
}