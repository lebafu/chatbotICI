<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers;
use App\Models\comentarios_y_sugerencias as Comentarios;
use App\Models\preguntas_sin_respuestas as Sugerencias;
use Carbon\Carbon;

class Bienvenida extends Component
{
    public function render()
    {
		$limite = Carbon::now()->subDays(90);
		$activas = Answers::where('habilitada',1)->count();
		$inactivas = Answers::where('habilitada',0)->count();
		$sietedias = Carbon::now()->addDays(7);
		$finalizan = Answers::where('fecha_caducacion', '>=', 'Carbon::now()')->where('fecha_caducacion', '<=', $sietedias)->count();	
		$comentarios = Comentarios::all()->count();
		$ult_comentario = Comentarios::orderBy('id', 'DESC')->first(); 
		$sugeridas = Sugerencias::all()->count();
		$ult_sugerida = Sugerencias::orderBy('id', 'DESC')->first();
		//dd($ult_sugerida);
        return view('livewire.bienvenida',['limite' => $limite, 'activas' => $activas, 'inactivas' => $inactivas, 'finalizan' => $finalizan, 'comentarios' => $comentarios, 'ult_comentario' => $ult_comentario, 'sugeridas' => $sugeridas, 'ult_sugerida' => $ult_sugerida]);
    }
}
