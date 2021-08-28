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
	public $selected_id, $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea,$contexto,$pregunta_copy,$es_archivo_flow,$name_image,$nombre,$textos,$tam_array_builtins_texts_unique,$builtins_texts_index_unique,$tam_array_todo,$todo_ordenado,$pos, $nombre_imagen,$nombres_imagenes;
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
        //dd($pregeditar->archivo_qna);
        $path_archivo=public_path("botpress12120/data/bots/icibot/qna/".$pregeditar->archivo_qna.".json");
        //dd($path_archivo);
             $leer = fopen($path_archivo, 'r+');
      $numlinea=0;
      while ($linea = fgets($leer)){
        //echo $linea.'<br/>';
           if($numlinea==5){
            //dd($linea);
              $this->contexto=substr($linea,7,-2);
           }    
             $numlinea++;
        }

        //dd($this->contexto);
        $this->nombre=$pregeditar->nombre;
        $this->pos=strpos($this->nombre,"builtin_image");
        //dd($this->pos);
        if($this->pos==false){
          $this->pos=0;
        }else{
          $this->pos=1;
        }
        $qnas_images=DB::table('qnas_images')->where('id_answer','=',$pregeditar->id)->get();
        //dd($datos,$answers,$nombre,$qnas_images);
        foreach($qnas_images as $qna_image);
         //dd($qna_image);
        //dd($this->pos);

        if($qnas_images->isEmpty()){
          $name_image=null;
        }else{
            $this->name_image=$qna_image->nombre_imagen_qna;
        }
        //return view('qna.edit',compact('question','answer','pos','name_image'));
       
        //Busco si existe el arrchivo .flow.json sacado de la base de datos, si es que no existen respuestas a cierta pregunta,
        //seguirá abriendo el archivo .flow.json buscando los builtin_text y builtin_image del archivo para mostrarlos por pantalla
        //sino encuentra el termino flow.json en la tabla answer campo nombre, entonces mostrará el archivo tiene las tipicas respuestas directas.
        $this->es_archivo_flow=strpos($pregeditar->nombre,"flow.json");
        //dd($datos,$questions,$answer,$this->pos,$name_image,$es_archivo_flow);
        if($this->es_archivo_flow==false){
           //Les paso los elementos de las consultas a la vista.
          //dd($question,$answer);
          //dd($es_archivo_flow);
          //dd($question,$answer,$this->pos,$name_image,$es_archivo_flow,$id_primero);
           //return view('qna.edit',compact('question','answer','pos','name_image','es_archivo_flow','contexto','id_primero'));
        }else{
             $path_archivo=public_path("botpress12120/data/bots/icibot/flows/".$pregeditar->nombre);
          $leer = fopen($path_archivo, 'r+');
      $numlinea=0;
      while ($linea = fgets($leer)){
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        $i=0;
        //$encuentra_builtins=array();

        $builtins=array(); //arreglo para guardar todos los builtin image y text en el archivo
        $todo=array(); //Se almacenará los builtin_image y builtin_text con sus respectivos codigos y ruta de imagen si es que corresponde
        $builtins_images=array(); //Se guardan los builtin_images
        $links_imagenes=array(); //Se almacenan los links o rutas de las imagenes
        $builtins_texts=array();  //Se almacenan los builtin_text
        $this->nombre_imagen=array(); //Se guardan los nombres de las imagenes.
        $this->textos=array();
       $i=0;
       //Recorremos el archivo linea por linea buscando los nombres de las imagenes.
         while($i<$numlinea){
          $encuentra_nombre_imagen=strpos($aux[$i],'condition": "temp['); //En esta linea con este string sabremos que es el nombre de la imagen que se guarda aqui, en esta linea
        
        if($encuentra_nombre_imagen!=false){;
           array_push($this->nombre_imagen,substr($aux[$i],65,-5));  //se recorta la linea encontrada y se almacena el nombre de las imagenes
           //dd($path_archivo,$aux,$aux[$i],$encuentra_builtins,$builtins,$encuentra_nombre_imagen);
        }

        $i=$i+1;
        }
        $i=0;
        $j=0;
        //Se recorre el archivo linea por linea buscando los builtin_text  y builtin_image 
        while($i<$numlinea){
          $encuentra_builtins=strpos($aux[$i],"builtin");
          $encuentra_builtin_image=strpos($aux[$i],"builtin_image");
          $encuentra_builtin_text=strpos($aux[$i],"builtin_text");
          if($encuentra_builtins!=false){
          //dd($path_archivo,$aux,$builtins);
        if($encuentra_builtin_image!=false){
                    array_push($builtins,substr($aux[$i],$encuentra_builtins,-3));
                    array_push($builtins_images,substr($aux[$i],$encuentra_builtin_image,-3));

        }if($encuentra_builtin_text!=false){
            //dd($this->nombre_imagen);
                    array_push($this->nombre_imagen, null);
                    array_push($builtins,substr($aux[$i],$encuentra_builtins,-2));
                    array_push($builtins_texts,substr($aux[$i],$encuentra_builtin_text,-2));

        }
      }
                $i=$i+1;
        }
        fclose($leer);
        $builtins_texts_unique=array_unique($builtins_texts);
        $builtins_texts=array();
        $i=0;
        foreach($builtins_texts_unique as $builtin_text)
        {
          $builtins_texts[$i]=$builtin_text;
          $i=$i+1;
        }
        //dd($builtins_texts);
        $i=0;
        //dd($path_archivo,$aux,$encuentra_builtins,$builtins);
        //dd($builtins);
        $k=0;
        $path_archivo_image=public_path("botpress12120/data/bots/icibot/content-elements/builtin_image.json");
        $leer_image = fopen($path_archivo_image, 'r+');
        $numlinea=0;

        while ($linea = fgets($leer_image)){
        //echo $linea.'<br/>';
            $aux_image[] = $linea;    
             $numlinea++;
        }
          $j=0;
        $tam_array=count($builtins_images);
        $i=0;
        //dd($i,$numlinea);
        //Se procede a recorrer el archivo builtin_image linea por linea buscando mediante el codigo builtin_image-codigo la ruta de la imagen.
        while($i<$numlinea){
          $j=0;
          while($j<$tam_array){
          $encuentra_builtin_image=strpos($aux_image[$i],$builtins_images[$j]);
            //dd($encuentra_builtin_image,$aux_image[$i+3]);
          if($encuentra_builtin_image!=false){
          $encuentra_coma=strpos($aux_image[$i+3],",");
          if($encuentra_coma!=false){
            //dd($encuentra_coma,(substr($aux_image[$i+3])));
          array_push($links_imagenes,substr($aux_image[$i+3],57,-3));
          array_push($todo,$builtins_images[$j],"builtin_image",substr($aux_image[$i+3],45,-3));
          }else{
            //dd($encuentra_coma,(substr($aux_image[$i+3])));
            array_push($links_imagenes,substr($aux_image[$i+3],57,-2));
            array_push($todo,$builtins_images[$j],"builtin_image",substr($aux_image[$i+3],45,-2));
          }
                    //dd($path_archivo,$aux,$builtins,$todo);
        }

        $j=$j+1;
        }
        $i=$i+1;
        }

         fclose($leer_image);
        $cantidad_imagenes=count($links_imagenes);
        //dd($links_imagenes,$cantidad_imagenes);
        //dd($path_archivo,$aux,$encuentra_builtins,$builtins,$builtins_images,$builtins_texts,$path_archivo_image,$aux_image,$links_imagenes,$numlinea);
            //Se procede a recorrer el archivo builtin_text linea por linea buscando mediante el codigo builtin_text-codigo el respectivo texto de ese codigo.

        $path_archivo_text=public_path("botpress12120/data/bots/icibot/content-elements/builtin_text.json");
        $leer_text= fopen($path_archivo_text, 'r+');
        $numlinea=0;
        while ($linea = fgets($leer_text)){
        //echo $linea.'<br/>';
            $aux_text[] = $linea;    
             $numlinea++;
        }
        $j=0;
        $tam_array=count($builtins_texts);
        $i=0;
        //dd($i,$numlinea);
        while($i<$numlinea){
          $j=0;
          while($j<$tam_array){
          $encuentra_builtin_text=strpos($aux_text[$i],$builtins_texts[$j]);
            //dd($encuentra_builtin_image,$aux_image[$i+3]);
          if($encuentra_builtin_text!=false){
          $encuentra_coma=strpos($aux_text[$i+4],",");
          //$encuentra_coma1=strpos($aux_text[$i+5],",");
          if($encuentra_coma!=false){
            //dd($encuentra_coma,(substr($aux_image[$i+3])));
          array_push($this->textos,substr($aux_text[$i+4],18,-3));
          array_push($todo,$builtins_texts[$j],"builtin_text",substr($aux_text[$i+4],18,-3));
          }else{
            array_push($this->textos,substr($aux_text[$i+4],18,-3));
            array_push($todo,$builtins_texts[$j],"builtin_text",substr($aux_text[$i+4],18,-3));

            //array_push($todo,substr($aux_image[$i+4],18,-2));
          }
                    //dd($path_archivo,$aux,$builtins);
        }
        $j=$j+1;
        }
        $i=$i+1;
        }

          fclose($leer_text);
        $builtins=array_reverse($builtins);
          //dd($todo,$builtins);
         $builtins_unique=array_unique($builtins);
         $builtins=array();
         $i=0;
        foreach($builtins_unique as  $builtin){
          $builtins[$i]=$builtin;
          $i=$i+1;
        }
        //dd($todo,$builtins);
        //dd($textos);
        //Se ordena de acuerdo al builtin de acuerdo a como muestra los mensajes el chatbot, de mannera ordenada, texto imagen respectiva.
       $this->todo_ordenado=array();
        $tam_array_builtins=count($builtins);
        $this->tam_array_todo=count($todo);
        for($i=0;$i<$tam_array_builtins;$i=$i+1){
          //dd($todo);
          for($j=0;$j<$this->tam_array_todo;$j=$j+3){
            if($builtins[$i]==$todo[$j]){
              array_push($this->todo_ordenado,$todo[$j],$todo[$j+1],$todo[$j+2]);
              break;
            }
          }
        }

         //dd($todo,$this->todo_ordenado);
        //if($this->todo_ordenado[2]=="builtin_text"){
        //A pesar de  que nombre imagen posee un tamaño mucho menor que todo_ordenado, se agrandará el tamañao de $this->nombres_imagenes llenandolo de null, y colocando en ciertas posiciones los nobres de las imagenes para usar la misma variable en el conntador de la vista.
        $this->nombres_imagenes=array();
        $j=$this->tam_array_todo-1;
        //dd($j);
        $i=0;
        while($j>=0){

          if(strpos($this->todo_ordenado[$j],".jpg")!=false or strpos($this->todo_ordenado[$j],".png")!=false){
            array_push($this->nombres_imagenes,$this->nombre_imagen[$i]);
             $i=$i+1;
          }else{
            array_push($this->nombres_imagenes,null);
          }
          $j=$j-1;
         /* if($j==0){
            dd($this->nombres_imagenes,$this->tam_array_todo,$this->todo_ordenado);
          }*/
        }
        $this->nombres_imagenes=array_reverse($this->nombres_imagenes); 
          //dd($this->nombres_imagenes,$this->tam_array_todo,$this->todo_ordenado);

        $builtins_texts_unico=array_unique($builtins_texts);
        $this->tam_array_builtins_texts_unique=count($builtins_texts_unico);

        $i=0;
        $this->builtins_texts_index_unique=array();
        foreach($builtins_texts as $builtins_texts_unique){
          //dd($builtins_texts_unique,$builtins_texts);
          $this->builtins_texts_index_unique[$i]=$builtins_texts_unique;
          $i=$i+1;
        }
       //dd($aux_text,$builtins,$this->builtins_texts_index_unique,$this->tam_array_builtins_texts_unique,$builtins_images,$path_archivo,$textos,$todo,$es_archivo_flow,$this->tam_array_todo,$this->todo_ordenado,$this->nombre_imagen,$j,$this->nombres_imagenes,$this->nombre_imagen);
        //}
        //dd($path_archivo,$aux,$builtins);
        //}
        //dd($this->textos);
        $textos_sin_repetir=array_unique($this->textos);
        $tam_array_textos_unicos=count($textos_sin_repetir);
        $i=0;
        $textos_unicos_index_orden=array();
        foreach($textos_sin_repetir as $textos_sin_repetir_unico){
          //dd($builtins_texts_unique,$builtins_texts);
          $textos_unicos_index_orden[$i]=$textos_sin_repetir_unico;
          $i=$i+1;
       }
        }
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
        //$this->contexto = $pregeditar->contexto;

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
