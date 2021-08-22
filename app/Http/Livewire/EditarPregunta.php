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
	public $selected_id, $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea, $contexto;
    public $inputs = [];
    public $i = 1;
    public $archivoPreg;

    public function render()
    {
        return view('livewire.editar-pregunta');
    }

    public function mount()
    {
    	$pregeditar = ArchivoPregunta::findOrFail($this->archivoPreg->id);
    	$this->edit($pregeditar->id);
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
    	//dd($id);
        $pregeditar = ArchivoPregunta::findOrFail($id);
    //    dd($pregeditar);
        $this->selected_id = $id;
        $this->resp = $pregeditar->nombre;
        $this->vence = $pregeditar->vence;
        $this->fecha_caducacion = $pregeditar->fecha_caducacion;
        $this->contexto = $pregeditar->contexto;
    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
        ]);
        if ($this->selected_id) {
            $pregeditar = ArchivoPregunta::find($this->selected_id);
            $pregeditar->update([
                'nombre' => $this->resp,
                'vence' => $this->vence,
                'fecha_caducacion' => $this->fecha_caducacion,
            ]);
            session()->flash('message', 'Pregunta actualizada correctamente');
        }
    }


}
