<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\comentarios_y_sugerencias as Comentarios;
use Livewire\WithPagination;

class IndexComentarios extends Component
{
    public $filtro, $orden, $cant_pagina;
    use WithPagination;
	
    public function render()
    {
        if ($this->filtro == "todos"){
            if($this->orden == "nuevo"){
                return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::orderBy('created_at', 'desc')->paginate($this->cant_pagina)
            ]);
            }
            else if($this->orden == "antiguo"){
                return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::orderBy('created_at', 'asc')->paginate($this->cant_pagina)
            ]);
            }
            else{
                return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::orderBy('nombre', 'asc')->paginate($this->cant_pagina)
            ]);
            }            
        }
        else{
            if($this->orden == "nuevo"){
                return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::where('tipo',$this->filtro)->orderBy('created_at', 'desc')->paginate($this->cant_pagina)
            ]);
            }
            else if($this->orden == "antiguo"){
                return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::where('tipo',$this->filtro)->orderBy('created_at', 'asc')->paginate($this->cant_pagina)
            ]);
            }
            else{
                return view('livewire.index-comentarios', [
                'comentarios' => Comentarios::where('tipo',$this->filtro)->orderBy('nombre', 'asc')->paginate($this->cant_pagina)
            ]);
            } 
        }
    }

    public function mount(){
        $this->filtro='todos';
        $this->orden='nuevo';
        $this->cant_pagina=9;
    }

    public function delete($id)
    {
        Comentarios::find($id)->delete();
        session()->flash('message', 'Comentario eliminado del sistema.');
    }
}

