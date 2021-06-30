<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class QnaImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //dd('HOLAAA');
        $images_qnas=DB::table('answer')->where('nombre','like','#!builtin_image%')->get();
        //dd($images_qnas);
        $res = array();
        
             //$directorio1="public/botpress12120/data/bots/ucm-botpress1/content-elements";
             /*$directorio1="public/botpress12120/data/bots/ucm-botpress1/intents";
                 $directorio2="public/botpress12120/data/bots/ucm-botpress1/qna/";*/
                 $directorio1="public/botpress12120/data/bots/icibot/intents";
                 $directorio2="public/botpress12120/data/bots/icibot/qna/";
             //$archivo1[0]="/builtin_image.json";
    if(substr($directorio1, -1) != "/") $directorio1 .= "/";

  // Creamos un puntero al directorio y obtenemos el listado de archivos
  /*$dir1 = @dir($directorio1) or die("getFileList: Error abriendo el directorio $directorio1 para leerlo");
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
  }*/
           $path_archivo="public/botpress12120/data/bots/icibot/content-elements/builtin_image.json";
            $leer = fopen($path_archivo, 'r+');
            $numlinea=0;
      foreach($images_qnas as $image_qna){
      while ($linea = fgets($leer)) {
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
        //dd($aux);
        $i=0;
        $tam=sizeof($aux);
        while($i<$tam){
        	//$i=2;
        	//dd($aux[$i]);
        	if($i==2){
        	//dd(substr($aux[$i],4,-2),'"id": "'.substr($image_qna->nombre,2).'"');
        	}
          //dd(substr($aux[$i],4,-2),'"id": "'.substr($image_qna->nombre,2).'"');
            if((substr($aux[$i],4,-2))=='"id": "'.substr($image_qna->nombre,2).'"'){
        		$i=$i+3;
        		$nombre=substr($aux[$i],57,-2);
        		//dd($nombre);
        		DB::table('qnas_images')->insert(['nombre_imagen_qna'=>$nombre,'id_answer'=> $image_qna->id]);
            }
            $i=$i+1;
        }
            //$tam=sizeof($res);
  		    //dd($res);
        	

        }

    }
}
