<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\preguntas_sin_respuestas as PregSugeridas;
use App\Models\Answers as ArchivoPregunta;
use App\Models\Question as Preguntas;
use Livewire\WithPagination;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class IndexPregSugeridas extends Component
{
	use WithPagination;

    public $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea, $contexto;
    public $inputs = [];
    public $i = 1;

    public function render()
    {
        return view('livewire.index-preg-sugeridas', [
            'PregSugeridas' => PregSugeridas::orderBy('updated_at', 'desc')->paginate(10),
        ]);
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
        session()->flash('message', 'Se ha añadido la pregunta y su respuesta al sistema');    
    }
}
