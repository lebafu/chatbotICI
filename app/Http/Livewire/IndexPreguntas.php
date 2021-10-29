<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Models\Question as Preguntas;
use App\Models\Categorias;
use Carbon\Carbon;
use DB;
use Livewire\WithPagination;

class IndexPreguntas extends Component
{
	 use WithPagination;
   public $orden, $estado, $filtro_cat, $cant_pagina;

    public function render()
    {
      $categorias = Categorias::all();
      $sietedias = Carbon::now()->addDays(7);
      if($this->estado == "todos"){
        if($this->filtro_cat == "todas"){
          return view('livewire.index-preguntas', [
            'archivoPregs' => ArchivoPregunta::orderBy('updated_at', $this->orden)->paginate($this->cant_pagina),
            'categorias' => $categorias,
            'fecha_limite' => $sietedias
          ]);
        }
        else{
          return view('livewire.index-preguntas', [
            'archivoPregs' => ArchivoPregunta::where('id_categoria', $this->filtro_cat)->orderBy('updated_at', $this->orden)->paginate($this->cant_pagina),
            'categorias' => $categorias,
            'fecha_limite' => $sietedias
          ]);
        }
      }
      else if($this->estado == "filtro_vence"){
        
        if($this->filtro_cat == "todas"){
          return view('livewire.index-preguntas', [
              'archivoPregs' => ArchivoPregunta::where('habilitada', 1)->where('fecha_caducacion', '<=', $sietedias)->orderBy('updated_at', $this->orden)->paginate($this->cant_pagina),
              'categorias' => $categorias,
              'fecha_limite' => $sietedias
          ]);
        }
        else{
          return view('livewire.index-preguntas', [
              'archivoPregs' => ArchivoPregunta::where('habilitada', 1)->where('fecha_caducacion', '<=', $sietedias)->where('id_categoria', $this->filtro_cat)->orderBy('updated_at', $this->orden)->paginate($this->cant_pagina),
              'categorias' => $categorias,
              'fecha_limite' => $sietedias
          ]);
        }
      }
      else{
        if($this->filtro_cat == "todas"){
          return view('livewire.index-preguntas', [
            'archivoPregs' => ArchivoPregunta::where('habilitada', $this->estado)->orderBy('updated_at', $this->orden)->paginate($this->cant_pagina),
            'categorias' => $categorias,
            'fecha_limite' => $sietedias
          ]); 
        }
        else{
          return view('livewire.index-preguntas', [
            'archivoPregs' => ArchivoPregunta::where('habilitada', $this->estado)->where('id_categoria', $this->filtro_cat)->orderBy('updated_at', $this->orden)->paginate($this->cant_pagina),
            'categorias' => $categorias,
            'fecha_limite' => $sietedias
          ]); 
        }
        
      }
      
    }

    public function mount(){
      $this->orden = "asc";
      $this->cant_pagina = 10;
      $this->estado = "1";
      $this->filtro_cat = "todas";
    }

