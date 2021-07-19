<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use App\Models\Question;
use App\Models\Answers;
use App\Models\Archivo_qna;
use Auth;
use Redirect;

class QnAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function qna_name_index(){
      
      //Obtengo pagino de a 7 filas el contenido de la tabla answers
      $datos=DB::table('answer')->paginate(7);
      //Tomo toda los datos de la tabla questions
      $questions=DB::table('questions')->get();
      //Creo un arreglo data
      $data=array();
      //Se desea conocer el id del primer elemnto del arreglo $dato, ya que este nos dirá el primer $answer->id que corresponde a esta pagina,
      //al encontrarlo salimos del ciclo for.
      foreach($datos as $dato){
        $i=$dato->id;
        break;
      }

      //Guardamos en un arreglo llamado data el valor de $question->pregunta siempre y cuando sea igual el valor de i coincida con el de questions->id_answers, esto se debe a
      foreach($questions as $question){
      //dd($nlu_question);
        if($question->id_answers==$i){
            array_push($data,$question->pregunta);
            //array_push($number, $i)
            /*if($i==45){
              dd($data,$question->pregunta);
            }*/
            $i=$i+1;
        }
      }
      //dd($data);
      $i=0;
      foreach($datos as $dato){
        $dato->pregunta=$data[$i];
        $i=$i+1;
      }
     
