<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\preguntas_sin_respuestas as PregSugeridas;
use Livewire\WithPagination;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class IndexPregSugeridas extends Component
{
    public $orden, $cant_pagina;
	use WithPagination;

    public function render()
    {
        if($this->orden == "antiguo"){
            return view('livewire.index-preg-sugeridas', [
            'PregSugeridas' => PregSugeridas::orderBy('id', 'asc')->paginate($this->cant_pagina),
            ]);
        }
        else{
            return view('livewire.index-preg-sugeridas', [
            'PregSugeridas' => PregSugeridas::orderBy('id', 'desc')->paginate($this->cant_pagina),
            ]);
        }
    }

    public function mount()
    {
        $this->orden = "nuevo";
        $this->cant_pagina = 10;
    }

    public function delete($id)
    {
        PregSugeridas::find($id)->delete();
        session()->flash('message', 'Sugerencia eliminada del sistema.');
    }
}