    public function habilitada($id)
    {
      //dd($question_min_id);
      //dd($question);
      //dd($id);
      $respuestas=DB::table('answer')->where('id','=',$id)->get();
      //dd($respuestas);
      foreach($respuestas as $respuesta);
      $question=DB::table('questions')->where('id_answers','=',$respuesta->id)->first();
      //foreach($questions as $question);
    //dd($cadena_final_actual);
      $largo_string=strlen($respuesta->archivo_qna);
       $cadena_final_actual=substr($respuesta->archivo_qna,11);
  $res2 = array();

  // Agregamos la barra invertida al final en caso de que no exista
 $directorio2="botpress12120/data/bots/icibot/qna";

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
            "Nombre" => $directorio2 . $archivo2,
            "Tamaño" => filesize($directorio2 . $archivo2),
            "Modificado" => filemtime($directorio2 . $archivo2)
          );
      }
  }
  
  //MODIFICAMOS EL CAMPO PREGUNTA DE LA TABLA QUIESTIONS PARA VERIFICAR

  $datosnuevos=null;
  $tam=sizeof($res2);
  //dd($tam);
 //dd($cadena_final_actual);
  $i=0;
   //dd($i,$tam,$res2);
   while($i<$tam){
    //RUTA DE LA CARPETA PUBLIC + RUTA DE DIRECTORIO HASTA CARPETA QNA DONDE RECORRERA CADA UNO DE LOS NOMBRES DE LOS ARCHIVOS QUE TIENE ALMACENADO EN LA VARIABLE RES2
    $path_archivo=public_path($res2[$i]["Nombre"]);
     $encuentra1=strpos($res2[$i]["Nombre"],$cadena_final_actual);
    
    if($encuentra1==false){

        //dd("NADA");
    }else{
      
      //dd($encuentra1);
        //dd($path_archivo);
    //print_r($res2[$i]["Nombre"]);

    //dd($patron , $sustitucion);
    //}
    //dd($path_archivo);
        //SE ABRE EL ARCHIVO PARA LEERLO
      $leer = fopen($path_archivo, 'r+');
      //if(filesize($path_archivo) > 0){
      //SE ALMACENA LO QUE SE LEE INTERMANETE EN EL ARCHIVO
      //dd($path_archivo);
      //dd($path_archivo,$cadena_final_actual);
      $data = fread($leer, filesize($path_archivo));
      $encuentra2=strpos($data,'"enabled": true,');
      $encuentra3=strpos($data,'"enabled": false,');
      //dd($encuentra2,$encuentra3);
      //dd($data);
      //SE CIERRA EL ARCHIVO QUE SE LEE
      fclose($leer);
      //SI EN EL ARCHIVO ENCUENTRA $patron entonces lo cambiará por $sustitucion y copiará lo demas del archivo data en la variable $datosnuevos
      //EL STRING QUE SE ESTA BUSCANDO EN LOS ARCHIVOS DE LA CARPETA QNA, PARA MODIFICAR ALGUNA DE LAS PREGUNTAS, QUE COMO $patron como 
    //en este caso no lleva coma, sabemos que no será el ultimo del arreglo questions: es:[]
      if($encuentra2==false){
        $patron= '"enabled": false,';
    //dd($patron);
    // LO QUE SE DESEA ESCRIBIR COMO NUEVA PREGUNTA EN LA TABLA QUESTIONS Y EN LA BASE DE DATOS DE BOTPRESS
    $sustitucion='"enabled": true,';
      }
      if($encuentra3==false){
    $patron= '"enabled": true,';
    //dd($patron);
    // LO QUE SE DESEA ESCRIBIR COMO NUEVA PREGUNTA EN LA TABLA QUESTIONS Y EN LA BASE DE DATOS DE BOTPRESS
    $sustitucion='"enabled": false,';
    }
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //dd($datosnuevos);
      $escribir = fopen($path_archivo, 'w');
      //dd($datosnuevos);
      //Se escribe en $datosnuevos los en el aarchivo que corresponde
      //dd($datosnuevos);
      fwrite($escribir, $datosnuevos);
      //cerramos la escritura en el archivo
      fclose($escribir);
      //dd($datosnuevos,$respuesta,$question);
    //print_r($i);
   //}
  }
   $i=$i+1;
}
//dd($escribir,$respuesta,$question);
        DB::table('answer')->where('id','=',$respuesta->id)->update(['habilitada'=>0]);
      if($respuesta->habilitada==0){
        DB::table('answer')->where('id','=',$respuesta->id)->update(['habilitada'=>1]);
        //$respuesta->habilitada=1;
      }
      



      //Envio en la variable datos la información de las atblas questions y answer mediante el join.
     //    $datos=DB::table('answer')->join('questions','answer.id','=','questions.id_answers')->select('questions.*', 'answer.nombre','answer.habilitada')->paginate(7);
    //dd($datos);
    //  return view('qna.index',compact('datos'));
      //dd($qna);
    }
}
