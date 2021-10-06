<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Bienvenida extends Component
{
    public function render()
    {



		$actual = Carbon::now();
		$limite = $actual->subDays(90); 
        return view('livewire.bienvenida')->with('limite', $limite);
    }
}
