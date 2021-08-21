<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\preguntas_sin_respuestas as PregSugeridas;
use Livewire\WithPagination;

class IndexPregSugeridas extends Component
{
	use WithPagination;

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
}
