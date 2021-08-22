<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Http\Livewire\Answers;
use App\Models\Question as Preguntas;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class EditarPregunta extends Component
{
	public $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea, $contexto;
    public $inputs = [];
    public $i = 1;
    public $archivoPreg;

    public function render()
    {
    	$pregeditar = ArchivoPregunta::findOrFail($this->archivoPreg->id);
     //   $this->id = $pregunta->id;
        $this->resp = $pregeditar->resp;
        $this->vence = $pregeditar->vence;
        $this->fecha_caducacion = $pregeditar->fecha_caducacion;
        $this->archivo_qna = $pregeditar->archivo_qna;
        $this->habilitada = $pregeditar->habilitada;
        $this->pregunta = $pregeditar->pregunta;
        $this->contexto = $pregeditar->contexto;
        $this->id_foranea = $pregeditar->id_foranea;
        return view('livewire.editar-pregunta');
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

    public function edit($id)
    {
        $pregunta = ArchivoPregunta::findOrFail($this->archivoPreg->$id);
        $this->id = $id;
        $this->resp = $pregunta->resp;
        $this->vence = $pregunta->vence;
        $this->fecha_caducacion = $pregunta->fecha_caducacion;
        $this->archivo_qna = $pregunta->archivo_qna;
        $this->habilitada = $pregunta->habilitada;
        $this->pregunta = $pregunta->pregunta;
        $this->contexto = $pregunta->contexto;
        $this->id_foranea = $pregunta->id_foranea;
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required|min:5',
            'email' => 'required|email:rfc,dns'
        ]);
        if ($this->selected_id) {
            $record = Contactos::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'email' => $this->email
            ]);
            $this->resetInput();
            $this->updateMode = false;
        }
    }


}
