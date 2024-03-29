<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Http\Livewire\Answers;
use App\Models\Question as Preguntas;
use App\Models\Categorias;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use DB;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use File;
use Carbon\Carbon;

class EditarPregunta extends Component
{
 use WithFileUploads;

  public $selected_id, $resp, $vence, $fecha_caducacion, $archivo_qna, $habilitada, $pregunta, $id_foranea, $id_categoria, $nueva_cat, $contexto,$pregunta_copy,$es_archivo_flow,$name_image,$nombre,$textos,$tam_array_builtins_texts_unique,$builtins_texts_index_unique,$tam_array_todo,$todo_ordenado,$todo_ordenado_copy,$pos,$nombre_imagen,$nombres_imagenes,$imagen_nueva,$imagen_actual,$imagenes_nuevas,$strings,$textos_originales,$imagen,$image_nueva,$remove,$fecha_minima,$agregar,$cant_preguntas;
    //public $pregunta=[];
    public $inputs = [];
    public $i = 0;
    public $archivoPreg;

    public function render()
    {
      $categorias = Categorias::all();
      return view('livewire.editar-pregunta',['categorias' => $categorias]);
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
        $this->agregar=1;
        //dd($this->agregar);
    }

    public function remove($i)
    {   

        
        //dd($this->inputs,$i,$this->inputs[$i],$this,$this->pregunta_copy[$i+1],$question);

        //$question=DB::table('questions')->where('pregunta','=',$this_pregunta[$i+1])->first();
      //dd($i);
       $this->remove=1;
        //dd($this->selected_id,$this);
        unset($this->inputs[$i]);
        if(array_key_exists($i+1,$this->pregunta)){
        $question=DB::table('questions')->where('pregunta','=',$this->pregunta[$i+1])->first();
        if($question!=null){
          //dd($this->selected_id);
          $archivos=DB::table('answer')->where('id','=',$this->selected_id)->get();
          foreach($archivos as $archivo);
          

          $path_archivo1=public_path("botpress12120/data/bots/icibot/qna/".$archivo->archivo_qna.".json");

        //dd($path_archivo);
             $leer1 = fopen($path_archivo1, 'r+');
      $numlinea=0;
      $aux_qna=array();
      while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
        $encontrar_pregunta_eliminar=strpos($linea,$this->pregunta[$i+1]);
          if($encontrar_pregunta_eliminar==false){
          $aux_qna[] = $linea;    
             $numlinea++;
          }
        }
        fclose($leer1);
        //dd($aux_qna);
        $path_archivo2=public_path("botpress12120/data/bots/icibot/intents/__qna__".$archivo->archivo_qna.".json");

        //dd($path_archivo);
             $leer2 = fopen($path_archivo2, 'r+');
      $numlinea=0;
      $aux_intents=array();
      while ($linea = fgets($leer2)){
        //echo $linea.'<br/>';
        $encontrar_pregunta_eliminar=strpos($linea,$this->pregunta[$i+1]);
          if($encontrar_pregunta_eliminar==false){
          $aux_intents[] = $linea;    
             $numlinea++;
          }
        }
        fclose($leer2);

        $cantidad_lineas_aux_qna=count($aux_qna);
        $contador_corchetes_qna=0;
        for($j=0;$j<$cantidad_lineas_aux_qna;$j++){
          $encontrar_corchete_qna=strpos($aux_qna[$j],']');
          if($encontrar_corchete_qna!=false){
            $contador_corchetes_qna=$contador_corchetes_qna+1;

            if($contador_corchetes_qna==3){
                $encontrar_coma_qna=strpos($aux_qna[$j-1],',');
                if($encontrar_coma_qna!=false){
                  $aux_qna[$j-1]=substr($aux_qna[$j-1],0,-3)."\r\n";
                }
            }
          }
        }
        //dd($aux_qna);
        $cantidad_lineas_aux_intents=count($aux_intents);
        $contador_corchetes_intents=0;
        for($j=0;$j<$cantidad_lineas_aux_intents;$j++){
          $encontrar_corchete_cerrado=strpos($aux_intents[$j],']');
          if($encontrar_corchete_cerrado!=false){
            $contador_corchetes_intents=$contador_corchetes_intents+1;
          
            if($contador_corchetes_intents==2){
                $encontrar_coma_intents=strpos($aux_intents[$j-1],',');
                if($encontrar_coma_intents!=false){
                  $aux_intents[$j-1]=substr($aux_intents[$j-1],0,-3)."\r\n";
                }
              }
            }
        }
      //dd($this,$archivo->archivo_qna,$aux_qna,$aux_intents,$this->remove,$this->pregunta_copy,$this->pregunta,$i);
        unlink($path_archivo1);
        unlink($path_archivo2);
         $j=0;
      $contenido="";
      while($j<$cantidad_lineas_aux_qna){
        $contenido .=$aux_qna[$j];
        $j=$j+1;
      }
      
       file_put_contents($path_archivo1,$contenido);
       $j=0;
       $contenido="";
      while($j<$cantidad_lineas_aux_intents){
        $contenido .=$aux_intents[$j];
        $j=$j+1;
      }
       
       file_put_contents($path_archivo2,$contenido);
       //dd($this->pregunta_copy,$i,$this->pregunta_copy,$this->pregunta);
          DB::table('questions')->where('pregunta','=',$this->pregunta[$i+1])->delete();
          unset($this->pregunta[$i+1]);
          $i=$i-1;
          session()->flash('message_delete', 'Se ha eliminado Input elemento de la Base de Datos y Archivos Botpress Correctamente');
        }else{
          $i=$i-1;
          session()->flash('message_delete', 'Se ha eliminado Input Correctamente');
        }
        }

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
          $this->name_image=null;
        }else{
            $this->name_image=$qna_image->nombre_imagen_qna;
        }
        //return view('qna.edit',compact('question','answer','pos','name_image'));
       
        //Busco si existe el arrchivo .flow.json sacado de la base de datos, si es que no existen respuestas a cierta pregunta,
        //seguirá abriendo el archivo .flow.json buscando los builtin_text y builtin_image del archivo para mostrarlos por pantalla
        //sino encuentra el termino flow.json en la tabla answer campo nombre, entonces mostrará el archivo tiene las tipicas respuestas directas.
        $this->es_archivo_flow=strpos($pregeditar->nombre,"flow.json");
        //dd($datos,$questions,$answer,$this->pos,$name_image,$es_archivo_flow);
        //dd($pregunta);
        if($this->es_archivo_flow==false){
           //Les paso los elementos de las consultas a la vista.
          //dd($question,$answer);
          //dd($es_archivo_flow);
          //dd($this);
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
        //dd($this);
        $this->todo_ordenado_copy=$this->todo_ordenado;
        $this->pregunta=$pregunta;
        $this->pregunta_copy=$pregunta;
        $this->cant_preguntas=$cantidad_preguntas;
        //dd($this->pregunta,$this->pregunta_copy);
        //dd($this->preguntas,$cantidad_preguntas);
        //$this->pregunta[$i]->pregunta
        //dd($pregeditar,$this->pregunta[0]->pregunta);
        $this->selected_id = $id;
        $this->resp = $pregeditar->nombre;
        $this->vence = $pregeditar->vence;
        $this->fecha_caducacion = $pregeditar->fecha_caducacion;
        $this->id_categoria = $pregeditar->id_categoria;
        $this->contexto = $pregeditar->contexto;
        //dd($this->fecha_minima,$hoy);
        //$this->contexto = $pregeditar->contexto;

    }
    public function update()
    {
        //dd($this->agregar);
            //dd($this);
        /*$this->validate([
            'selected_id' => 'required|numeric',
        ]);*/
        if ($this->vence != 1){
            $this->vence = null;
            $this->fecha_caducacion = null;
        }

        if ($this->id_categoria == 'nueva'){
        $categoria_creada = Categorias::create(['nombre' => $this->nueva_cat]);
        $this->id_categoria = $categoria_creada->id;
       }
        //dd($this);
        $this->pregunta_copy=$this->pregunta;
        
        if($this->remove!=1){
         $questions=DB::table('questions')->where('id_answers','=',$this->selected_id)->get();
      foreach($questions as $question);
      
      $answers=DB::table('answer')->where('id','=',$this->selected_id)->get();
      foreach($answers as $answer);
      $archivos_qnas=DB::table('answer')->where('id','=',$answer->id)->get();
      //dd($this,$this->todo_ordenado,$questions,$answers,$archivos_qnas,$this->es_archivo_flow);


      foreach($archivos_qnas as $archivo_qna);
      foreach($answers as $answer);
     
    //dd($this->contexto);
      $builtin_tipo=array();
      $builtin_codigo=array();
      $this->string=array();
      $this->textos_originales=array();
      $this->imagen_actual=array();
      $this->imagen_nueva=array();
      $es_archivo_flow=$this->es_archivo_flow;
      //dd($this,$this->todo_ordenado,$questions,$answers,$archivos_qnas,$this->es_archivo_flow);
      if($es_archivo_flow!=false){
        $largo_array_todo_ordenado_copy=count($this->todo_ordenado_copy);
        $a=0;
        while($a<$largo_array_todo_ordenado_copy){
          $encontrar_image_jpg=strpos($this->todo_ordenado_copy[$a],"jpg");
          $encontrar_image_png=strpos($this->todo_ordenado_copy[$a],"png");
          if($encontrar_image_jpg!=false or $encontrar_image_png!=false){
              array_push($this->imagen_actual,$this->todo_ordenado_copy[$a]);
              array_push($this->imagen_nueva,$this->todo_ordenado[$a]);
          }elseif($a>0 and $this->todo_ordenado[$a-1]=="builtin_text"){
                array_push($this->string,$this->todo_ordenado[$a]);
                array_push($this->textos_originales,$this->todo_ordenado_copy[$a]);
                array_push($builtin_tipo,$this->todo_ordenado_copy[$a-1]);
                array_push($builtin_codigo,$this->todo_ordenado_copy[$a-2]);
          }
          $a=$a+1;
        }
        //dd($this->contexto);
        //dd($this->imagen_actual,$this->imagen_nueva);
      //dd($request,$request->file('imagen_nueva'));
    //dd($this,$this->todo_ordenado,$questions,$answers,$archivos_qnas,$this->es_archivo_flow,'o');
      $imagenes_nuevas=$this->imagen_nueva;
      //dd($request->hasfile('imagen_nueva'));
      //$imagen_actual=$this->imagen_actual;
      //$imagenes_actuales=$request->file('imagenes_actual');
      $imagen_nueva=array();
      $imagen_actual=array();
      //$imagen1=$imagenes[1]->getClientOriginalName();
      //$names_imagenes=$request->names_imagenes;
      $i=0;
      //dd($request);
      //dd($imagenes_nuevas,$imagen_actual,$imagen_nueva,$this->file('imagenes_nuevas'));
      if($this->imagen_nueva!=false){
      $tam_array_imagen=count($this->imagen_nueva);
      //dd($tam_array_imagen,$this->imagen_nueva);
      }else{
        $tam_array_imagen=0;
      }
      $builtins_texts_unique=array();
      //dd($this->imagenes_nuevas,$tam_array_imagen,$this->string,$this->builtins_texts_index_unique);
      $tam_array_text=count($this->string);
      $builtins_texts_unique=$this->builtins_texts_index_unique;
      $textos_originales=$this->textos_originales;
      $strings=$this->string;
       //dd($builtins_texts_unique);
      /*$i=0;
        $unique=array();
        foreach($textos_originales_unique as $textos){
          $textos_inicial[$i]=$textos;
          $i=$i+1;
        }*/
      $es_archivo_flow=$this->es_archivo_flow;
      $textos_originales_unique=array_unique($textos_originales);
      $tam_textos_unicos=count($textos_originales_unique);
       $i=0;
        $textos_initial=array();
        foreach($textos_originales_unique as $textos){
          $textos_initial[$i]=$textos;
          $i=$i+1;
        }
        $i=0;
        $textos_iniciales=array();
        $reverse = array_reverse($textos_initial);
        foreach($reverse as $index => $value)
        {
       $textos_iniciales[$i] = $value;
       $i=$i+1;
        }
        $i=0;
        //dd($textos_inicial);
      //dd($es_archivo_flow);
      //dd($imagen1,$request,$request->file('imagen'),$tam_array_imagen);
      //dd($this,$textos_iniciales);
        //dd($this->imagen_actual,$this->imagen_nueva[0]);
        $i=0;
       if($this->imagen_nueva!=false){
      while($i<$tam_array_imagen){
        //dd($this->imagen_nueva[$i]);
         if(($this->imagen_nueva[$i]!=$this->imagen_actual[$i])){
        array_push($imagen_nueva,$this->imagen_nueva[$i]->getfilename());
        array_push($imagen_actual,$this->imagen_actual[$i]);
      }
        $i=$i+1;
      }
    }
      //dd($this,$imagen_actual,$imagen_nueva);
      //dd($this->contexto);
      $path_chatbot=public_path("botpress12120/data/bots/icibot/media/");
      $path_bp_laravel=public_path("images/bp/");
      $path_text=public_path("botpress12120/data/bots/icibot/content-elements/builtin_text.json");
          $leer = fopen($path_text, 'r+');
      $numlinea=0;
      while ($linea = fgets($leer)){
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        fclose($leer);
        //dd($aux);

     /*     $i=0;
          $builtin_text_inicial=array();
   while($i<$numlinea){
          $encuentra_builtins=strpos($aux[$i],"builtin");
          if($encuentra_builtins!=false){
        if($encuentra_builtin_text!=false){
                    array_push($builtins,substr($aux[$i],$encuentra_builtins,-2));
                    array_push($builtins_texts_inicial,substr($aux[$i],$encuentra_builtin_text,-2));
        }
      }
                $i=$i+1;
        }*/

      //$data = fread($leer, filesize($path_text));
      //while($i<$tam_array_text){

         //Se realiza el reeemplzado de la linea $patron por lo que dice en sustitución y lo demas queda exactamente igual a cmo esta en $data
      //$datosnuevos = str_replace($textos_originales[$i],$strings[$i],$data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
        //Se abre el archivo para reescribirlo
      
      $i=0;
      while($i<$numlinea){
        for($j=0;$j<$tam_array_text;$j++){
          $encuentra_texto=strpos($aux[$i],$textos_originales[$j]);
          if($encuentra_texto!=false){
                $aux[$i]=str_replace(
                $textos_originales[$j],
                $strings[$j],$aux[$i]);
        
          }
          
        }
        $i=$i+1;
      }
      $i=0;
      $contenido="";
      while($i<$numlinea){
        $contenido .=$aux[$i];
        $i=$i+1;
      }

        //file_put_contents(public_path("botpress12120/data/bots/icibot/content-elements/builtin_text.json"),$contenido);
      
      
        
       //dd($request,$request->file('imagen'),$request->imagen_actual,$imagen_nueva,$path_chatbot,$path_bp_laravel,$strings,$textos_originales,$tam_array_text,$aux,$contenido);
      //fclose($leer);
       unlink($path_text);
       file_put_contents(public_path("botpress12120/data/bots/icibot/content-elements/builtin_text.json"),$contenido);
       //$ruta= public_path("botpress12120/data/bots/icibot/content-elements/");
       //rename($ruta."textos.json", $ruta."builtin_text.json");
        //dd($request,$request->file('imagen'),$request->imagen_actual,$imagenes_nuevas,$imagen_nueva,$path_chatbot,$path_bp_laravel,$strings,$textos_originales,$tam_array_text,$aux,$contenido);
        
      $i=0;
      //dd($imagen_actual);
      //dd($request->hasfile('imagen_nueva'));
      //if(($this->hasfile('imagen_nueva'))==true){
      //dd($this->imagen_nueva,$imagenes_nuevas);
      foreach($imagenes_nuevas as $imagen_nueva){
         //dd($imagenes_nuevas[$i]->getClientOriginalName(),$imagen_nueva);
        //dd(!empty($request->file('imagen_nueva')[1]));
        //dd($this->imagen_nueva[$i],$this,$this->imagen_actual[$i]);
        if($this->imagen_nueva[$i]!=$this->imagen_actual[$i]){
          //dd(!empty($request->file('imagen_nueva')[1]));
        $filename=time().$imagen_nueva->getfilename(); 
        //OJO CON LA RUTA STORAGE/APP/IMAGES/BP E AHI EL PROBLEMA POR QUE ABRE LA RUTA /STORAGE/IMAGES/BP OJOOOO
        //dd($imagen_nueva->getfilename());
         $imagen_actual[$i]=$this->imagen_actual[$i];
         $imagen_nueva->storeAs(('images/bp/'),$filename);
        $fichero_storage=storage_path().'/app/images/bp/'.$filename;
        $fichero_public=public_path('/images/bp/'.$filename);
      $nuevo_fichero=public_path().'/botpress12120/data/bots/icibot/media/'.$filename;
      copy($fichero_storage,$nuevo_fichero);
      copy($fichero_storage,$fichero_public);
         //dd($path_chatbot,$imagen_actual[$i]);
          unlink($path_chatbot.$imagen_actual[$i]);
          unlink($path_bp_laravel.$imagen_actual[$i]);
          rename($path_chatbot.$filename,$path_chatbot.$imagen_actual[$i]);
          rename($path_bp_laravel.$filename,$path_bp_laravel.$imagen_actual[$i]);
      }
      $i=$i+1;
      /*if($i==count($this->imagen_actual)){
        break;
      }*/
  }
  //dd($this->contexto);
  $tam_array_imagen=count($imagen_actual);
//}    
    $i=0;
    //dd($this->nombres_imagenes);
    $names_imagenes=array();
    while($i<count($this->nombres_imagenes)){
      if($this->nombres_imagenes[$i]!=null){
          array_push($names_imagenes,$this->nombres_imagenes[$i]);
    }
    $i=$i+1;
  }
  $i=0;
  //dd($this->imagen_nueva,$this->imagen_actual);
  while($i<count($this->imagen_actual)){
    //dd($this->imagen_nueva[$i],$this->imagen_actual[$i],$this);
      if($this->imagen_nueva[$i]==$this->imagen_actual[$i]){
          unset($imagenes_nuevas[$i]);
          unset($this->imagen_nueva[$i]);
      }
  $i=$i+1;
  }
    //dd($this,$this->imagen_nueva,$this->imagen_actual,$imagenes_nuevas);
  $i=0;
    //$tam_array_imagen=count($imagen_actual);
    //dd($imagen_actual,$es_archivo_flow,$tam_array_imagen,empty($imagen_actual[$i]),$names_imagenes);
    //dd(!empty($imagen_actual[$i]));
    $path_text=public_path("botpress12120/data/bots/icibot/content-elements/builtin_text.json");
    $leer=null;
    $aux[]=null;
          $leer = fopen($path_text, 'r+');
      $numlinea=0;
      while ($linea = fgets($leer)){
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        fclose($leer);
    
     $builtins_texts_unique=$this->builtins_texts_index_unique;
     $tam_array_builtins_texts_unique=count($builtins_texts_unique);
     //dd($builtins_texts_unique,$tam_array_builtins_texts_unique);
    $i=0;
    $textos_finales=array();
      for($i=0;$i<$numlinea;$i++){
        for($j=0;$j<$tam_array_builtins_texts_unique;$j++){
           $encontrar_builtin_text=strpos($aux[$i],$builtins_texts_unique[$j]);
            if($encontrar_builtin_text!=false){
              //dd(substr($aux[$j+4],18,-3));
              array_push($textos_finales,substr($aux[$i+4],18,-3));
            }
        }
   }


    $directorio1="botpress12120/data/bots/icibot/intents";
      
      //Se creaa arreglo para guadar direccion de archivos de carpeta
      $res = array();

  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio1, -1) != "/") $directorio1 .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir1 = @dir($directorio1) or die("getFileList: Error abriendo el directorio $directorio1 para leerlo");
  while(($archivo1 = $dir1->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo1[0] == ".") continue;
      if(is_dir($directorio1 . $archivo1)) {
          $res[] = array(
            "Nombre" => $directorio1 . $archivo1 . '"/"',
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio1 . $archivo1)
          );
      } else if (is_readable($directorio1 . $archivo1)) {
          $res[] = array(
            "Nombre" => $directorio1 . $archivo1,
            "Tamaño" => filesize($directorio1 . $archivo1),
            "Modificado" => filemtime($directorio1 . $archivo1)
          );
      }
  }

$tam=count($res);
  //dd($tam);
  $i=0;
  $pos=strpos($res[$i]["Nombre"],$archivo_qna->archivo_qna);
  //dd($pos);
  if($pos!=false){

  }else{
  while($pos==false){
    //dd($pos);
    if($i==2){
      //dd($i,$pos,$res[$i]["Nombre"],$archivo_qna->archivo_qna);
    }
      $i=$i+1;
      $pos=strpos($res[$i]["Nombre"],$archivo_qna->archivo_qna);
     

  }
   //dd($this,$this->selected_id,$answer,$archivo_qna->nombre,$res[$i]["Nombre"]);
}

       $directorio2="botpress12120/data/bots/icibot/qna";
  $res2 = array();

  // Agregamos la barra invertida al final en caso de que no exista


  if(substr($directorio2, -1) != "/") $directorio2 .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir2 = @dir($directorio2) or die("getFileList: Error abriendo el directorio $directorio2 para leerlo");
  while(($archivo2 = $dir2->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo2[0] == ".") continue;
      if(is_dir($directorio2 . $archivo2)) {
          $res2[] = array(
            "Nombre" => $directorio2 . $archivo2 . "/",
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio2 . $archivo2)
          );
      } else if (is_readable($directorio2 . $archivo2)) {
          $res2[] = array(
            "Nombre" => $directorio2.$archivo2,
            "Tamaño" => filesize($directorio2.$archivo2),
            "Modificado" => filemtime($directorio2.$archivo2)
          );
      }
  }

  $tam=count($res2);
  //dd($tam);
  $j=0;
  $pos=strpos($res2[$j]["Nombre"],$archivo_qna->archivo_qna);
  //dd($pos); dd($question);
  if($pos!=false){

  }else{
      while($pos==false){
          $j=$j+1;
          $pos=strpos($res2[$j]["Nombre"],$archivo_qna->archivo_qna);
      //dd($request,$id,$question,$answer,$archivo_qna->nombre,$datos,$res2[$j]["Nombre"]);

  }
  //dd($this,$this->selected_id,$question,$answer,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"]);
}
  //dd($this,$this->selected_id,$question,$answer,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"],public_path());
   $tam_pregunta=count($this->pregunta);
   $tam_pregunta_copy=count($this->pregunta_copy);
        //dd($this->pregunta,$this);
      $a=0;
        $b=0;
        $copy_pregunta=$this->pregunta;
        $this->pregunta=null;
        $this->pregunta=array();
        //$this->pregunta_copy=array();
      //dd($this,$copy_pregunta,max($this->inputs));
        while($b<$tam_pregunta){
            if(array_key_exists($a,$copy_pregunta)){
                 array_push($this->pregunta,$copy_pregunta[$a]);
                 //array_push($this->inputs,$b+1);
                 $b++;
            }
            $a++;
        }
        $a=0;
        $b=0;
        $this->inputs=array();
        while($b<$tam_pregunta){
            if(array_key_exists($a,$copy_pregunta)){
                 array_push($this->inputs,$b+1);
                 //array_push($this->inputs,$b+1);
                 $b++;
            }
            $a++;
        }
        $a=0;
        $b=0;
  $this->pregunta_copy=$this->pregunta;
 //dd($this->pregunta,$this->pregunta_copy,$this);
  $nombre_archivo_intents=$res[$i]["Nombre"];
  $nombre_archivo_qna=$res2[$j]["Nombre"];
  $path_archivo_intents=public_path("/".$nombre_archivo_intents);

  $leer1 = fopen($path_archivo_intents, 'r+');
        $numlinea=0;
        while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
            $aux_intents[] = $linea;    
             $numlinea++;
        }
        //dd($aux_intents);
        $ultimas_4_lineas=array();
        $ultimas_4_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-3;
      while($i<$numlinea){
           $ultimas_4_lineas[$j]=$aux_intents[$i];
           $j=$j+1;
          $i=$i+1;
      }
        //dd($ultimas_4_lineas);
        fclose($leer1);
        $k=0;
        $cantidad_preguntas_actual=count($this->pregunta);
        $cantidad_preguntas_antes=count($this->pregunta_copy);
        //dd($aux_intents,$questions,$this->pregunta,$this->pregunta_copy,$cantidad_preguntas_antes,$cantidad_preguntas_actual,$ultimas_4_lineas);
        //dd($this->pregunta_copy,$this->pregunta);
         //dd(substr($aux_intents[11],7,-3));
        $i=0;
        $k=0;
        $var_contexto_intents=0;
        $tam_archivo_intents=count($aux_intents);
        while($i<$tam_archivo_intents and $k<$cantidad_preguntas_antes){
             $pos=strpos($aux_intents[$i],$this->pregunta_copy[$k]);
             $pos_coma=strpos($aux_intents[$i],',');
             //dd($pos,$aux_intents,$this->pregunta_copy);
              while($pos!=false and $k<$cantidad_preguntas_antes){
                    if($pos_coma!=false){
                    $aux_intents[$i]='       "'.$this->pregunta[$k].'",'."\r\n";
                    //dd($aux_intents,$this->pregunta_copy[$k],$this->pregunta[$k],$this);
                    $k=$k+1;
                    $i=$i+1;
                    /*if($i==16){
                      dd($aux_intents,$aux_intents[$i],$this->pregunta_copy[$k],$this->pregunta[$k],$i,$k);
                    }*/
                  }
              }
        if($var_contexto_intents==0){
            //dd($aux_intents[$i],$this->contexto);
           if(substr($aux_intents[$i],5,-2)=="global" or substr($aux_intents[$i],5,-2)=="regular" or substr($aux_intents[$i],5,-2)=="egresado"){
            //dd(substr($aux_intents[3],5,-2),$this->contexto);
            $aux_intents[$i]=str_replace(substr($aux_intents[$i],5,-2),$this->contexto,$aux_intents[$i]);
            $var_contexto_intents=1;
          }
          if(substr($aux_intents[$i],5,-3)=="global" or substr($aux_intents[$i],5,-3)=="regular" or substr($aux_intents[$i],5,-3)=="egresado"){
            //dd($aux_intents[$i],$this->contexto);
            $aux_intents[$i]=str_replace(substr($aux_intents[$i],5,-3),$this->contexto,$aux_intents[$i]);
            $var_contexto_intents=1;
          }
          
        }
        $i=$i+1;
        }
        $i=$i-1;
               
        if($k<$cantidad_preguntas_actual){
        $aux_intents[$i]=$ultimas_4_lineas[0];
          $aux_intents[$i+1]=$ultimas_4_lineas[1];
          $aux_intents[$i+2]=$ultimas_4_lineas[2];
          $aux_intents[$i+3]=$ultimas_4_lineas[3];
          //dd($aux_intents,$k,$i,$cantidad_preguntas_actual,$this->pregunta,$this);
        }else{
          $aux_intents[$i]=$ultimas_4_lineas[0];
          $aux_intents[$i+1]=$ultimas_4_lineas[1];
          $aux_intents[$i+2]=$ultimas_4_lineas[2];
          $aux_intents[$i+3]=$ultimas_4_lineas[3];
          //dd($aux_intents,$k,$i,$cantidad_preguntas_actual,$this->pregunta,$this);
          $i=0;
            $cantidad_corchetes_intents=0;
              while($i<$numlinea){
                $encontrar_coma_intents=strpos($aux_intents[$i],"]");
                if($encontrar_coma_intents!=false){
                $cantidad_corchetes_intents=$cantidad_corchetes_intents+1;
               }
               if($cantidad_corchetes_intents==2){
                //dd($aux_intents[$i],$aux_intents);
                $aux_intents[$i-1]=substr($aux_intents[$i-1],0,-3)."\r\n";
                $cantidad_corchetes_intents=$cantidad_corchetes_intents+1;
               }
                $i=$i+1;
              }
        }
        //dd($aux_intents,$this);
  $path_archivo_qna=public_path("/".$nombre_archivo_qna);
  $leer2 = fopen($path_archivo_qna, 'r+');
   $numlinea=0;
        while ($linea = fgets($leer2)){
        //echo $linea.'<br/>';
            $aux_qna[] = $linea;    
             $numlinea++;
        }
        fclose($leer2);
        //dd($aux_qna);
        //$cantidad_preguntas=count($this->pregunta);
         $ultimas_5_lineas=array();
         //$ultimas_5_lineas[0]=;
        $j=0;
        $i=$numlinea-6;
      while($i<$numlinea){
           $ultimas_5_lineas[$j]=$aux_qna[$i];
           $j=$j+1;
          $i=$i+1;
      }
      //dd($ultimas_5_lineas);
      $ultimas_5_lineas[5]="}\n";
        $k=0;
        $i=0;
        $j=0;
        $pos1=strpos($aux_qna[$i],$this->pregunta_copy[$k]);
        //$pos2=strpos($aux_qna[$i],$this->pregunta_copy[$k]);
        //dd($pos1,$pos_coma,$this->pregunta);
        $tam_archivo_qna=count($aux_qna);
        while($i<$tam_archivo_qna and $k<$cantidad_preguntas_antes){
          $pos_preguntas=strpos($aux_qna[$i],$this->pregunta_copy[$k]);
          $pos_respuesta=strpos($aux_qna[$i],$this->nombre);
          $pos_coma=strpos($aux_qna[$i],',');
          if($pos_respuesta!=false){
            $aux_qna[$i]='         "'.$this->resp.'"'."\r\n";
            $i=$i+1;
          }
          //dd($pos_preguntas,$k,$cantidad_preguntas_antes,$pos_coma);
          while($pos_preguntas!=false and $k<$cantidad_preguntas_antes){
              if($pos_coma!=false){
                $aux_qna[$i]='         "'.$this->pregunta[$k].'",'."\r\n";
                $k=$k+1;
                $i=$i+1;
          }
        } 
          if(substr($aux_qna[$i],7,-2)=="global" or substr($aux_qna[$i],7,-2)=="regular" or substr($aux_qna[$i],7,-2)=="egresado"){
            //dd(substr($aux_qna[$i],7,-2),$this->contexto);
            $aux_qna[$i]=str_replace(substr($aux_qna[$i],7,-2),$this->contexto,$aux_qna[$i]);
          }
          $i=$i+1;
        }
        $i=$i-1;
        //dd($aux_qna,$k,$i,$this);
        //dd($k,$cantidad_preguntas_actual,$this->pregunta);
        if($k<$cantidad_preguntas_actual){
         for($j=0;$j<6;$j++){
              $aux_qna[$i]=$ultimas_5_lineas[$j];
              $i=$i+1;
            }
            //dd($aux_intents,$aux_qna,$i,$k,$cantidad_preguntas_actual);
           }else{
             for($j=0;$j<6;$j++){
              $aux_qna[$i]=$ultimas_5_lineas[$j];
              $i=$i+1;
            }
            //dd($aux_intents,$aux_qna,$i,$k,$cantidad_preguntas_actual);
            $i=0;
             
            $cantidad_corchetes_qna=0;
            //dd($aux_intents,$aux_qna,$i,$k,$cantidad_preguntas_actual);

              while($i<$numlinea){
                $encontrar_corchete_qna=strpos($aux_qna[$i],"]");
                //dd($aux_qna[$i],$i);
             if($encontrar_corchete_qna!=false){
                //dd($aux_qna[$i],$i,$encontrar_corchete_qna);
                $cantidad_corchetes_qna=$cantidad_corchetes_qna+1;
               }
               if($cantidad_corchetes_qna==3){
                $aux_qna[$i-1]=substr($aux_qna[$i-1],0,-3)."\r\n";
                $cantidad_corchetes_qna=$cantidad_corchetes_qna+1;
                //dd($cantidad_corchetes_qna,$aux_qna);
               }
                //$cantidad_corchetes_qna=$cantidad_corchetes_qna+1;
                $i=$i+1;
              }
              //dd($aux_intents,$aux_qna,$i,$k,$this);
           }
            //dd($aux_qna,$k,$i,$this,$aux_intents);
  //dd($aux_intents,$aux_qna,$this);
  //dd($request,$id,$question,$answer,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"],public_path(),$path_archivo_intents,$path_archivo_qna,$aux_intents,$aux_qna);
      
     unlink($path_archivo_intents);
     unlink($path_archivo_qna);

      $contenido1="";
       $i=0;
       $tam_array_aux_intents=count($aux_intents);
      while($i<$tam_array_aux_intents){
        $contenido1 .=$aux_intents[$i];
        $i=$i+1;
      }

        $escribir1 = fopen($path_archivo_intents, 'w+');
         //fwrite($escribir1, $data1);
        fwrite($escribir1, $contenido1);
       fclose($escribir1);

      $contenido2="";
       $i=0;
       $tam_array_aux_qna=count($aux_qna);
      while($i<$tam_array_aux_qna){
        $contenido2.=$aux_qna[$i];
        $i=$i+1;
      }

        $escribir2 = fopen($path_archivo_qna, 'w+');
         //fwrite($escribir1, $data1);
        fwrite($escribir2, $contenido2);
       fclose($escribir2);
        

    //dd($request,$request->file('imagen_nueva'),$textos_iniciales,$textos_finales,$request->imagen_actual,$imagen_nueva,$names_imagenes,$path_chatbot,$path_bp_laravel,$strings,$textos_originales,$tam_array_text,$aux,$contenido,$tam_array_builtins_texts_unique);
    //dd($textos_iniciales,$textos_finales);
       //dd($this,$imagenes_nuevas);
      session()->flash('message', 'Pregunta actualizada correctamente');
      /*return view('qna.message',compact('imagen_actual','tam_array_text','strings','textos_originales','tam_array_imagen','es_archivo_flow','tam_array_builtins_texts_unique','names_imagenes','textos_iniciales','textos_finales'));*/
    }else{
      //dd($this->contexto);
     // dd($this,$this->todo_ordenado,$questions,$answers,$archivos_qnas,$this->es_archivo_flow);
      //La ruta del directorio dentro de la carpeta public, que como se dijo anteriormente irá dentro de directorio1
      //dd($this);
      $directorio1="botpress12120/data/bots/icibot/intents";
      
      //Se creaa arreglo para guadar direccion de archivos de carpeta
      $res = array();

  // Agregamos la barra invertida al final en caso de que no exista
  if(substr($directorio1, -1) != "/") $directorio1 .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir1 = @dir($directorio1) or die("getFileList: Error abriendo el directorio $directorio1 para leerlo");
  while(($archivo1 = $dir1->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo1[0] == ".") continue;
      if(is_dir($directorio1 . $archivo1)) {
          $res[] = array(
            "Nombre" => $directorio1 . $archivo1 . '"/"',
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio1 . $archivo1)
          );
      } else if (is_readable($directorio1 . $archivo1)) {
          $res[] = array(
            "Nombre" => $directorio1 . $archivo1,
            "Tamaño" => filesize($directorio1 . $archivo1),
            "Modificado" => filemtime($directorio1 . $archivo1)
          );
      }
  }

