<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class CrearPregunta extends Component
{
	public $nombre, $habilitada;
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
}
