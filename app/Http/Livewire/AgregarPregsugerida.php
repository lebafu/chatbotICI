<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\preguntas_sin_respuestas as PregSugeridas;
use App\Models\Answers as ArchivoPregunta;
use App\Models\Question as Preguntas;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class AgregarPregsugerida extends Component
{
	public $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea, $contexto;
	public $inputs = [];
    public $i = 1;
	public $PregSugerida;

    public function render()
    {
    	$this->pregunta[0] = $this->PregSugerida->pregunta_sin_respuesta;
        return view('livewire.agregar-pregsugerida');
    }

    public function delete($id)
    {
        PregSugeridas::find($id)->delete();
        session()->flash('message', 'Sugerencia eliminada del sistema.');
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
        $this->resp = null;
        $this->vence = null;
        $this->fecha_caducacion = null;
        $this->archivo_qna = null;
        $this->habilitada = null;
        $this->pregunta = null;
        $this->id_foranea = null;
    }

   public function store($id)
    {
        $this->validate([
            'resp' => 'required|min:2',
            'pregunta.0' => 'required|min:1|max:100',
            'pregunta.*' => 'required|min:1|max:100',
        ],
        [
            'resp.required' => 'Debes ingresar una respuesta',
            'pregunta.0.required' => 'No puedes ingresar preguntas en blanco',
            'pregunta.*.required' => 'No puedes ingresar preguntas en blanco'
        ]);

        if ($this->vence != 1){
            $this->vence = 0;
        }

       $registro = ArchivoPregunta::create(['nombre' => $this->resp, 'vence' => $this->vence, 'fecha_caducacion' => $this->fecha_caducacion, 'archivo_qna' => 'prueba', 'habilitada' => 1 ]);

        foreach ($this->pregunta as $key => $value) {
            Preguntas::create(['pregunta' => $this->pregunta[$key], 'id_answers' => $registro->id ]);
        }
        $this->inputs = [];
        $this->resetInput();
        $this->delete($id);
        session()->flash('message', 'Pregunta sugerida ingresada en el sistema');
        return redirect()->route('index_preguntas_sugeridas');
    }
}