$tam=count($res);
  //dd($res);
  $i=0;
  $pos=strpos($res[$i]["Nombre"],$archivo_qna->archivo_qna);
  //dd($pos);
  if($pos!=false){

  }else{
  while($pos==false){
    //dd($pos);
    if($i==2){
      //dd($i,$pos,$res[$i]["Nombre"],$archivo_qna->archivo_qna);
    }
      $i=$i+1;
      $pos=strpos($res[$i]["Nombre"],$archivo_qna->archivo_qna);
     

  }
   //dd($this,$this->selected_id,$answer,$archivo_qna->nombre,$res[$i]["Nombre"]);
}

       $directorio2="botpress12120/data/bots/icibot/qna";
  $res2 = array();

  // Agregamos la barra invertida al final en caso de que no exista


  if(substr($directorio2, -1) != "/") $directorio2 .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  $dir2 = @dir($directorio2) or die("getFileList: Error abriendo el directorio $directorio2 para leerlo");
  while(($archivo2 = $dir2->read()) !== false) {
      // Obviamos los archivos ocultos
      if($archivo2[0] == ".") continue;
      if(is_dir($directorio2 . $archivo2)) {
          $res2[] = array(
            "Nombre" => $directorio2 . $archivo2 . "/",
            "Tamaño" => 0,
            "Modificado" => filemtime($directorio2 . $archivo2)
          );
      } else if (is_readable($directorio2 . $archivo2)) {
          $res2[] = array(
            "Nombre" => $directorio2.$archivo2,
            "Tamaño" => filesize($directorio2.$archivo2),
            "Modificado" => filemtime($directorio2.$archivo2)
          );
      }
  }

  $tam=count($res2);
  //dd($tam);
  $j=0;
  $pos=strpos($res2[$j]["Nombre"],$archivo_qna->archivo_qna);
  //dd($pos); dd($question);
  if($pos!=false){

  }else{
      while($pos==false){
          $j=$j+1;
          $pos=strpos($res2[$j]["Nombre"],$archivo_qna->archivo_qna);
      //dd($request,$id,$question,$answer,$archivo_qna->nombre,$datos,$res2[$j]["Nombre"]);

  }
  //dd($this,$this->selected_id,$question,$answer,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"]);
}
  //dd($this,$this->selected_id,$question,$answer,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"],public_path());
   $tam_pregunta=count($this->pregunta);
   $tam_pregunta_copy=count($this->pregunta_copy);
        //dd($this->pregunta,$this);
      $a=0;
        $b=0;
        $copy_pregunta=$this->pregunta;
        $this->pregunta=null;
        $this->pregunta=array();
        //$this->pregunta_copy=array();
      //dd($this,$copy_pregunta,max($this->inputs));
        while($b<$tam_pregunta){
            if(array_key_exists($a,$copy_pregunta)){
                 array_push($this->pregunta,$copy_pregunta[$a]);
                 //array_push($this->inputs,$b+1);
                 $b++;
            }
            $a++;
        }
        $a=0;
        $b=0;
        $this->inputs=array();
        while($b<$tam_pregunta){
            if(array_key_exists($a,$copy_pregunta)){
                 array_push($this->inputs,$b+1);
                 //array_push($this->inputs,$b+1);
                 $b++;
            }
            $a++;
        }
        $a=0;
        $b=0;
  $this->pregunta_copy=$this->pregunta;
 //dd($this->pregunta,$this->pregunta_copy,$this);
  $nombre_archivo_intents=$res[$i]["Nombre"];
  $nombre_archivo_qna=$res2[$j]["Nombre"];
  $path_archivo_intents=public_path("/".$nombre_archivo_intents);

  $leer1 = fopen($path_archivo_intents, 'r+');
        $numlinea=0;
        while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
            $aux_intents[] = $linea;    
             $numlinea++;
        }
        //dd($aux_intents);
        $ultimas_4_lineas=array();
        $ultimas_4_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-3;
      while($i<$numlinea){
           $ultimas_4_lineas[$j]=$aux_intents[$i];
           $j=$j+1;
          $i=$i+1;
      }
       $ultimas_4_lineas[3]="}\n";
        //dd($ultimas_4_lineas);
        fclose($leer1);
        $k=0;
        $cantidad_preguntas_actual=count($this->pregunta);
        $cantidad_preguntas_antes=count($this->pregunta_copy);
        //dd($aux_intents,$questions,$this->pregunta,$this->pregunta_copy,$cantidad_preguntas_antes,$cantidad_preguntas_actual,$ultimas_4_lineas);
        //dd($this->pregunta_copy,$this->pregunta);
         //dd(substr($aux_intents[11],7,-3));
        $i=0;
        //dd($aux_intents,$question->pregunta,$cantidad_preguntas);
        //dd(substr($aux_intents[8],7,-3));
        //$pos=strpos(substr($aux_intents[$i],7,-3),$question->pregunta);
        //dd(substr($aux_intents[$i],7,-3));
       //dd($pos,$aux_intents[8],substr($aux_intents[8],7,-3),$question->pregunta);
        $var_contexto_intents=0;
        $k=0;
        $tam_archivo_intents=count($aux_intents);
        while($i<$tam_archivo_intents and $k<$cantidad_preguntas_antes){
             $pos=strpos($aux_intents[$i],$this->pregunta_copy[$k]);
             $pos_coma=strpos($aux_intents[$i],',');
             //dd($pos,$aux_intents,$this->pregunta_copy);
              while($pos!=false and $k<$cantidad_preguntas_antes){
                    if($pos_coma!=false){
                    $aux_intents[$i]='       "'.$this->pregunta[$k].'",'."\r\n";
                    //dd($aux_intents,$this->pregunta_copy[$k],$this->pregunta[$k],$this);
                    $k=$k+1;
                    $i=$i+1;
                    /*if($i==16){
                      dd($aux_intents,$aux_intents[$i],$this->pregunta_copy[$k],$this->pregunta[$k],$i,$k);
                    }*/
                  }
              }
            
          if($var_contexto_intents==0){
           if((substr($aux_intents[$i],5,-2)=="global" or substr($aux_intents[$i],5,-2)=="regular" or substr($aux_intents[$i],5,-2)=="egresado") and $i<$tam_archivo_intents and $var_contexto_intents==0){
            $aux_intents[$i]=str_replace(substr($aux_intents[$i],5,-2),$this->contexto,$aux_intents[$i]);
            $var_contexto_intents=1;
            //dd($var_contexto_intents,$k,$cantidad_preguntas_actual,$aux_intents[$i],$this->contexto,substr($aux_intents[$i],5,-2));
          }
          if((substr($aux_intents[$i],5,-3)=="global" or substr($aux_intents[$i],5,-3)=="regular" or substr($aux_intents[$i],5,-3)=="egresado") and $i<$tam_archivo_intents and $var_contexto_intents==0){
            $aux_intents[$i]=str_replace(substr($aux_intents[$i],5,-3),$this->contexto,$aux_intents[$i]);
            $var_contexto_intents=1;
            //dd($var_contexto_intents,$k,$cantidad_preguntas_actual,$aux_intents[$i],$this->contexto,substr($aux_intents[$i],5,-2));
          }
        }
        //
        $i=$i+1;
        }
        //dd($aux_intents,$tam_archivo_intents);
        $i=$i-1;
               
        if($k<$cantidad_preguntas_actual){
        $aux_intents[$i]=$ultimas_4_lineas[0];
          $aux_intents[$i+1]=$ultimas_4_lineas[1];
          $aux_intents[$i+2]=$ultimas_4_lineas[2];
          $aux_intents[$i+3]=$ultimas_4_lineas[3];
          //dd($aux_intents,$k,$i,$cantidad_preguntas_actual,$this->pregunta,$this);
        }else{
          $aux_intents[$i]=$ultimas_4_lineas[0];
          $aux_intents[$i+1]=$ultimas_4_lineas[1];
          $aux_intents[$i+2]=$ultimas_4_lineas[2];
          $aux_intents[$i+3]=$ultimas_4_lineas[3];
          //dd($aux_intents,$k,$i,$cantidad_preguntas_actual,$this->pregunta,$this);
          $i=0;
            $cantidad_corchetes_intents=0;
              while($i<$numlinea){
                $encontrar_coma_intents=strpos($aux_intents[$i],"]");
                if($encontrar_coma_intents!=false){
                $cantidad_corchetes_intents=$cantidad_corchetes_intents+1;
               }
               if($cantidad_corchetes_intents==2){
                //dd($aux_intents[$i],$aux_intents);
                $aux_intents[$i-1]=substr($aux_intents[$i-1],0,-3)."\r\n";
                $cantidad_corchetes_intents=$cantidad_corchetes_intents+1;
               }
                $i=$i+1;
              }
        }
        //dd($aux_intents,$this);
  $path_archivo_qna=public_path("/".$nombre_archivo_qna);
  $leer2 = fopen($path_archivo_qna, 'r+');
   $numlinea=0;
        while ($linea = fgets($leer2)){
        //echo $linea.'<br/>';
            $aux_qna[] = $linea;    
             $numlinea++;
        }
        fclose($leer2);
        //dd($aux_qna);
        //$cantidad_preguntas=count($this->pregunta);
         $ultimas_5_lineas=array();
         //$ultimas_5_lineas[0]=;
        $j=0;
        $i=$numlinea-6;
      while($i<$numlinea){
           $ultimas_5_lineas[$j]=$aux_qna[$i];
           $j=$j+1;
          $i=$i+1;
      }
      $ultimas_5_lineas[5]="}\n";
      //dd($ultimas_5_lineas);
        $k=0;
        $i=0;
        $j=0;
        $var_qna_contexto=0;
        //dd($aux_qna,$this->pregunta_copy);
        $pos1=strpos($aux_qna[$i],$this->pregunta_copy[$k]);
        //$pos2=strpos($aux_qna[$i],$this->pregunta_copy[$k]);
        //dd($pos1,$pos_coma,$this->pregunta);
        $tam_archivo_qna=count($aux_qna);

        while($i<$tam_archivo_qna and $k<$cantidad_preguntas_antes){
          $pos_preguntas=strpos($aux_qna[$i],$this->pregunta_copy[$k]);
          $pos_respuesta=strpos($aux_qna[$i],$this->nombre);
          $pos_coma=strpos($aux_qna[$i],',');
          if($pos_respuesta!=false){
            $aux_qna[$i]='         "'.$this->resp.'"'."\r\n";
            $i=$i+1;
            //dd($i,$tam_archivo_qna,$aux_qna,$k,$cantidad_preguntas_antes); 
          }
          //dd($pos_preguntas,$k,$cantidad_preguntas_antes,$pos_coma);

          while($pos_preguntas!=false and $k<$cantidad_preguntas_antes){
              if($pos_coma!=false){
                $aux_qna[$i]='         "'.$this->pregunta[$k].'",'."\r\n";
                $k=$k+1;
                $i=$i+1;
          }
        }
        //dd($aux_qna[$i],substr($aux_qna[$i],7,-2),$this->contexto);
        if($var_qna_contexto==0){
          //dd($aux_qna[$i],substr($aux_qna[5],7,-2),$this->contexto);
          if((substr($aux_qna[$i],7,-2)=="global" or substr($aux_qna[$i],7,-2)=="regular" or substr($aux_qna[$i],7,-2)=="egresado") and $i<$tam_archivo_qna){
            //dd($aux_qna[$i],substr($aux_qna[$i],7,-2),$this->contexto);
            $aux_qna[$i]=str_replace(substr($aux_qna[$i],7,-2),$this->contexto,$aux_qna[$i]);
            $var_qna_contexto=1;
          }
          if((substr($aux_qna[$i],7,-3)=="global" or substr($aux_qna[$i],7,-3)=="regular" or substr($aux_qna[$i],7,-3)=="egresado") and $i<$tam_archivo_qna){
            //dd($aux_qna[$i],substr($aux_qna[$i],7,-2),$this->contexto);
            $aux_qna[$i]=str_replace(substr($aux_qna[$i],7,-3),$this->contexto,$aux_qna[$i]);
            $var_qna_contexto=1;
          }
        }
          $i=$i+1;
        }
        $i=$i-1;
        //dd($aux_qna,$k,$i,$this);
        //dd($k,$cantidad_preguntas_actual,$this->pregunta);
        if($k<$cantidad_preguntas_actual){
         for($j=0;$j<6;$j++){
              $aux_qna[$i]=$ultimas_5_lineas[$j];
              $i=$i+1;
            }
            //dd($aux_intents,$aux_qna,$i,$k,$cantidad_preguntas_actual);
           }else{
             for($j=0;$j<6;$j++){
              $aux_qna[$i]=$ultimas_5_lineas[$j];
              $i=$i+1;
            }
            //dd($aux_intents,$aux_qna,$i,$k,$cantidad_preguntas_actual);
            $i=0;
             
            $cantidad_corchetes_qna=0;
            //dd($aux_intents,$aux_qna,$i,$k,$cantidad_preguntas_actual);

              while($i<$numlinea){
                $encontrar_corchete_qna=strpos($aux_qna[$i],"]");
                //dd($aux_qna[$i],$i);
             if($encontrar_corchete_qna!=false){
                //dd($aux_qna[$i],$i,$encontrar_corchete_qna);
                $cantidad_corchetes_qna=$cantidad_corchetes_qna+1;
               }
               if($cantidad_corchetes_qna==3){
                $aux_qna[$i-1]=substr($aux_qna[$i-1],0,-3)."\r\n";
                $cantidad_corchetes_qna=$cantidad_corchetes_qna+1;
                //dd($cantidad_corchetes_qna,$aux_qna);
               }
                //$cantidad_corchetes_qna=$cantidad_corchetes_qna+1;
                $i=$i+1;
              }
              //dd($aux_intents,$aux_qna,$i,$k);
           }
            //dd($aux_qna,$k,$i,$this,$aux_intents);