      //dd($datos,$dato,$data);
      return view('qna.qna_name_index',compact('datos','data'));

    }


    public function index($id)
    {
        //
        //Envio en la variable datos la información de las atblas questions y answer mediante el join.
         $datos=DB::table('answer')->join('questions','answer.id','=','questions.id_answers')->select('questions.*', 'answer.nombre','answer.habilitada')->where('questions.id_answers','=',$id)->paginate(7);
    //dd($datos);
         if(Auth::id()==null){
        return Redirect::to('dashboard');
      }
      return view('qna.index',compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('qna.create');
    }

   public function pregunta_sin_respuesta(Request $request){
      //dd($request);
      $text_area=$request->preguntas;
      $pos_coma=strpos($text_area,',');
      $strings=array();
      $array_pos_coma=array();
      $array_pos_coma[0]=0;
      for($i=0;$i<strlen($text_area);$i++)
      { 
        if($text_area[$i]==','){
         array_push($array_pos_coma,$i);
        }
      }
      $cantidad_coma=count($array_pos_coma);
      //dd($text_area,$array_pos_coma);
      $i=0;
      //dd($array_pos_coma,$cantidad_coma);
      while($i+1<$cantidad_coma){
      if($i==0){
        $pregunta=substr($text_area,$array_pos_coma[$i],$array_pos_coma[$i+1]);
        //dd($pregunta);
        array_push($strings,$pregunta);
      }else{
      $pregunta=null;
      //dd($text_area,$pregunta,$strings,$array_pos_coma,$array_pos_coma[$i],$array_pos_coma[$i+1]);
      //dd(substr($text_area,25,54-25));
      $pregunta=substr($text_area,$array_pos_coma[$i]+1,$array_pos_coma[$i+1]-$array_pos_coma[$i]-1);
      //dd($text_area,$pregunta,$strings,$array_pos_coma,$array_pos_coma[$i],$array_pos_coma[$i+1]);
      array_push($strings,$pregunta);
       }
       $i=$i+1;
      }
      $pregunta=substr($text_area,$array_pos_coma[$i]+1,strlen($text_area));
      $pregunta=str_replace(',',"",$pregunta);
      array_push($strings,$pregunta);
      //dd($text_area,$strings,$array_pos_coma,$cantidad_coma);

      for($i=0;$i<$cantidad_coma;$i=$i+1){
        DB::table('preguntas_sin_respuestas')->insert(['pregunta_sin_respuesta' => $strings[$i]]);
      }

      $strings=DB::table('preguntas_sin_respuestas')->get();
      //dd($text_area,$strings,$array_pos_coma,$cantidad_coma);
      return view('qna.pregunta_almacenada_correctamente',compact('strings'));
      }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   

    public function store(Request $request)
    {

        //dd($request);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $question=$request->question."\r\n";
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
        //dd(strlen($request->question));dd($request,$nombre_archivo);
     //dd($request);
        $cadena=$request->question;
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
          //dd($largo_cadena);
        if(($init_interrogacion==0 and $cerrar_interrogacion==0)){
            //dd($request);
          $cadena_final=$cadena;
           $cadena_final = str_replace(array(' '),array('_'),$cadena_final);
           $cadena_final =strtolower($cadena_final);
           $nombre_archivo='__qna__'.$randomString.'_'.$cadena_final.'.json';
        $nombre_archivo2=$randomString.'_'.$cadena_final.'.json';
        $id_qna=$randomString.'_'.$cadena_final;
           //dd($cadena_final,$nombre_archivo,$nombre_archivo2);
            $path_archivo1=("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/intents/".$nombre_archivo);
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
   while($i<$tam){
    
    //Se van abriendo cada uno de los archivos de la carpeta hasta que abre todos los archivos de la carpeta
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"]);
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
  }
  //dd($vector_substring);
        
        
        $archivo_ejemplo1="C:/Users/LI/Desktop/chtbtICI/public/__qna__intents_prueba.txt";
        $archivo_ejemplo2="C:/Users/LI/Desktop/chtbtICI/public/qna__qna_prueba.txt";

        $leer1 = fopen($archivo_ejemplo1, 'r+');
        $numlinea=0;
        while ($linea = fgets($leer1)){
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        fclose($leer1);
      //dd($request,$aux,$numlinea);
      $ultimas_4_lineas=array();
        $ultimas_4_lineas[0]="    ]\r\n";
        $j=1;
        $i=$numlinea-3;
      while($i<$numlinea){
           $ultimas_4_lineas[$j]=$aux[$i];
           $j=$j+1;
          $i=$i+1;
      }
       //dd($request,$aux,$numlinea,$ultimas_4_lineas);
      $i=0;
      while($i<$numlinea){
        $buscar_utterances=strpos($aux[$i],'"utterances": {');
        $buscar_es_pregunta=strpos($aux[$i+1],'"es": []');
         $buscar_es_llave=strpos($aux[$i+2],'},');
         $global=strpos($aux[$i], "global");
         $name_vacio=strpos($aux[$i],'"name": "",');
        if($buscar_utterances!=false and $buscar_es_pregunta!=false and $buscar_es_llave!=false){
          //dd($buscar_utterances,$buscar_es_pregunta,$buscar_es_llave,$i);
          $aux[$i+1]='      '.'"'.'es'.'":'." [\r\n";
          $aux[$i+2]='        '.'"'.$request->question.'"'."\r\n";
          $aux[$i+3]=$ultimas_4_lineas[0];
          $aux[$i+4]=$ultimas_4_lineas[1];
          array_push($aux,$ultimas_4_lineas[2]);
          array_push($aux,$ultimas_4_lineas[3]);
          //dd($aux);
        }if($global!=false){
          $aux[$i]=str_replace("global",$request->contexto,$aux[$i]);
        }if($name_vacio!=false){
            $aux[$i]=str_replace('"name": "",','"name":'.' "'.$nombre_archivo.'",',$aux[$i]);
        /*elseif($aux[$i]=='"utterances": {' and $aux[$i+1]=='"es": [' and $aux[$i+2]!='},'){
          $aux[$i+1]='"es": [';
          $aux[$i+2]='       "'.$request->question.'"';
          $aux[$i+3]=']';
        }*/
      }
        $i=$i+1;

      }
//dd($request,$aux,$aux[6],$numlinea,$ultimas_4_lineas);



       $contenido="";
       $i=0;
       $tam_array_aux=count($aux);
      while($i<$tam_array_aux){
        $contenido .=$aux[$i];
        $i=$i+1;
      }
      //dd($request,$aux,$aux[6],$numlinea,$ultimas_4_lineas,$contenido);
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
         //$data1 = fread($leer1, filesize($archivo_ejemplo1));
        //dd($data1);
        //fclose($leer1);
        $escribir1 = fopen($path_archivo1, 'w+');
         //fwrite($escribir1, $data1);
        fwrite($escribir1, $contenido);
       fclose($escribir1);

      //Fila con el nombre del archivo esccibiendo nombre del archivo//

      $leer1 = fopen($path_archivo1, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //dd(filesize($path_archivo1));
      $data1 = fread($leer1, filesize($path_archivo1));
      //dd($data1);
      //Se cierra el archivo
      fclose($leer1);

       //Dejando formato adecuado a archivo __qna__ en carpeta intents
       $patron1=     '"'.'name'.'":'.' ""'.',';
       //dd($patron);
       $sustitucion1='"'.'name'.'":'.' "'.$nombre_archivo.'"'.',';
       //dd($patron1,$sustitucion1);
       //dd($data1);
       $datosnuevos1 = str_replace($patron1, $sustitucion1, $data1);

       //dd($datosnuevos11);
        //Se abre el archivo para reescribirlo
      $escribir1 = fopen($path_archivo1, 'w');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir1, $datosnuevos1);
      fclose($escribir1);


  
     /* $path_archivo11=("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/intents/".$nombre_archivo);
      $leer11 = fopen($path_archivo11, 'rb');
      //dd($leer11,$path_archivo1);
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //NO TOMA TODOS LOS CARACTERES DE MANERA CORRECTA   
      //                      AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII REVISAAR
      //dd(filesize($path_archivo11));
      $data11 = fread($leer11, 2*filesize($path_archivo11));  //Filesize no me entrega el tamaño actual del archivo, no se bien por que, pero al multiplicarlo por 2, consigo tomar todos los caracteres del archivo, y no solo hasta utterances.
      //dd($data11);
      //Se cierra el archivo
      //dd($data11);
      fclose($leer11);

      //dd($data1);
      $patron2=     '"es":'.' ['.']';
       //dd($patron1);
       $sustitucion2='"es":'.' ["'.$request->question.'"]';
       //dd(filesize($path_archivo1),filesize($path_archivo11),$data11,$patron2,$sustitucion2);
       $datosnuevos11 = str_replace($patron2, $sustitucion2, $data11);
        $escribir11 = fopen($path_archivo1, 'w+');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir11, $datosnuevos11);
      fclose($escribir11); */


       //CARPETA QNA CREAR ARCHIVO


        $path_archivo2=("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/qna/".$nombre_archivo2);
        $leer2 = fopen($archivo_ejemplo2, 'r+');
        $numlinea=0;
         while ($linea = fgets($leer2)){
        //echo $linea.'<br/>';
            $aux_qna[] = $linea;    
             $numlinea++;
        }
        fclose($leer2);
      //dd($request,$aux,$numlinea);
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
          $aux_qna[$i+2]='        '.'"'.$request->answer.'"'."\r\n";
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
          $aux_qna[$i+2]='        '.'"'.$request->question.'"'."\r\n";
          $aux_qna[$i+3]=$ultimas_8_lineas[0];
          $aux_qna[$i+4]=$ultimas_8_lineas[4];
          $aux_qna[$i+5]=$ultimas_8_lineas[5];
          $aux_qna[$i+6]=$ultimas_8_lineas[6];
          $aux_qna[$i+7]=$ultimas_8_lineas[7];
          $aux_qna[$i+8]=$ultimas_8_lineas[8];
          //dd($aux_qna);
        }if($global!=false){
          $aux_qna[$i]=str_replace("global",$request->contexto,$aux_qna[$i]);
        }if($name_vacio!=false){
            $aux_qna[$i]=str_replace('"id": "",','"id":'.' "'.$nombre_archivo2.'",',$aux_qna[$i]);
            $global=strpos($aux_qna[$i], "global");
          }
        $i=$i+1;

      }
//dd($request,$aux_qna,$aux[6],$numlinea,$ultimas_8_lineas);


      $contenido=null;
       $contenido="";
       $i=0;
       $tam_array_aux_qna=count($aux_qna);
      while($i<$tam_array_aux_qna){
        $contenido .=$aux_qna[$i];
        $i=$i+1;
      }
      //dd($request,$aux_qna,$aux_qna[6],$numlinea,$ultimas_8_lineas,$contenido);
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
         //$data2 = fread($leer2, filesize($archivo_ejemplo2));
        //dd($data2);
        //fclose($leer2);
        $escribir2 = fopen($path_archivo2, 'w+');
         fwrite($escribir2, $contenido);
       fclose($escribir2);

       //Fila con el nombre del archivo//

      $leer2 = fopen($path_archivo2, 'rb');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //dd(filesize($path_archivo1));
      $data2_id = fread($leer2, filesize($path_archivo2));
      //dd($data1);
      //Se cierra el archivo
      fclose($leer2);

      $datosnuevos2=null;
       //Dejando formato adecuado a archivo __qna__ en carpeta intents
       $patron_id=     '"'.'id'.'":'.' ""';
       //dd($patron2);
       $sustitucion_id='"'.'id'.'":'.' "'.$id_qna.'"';
       //dd($patron1,$sustitucion1);
       //dd($data1);
       $datosnuevos2_id = str_replace($patron_id, $sustitucion_id, $data2_id);

       //dd($datosnuevos2_id);
        //Se abre el archivo para reescribirlo
      $escribir2_id = fopen($path_archivo2, 'w');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir2_id, $datosnuevos2_id);
      fclose($escribir2_id);
        //rewind($path_archivo2);
        $leer2_answer = fopen($path_archivo2, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //dd(filesize($path_archivo1));
      $data2_answer = fread($leer2_answer, 2*filesize($path_archivo2));
      //dd($data1);
      //Se cierra el archivo
      fclose($leer2_answer);

       $patron2_answer=  '"es": []';   
       //dd($patron1);
       $sustitucion2_answer='"es": ["'.$request->answer.'"]';  
       //dd(filesize($path_archivo1),filesize($path_archivo11),$data11,$patron2,$sustitucion2);
       $datosnuevos2_answer = str_replace($patron2_answer, $sustitucion2_answer, $data2_answer);
        $escribir2_answer = fopen($path_archivo2, 'w+');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir2_answer, $datosnuevos2_answer);
      fclose($escribir2_answer);

      $leer2_question = fopen($path_archivo2, 'rb');
        $data2_question = fread($leer2_question, 2*filesize($path_archivo2));
    fclose($leer2_question);
        //dd($data2_question);
       $patron2_question='"es":[]';   
       //dd($patron1);
       $sustitucion2_question='"es":["'.$request->question.'" ]';  
       //dd(2*filesize($path_archivo2),$data2_question,$patron2_question,$sustitucion2_question);
       $datosnuevos2_question = str_replace($patron2_question, $sustitucion2_question, $data2_question);
       //dd($data2_question,$patron2_question,$sustitucion2_question,$datosnuevos2_question);
        $escribir2_question = fopen($path_archivo2, 'w+');
      //dd($datosnuevos2_question);
      //Se esccribe en el archivo
      fwrite($escribir2_question, $datosnuevos2_question);
      fclose($escribir2_question);
      
      $archivo_qna=new Archivo_qna();
      //dd($randomString.$cadena_final);
      $archivo_qna->nombre=$randomString.$cadena_final;
      $archivo_qna->save();
      $ids_archivos=DB::table('archivo_qna')->where('nombre','=',$randomString.$cadena_final)->select('id')->get();
      foreach($ids_archivos as $id_archivo);
      //dd($id_archivo);
      $respuesta=new Answers();
        $respuesta->nombre=$request->answer;
        //dd($id_archivo);
        $respuesta->id_archivo=$id_archivo->id;
        $respuesta->habilitada=1;
        $respuesta->save();
        $answers=DB::table('answer')->where('nombre','=',$request->answer)->get();
        foreach($answers as $answer);
        $pregunta=new Question();
        $pregunta->id_answers=$answer->id;
        $pregunta->pregunta=$request->question;
        //$pregunta->habilitada=1;
        $pregunta->save();

      //Se cierra el archivo
      
      return view('qna.archivos_creados',compact('nombre_archivo','nombre_archivo2'));

        }elseif($init_interrogacion==1 and $cerrar_interrogacion==1){
        $cadenaf1 = str_replace("¿", "", $cadena);
        $cadenaf2 = str_replace("?","",$cadenaf1);
        $cadena_final=strtolower($cadenaf2);
         $cadena_final = str_replace(array(' '),array('_'),$cadena_final);
         //dd($request,$cadena_final);
        //dd($request,$nombre_archivo);
        $nombre_archivo='__qna__'.$randomString.'_'.$cadena_final.'.json';
        $nombre_archivo2=$randomString.'_'.$cadena_final.'.json';
        $id_qna=$randomString.'_'.$cadena_final;
        

        $path_archivo1=("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/intents/".$nombre_archivo);
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
   while($i<$tam){
    
    //Se van abriendo cada uno de los archivos de la carpeta hasta que abre todos los archivos de la carpeta
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"]);
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
  }
  //dd($vector_substring);
        
        
        $archivo_ejemplo1="C:/Users/LI/Desktop/chtbtICI/public/__qna__intents_prueba.txt";
        $archivo_ejemplo2="C:/Users/LI/Desktop/chtbtICI/public/qna__qna_prueba.txt";

        $leer1 = fopen($archivo_ejemplo1, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
         $data1 = fread($leer1, filesize($archivo_ejemplo1));
        //dd($data1);
        fclose($leer1);
        $escribir1 = fopen($path_archivo1, 'w+');
         fwrite($escribir1, $data1);
       fclose($escribir1);

      //Fila con el nombre del archivo//

      $leer1 = fopen($path_archivo1, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //dd(filesize($path_archivo1));
      $data1 = fread($leer1, filesize($path_archivo1));
      //dd($data1);
      //Se cierra el archivo
      fclose($leer1);

       //Dejando formato adecuado a archivo __qna__ en carpeta intents
       $patron1=     '"'.'name'.'":'.' ""'.',';
       //dd($patron);
       $sustitucion1='"'.'name'.'":'.' "'.$nombre_archivo.'"'.',';
       //dd($patron1,$sustitucion1);
       //dd($data1);
       $datosnuevos1 = str_replace($patron1, $sustitucion1, $data1);

       //dd($datosnuevos11);
        //Se abre el archivo para reescribirlo
      $escribir1 = fopen($path_archivo1, 'w');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir1, $datosnuevos1);
      fclose($escribir1);


  
      $path_archivo11=("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/intents/".$nombre_archivo);
      $leer11 = fopen($path_archivo11, 'rb');
      //dd($leer11,$path_archivo1);
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //NO TOMA TODOS LOS CARACTERES DE MANERA CORRECTA   
      //                      AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII REVISAAR
      //dd(filesize($path_archivo11));
      $data11 = fread($leer11, 2*filesize($path_archivo11));  //Filesize no me entrega el tamaño actual del archivo, no se bien por que, pero al multiplicarlo por 2, consigo tomar todos los caracteres del archivo, y no solo hasta utterances.
      //dd($data11);
      //Se cierra el archivo
      //dd($data11);
      fclose($leer11);

      //dd($data1);
      $patron2=     '"es":'.' ['.']';
       //dd($patron1);
       $sustitucion2='"es":'.' ["'.$request->question.'"]';
       //dd(filesize($path_archivo1),filesize($path_archivo11),$data11,$patron2,$sustitucion2);
       $datosnuevos11 = str_replace($patron2, $sustitucion2, $data11);
        $escribir11 = fopen($path_archivo1, 'w+');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir11, $datosnuevos11);
      fclose($escribir11);


       //CARPETA QNA CREAR ARCHIVO


        $path_archivo2=("C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/qna/".$nombre_archivo2);
        $leer2 = fopen($archivo_ejemplo2, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
         $data2 = fread($leer2, filesize($archivo_ejemplo2));
        //dd($data2);
        fclose($leer2);
        $escribir2 = fopen($path_archivo2, 'w+');
         fwrite($escribir2, $data2);
       fclose($escribir2);

       //Fila con el nombre del archivo//

      $leer2 = fopen($path_archivo2, 'rb');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //dd(filesize($path_archivo1));
      $data2_id = fread($leer2, filesize($path_archivo2));
      //dd($data1);
      //Se cierra el archivo
      fclose($leer2);

      $datosnuevos2=null;
       //Dejando formato adecuado a archivo __qna__ en carpeta intents
       $patron_id=     '"'.'id'.'":'.' ""';
       //dd($patron2);
       $sustitucion_id='"'.'id'.'":'.' "'.$id_qna.'"';
       //dd($patron1,$sustitucion1);
       //dd($data1);
       $datosnuevos2_id = str_replace($patron_id, $sustitucion_id, $data2_id);

       //dd($datosnuevos2_id);
        //Se abre el archivo para reescribirlo
      $escribir2_id = fopen($path_archivo2, 'w');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir2_id, $datosnuevos2_id);
      fclose($escribir2_id);
        //rewind($path_archivo2);
        $leer2_answer = fopen($path_archivo2, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      //dd(filesize($path_archivo1));
      $data2_answer = fread($leer2_answer, 2*filesize($path_archivo2));
      //dd($data1);
      //Se cierra el archivo
      fclose($leer2_answer);

       $patron2_answer=  '"es": []';   
       //dd($patron1);
       $sustitucion2_answer='"es": ["'.$request->answer.'"]';  
       //dd(filesize($path_archivo1),filesize($path_archivo11),$data11,$patron2,$sustitucion2);
       $datosnuevos2_answer = str_replace($patron2_answer, $sustitucion2_answer, $data2_answer);
        $escribir2_answer = fopen($path_archivo2, 'w+');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir2_answer, $datosnuevos2_answer);
      fclose($escribir2_answer);

      $leer2_question = fopen($path_archivo2, 'rb');
        $data2_question = fread($leer2_question, 2*filesize($path_archivo2));
    fclose($leer2_question);
        //dd($data2_question);
       $patron2_question='"es":[]';   
       //dd($patron1);
       $sustitucion2_question='"es":["'.$request->question.'" ]';  
       //dd(2*filesize($path_archivo2),$data2_question,$patron2_question,$sustitucion2_question);
       $datosnuevos2_question = str_replace($patron2_question, $sustitucion2_question, $data2_question);
       //dd($data2_question,$patron2_question,$sustitucion2_question,$datosnuevos2_question);
        $escribir2_question = fopen($path_archivo2, 'w+');
      //dd($datosnuevos2_question);
      //Se esccribe en el archivo
      fwrite($escribir2_question, $datosnuevos2_question);
      fclose($escribir2_question);
      
      $archivo_qna=new Archivo_qna();
      //dd($randomString.$cadena_final);
      $archivo_qna->nombre=$randomString.$cadena_final;
      $archivo_qna->save();
      $ids_archivos=DB::table('archivo_qna')->where('nombre','=',$randomString.$cadena_final)->select('id')->get();
      foreach($ids_archivos as $id_archivo);
      //dd($id_archivo);
      $respuesta=new Answers();
        $respuesta->nombre=$request->answer;
        //dd($id_archivo);
        $respuesta->id_archivo=$id_archivo->id;
        $respuesta->habilitada=1;
        $respuesta->save();
        $answers=DB::table('answer')->where('nombre','=',$request->answer)->get();
        foreach($answers as $answer);
        $pregunta=new Question();
        $pregunta->id_answers=$answer->id;
        $pregunta->pregunta=$request->question;
        //$pregunta->habilitada=1;
        $pregunta->save();
        //dd($request);
      //Se cierra el archivo
      
            return view('qna.archivos_creados',compact('nombre_archivo','nombre_archivo2'));
//REVISAR
        //dd($path_archivo2);
        }else{
          $nombre_archivo=null;
          $nombre_archivo2=null;
            return view('qna.archivos_creados',compact('nombre_archivo','nombre_archivo2'));
        }
        
        //}
        //$parte_name_archivo=bin2hex(random_bytes(5));
        //Link de interes para cadenas aleatorias https://code.tutsplus.com/es/tutorials/generate-random-alphanumeric-strings-in-php--cms-32132
        //dd($parte_name_archivo); https://ejemplocodigo.com/ejemplo-php-generar-cadena-aleatoria-o-random-string/

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         $datos=DB::table('answer')->join('questions','answer.id','=','questions.id_answers')->select('questions.*', 'answer.nombre')->select('questions.*','answer.nombre')->where('answer.id','=',$id)->get();

        //Selecciono el elemento de la tabla questions que editaremos
        $questions=DB::table('questions')->where('questions.id',$id)->get();
        //Como tenemos 2 consultas question y answer lo mejor es recorrer con un foreach estas variables e imprimirlas de manera directa en la vista
        foreach($questions as $question)

        //dd($nlu_question->nlu_name_id);

        //Selecciono el elemento answer que editaremos conectandolo con su fk de la tabla question
        $answers=DB::table('answer')->where('answer.id','=',$question->id_answers)->get();
        //Como tenemos 2 consultas question y answer lo mejor es recorrer con un foreach estas variables e imprimirlas de manera directa en la vista
        foreach($answers as $answer);
         $nombre=$answer->nombre;
        $pos=strpos($nombre,"builtin_image");
        //dd($pos);
        if($pos==false){
          $pos=0;
        }else{
          $pos=1;
        }
        $qnas_images=DB::table('qnas_images')->where('id_answer','=',$answer->id)->get();
        //dd($datos,$answers,$nombre,$qnas_images);
        foreach($qnas_images as $qna_image);
         //dd($qna_image);
        //dd($pos);

        if($qnas_images->isEmpty()){
          $name_image=null;
        }else{
            $name_image=$qna_image->nombre_imagen_qna;
        }
        //return view('qna.edit',compact('question','answer','pos','name_image'));
       
        //Busco si existe el arrchivo .flow.json sacado de la base de datos, si es que no existen respuestas a cierta pregunta,
        //seguirá abriendo el archivo .flow.json buscando los builtin_text y builtin_image del archivo para mostrarlos por pantalla
        //sino encuentra el termino flow.json en la tabla answer campo nombre, entonces mostrará el archivo tiene las tipicas respuestas directas.
        $es_archivo_flow=strpos($answer->nombre,"flow.json");
        //dd($datos,$questions,$answer,$pos,$name_image,$es_archivo_flow);
        if($es_archivo_flow==false){
           //Les paso los elementos de las consultas a la vista.
          //dd($question,$answer);
          //dd($es_archivo_flow);
           return view('qna.edit',compact('question','answer','pos','name_image','es_archivo_flow'));
        }else{
          //Al encontrar el enlace hacia un archivo .flow.json que a su vez contiene los builtin_text y builtin_immge respectivo sigue esta parte del codigo.Se abre el archivo .flow.json en esa ruta y se lee linea por linea almacenandolo en un arreglo
          $path_archivo=public_path("botpress12120/data/bots/icibot/flows/".$answer->nombre);
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
        $nombre_imagen=array(); //Se guardan los nombres de las imagenes.
        $textos=array();
       $i=0;
       //Recorremos el archivo linea por linea buscando los nombres de las imagenes.
         while($i<$numlinea){
          $encuentra_nombre_imagen=strpos($aux[$i],'condition": "temp['); //En esta linea con este string sabremos que es el nombre de la imagen que se guarda aqui, en esta linea
        
        if($encuentra_nombre_imagen!=false){;
           array_push($nombre_imagen,substr($aux[$i],65,-5));  //se recorta la linea encontrada y se almacena el nombre de las imagenes
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
                    array_push($nombre_imagen, null);
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
        //dd($todo,$builtins_texts);
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
          array_push($textos,substr($aux_text[$i+4],18,-3));
          array_push($todo,$builtins_texts[$j],"builtin_text",substr($aux_text[$i+4],18,-3));
          }else{
            array_push($textos,substr($aux_text[$i+4],18,-3));
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
        $todo_ordenado=array();
        $tam_array_builtins=count($builtins);
        $tam_array_todo=count($todo);
        for($i=0;$i<$tam_array_builtins;$i=$i+1){
          //dd($todo);
          for($j=0;$j<$tam_array_todo;$j=$j+3){
            if($builtins[$i]==$todo[$j]){
              array_push($todo_ordenado,$todo[$j],$todo[$j+1],$todo[$j+2]);
              break;
            }
          }
        }
        //dd($todo,$todo_ordenado);
        //if($todo_ordenado[2]=="builtin_text"){
        //A pesar de  que nombre imagen posee un tamaño mucho menor que todo_ordenado, se agrandará el tamañao de $nombres_imagenes llenandolo de null, y colocando en ciertas posiciones los nobres de las imagenes para usar la misma variable en el conntador de la vista.
        $nombres_imagenes=array();
        $j=$tam_array_todo-1;
        //dd($j);
        $i=0;
        while($j>=0){

          if(strpos($todo_ordenado[$j],".jpg")!=false or strpos($todo_ordenado[$j],".png")!=false){
            array_push($nombres_imagenes,$nombre_imagen[$i]);
             $i=$i+1;
          }else{
            array_push($nombres_imagenes,null);
          }
          $j=$j-1;
         /* if($j==0){
            dd($nombres_imagenes,$tam_array_todo,$todo_ordenado);
          }*/
        }
        $nombres_imagenes=array_reverse($nombres_imagenes);
          //dd($nombres_imagenes,$tam_array_todo,$todo_ordenado);

        $builtins_texts_unico=array_unique($builtins_texts);
        $tam_array_builtins_texts_unique=count($builtins_texts_unico);

        $i=0;
        $builtins_texts_index_unique=array();
        foreach($builtins_texts as $builtins_texts_unique){
          //dd($builtins_texts_unique,$builtins_texts);
          $builtins_texts_index_unique[$i]=$builtins_texts_unique;
          $i=$i+1;
        }
       //dd($aux_text,$builtins,$builtins_texts_index_unique,$tam_array_builtins_texts_unique,$builtins_images,$path_archivo,$textos,$todo,$es_archivo_flow,$tam_array_todo,$todo_ordenado,$nombre_imagen,$j,$nombres_imagenes,$nombre_imagen);
        //}
        //dd($path_archivo,$aux,$builtins);
        }
        $textos_sin_repetir=array_unique($textos);
        $tam_array_textos_unicos=count($textos_sin_repetir);
        $i=0;
        $textos_unicos_index_orden=array();
        foreach($textos_sin_repetir as $textos_sin_repetir_unico){
          //dd($builtins_texts_unique,$builtins_texts);
          $textos_unicos_index_orden[$i]=$textos_sin_repetir_unico;
          $i=$i+1;
        }
        /*$mapa=array();
        $index_text=array();
        for($i=0;$i<$tam_array_textos_unicos;$i++){
            for($j=0;$j<$tam_array_todo;$j++){
              if($todo_ordenado[$j]==$textos_unicos_index_orden[$i]){
                 array_push($index_text,$j);
              }
            }
          //dd($index_text[0]);
           array_push($mapa,$index_text);
           $index_text=array();
        }*/
        //dd($todo_ordenado,$nombres_imagenes);
        //dd($builtins_texts,$todo_ordenado,$builtins_texts_index_unique,$textos_sin_repetir,$textos_unicos_index_orden,$tam_array_builtins_texts_unique);
        return view('qna.edit',compact('question','answer','builtins_texts_index_unique','tam_array_builtins_texts_unique','pos','name_image','es_archivo_flow','todo_ordenado','tam_array_todo','nombres_imagenes','nombre_imagen','cantidad_imagenes','textos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request,$id)
    {
        //
        //
      //$i=3;
      //dd($request);
      //dd($request->imagen_actual[0]);
      //dd(($request->file('imagen_nueva')[0]));
      //dd($request->es_archivo_flow);
      $es_archivo_flow=$request->archivo_flow;
      if($request->es_archivo_flow!=null){
      //dd($request,$request->file('imagen_nueva'));
      $imagenes_nuevas=$request->file('imagen_nueva');
      //dd($request->hasfile('imagen_nueva'));
      $imagen_actual=$request->imagen_actual;
      //$imagenes_actuales=$request->file('imagenes_actual');
      $imagen_nueva=array();
      //$imagen1=$imagenes[1]->getClientOriginalName();
      //$names_imagenes=$request->names_imagenes;
      $i=0;
      //dd($request);
      if($request->file('image_nueva')!=false){
      $tam_array_imagen=count($request->file('imagen_nueva'));
      }
      else{
        $tam_array_imagen=0;
      }
      $tam_array_text=count($request->string);
      $builtins_texts_unique=$request->builtins_texts_unique;
      $textos_originales=$request->textos_originales;
      $strings=$request->string;

      /*$i=0;
        $unique=array();
        foreach($textos_originales_unique as $textos){
          $textos_inicial[$i]=$textos;
          $i=$i+1;
        }*/
      $es_archivo_flow=$request->es_archivo_flow;
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
      //dd($request,$textos_iniciales);
        $i=0;
      if($request->file('image_nueva')!=false){
      while($i<$tam_array_imagen){
         if((!empty($request->file('imagen_nueva')[$i]))==true){
        array_push($imagen_nueva,$imagenes_nuevas[$i]->getClientOriginalName());
        array_push($imagen_actual,$request->imagen_actual[$i]);
      }
        $i=$i+1;
      }
    }
      //dd($request,$request->file('imagen'),$request->imagen_actual,$imagen_nueva);
      
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
      if(($request->hasfile('imagen_nueva'))==true){
      foreach($imagenes_nuevas as $imagen_nueva){
         //dd($imagenes_nuevas[$i]->getClientOriginalName(),$imagen_nueva);
        //dd(!empty($request->file('imagen_nueva')[1]));
        if((!empty($request->file('imagen_nueva')[$i]))==true){
          //dd(!empty($request->file('imagen_nueva')[1]));
        $filename=time().$imagen_nueva->getClientOriginalName();
        //dd($filename);
         $imagen_actual[$i]=$request->imagen_actual[$i];
         $imagen_nueva->move(public_path('images/bp/'),$filename);
        $fichero=public_path().'/images/bp/'.$filename;
      $nuevo_fichero=public_path().'/botpress12120/data/bots/icibot/media/'.$filename;
      copy($fichero,$nuevo_fichero);
          unlink($path_chatbot.$imagen_actual[$i]);
          unlink($path_bp_laravel.$imagen_actual[$i]);
          rename($path_chatbot.$filename,$path_chatbot.$imagen_actual[$i]);
          rename($path_bp_laravel.$filename,$path_bp_laravel.$imagen_actual[$i]);
      }
      $i=$i+1;
  }
}    
    $i=0;
    $names_imagenes=$request->imagenes_news;
    $tam_array_imagen=count($imagen_actual);
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
    
     $builtins_texts_unique=$request->builtins_texts_unique;
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

    //dd($request,$request->file('imagen_nueva'),$textos_iniciales,$textos_finales,$request->imagen_actual,$imagen_nueva,$names_imagenes,$path_chatbot,$path_bp_laravel,$strings,$textos_originales,$tam_array_text,$aux,$contenido,$tam_array_builtins_texts_unique);
    //dd($textos_iniciales,$textos_finales);
      
      return view('qna.message',compact('imagen_actual','tam_array_text','strings','textos_originales','tam_array_imagen','es_archivo_flow','tam_array_builtins_texts_unique','names_imagenes','textos_iniciales','textos_finales'));
    }else{
      //dd($request,$request->file('image_nueva'));
        //dd($id);
        //dd($request);
        $imagen=$request->imagen;
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
        $request->validate(
              [
              'image_nueva' => 'image',
            ]);
        if(($request->hasfile('image_nueva'))==true){
          $nombre_imagen=time().$request->file('image_nueva')->getClientOriginalName();
          //dd($imagen,$nombre_imagen);
          $request->file('image_nueva')->move('images/bp', $nombre_imagen);
          $fichero=public_path().'/images/bp/'.$nombre_imagen;
          $nuevo_fichero=public_path().'/botpress12120/data/bots/icibot/media/'.$nombre_imagen;
          copy($fichero,$nuevo_fichero);
          unlink(public_path()."/images/bp/".$imagen);
          unlink(public_path()."/botpress12120/data/bots/icibot/media/".$imagen);
          rename(public_path()."/images/bp/".$nombre_imagen,public_path()."/images/bp/".$imagen);
          rename(public_path()."/botpress12120/data/bots/icibot/media/".$nombre_imagen,public_path()."/botpress12120/data/bots/icibot/media/".$imagen);
       }
        
        //dd($id);
        //dd($request);
        //consulto por cual es la tupla editada en la tabla questions
        $questions=DB::table('questions')->where('id','=',$id)->get();
        //Recorro con el foreach para pasar los datos de esta tabla por separado con los de la otra tabla, sin usar un join
        //ya que question y answer en un inicio tenían el mismo nombre y me lanzaba un problema
        foreach($questions as $question);
        //dd($question);
        //pregunto mediante la fk de la tabla question, a cual id de la tabla answer corresponde...
        $answers=DB::table('answer')->where('id','=',$question->id_answers)->get();
      foreach($answers as $answer);
      
      //Guardo en $contador_question cuantos answers o respuestas tengo asociadas a esa pregunta...
      $contador_question=DB::table('questions')->where('id_answers','=',$question->id_answers)->count();
      $question_min_id=DB::table('questions')->where('id_answers','=',$question->id_answers)->select('id')->min('id');
      //dd($question_min_id,$question->id);
      $cadena=$request->pregunta;
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
        //dd($cadena);
        $init_interrogacion=substr_count($cadena, '¿');
        $cerrar_interrogacion=substr_count($cadena, '?');
          $pos_inicial = strpos($cadena, '¿');
          $pos_final = strpos($cadena,'?');
          $largo_cadena=strlen($cadena);
          //dd($pos_inicial);
          //dd($pos_final);
          //dd($largo_cadena);
        if(($init_interrogacion==0 and $cerrar_interrogacion==0)){
          $cadenaf1 = str_replace("¿", "", $cadena);
        $cadenaf2 = str_replace("?","",$cadenaf1);
        $cadena_final=strtolower($cadenaf2);
         $cadena_final = str_replace(
        array(' '),
        array('_'),
        $cadena_final
        );
        }elseif($init_interrogacion==1 and $cerrar_interrogacion==1){
        $cadenaf1 = str_replace("¿", "", $cadena);
        $cadenaf2 = str_replace("?","",$cadenaf1);
        $cadena_final=strtolower($cadenaf2);
         $cadena_final = str_replace(
        array(' '),
        array('_'),
        $cadena_final
        );

        //dd($cadena_final);
    }

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
    //dd($cadena_final);
      //rename ("/folder/file.ext", "/folder/newfile.ext");
      //dd($question_min_id);
      //dd($contador_question);
      //La ruta del directorio dentro de la carpeta public, que como se dijo anteriormente irá dentro de directorio1

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

  //MODIFICO  EL ARCHIVO EN EL QUE SE ENCUENTRE $patron DENTRO DE LA CARPETA INTENTS (PREGUNTA O QUESTION)
  //SI LA LINEA DE PREGUNTAS A MODIFICAR NO ES LA ULTIMA DEL ARREGLO NO LLEVA COMA, ENTONCES AQUI ACTUALIZARÁ ESTA LINEA
  //DE LO CONTRARIO HARÁ LA MODIFICACIÓN EN EEL SIGUIENTE WHILE
   $datosnuevos=null;
   //para saber cuantos archivos existen en la carpeta
  $tam=sizeof($res);
  //dd($tam);

  $i=0;
  //Si el valor de i es menor a la cantidad de archivos entonces saldrá del ciclo while
   while($i<$tam){
    
    //Se van abriendo cada uno de los archivos de la carpeta hasta que abre todos los archivos de la carpeta
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"]);
    //dd($encuentra);
    $encuentra=strpos($res[$i]["Nombre"],$cadena_final_actual);
    //dd($encuentra,$res[$i]["Nombre"],$cadena_final_actual);
    if($encuentra==false){
        //dd("NADA");
    }else{
        //dd($res[$i]["Nombre"],$cadena_final_actual);
        //dd(strpos($res[$i]["Nombre"],$cadena_final_actual));
    //El texto que se desea modificar en el archivo de texto
    $patron= '"'.$question->pregunta.'"';
    //dd($patron);

    //Lo que se desea escribir en el archivo
    $sustitucion='"'.$request->pregunta.'"';
   
     //Se abre el archivo y se lee
      $leer = fopen($path_archivo, 'r+');
      //if(filesize($path_archivo) > 0){
      // Se almacena en data el contenido inicial del archivo
      $data = fread($leer, filesize($path_archivo));
      //dd($data);
      //Se cierra el archivo
      fclose($leer);
      //Se realiza el reeemplzado de la linea $patron por lo que dice en sustitución y lo demas queda exactamente igual a cmo esta en $data
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
        //Se abre el archivo para reescribirlo
      $escribir = fopen($path_archivo, 'w');
      //dd($datosnuevos);
      //Se esccribe en el archivo
      fwrite($escribir, $datosnuevos);
      fclose($escribir);
      }
      //dd($datosnuevos);
      //Se le suma uno a $i y se abre el siguiente archivo siempre y cuando $i< la cantidad de archivos en esta carpeta
    $i=$i+1;
    //print_r($i);
   //}
  }
 

     //MODIFICO  EL ARCHIVO EN EL QUE SE ENCUENTRE $patron DENTRO DE LA CARPETA INTENTS (QUESTION O PREGUNTA)
    //SEGUIRÁ A ESTE WHILE SI EL PATRON QUE SE BUSCA ES EL ULTIMO ELEMENTO DELA ARREGLO QUESTION, ES:{}
   $datosnuevos=null;
    $i=0;
    //Si i es menor que la cantidad de archivos en la carpeta Intents mantiene el ciclo..., sino sale.
    while($i<$tam){
    
    //La ruta con los archivos que va abriendo 
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"]);
     $find=strpos($res[$i]["Nombre"],$cadena_final_actual);
     //dd($res[$i]["Nombre"]);
    //dd($find);
    if($find==false){
        //dd("NADA");
    }else{
        //dd($res[$i]["Nombre"],$cadena_final_actual);
        //dd(substr($res[$i]["Nombre"],46),$find);
        //dd($res[$i]["Nombre"],$cadena_final_actual);
    //print_r($res2[$i]["Nombre"]);
    //dd($cadena_final_actual,$cadena_final);
    //El string que es buscando en alguna linea en los archivos
    //dd($cadena_final_actual);
    $patron= '"'.$question->pregunta.'","';
    $patron2='"name": '.'"'.(substr($res[$i]["Nombre"],46,-5)).'",';    //Lo que viene del formulario edit para modificar y añadirlo a la base de datos
    $sustitucion='"'.$request->pregunta.'","';
    $sustitucion2=str_replace($cadena_final_actual,$cadena_final,$patron2);
    //dd($sustitucion2);
    //dd($sustitucion);
    //}
        $leer = fopen($path_archivo, 'r+');
      $data = fread($leer, filesize($path_archivo));
      //dd($data , $patron, $sustitucion);
      fclose($leer);
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      $datosnuevos1= str_replace($patron2,$sustitucion2,$datosnuevos);
      $escribir = fopen($path_archivo, 'w');
      fwrite($escribir, $datosnuevos1);
      fclose($escribir);
      //dd($datosnuevos);
      $largo_actual_archivo1=strlen("C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"]);
      $nombre_archivo_mod=substr($res[$i]["Nombre"],46);
      $nombre_archivo_mod1=str_replace($cadena_final_actual,$cadena_final,$nombre_archivo_mod);
      //dd($nombre_archivo_mod1);
      //dd($largo_actual_archivo1,$find,$nombre_actual_archivo1);
      //dd($nombre_actual_archivo1,$encuentra,$largo_actual_archivo1);
     
     $fichero="C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"];
     $nuevo_fichero="C:/Users/LI/Desktop/chtbtICI/public/botpress12120/data/bots/icibot/intents/__qna__".$nombre_archivo_mod1;
     //dd($nuevo_fichero);
     $leer_fichero= fopen($fichero, 'r+');
     $info_nuevo_fichero = fread($leer_fichero, filesize($fichero));
     //dd($info_nuevo_fichero);
     fclose($leer_fichero);
     //dd($info_nuevo_fichero);

     $escribir_nuevo_fichero = fopen($nuevo_fichero, 'w+');
     fwrite($escribir_nuevo_fichero,$info_nuevo_fichero);
     fclose($escribir_nuevo_fichero);
     //rename($nuevo_fichero,$fichero);
     if($question_min_id==$question->id){
      //dd($fichero,$nuevo_fichero);
     rename($fichero,$nuevo_fichero);
     }

  //unlink("C:/Users/LI/Desktop/chtbtICI/public/".$res[$i]["Nombre"]);
      
  }
    $i=$i+1;
    //print_r($i);
  }

   //CERRAMOS EL DIRECTORIO
  $dir1->close();



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

  $i=0;
   while($i<$tam){
    //RUTA DE LA CARPETA PUBLIC + RUTA DE DIRECTORIO HASTA CARPETA QNA DONDE RECORRERA CADA UNO DE LOS NOMBRES DE LOS ARCHIVOS QUE TIENE ALMACENADO EN LA VARIABLE RES2
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res2[$i]["Nombre"]);
     $find=strpos($res2[$i]["Nombre"],$cadena_final_actual);
     //dd($res[$i]["Nombre"]);
    //dd($find);
    if($find==false){
      $archivo_nombre_original=(substr($res2[$i]["Nombre"],42,-5)).'.json';
      $archivo_nombre_nuevo=str_replace($cadena_final_actual,$cadena_final,(substr($res2[$i]["Nombre"],42,-5))).'.json';
        //dd("NADA");
    }else{
      $archivo_nombre_original=(substr($res2[$i]["Nombre"],42,-5)).'.json';

      //dd($cadena_final_actual);
    //print_r($res2[$i]["Nombre"]);
    //EL STRING QUE SE ESTA BUSCANDO EN LOS ARCHIVOS DE LA CARPETA QNA, PARA MODIFICAR ALGUNA DE LAS PREGUNTAS, QUE COMO $patron como 
    //en este caso no lleva coma, sabemos que no será el ultimo del arreglo questions: es:[]
    $patron= '"'.$question->pregunta.'"';
    $patron2='"id": '.'"'.(substr($res2[$i]["Nombre"],42,-5)).'",';
    //dd($patron);
    // LO QUE SE DESEA ESCRIBIR COMO NUEVA PREGUNTA EN LA TABLA QUESTIONS Y EN LA BASE DE DATOS DE BOTPRESS
    $sustitucion='"'.$request->pregunta.'"';
    $sustitucion2=str_replace($cadena_final_actual,$cadena_final,$patron2);
    $archivo_nombre_nuevo=str_replace($cadena_final_actual,$cadena_final,(substr($res2[$i]["Nombre"],42,-5))).'.json';
    //dd($archivo_nombre_original,$archivo_nombre_nuevo);
    //dd($cadena_final_actual,$cadena_final,$patron2,$sustitucion2);
    //}
    //dd($path_archivo);
        //SE ABRE EL ARCHIVO PARA LEERLO
      $leer = fopen($path_archivo, 'r+');
      //if(filesize($path_archivo) > 0){
      //SE ALMACENA LO QUE SE LEE INTERMANETE EN EL ARCHIVO
      $data = fread($leer, filesize($path_archivo));
      //dd($data);
      //SE CIERRA EL ARCHIVO QUE SE LEE
      fclose($leer);
      //SI EN EL ARCHIVO ENCUENTRA $patron entonces lo cambiará por $sustitucion y copiará lo demas del archivo data en la variable $datosnuevos
      $datosnuevos = str_replace($patron, $sustitucion, $data);
      $datosnuevos1= str_replace($patron2,$sustitucion2,$datosnuevos); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      $escribir = fopen($path_archivo, 'w');
      //dd($datosnuevos);
      //Se escribe en $datosnuevos los en el aarchivo que corresponde
      fwrite($escribir, $datosnuevos1);
      //cerramos la escritura en el archivo
      fclose($escribir);
      //dd($datosnuevos);
    }
    $i=$i+1;
    //print_r($i);
   //}
  }
 
   $datosnuevos=null;
    $i=0;
    while($i<$tam){
    //dd($request->pregunta);
    //dd($question->pregunta);
    //if($i+1==11){

        //RUTA DE LA CARPETA PUBLIC + RUTA DE DIRECTORIO HASTA CARPETA QNA DONDE RECORRERA CADA UNO DE LOS NOMBRES DE LOS ARCHIVOS QUE TIENE ALMACENADO EN LA VARIABLE RES2
    $find=strpos($res2[$i]["Nombre"],$cadena_final_actual);
     //dd($res[$i]["Nombre"]);
    //dd($find);
    if($find==false){
    $path_archivo=("C:/Users/LI/Desktop/chtbtICI/public/".$res2[$i]["Nombre"]);
    //print_r($res2[$i]["Nombre"]);
   }else{
    //EL STRING QUE SE ESTA BUSCANDO EN LOS ARCHIVOS DE LA CARPETA QNA, PARA MODIFICAR ALGUNA DE LAS PREGUNTAS, QUE COMO $patron como 
    //en este caso no lleva coma, sabemos que no será el ultimo del arreglo questions: es:[]
    $patron= '"'.$question->pregunta.'","';
        // LO QUE SE DESEA ESCRIBIR COMO NUEVA PREGUNTA EN LA TABLA QUESTIONS Y EN LA BASE DE DATOS DE BOTPRESS MEDIANTE MODIFICACION DE ARCHIVO .JSON SE LOGRARÁ.
    $sustitucion='"'.$request->pregunta.'","';
    //dd($sustitucion);
    //}
       //SE ALMACENA LO QUE SE LEE INTERNAMENTE EN EL ARCHIVO
        $leer = fopen($path_archivo, 'r+');
      $data = fread($leer, filesize($path_archivo));
      //dd($data , $patron, $sustitucion);
      //se cierra la lectura del archivo
      fclose($leer);
    //SI EN EL ARCHIVO ENCUENTRA $patron entonces lo cambiará por $sustitucion y copiará lo demas del archivo data en la variable $datosnuevos
      $datosnuevos = str_replace($patron, $sustitucion, $data); //REEMPLAZA LO QUE CONTINE EL ARCHIVO VIEJO POR EL ARCHIVO NUEVO
      //SE ABRE EL ARCHIVO APRA ESCRITURA
      $escribir = fopen($path_archivo, 'w');
     //Se escribe en $datosnuevos los en el aarchivo que corresponda a esta iteracion
      fwrite($escribir, $datosnuevos);
      fclose($escribir);

      //dd($datosnuevos);
    }
    $i=$i+1;
    //print_r($i);
  }

     //dd($datosnuevos);
    //Se cierra directorio
     $dir2->close();
   //dd($archivo_nombre_original,$archivo_nombre_nuevo);
  //MODIFICANDO RESPUESTA DE QNA QUESTION PREGUNTA 
  $tam=sizeof($res2);
  $i=0;
  while($i<$tam){
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
  }
  //dd($archivo_nombre_original,$archivo_nombre_nuevo);


  //Actualizamos la base de datos mysql con las respectivas tablas
  //dd($request);
   DB::table('questions')->where('id', $id)->update(['pregunta' => $request->pregunta]);
   //$question->pregunta=$request->pregunta;
   //$question->save();
   //dd($request);
    DB::table('answer')->where('id','=',$question->id_answers)->update(['nombre'=>$request->respuesta]);

   //$answer->nombre=$request->nombre;
   //$answer->save();
   //$dir2->close();
   } 
   $imagenes=DB::table('qnas_images')->where('id_answer','=',$question->id_answers)->get();
   foreach($imagenes as $imagen);
   //dd($imagen,$es_archivo_flow);
  $tam_array_imagen=0;
 return view('qna.message',compact('question','answer','datosnuevos','es_archivo_flow','imagen','tam_array_imagen'));
 
  
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function habilitada($id)
    {
      $qnas=Question::where('id','=',$id)->get();
      foreach($qnas as $qna);
      $question_min_id=DB::table('questions')->where('id_answers','=',$qna->id_answers)->select('id')->min('id');
      //dd($question_min_id);
      $questions=DB::table('questions')->where('id','=',$question_min_id)->get();
      $respuestas=DB::table('answer')->where('id','=',$qna->id_answers)->get();
      //dd($respuestas);
      foreach($respuestas as $respuesta);
      foreach($questions as $question);
      //dd($question->pregunta);
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
    //dd($cadena_final);

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
