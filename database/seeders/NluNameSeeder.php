<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;


class NluNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

       $directorio1="public/botpress12120/data/bots/ucm-botpress1/intents";
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
  //dd($tam,$res);

    //dd($res[$i]["Nombre"]);
  $array_nombre=array();
  $nombre_sin_qna=array();
  $res_nombres=array();
  $i=0;
  //Si el valor de i es menor a la cantidad de archivos entonces saldrá del ciclo while
  $j=0;
   while($i<$tam){
   		 if((strpos($res[$i]["Nombre"],'qna'))==false){
   		    $res_nombres[$j]=substr($res[$i]["Nombre"],53,-5);
 		 $j=$j+1;
   		 }else{
 		 
         /*if(($res[$i]["Nombre"])){
  		 	$path_archivo=("C:/Users/LI/Desktop/chatbot/public/".$res_nombre[$i]);
  		}*/
  	}
  		$i=$i+1;
    }
     $i=0;
      $tam_nombres=sizeof($res_nombres);
     while($i<$tam_nombres){
      $path_archivo=$directorio1.$res_nombres[$i].'.json';
      //dd($path_archivo);
      $aux=null;
      if($i==1){
        //dd($path_archivo);
      }
      $leer = fopen($path_archivo, 'r+');

      $numlinea=0;
      while ($linea = fgets($leer)) {
        //echo $linea.'<br/>';
            $aux[] = $linea;    
             $numlinea++;
        }
       
        $pos1=$aux[1];
          //dd(substr($aux[10],-1));
          $nombre=substr($pos1,11,-3);
          $archivos_nlus=DB::table('archivo_nlu')->where('nombre','=',$res_nombres[$i])->get();
          foreach($archivos_nlus as $archivo_nlu);
          //dd('ARCHIVO_NLU',$archivos_nlus);    
        DB::table('nlu_name')->insert(['nombre'=>$nombre, 'id_archivo_nlu'=>$archivo_nlu->id]);
    
      //DB::table('answer')->insert(['nombre'=>$res_nombres[$i]]);
        fclose($leer);
      $i=$i+1;
    }
        //if($i==4){
        //dd($path_archivo,$leer,$i,$aux);
        //}
        //$largo_archivo=sizeof($aux);
   

    }
}
