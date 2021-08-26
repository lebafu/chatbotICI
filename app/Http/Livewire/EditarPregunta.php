<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Http\Livewire\Answers;
use App\Models\Question as Preguntas;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use DB;

class EditarPregunta extends Component
{
	public $selected_id, $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea, $contexto,$pregunta_copy;
    //public $pregunta=[];
    public $inputs = [];
    public $i = 0;
    public $archivoPreg;

    public function render()
    {
        return view('livewire.editar-pregunta');
    }

    public function mount()
    {
    	$pregeditar = ArchivoPregunta::findOrFail($this->archivoPreg->id);
        $preguntas =DB::table('questions')->where('id_answers','=',$this->id)->select('pregunta')->get();
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

        
        //dd($this->inputs,$i,$this->inputs[$i],$this,$this->pregunta_copy[$i+1],$question);

        //$question=DB::table('questions')->where('pregunta','=',$this_pregunta[$i+1])->first();
        
        unset($this->inputs[$i]);
        if(array_key_exists($i+1,$this->pregunta)){
        DB::table('questions')->where('pregunta','=',$this->pregunta_copy[$i+1])->delete();
        
        session()->flash('message_delete', 'Se ha eliminado Input Correctamente');
        }

    }

    public function resetInput()
    {
        $this->resp = null;
        $this->vence = null;
        $this->fecha_caducacion = null;
        $this->archivo_qna = null;
        $this->habilitada = null;
        $this->pregunta = null;
        $this->pregunta_copy=null;
        $this->id_foranea = null;
    }

    public function edit($id)
    {
    	//dd($id);
        $pregeditar = ArchivoPregunta::findOrFail($id);
        //dd($preguntas);
        $preguntas=DB::table('questions')->where('id_answers','=',$id)->select('pregunta')->get();
        //$this->pregunta=$pregunta->nombre;
        $cantidad_preguntas=DB::table('questions')->where('id_answers','=',$id)->count();
        //array_push($this->pregunta,1);
        //$this->pregunta=array();
        //dd($this->pregunta,$preguntas);
        $pregunta=array();
        for($i=0;$i<$cantidad_preguntas;$i++){
            array_push($pregunta,$preguntas[$i]->pregunta);
            
        }
        //dd($pregunta);
        $this->pregunta=$pregunta;
        $this->pregunta_copy=$pregunta;
        //dd($this->pregunta,$this->pregunta_copy);
        //dd($this->preguntas,$cantidad_preguntas);
        //$this->pregunta[$i]->pregunta
        //dd($pregeditar,$this->pregunta[0]->pregunta);
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
            $cantidad_preguntas_anterior=count($this->pregunta_copy);
            $cantidad_preguntas_nueva=count($this->pregunta);
            dd($this->pregunta,$this->pregunta_copy,$cantidad_preguntas_nueva,$cantidad_preguntas_anterior);
            if($cantidad_preguntas_anterior<$cantidad_pregunta_nueva){
            $i=0;
             foreach($this->pregunta_copy as $pregunta_actual){
                DB::table('questions')->where('pregunta','=',$pregunta_actual)->update(['pregunta'=> $this->pregunta[$i]]);
                $i=$i+1;
                //dd($pregunta_actual);
            }
                    while($i<$cantidad_preguntas_nueva){
                        DB::table('questions')->insert([
                            'pregunta' => $this->pregunta[$i],
                            'id_answers' => $this->selected_id
                     ]);
                $i=$i+1;
                    }
            }elseif($cantidad_preguntas_anterior==$cantidad_pregunta_nueva){
                    $i=0;
             foreach($this->pregunta_copy as $pregunta_actual){
                DB::table('questions')->where('pregunta','=',$pregunta_actual)->update(['pregunta'=> $this->pregunta[$i]]);
                $i=$i+1;
                //dd($pregunta_actual);
                }
            }
            //dd($pregeditar,$this);
            $pregeditar->update([
                'nombre' => $this->resp,
                'vence' => $this->vence,
                'fecha_caducacion' => $this->fecha_caducacion,
            ]);


            session()->flash('message', 'Pregunta actualizada correctamente');
        }
    }


}
