<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers as ArchivoPregunta;
use App\Models\Question as Preguntas;
use DB;
use Livewire\WithPagination;

class IndexPreguntas extends Component
{
	 use WithPagination;
   public $hab=1;

    public function render()
    {
      if ($this->hab == 1){
        return view('livewire.index-preguntas', [
            'archivoPregs' => ArchivoPregunta::where('habilitada', 1)->orderBy('updated_at', 'desc')->paginate(10),
        ]);
      }
      else{
        return view('livewire.index-preguntasdeshab', [
            'archivoPregs' => ArchivoPregunta::where('habilitada', 0)->orderBy('updated_at', 'desc')->paginate(5),
        ]);
      } 
    }

    public function vista_hab(){
      $this->hab = 1;
    }

    public function vista_des(){
      $this->hab = 0;
    }

    public function habilitada($id)
    {
      //dd($question_min_id);
      //dd($question);
      $respuestas=DB::table('answer')->where('id','=',$id)->get();
      //dd($respuestas);
      foreach($respuestas as $respuesta);
      $question=DB::table('questions')->where('id_answers','=',$respuesta->id)->first();
      //foreach($questions as $question);
      

      //dd($respuesta,$question);
      $cadena_actual=$question->pregunta;
      //dd($cadena_actual);
        $cadena_actual = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('_', '_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena_actual
        );
 
        //Reemplazamos la E y e
        $cadena_actual = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena_actual );
 
        //Reemplazamos la I y i
        $cadena_actual = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena_actual );
 
        //Reemplazamos la O y o
        $cadena_actual = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena_actual );
 
        //Reemplazamos la U y u
        $cadena_actual = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('_', '_', '_', '_', '_', '_', '_', '_'),
        $cadena_actual );
 
        //Reemplazamos la N, n, C y c

        //OBSERVAR QUE OCURRE CON LOS TERMINOS CON Ñ
        $cadena_actual = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', '_', '_'),
        $cadena_actual
        );
        //dd($cadena_actual);
        $init_interrogacion=substr_count($cadena_actual, '¿');
        $cerrar_interrogacion=substr_count($cadena_actual, '?');
          $pos_inicial = strpos($cadena_actual, '¿');
          $pos_final = strpos($cadena_actual,'?');
          $largo_cadena=strlen($cadena_actual);
          //dd($pos_inicial);
          //dd($pos_final);
          //dd($largo_cadena);
          //dd($cadena_actual);
        if(($init_interrogacion==0 and $cerrar_interrogacion==0)){
            $cadenaf1_actual = str_replace("¿", "", $cadena_actual);
        $cadenaf2_actual = str_replace("?","",$cadenaf1_actual);
        $cadena_final_actual=strtolower($cadenaf2_actual);
         $cadena_final_actual = str_replace(
        array(' '),
        array('_'),
        $cadena_final_actual
        );
         $cadena_final_actual = str_replace(
        array('-'),
        array('_'),
        $cadena_final_actual
        );

        }elseif($init_interrogacion==1 and $cerrar_interrogacion==1){
        $cadenaf1_actual = str_replace("¿", "", $cadena_actual);
        $cadenaf2_actual = str_replace("?","",$cadenaf1_actual);
        $cadena_final_actual=strtolower($cadenaf2_actual);
         $cadena_final_actual = str_replace(
        array(' '),
        array('_'),
        $cadena_final_actual
        );

        //dd($cadena_final_actual);
    }
    //dd($cadena_final_actual);

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
   //dd($i,$tam,$res2[$i]["Nombre"]);
   while($i<$tam){
    //RUTA DE LA CARPETA PUBLIC + RUTA DE DIRECTORIO HASTA CARPETA QNA DONDE RECORRERA CADA UNO DE LOS NOMBRES DE LOS ARCHIVOS QUE TIENE ALMACENADO EN LA VARIABLE RES2
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res2[$i]["Nombre"]);
    //dd($path_archivo,$cadena_final_actual);
     $encuentra1=strpos($res2[$i]["Nombre"],$cadena_final_actual);
    //dd($encuentra1);
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
      fwrite($escribir, $datosnuevos);
      //cerramos la escritura en el archivo
      fclose($escribir);
      //dd($datosnuevos);
    //print_r($i);
   //}
  }
   $i=$i+1;
}
        DB::table('answer')->where('id','=',$respuesta->id)->update(['habilitada'=>0]);
      if($respuesta->habilitada==0){
        DB::table('answer')->where('id','=',$respuesta->id)->update(['habilitada'=>1]);
        //$respuesta->habilitada=1;
      }
      



      //Envio en la variable datos la información de las atblas questions y answer mediante el join.
         $datos=DB::table('answer')->join('questions','answer.id','=','questions.id_answers')->select('questions.*', 'answer.nombre','answer.habilitada')->paginate(7);
    //dd($datos);
      return view('qna.index',compact('datos'));
      //dd($qna);
    }
}
