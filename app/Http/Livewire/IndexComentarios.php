<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\comentarios_y_sugerencias as Comentarios;
use Livewire\WithPagination;

class IndexComentarios extends Component
{
    public $filtro='todos';
    use WithPagination;
	
    public function render()
    {
        if ($this->filtro == "todos"){
            return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::orderBy('created_at', 'desc')->paginate(9)
            ]);
        }
        else{
            return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::orderBy('created_at', 'desc')->paginate(2)
            ]);
        }
    }

    public function delete($id)
    {
        Comentarios::find($id)->delete();
        session()->flash('message', 'Comentario eliminado del sistema.');
    }
}

