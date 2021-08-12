<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use Livewire\WithPagination;

class IndexPreguntas extends Component
{
	use WithPagination;

    public function render()
    {
        return view('livewire.index-preguntas', [
            'archivoPregs' => ArchivoPregunta::orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }

    public function deshabilitar($id)
    {
    //    Comentarios::find($id)->delete();
    //    session()->flash('message', 'Comentario eliminado del sistema.');
    }
}
