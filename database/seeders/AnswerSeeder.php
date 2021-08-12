<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
                 /*$directorio1="public/botpress12120/data/bots/ucm-botpress1/intents";
                 $directorio2="public/botpress12120/data/bots/ucm-botpress1/qna/";*/
                 $directorio1="public/botpress12120/data/bots/icibot/intents";
                 $directorio2="public/botpress12120/data/bots/icibot/qna/";
         //dd($directorio1);
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

  //dd($res[$i]["Nombre"]);
  $array_nombre=array();
  $nombre_sin_qna=array();
  $res_nombres=array();
  $i=0;
  //Si el valor de i es menor a la cantidad de archivos entonces saldrá del ciclo while
  $j=0;
   while($i<$tam){
   		 if((strpos($res[$i]["Nombre"],'qna'))==false){
   		 }else{
 		 $res_nombres[$j]=substr($res[$i]["Nombre"],53,-5);
     //dd($res_nombres[$j]);
 		 $j=$j+1;
         /*if(($res[$i]["Nombre"])){
  		 	$path_archivo=("C:/Users/LI/Desktop/chatbot/public/".$res_nombre[$i]);
  		}*/
  	}
  		$i=$i+1;
    }
    //dd($res[$i]["Nombre"],60,-5);
   
    $tam_nombres=sizeof($res_nombres);
    $i=0;
    //dd($res_nombres[$i]);
    while($i<$tam_nombres){
    	$path_archivo=$directorio2.$res_nombres[$i].'.json';
    	//dd($path_archivo);
    	$aux=null;
    	if($i==1){
    		//dd($path_archivo);
    	}
    //dd($res_nombres,$path_archivo);
    	$leer = fopen($path_archivo, 'r+');

    	$numlinea=0;
    	while ($linea = fgets($leer)) {
    		//echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        
        if($i==0){
          //dd($aux);
        //dd($path_archivo,$leer,$i,$aux);
        }
        $pos1=strpos($aux[11],']');
        if($pos1!=false){
        	//dd(substr($aux[10],-1));
        	$nombre=substr($aux[10],9,-2);
        	//dd($nombre);
        	//$archivos_qnas=DB::table('archivo_qna')->where('nombre','=',$res_nombres[$i])->get();
        	//foreach($archivos_qnas as $archivo_qna);
        	$pos2=strpos($aux[7],'true');
        	 if($pos2==false)
        {
            $habilitada=0;
        }else{
        	$habilitada=1;
        }
    }else{
    	$nombre=substr($aux[9],14,-4);
         //if($i==2){
         // dd('vacio',$nombre);
         //}
        	//dd(substr($nombre,14,-6));
         //dd($archivos_qnas);
        	//$archivos_qnas=DB::table('archivo_qna')->where('nombre','=',$res_nombres[$i])->get();
        	//foreach($archivos_qnas as $archivo_qna);
        	$pos2=strpos($aux[7],'true');
        	 if($pos2==false)
        {
            $habilitada=0;
        }else{
        	$habilitada=1;
        }
    }
            //dd($nombre,$archivo_qna->id,$habilitada);	
         if($nombre==false){
          //dd(substr($aux[$numlinea-4],21,-3));
          $nombre=substr($aux[$numlinea-4],21,-3);
         }		
         $carbon = new \Carbon\Carbon();
        $fecha_actual = $carbon->now();
        //$fecha_actual= strtotime($fecha_actual->format('Y-m-d'));
     		DB::table('answer')->insert(['nombre'=>$nombre,'archivo_qna'=>$res_nombres[$i] ,'habilitada'=> $habilitada,'created_at' => $fecha_actual,'updated_at'=>$fecha_actual]);
    
    	//DB::table('answer')->insert(['nombre'=>$res_nombres[$i]]);
     		fclose($leer);
    	$i=$i+1;
    }

    Schema::dropIfExists('archivo_qna');
}
}