//dd($aux_intents,$aux_qna,$this);
  //dd($request,$id,$question,$answer,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"],public_path(),$path_archivo_intents,$path_archivo_qna,$aux_intents,$aux_qna);
      
     unlink($path_archivo_intents);
     unlink($path_archivo_qna);

      $contenido1="";
       $i=0;
       $tam_array_aux_intents=count($aux_intents);
      while($i<$tam_array_aux_intents){
        $contenido1 .=$aux_intents[$i];
        $i=$i+1;
      }

        $escribir1 = fopen($path_archivo_intents, 'w+');
         //fwrite($escribir1, $data1);
        fwrite($escribir1, $contenido1);
       fclose($escribir1);

      $contenido2="";
       $i=0;
       $tam_array_aux_qna=count($aux_qna);
      while($i<$tam_array_aux_qna){
        $contenido2.=$aux_qna[$i];
        $i=$i+1;
      }

        $escribir2 = fopen($path_archivo_qna, 'w+');
         //fwrite($escribir1, $data1);
        fwrite($escribir2, $contenido2);
       fclose($escribir2);
        
       
       
        //break;
      //dd($request,$request->file('image_nueva'));
        //dd($id);
        //dd($request);
        $imagen=$this->name_image;
        //dd($imagen);
        //consulto por cual es la tupla editada en la tabla questions
       /*$rules = ['image_nueva' => 'required|image'];
        $messages = [
            'image_nueva.image' => 'Formato no permitido',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('/qna_edit{{$id}}')->withErrors($validator);
        }*/
        //dd($this->image_nueva);
        if((empty($this->image_nueva))==false){
        $this->validate(
              [
              'image_nueva' => 'image|mimes:jpg,bmp,png',
            ]);
        //dd($this->image_nueva,$imagen);
        if((!empty($this->image_nueva))==true){
          $nombre_imagen=time().$this->image_nueva->getfilename(); 
          //dd($imagen,$nombre_imagen);
           $this->image_nueva->storeAs(('images/bp/'),$nombre_imagen);
           $fichero_storage=storage_path().'/app/images/bp/'.$nombre_imagen;
        $fichero_storage=storage_path().'/app/images/bp/'.$nombre_imagen;
        $fichero_public=public_path('/images/bp/'.$nombre_imagen);
      $nuevo_fichero=public_path().'/botpress12120/data/bots/icibot/media/'.$nombre_imagen;
      copy($fichero_storage,$nuevo_fichero);
      copy($fichero_storage,$fichero_public);
          $fichero=public_path().'/images/bp/'.$nombre_imagen;
          unlink(public_path()."/images/bp/".$this->name_image);
          unlink(public_path()."/botpress12120/data/bots/icibot/media/".$this->name_image);
          //dd($this->name_image,$this->image_nueva);
          rename(public_path()."/images/bp/".$nombre_imagen,public_path()."/images/bp/".$this->name_image);
          rename(public_path()."/botpress12120/data/bots/icibot/media/".$nombre_imagen,public_path()."/botpress12120/data/bots/icibot/media/".$this->name_image);
       }
     }   

    $i=0;
    /*while($i<$tam){
    //dd($request->pregunta);
    //dd($question->pregunta);
    //if($i+1==11){
        //RUTA DE LA CARPETA PUBLIC + RUTA DE DIRECTORIO HASTA CARPETA QNA DONDE RECORRERA CADA UNO DE LOS NOMBRES DE LOS ARCHIVOS QUE TIENE ALMACENADO EN LA VARIABLE RES2
    $find=strpos($res2[$i]["Nombre"],$cadena_final_actual);
     //dd($res);
    //dd($find);
    if($find==false){
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res2[$i]["Nombre"]);
    //print_r($res2[$i]["Nombre"]);
   }else{
    //EL STRING QUE SE ESTA BUSCANDO EN LOS ARCHIVOS DE LA CARPETA QNA, PARA MODIFICAR ALGUNA DE LAS PREGUNTAS, QUE COMO $patron como 
    //en este caso no lleva coma, sabemos que no será el ultimo del arreglo questions: es:[]
    $patron= '"'.$question->pregunta.'","';
        // LO QUE SE DESEA ESCRIBIR COMO NUEVA PREGUNTA EN LA TABLA QUESTIONS Y EN LA BASE DE DATOS DE BOTPRESS MEDIANTE MODIFICACION DE ARCHIVO .JSON SE LOGRARÁ.
    $sustitucion='"'.$this->pregunta.'","';
    //dd($sustitucion);
    //}
       //SE ALMACENA LO QUE SE LEE INTERNAMENTE EN EL ARCHIVO
        $leer = fopen($path_archivo, 'r+');
      $data = fread($leer, filesize($path_archivo));
      //dd($data , $patron, $sustitucion);
      //se cierra la lectura del archivo
      fclose($leer);
    //SI EN EL ARCHIVO ENCUENTRA $patron entonces lo cambiará por $sustitucion y copiará lo demas del archivo data en la variable $datosnuevos
      $datosnuevos = str_replace($patron,$sustitucion,$data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //SE ABRE EL ARCHIVO APRA ESCRITURA
      $escribir = fopen($path_archivo, 'w');
     //Se escribe en $datosnuevos los en el aarchivo que corresponda a esta iteracion
      fwrite($escribir, $datosnuevos);
      fclose($escribir);
      //dd($datosnuevos);
    }
    $i=$i+1;
    //print_r($i);
  }*/

     //dd($datosnuevos);
    //Se cierra directorio
     $dir2->close();
   //dd($archivo_nombre_original,$archivo_nombre_nuevo);
  //MODIFICANDO RESPUESTA DE QNA QUESTION PREGUNTA 
  $tam=sizeof($res2);
  $i=0;
  /*while($i<$tam){
    //dd($request->pregunta);
    //dd($question->pregunta);
    //if($i+1==11){
    //Se abre cada uno de los archivos de la carpeta  QNA, SI SE MODIFICA EL NOMBRE DE BOT DESDE icibot a otro nombree modificar numero 35
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res2[$i]["Nombre"]);
    //dd($path_archivo);
     $find=strpos($res2[$i]["Nombre"],$cadena_final_actual);
     //dd($res[$i]["Nombre"],$res2[$i]["Nombre"],$cadena_final_actual);
    //dd($find);
    if($find==false){
         $archivo_nombre_original=(substr($res2[$i]["Nombre"],35,-5)).'.json';
      $archivo_nombre_nuevo=str_replace($cadena_final_actual,$cadena_final,(substr($res2[$i]["Nombre"],35,-5))).'.json';
    //print_r($res2[$i]["Nombre"]);
    }else{
       //dd($archivo_nombre_original,$res2[$i]["Nombre"]);
      $archivo_nombre_original=(substr($res2[$i]["Nombre"],35,-5)).'.json';
    //dd($path_archivo,$archivo_nombre_original);
    //EL STRING QUE SE ESTA BUSCANDO EN LOS ARCHIVOS DE LA CARPETA QNA, PARA MODIFICAR ALGUNA DE LA RESPUESTAS, QUE COMO $patron como 
    //en este caso no lleva coma, sabemos que no será el ultimo del arreglo answers: es:[], cbae señalar que las respuestas de QNA son solo son una fla con el texto entre comillas, no tienen ninguna coma final al ser solo una respuesta única.
    $patron= '"'.$answer->nombre.'"';
    //dd($patron);
    $sustitucion='"'.$request->respuesta.'"';
    $sustitucion2=str_replace($cadena_final_actual,$cadena_final,$patron2);
    $archivo_nombre_nuevo=str_replace($cadena_final_actual,$cadena_final,(substr($res2[$i]["Nombre"],35,-5))).'.json';
    //dd($archivo_nombre_nuevo);
    //dd($archivo_nombre_original,$archivo_nombre_nuevo);
    //}
     //Abro el archivo que corresponda para leerlo
      $leer = fopen($path_archivo, 'r+');
      //lo leo y copio eso en la variable $data
      $data = fread($leer, filesize($path_archivo));
      //cierro el archivo para leer
      fclose($leer);
    //SI EN EL ARCHIVO ENCUENTRA $patron entonces lo cambiará por $sustitucion y copiará lo demas del archivo data en la variable $datosnuevos
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //dd($datosnuevos);
      //Abro el archivo para escribir en el
      $escribir = fopen($path_archivo, 'w');
      //Escribo lo que se encuentra en $datosnuevos lo que see haya en el archivo respectivo de la iteración en la que estemos
      fwrite($escribir, $datosnuevos);
      //Cerramos el archivo apara escribir
      fclose($escribir);
      //dd($question_min_id,$question->id,"C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/qna/".$archivo_nombre_original,"C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/qna/".$archivo_nombre_nuevo);
        if($question_min_id==$question->id){
     rename("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/qna/".$archivo_nombre_original,"C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/qna/".$archivo_nombre_nuevo);
     }
    }
      //dd($datosnuevos);
    $i=$i+1;
    //print_r($i);
  }*/
  //dd($archivo_nombre_original,$archivo_nombre_nuevo);


  

   //$answer->nombre=$request->nombre;
   //$answer->save();
   //$dir2->close();
   } 
  //dd($this->agregar);
  /* $imagenes=DB::table('qnas_images')->where('id_answer','=',$question->id_answers)->get();
   foreach($imagenes as $imagen);
   //dd($imagen,$es_archivo_flow);
   //Actualizamos la base de datos mysql con las respectivas tablas
  //dd($request);
   DB::table('questions')->where('id', $this->selected_id)->update(['pregunta' => $request->pregunta]);
   //$question->pregunta=$request->pregunta;
   //$question->save();
   //dd($request);
    DB::table('answer')->where('id','=',$question->id_answers)->update(['nombre'=>$request->respuesta,'vence'=>$request->vence,'fecha_caducacion'=>date('Y-m-d',strtotime($request->fecha_vencimiento))]);*/
    //dd($this);
  $tam_array_imagen=0;
        if ($this->selected_id){

            $pregeditar = ArchivoPregunta::find($this->selected_id);
            $pregunta_copy=DB::table('questions')->select('pregunta')->where('id_answers','=',$this->selected_id)->get();
            $this->pregunta_copy=array();

            foreach($pregunta_copy as $pregunta_hecha){
              array_push($this->pregunta_copy,$pregunta_hecha->pregunta);
            }
            //dd($this->agregar);
            //dd($this->pregunta_copy);

            $cantidad_preguntas_anterior=count($this->pregunta_copy);
            $cantidad_preguntas_nueva=count($this->pregunta);

            //dd($this->pregunta,$this->pregunta_copy,$cantidad_preguntas_nueva,$cantidad_preguntas_anterior);
            if($cantidad_preguntas_anterior<$cantidad_preguntas_nueva){
            $i=0;
             foreach($this->pregunta_copy as $pregunta_actual){
                DB::table('questions')->where('pregunta','=',$pregunta_actual)->update(['pregunta'=> $this->pregunta[$i]]);
                $i=$i+1;
                //dd($pregunta_actual);
            }
                
                   //dd($this,$i,$cantidad_preguntas_anterior,$cantidad_preguntas_nueva,$questions,$this->pregunta_copy,$$this->pregunta);
                    while($i<$cantidad_preguntas_nueva){
                        $questions_existe=DB::table('questions')->where('pregunta','=',$this->pregunta[$i])->count();
                        //dd($questions);
                        if($questions_existe==0){
                        DB::table('questions')->insert([
                            'pregunta' => $this->pregunta[$i],
                            'id_answers' => $this->selected_id
                     ]);
                      }
                $i=$i+1;
                    }
                    //$questions=DB::table('questions')->get();
                    //dd($this,$i,$cantidad_preguntas_anterior,$cantidad_preguntas_nueva,$questions,$this->pregunta_copy,$this->pregunta);
            }elseif($cantidad_preguntas_anterior==$cantidad_preguntas_nueva){
               //dd($this->agregar);    
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
                'id_categoria'=>$this->id_categoria,
                'vence' => $this->vence,
                'fecha_caducacion' => $this->fecha_caducacion,
                'contexto'=> $this->contexto,
            ]);
                   
            //dd($this,$imagenes_nuevas,$cantidad_preguntas_anterior,$cantidad_preguntas_nueva,$pregeditar);
            if($this->agregar!=1){
              session()->flash('message', 'Pregunta actualizada correctamente');
            }else{
              $this->agregar=0;
            }
            //dd($this->agregar);
          }
        }else{
          //dd($this);
          $this->pregunta_copy=null;
          $this->pregunta_copy=array();
          $this->cant_preguntas=count($this->pregunta);
          //dd($this->pregunta);
          for($i=0;$i<$this->cant_preguntas;$i++){
                if(array_key_exists($i,$this->pregunta)){
                  array_push($this->pregunta_copy,$this->pregunta[$i]);
                }
          }
          //dd($this->pregunta_copy,$this);
          $this->pregunta=null;
          $this->pregunta=array();
          for($i=0;$i<$this->cant_preguntas-1;$i++){
              array_push($this->pregunta,$this->pregunta_copy[$i]);
          }
          //dd($this);
          $this->remove=0;
          session()->flash('message_delete', 'Se ha eliminado Input elemento de la Base de Datos y Archivos Botpress Correctamente');
        }
    }


}

