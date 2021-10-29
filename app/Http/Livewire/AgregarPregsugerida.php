<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\preguntas_sin_respuestas as PregSugeridas;
use App\Models\Answers as ArchivoPregunta;
use App\Models\Question as Preguntas;
use App\Models\Categorias;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use DB;

class AgregarPregsugerida extends Component
{
    public $resp, $vence, $fecha_caducacion, $categoria, $nueva_cat, $archivo_qna, $habilitada, $pregunta, $id_foranea, $contexto, $respuesta_existente, $answers, $resp2;
    public $inputs = [];
    public $i = 1;
    public $PregSugerida;

    public function render()
    {
      $categorias = Categorias::all();
      return view('livewire.agregar-pregsugerida',['categorias' => $categorias]);
    }

    public function mount()
    {
        $this->pregunta[0] = $this->PregSugerida->pregunta_sin_respuesta;
        $this->respuesta_existente=null;
        $this->answers=ArchivoPregunta::all();
        $this->contexto="global";
        $this->categoria = "1";
        //dd($this->answers,$this->respuesta_existente,$this);
    }

    public function delete($id)
    {
        PregSugeridas::find($id)->delete();
        session()->flash('message', 'Sugerencia eliminada del sistema.');
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

   public function store()
    {
        if($this->respuesta_existente==false){
        $this->validate([
            'resp' => 'required|min:2',
            'pregunta.0' => 'required|min:1|max:100',
            'pregunta.*' => 'required|min:1|max:100',
        ],
        [
            'resp.required' => 'Debes ingresar una respuesta',
            'pregunta.0.required' => 'No puedes ingresar preguntas en blanco',
            'pregunta.*.required' => 'No puedes ingresar preguntas en blanco'
        ]);

        if ($this->vence != 1){
            $this->vence = null;
            $this->fecha_caducacion = null;
        }

        if ($this->categoria == 'nueva'){
        $categoria_creada = Categorias::create(['nombre' => $this->nueva_cat]);
        $this->categoria = $categoria_creada->id;
       }

        
            $id=$this->PregSugerida->id;
          $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
         $a=0;
         $cantidad_preguntas=count($this->pregunta);
        //dd($this,$a,$cantidad_preguntas,isset($this->pregunta[1]));
 
              

        $question=$this->pregunta[$a]."\r\n";
        //dd($question);
        $charactersLength=strlen($characters);
        $randomString = '';
    for ($i = 0; $i < 10; $i++){
        if($i==9)
        {
          $characters='abcdefghijklmnopqrstuvwxyz';
          $charactersLength=strlen($characters);
        }
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    } 
    //dd($randomString);
     $nombre_parte1='__qna__'.$randomString;
    //$nombre_parte1=$randomString;
     //dd($nombre_parte1);
     //Reemplazamos la A y a
        //dd(strlen($this->pregunta));dd($request,$nombre_archivo);
     //dd($request);
        $cadena=$this->pregunta[$a];
        //dd($cadena);
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('_', '_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena );
 
        //Reemplazamos la N, n, C y c

        //OBSERVAR QUE OCURRE CON LOS TERMINOS CON Ñ
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', '_', '_'),
        $cadena
        );

        $init_interrogacion=substr_count($cadena, '¿');
        $cerrar_interrogacion=substr_count($cadena, '?');
          $pos_inicial = strpos($cadena, '¿');
          $pos_final = strpos($cadena,'?');
          $largo_cadena=strlen($cadena);
          ///dd($cadena);
          //dd($pos_inicial);
          //dd($pos_final);
          //dd($largo_cadena,$cadena,$init_interrogacion,$cerrar_interrogacion);

        if(($init_interrogacion==0 and $cerrar_interrogacion==0)){
                //dd($request);
          $cadena_final=$cadena;
           $cadena_final = str_replace(array(' '),array('_'),$cadena_final);
           $cadena_final =strtolower($cadena_final);
           $nombre_archivo='__qna__'.$randomString.'_'.$cadena_final;
        $nombre_archivo2=$randomString.'_'.$cadena_final;
        $name_qna='__qna__'.$randomString.$cadena_final;
        $id_qna=$randomString.'_'.$cadena_final;
           //dd($cadena_final,$nombre_archivo,$nombre_archivo2);
            $path_archivo1=public_path("botpress12120/data/bots/icibot/intents/".$nombre_archivo.".json");
        //dd($path_archivo1);
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
    $tam=sizeof($res);
  $vector_substring=array();
  //dd($vector_substring);


   $archivo_ejemplo1=public_path("__qna__intents_prueba.txt");
        $archivo_ejemplo2=public_path("qna__qna_prueba.txt");

        $leer1 = fopen($archivo_ejemplo1, 'r+');
        $numlinea=0;
        while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        fclose($leer1);
      //dd($this,$aux,$numlinea);
        $ultimas_4_lineas=array();
        $ultimas_4_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-3;
      while($i<$numlinea){
           $ultimas_4_lineas[$j]=$aux[$i];
           $j=$j+1;
          $i=$i+1;
      }
       //dd($this,$aux,$numlinea,$ultimas_4_lineas);
      $i=0;
      $a=0;
       while($i<$numlinea){
        $buscar_utterances=strpos($aux[$i],'"utterances": {');
        $buscar_es_pregunta=strpos($aux[$i+1],'"es": []');
         $buscar_es_llave=strpos($aux[$i+2],'},');
         $global=strpos($aux[$i], "global");
         $name_vacio=strpos($aux[$i],'"name": "",');
        if($buscar_utterances!=false and $buscar_es_pregunta!=false and $buscar_es_llave!=false){
          //dd($buscar_utterances,$buscar_es_pregunta,$buscar_es_llave,$i,$this,$aux);
          $aux[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          //dd($aux);
          if($cantidad_preguntas==1){
                $aux[$i+2]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
                //dd($aux);
          }else{
             //dd($aux);
           $b=0;
           $c=2;
           while($b<$cantidad_preguntas){
            if(isset($this->pregunta[$a])==true){
              if($b+1<$cantidad_preguntas){
           $aux[$i+$c]='        '.'"'.$this->pregunta[$a].'",'."\r\n";
            }else{
                //dd($aux,$b);
                $aux[$i+$c]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
            }

            $b=$b+1;
            }else{
                //dd($a,$c);
             $c=$c-1;
            }
           //dd($aux,$this->pregunta,$a,$b,$c);
           $a=$a+1;
           $c=$c+1;
            }
          $aux[$i+$c]=$ultimas_4_lineas[0];
          $aux[$i+1+$c]=$ultimas_4_lineas[1];
          array_push($aux,$ultimas_4_lineas[2]);
          array_push($aux,$ultimas_4_lineas[3]);
          //dd($aux,$cantidad_preguntas,$this->pregunta,$path_archivo1);
        }
    }if($global!=false){
          $aux[$i]=str_replace("global",$this->contexto,$aux[$i]);
        }if($name_vacio!=false){
            $aux[$i]=str_replace('"name": "",','"name":'.' "'.'__qna__'.$randomString.'_'.$cadena_final.'",',$aux[$i]);
        /*elseif($aux[$i]=='"utterances": {' and $aux[$i+1]=='"es": [' and $aux[$i+2]!='},'){
          $aux[$i+1]='"es": [';
          $aux[$i+2]='       "'.$this->pregunta.'"';
          $aux[$i+3]=']';
        }*/
        //dd($aux);
      }
       

       $i=$i+1;         
    }
    //dd($aux);
     $contenido="";
       $i=0;
       $tam_array_aux=count($aux);
      while($i<$tam_array_aux){
        $contenido .=$aux[$i];
        $i=$i+1;
      }
      //unlink($path_archivo);

       $escribir = fopen($path_archivo1, 'w+');
         fwrite($escribir, $contenido);
       fclose($escribir);
      //dd($request,$aux,$aux[6],$numlinea,$ultimas_4_lineas,$contenido);
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
         //$data1 = fread($leer1, filesize($archivo_ejemplo1));
        //dd($data1);
      
       //CARPETA QNA CREAR ARCHIVO


        $path_archivo2=public_path("botpress12120/data/bots/icibot/qna/".$nombre_archivo2.".json");
        $leer2 = fopen($archivo_ejemplo2, 'r+');
        $numlinea=0;
         while ($linea = fgets($leer2)){
        //echo $linea.'<br/>';
            $aux_qna[] = $linea;    
             $numlinea++;
        }
        fclose($leer2);
      //dd($this,$aux_qna,$numlinea);
      $ultimas_8_lineas=array();
        $ultimas_8_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-8;
      while($i<$numlinea){
           $ultimas_8_lineas[$j]=$aux_qna[$i];
           $j=$j+1;
          $i=$i+1;
      }
       //dd($this,$aux_qna,$numlinea,$ultimas_8_lineas);
      $i=0;
      $a=0;
      $b=0;
      $c=0;
     while($i<$numlinea){
        $buscar_questions=strpos($aux_qna[$i],'"questions": {');
        $buscar_answers=  strpos($aux_qna[$i],'"answers": {');
        $buscar_es_corchete=strpos($aux_qna[$i+1],'"es": []');
        $global=strpos($aux_qna[$i], "global");
        $id_vacio=strpos($aux_qna[$i],'"id": "",');
        //$buscar_es_corchete_solo=strpos($aux_qna[$i+2],']');
         $buscar_es_llave=strpos($aux_qna[$i+2],'},');
         if($buscar_questions!=false){
          //dd($aux_qna,$i,'buscar_questions es distinto de false',$buscar_questions,$buscar_es_corchete,$buscar_es_llave);
        }
        if($buscar_answers!=false and $buscar_es_corchete!=false and $buscar_es_llave!=false){
          //dd($buscar_utterances,$buscar_es_pregunta,$buscar_es_llave,$i);
          $aux_qna[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          $aux_qna[$i+2]='        '.'"'.$this->resp.'"'."\r\n";
          $aux_qna[$i+3]=$ultimas_8_lineas[0];
          $aux_qna[$i+4]=$ultimas_8_lineas[1];
          $aux_qna[$i+5]=$ultimas_8_lineas[2];
          $aux_qna[$i+6]=$ultimas_8_lineas[3];
          $aux_qna[$i+7]=$ultimas_8_lineas[4];
          $aux_qna[$i+8]=$ultimas_8_lineas[5];
          $aux_qna[$i+9]=$ultimas_8_lineas[6];
          $aux_qna[$i+10]=$ultimas_8_lineas[7];
          $aux_qna[$i+11]=$ultimas_8_lineas[8];
          //dd($aux_qna,$ultimas_8_lineas);
        }elseif($buscar_questions!=false and $buscar_es_corchete!=false and $buscar_es_llave!=false){
          $aux_qna[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          if($cantidad_preguntas==1){
          $aux_qna[$i+2]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
          }else{
           $b=0;
           $c=2;
           while($b<$cantidad_preguntas){
            if(isset($this->pregunta[$a])==true){
              if($b+1<$cantidad_preguntas){
           $aux_qna[$i+$c]='        '.'"'.$this->pregunta[$a].'",'."\r\n";
            }else{
                //dd($aux,$b);
                $aux_qna[$i+$c]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
            }

            $b=$b+1;
            }else{
                //dd($a,$c);
             $c=$c-1;
            }
           //dd($aux,$this->pregunta,$a,$b,$c);
           $a=$a+1;
           $c=$c+1;

            }
          //$aux_qna[$i+2]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
          $aux_qna[$i+$c]=$ultimas_8_lineas[0];
          $aux_qna[$i+2+$c]=$ultimas_8_lineas[4];
          $aux_qna[$i+3+$c]=$ultimas_8_lineas[5];
          $aux_qna[$i+4+$c]=$ultimas_8_lineas[6];
          $aux_qna[$i+5+$c]=$ultimas_8_lineas[7];
          $aux_qna[$i+6+$c]=$ultimas_8_lineas[8];
          //dd($aux_qna,$this->pregunta,$a,$c);
        }
        }if($global!=false){
          $aux_qna[$i]=str_replace("global",$this->contexto,$aux_qna[$i]);
        }if($id_vacio!=false){
            $aux_qna[$i]=str_replace('"id": "",','"id":'.' "'.$id_qna.'",',$aux_qna[$i]);
            $global=strpos($aux_qna[$i], "global");
          }
        $i=$i+1;

      }


//dd($aux_qna);
    

      $contenido=null;
       $contenido="";
       $i=0;
       $tam_array_aux_qna=count($aux_qna);
       //dd($tam_array_aux_qna,$aux_qna);
      while($i<$tam_array_aux_qna){
        if(isset($aux_qna[$i])==true){
                $contenido .=$aux_qna[$i];
        }
                $i=$i+1;
      }
      $aux_qna[$tam_array_aux_qna]="}"."\r\n";
      //dd($aux_qna);
      $contenido.=$aux_qna[$tam_array_aux_qna];
      //$aux_qna[$tam_array_aux_qna-6]=$aux_qna[$tam_array_aux_qna-6]."\r\n";
      //dd($aux_qna,$tam_array_aux_qna);
      //unlink($path_archivo2);

       $escribir2 = fopen($path_archivo2, 'w+');
         fwrite($escribir2, $contenido);
       fclose($escribir2);
       $registro = ArchivoPregunta::create(['nombre' => $this->resp, 'vence' => $this->vence, 'fecha_caducacion' => $this->fecha_caducacion, 'id_categoria' => $this->categoria, 'contexto' => $this->contexto, 'archivo_qna' => $nombre_archivo2, 'habilitada' => 1 ]);

        foreach ($this->pregunta as $key => $value) {
            Preguntas::create(['pregunta' => $this->pregunta[$key], 'id_answers' => $registro->id ]);
        }
        
        $this->inputs = [];
        $this->delete($id);
        session()->flash('message', 'Pregunta sugerida ingresada en el sistema');
        return redirect()->route('index_preguntas_sugeridas');
  

        //dd($aux_qna,$aux);
    }elseif($init_interrogacion==1 and $cerrar_interrogacion==1){
        $cadenaf1 = str_replace("¿", "", $cadena);
        $cadenaf2 = str_replace("?","",$cadenaf1);
        $cadena_final=strtolower($cadenaf2);
         $cadena_final = str_replace(array(' '),array('_'),$cadena_final);
         //dd($this,$cadena_final);
        //dd($request,$nombre_archivo);
        $nombre_archivo='__qna__'.$randomString.'_'.$cadena_final;
        $nombre_archivo2=$randomString.'_'.$cadena_final;
        $name_qna='__qna__'.$randomString.$cadena_final;
        $id_qna=$randomString.'_'.$cadena_final;

        $path_archivo1=public_path("botpress12120/data/bots/icibot/intents/".$nombre_archivo.".json");
        //dd($path_archivo1);
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

  $tam=sizeof($res);
  $vector_substring=array();
  //dd($vector_substring);
        $i=0;
  //Si el valor de i es menor a la cantidad de archivos entonces saldrá del ciclo while
   /*while($i<$tam){
    
    //Se van abriendo cada uno de los archivos de la carpeta hasta que abre todos los archivos de la carpeta
    $path_archivo=public_path($res[$i]["Nombre"]);
    $pos = strpos($path_archivo, $cadena_final);
    //dd($pos);
    array_push($vector_substring,$pos);
    //$vector_substring=array($i=>$pos);
    //dd($vector_substring);
    //dd($path_archivo);
    //print_r($res2[$i]["Nombre"]);
    //El texto que se desea modificar en el archivo de texto
    //dd($pos);
    if($pos==true){
        //print_r($path_archivo);
        //return('ARCHIVO YA HA SIDO CREADO Y PREGUNTA(QUESTION) REALIZADA');
        //dd($pos);
        $i=$tam;
    }
      //dd($datosnuevos);
      //Se le suma uno a $i y se abre el siguiente archivo siempre y cuando $i< la cantidad de archivos en esta carpeta
    $i=$i+1;
    //print_r($i);
   //}
  }*/
  $archivo_ejemplo1=public_path("__qna__intents_prueba.txt");
        $archivo_ejemplo2=public_path("qna__qna_prueba.txt");

        $leer1 = fopen($archivo_ejemplo1, 'r+');
        $numlinea=0;
        while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        fclose($leer1);
      //dd($this,$aux,$numlinea);
      $ultimas_4_lineas=array();
        $ultimas_4_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-3;
      while($i<$numlinea){
           $ultimas_4_lineas[$j]=$aux[$i];
           $j=$j+1;
          $i=$i+1;
      }
       //dd($this,$aux,$numlinea,$ultimas_4_lineas);
      $i=0;
      $a=0;
      while($i<$numlinea){
        $buscar_utterances=strpos($aux[$i],'"utterances": {');
        $buscar_es_pregunta=strpos($aux[$i+1],'"es": []');
         $buscar_es_llave=strpos($aux[$i+2],'},');
         $global=strpos($aux[$i], "global");
         $name_vacio=strpos($aux[$i],'"name": "",');
        if($buscar_utterances!=false and $buscar_es_pregunta!=false and $buscar_es_llave!=false){
          //dd($buscar_utterances,$buscar_es_pregunta,$buscar_es_llave,$i,$this,$aux);
          $aux[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          //dd($aux);
          if($cantidad_preguntas==1){
                $aux[$i+2]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
                //dd($aux);
          }else{
            //dd($aux);
           $b=0;
           $c=2;
           while($b<$cantidad_preguntas){
            if(isset($this->pregunta[$a])==true){
              if($b+1<$cantidad_preguntas){
           $aux[$i+$c]='        '.'"'.$this->pregunta[$a].'",'."\r\n";
            }else{
                //dd($aux,$b);
                $aux[$i+$c]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
            }

            $b=$b+1;
            }else{
                //dd($a,$c);
             $c=$c-1;
            }
           //dd($aux,$this->pregunta,$a,$b,$c);
           $a=$a+1;
           $c=$c+1;
               /* if($a==6){
            dd($aux,$this->pregunta,$a,$b,$c,$cantidad_preguntas);
        }*/
        /*if($b==$cantidad_preguntas){
                    dd($b,$cantidad_preguntas,$aux,$i,$c);
                }*/
            }
          $aux[$i+$c]=$ultimas_4_lineas[0];
          $aux[$i+1+$c]=$ultimas_4_lineas[1];
          array_push($aux,$ultimas_4_lineas[2]);
          array_push($aux,$ultimas_4_lineas[3]);
          //dd($aux,$cantidad_preguntas,$this->pregunta);
        }
    }if($global!=false){
          $aux[$i]=str_replace("global",$this->contexto,$aux[$i]);
          //dd($aux);
        }if($name_vacio!=false){
            $aux[$i]=str_replace('"name": "",','"name":'.' "'.$name_qna.'",',$aux[$i]);
        /*elseif($aux[$i]=='"utterances": {' and $aux[$i+1]=='"es": [' and $aux[$i+2]!='},'){
          $aux[$i+1]='"es": [';
          $aux[$i+2]='       "'.$this->pregunta.'"';
          $aux[$i+3]=']';
        }*/
        //dd($aux);
      }
       

       $i=$i+1;         
    }

    //dd($aux,$nombre_archivo);

       $contenido="";
       $i=0;
       $tam_array_aux=count($aux);
      while($i<$tam_array_aux){
        $contenido .=$aux[$i];
        $i=$i+1;
      }
      //unlink($path_archivo);

       $escribir = fopen($path_archivo1, 'w+');
         fwrite($escribir, $contenido);
       fclose($escribir);
      //dd($this,$aux,$aux[6],$numlinea,$ultimas_4_lineas,$contenido);
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
         //$data1 = fread($leer1, filesize($archivo_ejemplo1));
        //dd($data1);
      
       //CARPETA QNA CREAR ARCHIVO


        $path_archivo2=public_path("botpress12120/data/bots/icibot/qna/".$nombre_archivo2.".json");
        $leer2 = fopen($archivo_ejemplo2, 'r+');
        $numlinea=0;
         while ($linea = fgets($leer2)){
        //echo $linea.'<br/>';
            $aux_qna[] = $linea;    
             $numlinea++;
        }
        fclose($leer2);
      //dd($this,$aux,$numlinea);
      $ultimas_8_lineas=array();
        $ultimas_8_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-8;
      while($i<$numlinea){
           $ultimas_8_lineas[$j]=$aux_qna[$i];
           $j=$j+1;
          $i=$i+1;
      }
       //dd($request,$aux_qna,$numlinea,$ultimas_8_lineas);
      $i=0;
      $a=0;
      $b=0;
      $c=0;
      while($i<$numlinea){
        $buscar_questions=strpos($aux_qna[$i],'"questions": {');
        $buscar_answers=  strpos($aux_qna[$i],'"answers": {');
        $buscar_es_corchete=strpos($aux_qna[$i+1],'"es": []');
        $global=strpos($aux_qna[$i], "global");
        $id_vacio=strpos($aux_qna[$i],'"id": "",');

        //$buscar_es_corchete_solo=strpos($aux_qna[$i+2],']');
         $buscar_es_llave=strpos($aux_qna[$i+2],'},');
         if($buscar_questions!=false){
          //dd($aux_qna,$i,'buscar_questions es distinto de false',$buscar_questions,$buscar_es_corchete,$buscar_es_llave);
        }
        if($buscar_answers!=false and $buscar_es_corchete!=false and $buscar_es_llave!=false){
          //dd($buscar_utterances,$buscar_es_pregunta,$buscar_es_llave,$i);
          $aux_qna[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          $aux_qna[$i+2]='        '.'"'.$this->resp.'"'."\r\n";
          $aux_qna[$i+3]=$ultimas_8_lineas[0];
          $aux_qna[$i+4]=$ultimas_8_lineas[1];
          $aux_qna[$i+5]=$ultimas_8_lineas[2];
          $aux_qna[$i+6]=$ultimas_8_lineas[3];
          $aux_qna[$i+7]=$ultimas_8_lineas[4];
          $aux_qna[$i+8]=$ultimas_8_lineas[5];
          $aux_qna[$i+9]=$ultimas_8_lineas[6];
          $aux_qna[$i+10]=$ultimas_8_lineas[7];
          $aux_qna[$i+11]=$ultimas_8_lineas[8];
          //dd($aux_qna,$ultimas_8_lineas);
        }elseif($buscar_questions!=false and $buscar_es_corchete!=false and $buscar_es_llave!=false){
          $aux_qna[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          if($cantidad_preguntas==1){
          $aux_qnaa[$i+2]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
          }else{
           $b=0;
           $c=2;
           while($b<$cantidad_preguntas){
            if(isset($this->pregunta[$a])==true){
              if($b+1<$cantidad_preguntas){
           $aux_qna[$i+$c]='        '.'"'.$this->pregunta[$a].'",'."\r\n";
            }else{
                //dd($aux,$b);
                $aux_qna[$i+$c]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
            }

            $b=$b+1;
            }else{
                //dd($a,$c);
             $c=$c-1;
            }
           //dd($aux,$this->pregunta,$a,$b,$c);
           $a=$a+1;
           $c=$c+1;

            }
          //$aux_qna[$i+2]='        '.'"'.$this->pregunta[$a].'"'."\r\n";
          $aux_qna[$i+$c]=$ultimas_8_lineas[0];
          $aux_qna[$i+2+$c]=$ultimas_8_lineas[4];
          $aux_qna[$i+3+$c]=$ultimas_8_lineas[5];
          $aux_qna[$i+4+$c]=$ultimas_8_lineas[6];
          $aux_qna[$i+5+$c]=$ultimas_8_lineas[7];
          $aux_qna[$i+6+$c]=$ultimas_8_lineas[8];
          //dd($aux_qna,$this->pregunta,$a,$c);
        }
        }if($global!=false){
          $aux_qna[$i]=str_replace("global",$this->contexto,$aux_qna[$i]);
          //dd($aux_qna);
        }if($id_vacio!=false){
            $aux_qna[$i]=str_replace('"id": "",','"id":'.' "'.$id_qna.'",',$aux_qna[$i]);
            $global=strpos($aux_qna[$i], "global");
          }
        $i=$i+1;

      }


  //dd($aux_qna);

      $contenido=null;
       $contenido="";
       $i=0;
       $tam_array_aux_qna=count($aux_qna);
       //dd($tam_array_aux_qna,$aux_qna);
      while($i<$tam_array_aux_qna){
        if(isset($aux_qna[$i])==true){
                $contenido .=$aux_qna[$i];
        }
                $i=$i+1;
      }
        $aux_qna[$tam_array_aux_qna]="}"."\r\n";
        $contenido.=$aux_qna[$tam_array_aux_qna];
       $escribir2 = fopen($path_archivo2, 'w+');
         fwrite($escribir2, $contenido);
       fclose($escribir2);

       $registro = ArchivoPregunta::create(['nombre' => $this->resp, 'vence' => $this->vence, 'fecha_caducacion' => $this->fecha_caducacion,  'id_categoria' => $this->categoria, 'contexto' => $this->contexto, 'archivo_qna' => $nombre_archivo2, 'habilitada' => 1 ]);

        foreach ($this->pregunta as $key => $value) {
            Preguntas::create(['pregunta' => $this->pregunta[$key], 'id_answers' => $registro->id ]);
        }
        $this->inputs = [];
        $this->delete($id);
        session()->flash('message', 'Pregunta sugerida ingresada en el sistema');
        return redirect()->route('index_preguntas_sugeridas');

  //dd($vector_substring);

//dd($this,$aux_qna,$aux,$numlinea,$ultimas_8_lineas);
}else{
    $this->inputs = [];
    //dd('AQUI DEBE ENTRAR');
    session()->flash('problema_con_parentesis', 'Los signos de pregunta no estan parejos');
}

}elseif($this->respuesta_existente==true){
      //dd($this);
      $answers=DB::table('answer')->where('id','=',$this->resp2)->get();
      //dd($this,$answers);
      foreach($answers as $archivo_qna);
      //dd($archivo_qna);
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
  //dd($this,$archivo_qna->nombre,$res[$i]["Nombre"],$res2[$j]["Nombre"]);
}
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
        
        fclose($leer1);
        $questions=DB::table('questions')->where('id_answers','=',$this->resp2)->get();
        foreach($questions as $question);
        $i=0;
        $k=0;
        $cont_corchete=0;
        $a=0;
        $b=0;
        //dd($this->pregunta);
        $pregunta=array();
        $tam_preguntas_nuevas=count($this->pregunta);
         while($b<$tam_preguntas_nuevas){
            if(array_key_exists($a,$this->pregunta)){
                 array_push($pregunta,$this->pregunta[$a]);
                 //array_push($this->inputs,$b+1);
                 $b++;
            }
            $a++;
        }
        $tam_archivo_intents=count($aux_intents);
        while($i<$tam_archivo_intents){
              $pos_corchete=strpos($aux_intents[$i],"]");
             if($pos_corchete!=false){
                $cont_corchete=$cont_corchete+1;
             }
             if($cont_corchete==2 and $tam_preguntas_nuevas==1){
                    $aux_intents[$i-1]='       "'.$question->pregunta.'",'."\r\n";
                    $aux_intents[$i]='       "'.$pregunta[0].'"'."\r\n";
                    $aux_intents[$i+1]=$ultimas_4_lineas[0];
                    $aux_intents[$i+2]=$ultimas_4_lineas[1];
                    $aux_intents[$i+3]=$ultimas_4_lineas[2];
                    $aux_intents[$i+4]=$ultimas_4_lineas[3];
                    /*if($i==16){
                      dd($aux_intents,$aux_intents[$i],$this->pregunta_copy[$k],$this->pregunta[$k],$i,$k);
                    }*/
                  }elseif($cont_corchete==2 and $tam_preguntas_nuevas>1){
                    $aux_intents[$i-1]='       "'.$question->pregunta.'",'."\r\n";
                    $aux_intents[$i]='       "'.$pregunta[0].'",'."\r\n";
                    $a=1;
                    while($a<$tam_preguntas_nuevas){
                         //dd($aux_intents,$i,$a,$pregunta);
                         $aux_intents[$i+$a]='       "'.$pregunta[$a].'"'."\r\n"; 
                         $a=$a+1;
                    }
                    $i=$i+1;
                    $aux_intents[$i+1]=$ultimas_4_lineas[0];
                    $aux_intents[$i+2]=$ultimas_4_lineas[1];
                    $aux_intents[$i+3]=$ultimas_4_lineas[2];
                    $aux_intents[$i+4]=$ultimas_4_lineas[3];
                  }
              //dd($aux_intents,$pos,$this->pregunta_copy[$k],$this->pregunta[$k],$i,$k);
                  //dd($aux_intents,$aux_intents[3],substr($aux_intents[3],5,-3),$this->contexto,$this);
           if(substr($aux_intents[$i],5,-2)=="global" or substr($aux_intents[$i],5,-2)=="regular" or substr($aux_intents[$i],5,-2)=="egresado"){
            $aux_intents[$i]=str_replace(substr($aux_intents[$i],5,-2),$this->contexto,$aux_intents[$i]);
          }
           if(substr($aux_intents[$i],5,-3)=="global" or substr($aux_intents[$i],5,-3)=="regular" or substr($aux_intents[$i],5,-3)=="egresado"){
            $aux_intents[$i]=str_replace(substr($aux_intents[$i],5,-3),$this->contexto,$aux_intents[$i]);
          }
        $i=$i+1;
        }
        //dd($aux_intents);


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
       $k=0;
        $i=0;
        $j=0;
        $cont_corchete=0;
        //dd($ultimas_5_lineas);
        $tam_archivo_qna=count($aux_qna);
         $tam_archivo_intents=count($aux_intents);
        while($i<$tam_archivo_qna){
              $pos_corchete=strpos($aux_qna[$i],"]");
             if($pos_corchete!=false){
                $cont_corchete=$cont_corchete+1;
             }
             if($cont_corchete==3 and $tam_preguntas_nuevas==1){
                    $aux_qna[$i-1]='         "'.$question->pregunta.'",'."\r\n";
                    $aux_qna[$i]='         "'.$pregunta[0].'"'."\r\n";
                    $aux_qna[$i+1]=$ultimas_5_lineas[0];
                    $aux_qna[$i+2]=$ultimas_5_lineas[1];
                    $aux_qna[$i+3]=$ultimas_5_lineas[2];
                    $aux_qna[$i+4]=$ultimas_5_lineas[3];
                    $aux_qna[$i+5]=$ultimas_5_lineas[4];
                    $aux_qna[$i+6]=$ultimas_5_lineas[5];
                    /*if($i==16){
                      dd($aux_intents,$aux_intents[$i],$this->pregunta_copy[$k],$this->pregunta[$k],$i,$k);
                    }*/
                  }elseif($cont_corchete==3 and $tam_preguntas_nuevas>1){
                    //dd($aux_qna,$pregunta);
                    $aux_qna[$i-1]='         "'.$question->pregunta.'",'."\r\n";
                    $aux_qna[$i]='         "'.$pregunta[0].'",'."\r\n";
                    $a=1;
                    //dd($aux_qna);
                    while($a<$tam_preguntas_nuevas){
                         $aux_qna[$i+$a]='         "'.$pregunta[$a].'"'."\r\n"; 
                         $a=$a+1;
                    }
                    //dd($aux_qna,$i,$a);
                    $i=$i+$a;
                    $aux_qna[$i]=$ultimas_5_lineas[0];
                    $aux_qna[$i+1]=$ultimas_5_lineas[1];
                    $aux_qna[$i+2]=$ultimas_5_lineas[2];
                    $aux_qna[$i+3]=$ultimas_5_lineas[3];
                    $aux_qna[$i+4]=$ultimas_5_lineas[4];
                    $aux_qna[$i+5]=$ultimas_5_lineas[5];
                    $cont_corchete=$cont_corchete+1;
                  //dd($aux_qna,$i,$a,substr($aux_qna[5],7,-2));
                  }
              //dd($aux_intents,$pos,$this->pregunta_copy[$k],$this->pregunta[$k],$i,$k);
                  //dd($aux_intents,$aux_intents[3],substr($aux_intents[3],5,-3),$this->contexto,$this);
           if(substr($aux_qna[$i],7,-2)=="global" or substr($aux_qna[$i],7,-2)=="regular" or substr($aux_qna[$i],7,-2)=="egresado"){
            $aux_qna[$i]=str_replace(substr($aux_qna[$i],7,-2),$this->contexto,$aux_qna[$i]);
          }
           if(substr($aux_qna[$i],7,-3)=="global" or substr($aux_qna[$i],7,-3)=="regular" or substr($aux_qna[$i],7,-3)=="egresado"){
            $aux_qna[$i]=str_replace(substr($aux_qna[$i],7,-3),$this->contexto,$aux_qna[$i]);
          }
        $i=$i+1;
        }
        //dd($aux_intents,$aux_qna);
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
       $i=0;
       while($i<$tam_preguntas_nuevas){
                        $questions_existe=DB::table('questions')->where('pregunta','=',$pregunta[$i])->count();
                        //dd($questions);
                        if($questions_existe==0){
                        DB::table('questions')->insert([
                            'pregunta' => $pregunta[$i],
                            'id_answers' => $this->resp2,
                     ]);
                      }
                $i=$i+1;
                    }
                    $this->inputs = [];
        $this->delete($id);
        session()->flash('message', 'Pregunta sugerida ingresada en el sistema');
        return redirect()->route('index_preguntas_sugeridas');
}

    }


}